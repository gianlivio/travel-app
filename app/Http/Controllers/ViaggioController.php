<?php

namespace App\Http\Controllers;

use App\Models\Viaggio;
use Illuminate\Http\Request;
use App\Models\Giornata;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ViaggioController extends Controller
{
    public function index()
    {
        $viaggi = Viaggio::all();
        return view('admin.viaggi.index', compact('viaggi'));
    }

    public function create()
    {
        return view('admin.viaggi.create'); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'titolo' => 'required|string|max:255',
            'meta' => 'required|string|max:255',
            'durata' => 'required|integer',
            'periodo' => 'required|string',
            'dettagli' => 'nullable|string',
            'immagine' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Crea il viaggio
        $viaggio = Viaggio::create([
            'titolo' => $request->input('titolo'),
            'meta' => $request->input('meta'),
            'durata' => $request->input('durata'),
            'periodo' => $request->input('periodo'),
            'dettagli' => $request->input('dettagli'),
            'immagine' => $request->file('immagine') ? $request->file('immagine')->store('viaggi_images', 'public') : null,
            'user_id' => Auth::id(),
        ]);

        // Associa una giornata al viaggio
        $giornata = Giornata::create([
            'viaggio_id' => $viaggio->id,
            'data' => now(), // Usa la data corrente o specifica una data
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crea le tappe
        $tappe = $request->input('tappe', []);
        foreach ($tappe as $tappa) {
            if (!empty($tappa)) {
                $viaggio->tappe()->create([
                    'descrizione' => $tappa,
                    'giornata_id' => $giornata->id, // Associa la tappa alla giornata appena creata
                    'titolo' => $viaggio->titolo
                ]);
            }
        }

        return redirect()->route('admin.viaggi.index')->with('success', 'Viaggio creato con successo.');
    }

    public function show($id)
    {
        $viaggio = Viaggio::findOrFail($id);
        return view('admin.viaggi.show', compact('viaggio'));
    }

    public function edit($id)
    {
        $viaggio = Viaggio::findOrFail($id);
        return view('admin.viaggi.edit', compact('viaggio'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'titolo' => 'required|string|max:255',
            'meta' => 'required|string|max:255',
            'durata' => 'required|integer',
            'periodo' => 'required|string',
            'dettagli' => 'nullable|string',
            'immagine' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $viaggio = Viaggio::findOrFail($id);

        // Controlla se c'è un file di immagine e gestisci il caricamento
        if ($request->hasFile('immagine')) {
            // Cancella l'immagine precedente se esiste
            if ($viaggio->immagine && Storage::exists('public/' . $viaggio->immagine)) {
                Storage::delete('public/' . $viaggio->immagine);
            }
            // Salva la nuova immagine
            $imagePath = $request->file('immagine')->store('viaggi_images', 'public');
            $viaggio->immagine = $imagePath;
        }

        // Aggiorna i campi del viaggio
        $viaggio->titolo = $request->input('titolo');
        $viaggio->meta = $request->input('meta');
        $viaggio->durata = $request->input('durata');
        $viaggio->periodo = $request->input('periodo');
        $viaggio->dettagli = $request->input('dettagli');
        $viaggio->save();

        // Elimina le tappe esistenti e crea quelle nuove
        $viaggio->tappe()->delete();

        $tappe = $request->input('tappe', []);
        foreach ($tappe as $tappa) {
            if (!empty($tappa)) {
                $viaggio->tappe()->create([
                    'descrizione' => $tappa,
                    'giornata_id' => $request->input('giornata_id', 1), // Usa un valore predefinito o gestisci dal form
                    'titolo' => $viaggio->titolo // Assumendo che il titolo della tappa sia lo stesso del viaggio
                ]);
            }
        }

        // Reindirizzamento alla pagina index con messaggio di successo
        return redirect()->route('admin.viaggi.index')->with('success', 'Viaggio aggiornato con successo');
    }


    public function destroy($id)
    {
        $viaggio = Viaggio::findOrFail($id);
        $viaggio->delete();
        return redirect()->route('admin.viaggi.index')->with('success', 'Viaggio eliminato con successo');
    }
}