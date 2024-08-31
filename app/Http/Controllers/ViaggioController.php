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
                'data_inizio' => 'required|date',
                'data_fine' => 'required|date|after_or_equal:data_inizio',
                'dettagli' => 'nullable|string',
                'immagine' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'giornate' => 'required|array',
                'giornate.*.data' => 'required|date',
                'giornate.*.tappe' => 'required|array',
                'giornate.*.tappe.*.titolo' => 'required|string|max:255',
                'giornate.*.tappe.*.descrizione' => 'nullable|string',
            ]);

            // Crea il viaggio
            $viaggio = Viaggio::create([
                'titolo' => $request->input('titolo'),
                'meta' => $request->input('meta'),
                'durata' => $request->input('durata'),
                'data_inizio' => $request->input('data_inizio'), 
                'data_fine' => $request->input('data_fine'),     
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
                    'data_inizio' => 'required|date',
                    'data_fine' => 'required|date|after_or_equal:data_inizio',
                    'dettagli' => 'nullable|string',
                    'immagine' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                    'giornate' => 'required|array',
                    'giornate.*.data' => 'required|date',
                    'giornate.*.tappe' => 'required|array',
                    'giornate.*.tappe.*.titolo' => 'required|string|max:255',
                    'giornate.*.tappe.*.descrizione' => 'nullable|string',
                ]);

                $viaggio = Viaggio::findOrFail($id);

                if ($request->hasFile('immagine')) {
                    if ($viaggio->immagine && Storage::exists('public/' . $viaggio->immagine)) {
                        Storage::delete('public/' . $viaggio->immagine);
                    }
                    $imagePath = $request->file('immagine')->store('viaggi_images', 'public');
                    $viaggio->immagine = $imagePath;
                }

                $viaggio->update($request->only('titolo', 'meta', 'durata', 'data_inizio', 'data_fine', 'dettagli'));

                // Aggiornamento delle giornate
                $existingGiornataIds = $viaggio->giornate()->pluck('id')->toArray();

                foreach ($request->input('giornate') as $giornataData) {
                    if (isset($giornataData['id'])) {
                        $giornata = Giornata::find($giornataData['id']);
                        if (!$giornata) {
                            continue;
                        }
                    } else {
                        $giornata = $viaggio->giornate()->create([
                            'data' => $giornataData['data'],
                        ]);
                    }

                    $giornata->data = $giornataData['data'];
                    $giornata->save();

                    if (($key = array_search($giornata->id, $existingGiornataIds)) !== false) {
                        unset($existingGiornataIds[$key]);
                    }

                    // Aggiorna le tappe per la giornata corrente
                    $existingTappaIds = $giornata->tappe()->pluck('id')->toArray();

                    foreach ($giornataData['tappe'] as $tappaData) {
                        if (isset($tappaData['id'])) {
                            $tappa = Tappa::find($tappaData['id']);
                            if (!$tappa) {
                                continue;
                            }
                        } else {
                            $tappa = $giornata->tappe()->create([
                                'titolo' => $tappaData['titolo'],
                                'descrizione' => $tappaData['descrizione'] ?? '',
                                'immagine' => $tappaData['immagine'] ?? null,
                                'cibo' => $tappaData['cibo'] ?? '',
                                'curiosita' => $tappaData['curiosita'] ?? '',
                            ]);
                        }

                        $tappa->fill($tappaData);
                        $tappa->save();

                        if (($key = array_search($tappa->id, $existingTappaIds)) !== false) {
                            unset($existingTappaIds[$key]);
                        }
                    }

                    // Elimina le tappe non più esistenti
                    Tappa::destroy($existingTappaIds);
                }

                // Elimina le giornate non più esistenti
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