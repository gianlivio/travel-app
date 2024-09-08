<?php

namespace App\Http\Controllers;

use App\Models\Viaggio;
use Illuminate\Http\Request;
use App\Models\Giornata;
use App\Models\Tappa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ViaggioController extends Controller
{
    public function index()
    {
        $viaggi = Viaggio::with('giornate.tappe')->get();
        return view('admin.viaggi.index', compact('viaggi'));
    }

    public function create()
    {
        return view('admin.viaggi.create'); 
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'titolo' => 'required|string|max:255',
                'meta' => 'required|string|max:255',
                'durata' => 'required|integer',
                'date_range' => 'required|string',
                'dettagli' => 'nullable|string',
                'immagine' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'giornate' => 'required|array',
                'giornate.*.data' => 'required|date',
                'giornate.*.tappe' => 'required|array',
                'giornate.*.tappe.*.titolo' => 'required|string|max:255',
                'giornate.*.tappe.*.descrizione' => 'nullable|string',
            ]);
    
            // Prima unifica data inizio fine in date range
            $dates = explode(' - ', $request->input('date_range'));
    
            // Crea il viaggio
            $viaggio = Viaggio::create([
                'titolo' => $request->input('titolo'),
                'meta' => $request->input('meta'),
                'durata' => $request->input('durata'),
                'data_inizio' => $dates[0], 
                'data_fine' => $dates[1],    
                'dettagli' => $request->input('dettagli'),
                'immagine' => $request->file('immagine') ? $request->file('immagine')->store('viaggi_images', 'public') : null,
                'user_id' => Auth::id(),
            ]);
    
            // Aggiungi le giornate e le tappe al viaggio
            foreach ($request->input('giornate') as $giornataData) {
                $giornata = $viaggio->giornate()->create([
                    'data' => $giornataData['data'],
                ]);
    
                foreach ($giornataData['tappe'] as $tappaData) {
                    $giornata->tappe()->create([
                        'titolo' => $tappaData['titolo'],
                        'descrizione' => $tappaData['descrizione'] ?? '',
                        'immagine' => $tappaData['immagine'] ?? null,
                        'cibo' => $tappaData['cibo'] ?? '',
                        'curiosita' => $tappaData['curiosita'] ?? '',
                    ]);
                }
            }
    
            return redirect()->route('admin.viaggi.index')->with('success', 'Viaggio creato con successo.');
        } catch (\Exception $e) {
            \Log::error('Errore nel salvataggio del viaggio: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Si è verificato un errore durante la creazione del viaggio.');
        }
    }

    public function show($id)
    {
        $viaggio = Viaggio::with('giornate.tappe')->findOrFail($id);
        return view('admin.viaggi.show', compact('viaggio'));
    }

    public function edit($id)
    {
        $viaggio = Viaggio::with('giornate.tappe')->findOrFail($id);
        return view('admin.viaggi.edit', compact('viaggio'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'titolo' => 'required|string|max:255',
                'meta' => 'required|string|max:255',
                'durata' => 'required|integer',
                'date_range' => 'required|string',
                'dettagli' => 'nullable|string',
                'immagine' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'giornate' => 'required|array',
                'giornate.*.data' => 'required|date',
                'giornate.*.tappe' => 'nullable|array',
                'giornate.*.tappe.*.titolo' => 'required|string|max:255',
                'giornate.*.tappe.*.descrizione' => 'nullable|string',
            ]);
    
            $dates = explode(' - ', $request->input('date_range'));
            $viaggio = Viaggio::findOrFail($id);
    
            if ($request->hasFile('immagine')) {
                if ($viaggio->immagine && Storage::exists('public/' . $viaggio->immagine)) {
                    Storage::delete('public/' . $viaggio->immagine);
                }
                $imagePath = $request->file('immagine')->store('viaggi_images', 'public');
                $viaggio->immagine = $imagePath;
            }
    
            $viaggio->update([
                'titolo' => $request->input('titolo'),
                'meta' => $request->input('meta'),
                'durata' => $request->input('durata'),
                'data_inizio' => $dates[0],
                'data_fine' => $dates[1],
                'dettagli' => $request->input('dettagli'),
                'immagine' => $imagePath ?? $viaggio->immagine,
            ]);
    
            // Ottieni gli ID delle giornate esistenti prima dell'aggiornamento
            $existingGiornataIds = $viaggio->giornate()->pluck('id')->toArray();
    
            // Loop per le giornate inviate dal form
            foreach ($request->input('giornate') as $giornataData) {
                if (isset($giornataData['id'])) {
                    // Aggiorna la giornata esistente
                    $giornata = Giornata::find($giornataData['id']);
                    if ($giornata) {
                        $giornata->update([
                            'data' => $giornataData['data'],
                        ]);
                    }
                } else {
                    // Crea una nuova giornata
                    $giornata = $viaggio->giornate()->create([
                        'data' => $giornataData['data'],
                    ]);
                }
    
                // Ottieni gli ID delle tappe esistenti
                $existingTappaIds = $giornata->tappe()->pluck('id')->toArray();
    
                // Aggiorna o crea le tappe
                if (isset($giornataData['tappe'])) {
                    foreach ($giornataData['tappe'] as $tappaData) {
                        if (isset($tappaData['id'])) {
                            // Aggiorna la tappa esistente
                            $tappa = Tappa::find($tappaData['id']);
                            if ($tappa) {
                                $tappa->update($tappaData);
                            }
                        } else {
                            // Crea una nuova tappa
                            $giornata->tappe()->create($tappaData);
                        }
    
                        // Rimuovi la tappa dall'elenco esistente, poiché è stata aggiornata
                        if (($key = array_search($tappa->id, $existingTappaIds)) !== false) {
                            unset($existingTappaIds[$key]);
                        }
                    }
                }
    
                // Elimina le tappe che non sono più presenti
                Tappa::destroy($existingTappaIds);
    
                // Rimuovi la giornata dall'elenco esistente, poiché è stata aggiornata
                if (($key = array_search($giornata->id, $existingGiornataIds)) !== false) {
                    unset($existingGiornataIds[$key]);
                }
            }
    
            // Elimina le giornate che non sono più presenti
            Giornata::destroy($existingGiornataIds);
    
            return redirect()->route('admin.viaggi.index')->with('success', 'Viaggio aggiornato con successo');
        } catch (\Exception $e) {
            \Log::error('Errore nell\'aggiornamento del viaggio: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Si è verificato un errore durante l\'aggiornamento del viaggio.');
        }
    }

    public function destroy($id)
    {
        try {
            $viaggio = Viaggio::findOrFail($id);
            $viaggio->giornate()->each(function($giornata) {
                $giornata->tappe()->delete();
                $giornata->delete();
            });
            $viaggio->delete();
            return redirect()->route('admin.viaggi.index')->with('success', 'Viaggio eliminato con successo');
        } catch (\Exception $e) {
            \Log::error('Errore durante l\'eliminazione del viaggio: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Si è verificato un errore durante l\'eliminazione del viaggio.');
        }
    }
}