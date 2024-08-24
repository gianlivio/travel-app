<?php

namespace App\Http\Controllers;

use App\Models\Viaggio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ViaggioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $viaggi = Viaggio::all();
        return view('viaggi.index', compact('viaggi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('viaggi.create'); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titolo' => 'required|string|max:255',
            'descrizione' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('viaggi_images', 'public');
        }

        $viaggio = Viaggio::create([
            'titolo' => $request->input('titolo'),
            'descrizione' => $request->input('descrizione'),
            'user_id' => Auth::id(),
            'image' => $imagePath,
        ]);

        // Salva le giornate
        if ($request->has('giornate')) {
            foreach ($request->giornate as $giornataData) {
                $viaggio->giornate()->create($giornataData);
            }
        }

        // Salva le tappe
        if ($request->has('tappe')) {
            foreach ($request->tappe as $tappaData) {
                $viaggio->tappe()->create($tappaData);
            }
        }

        return redirect()->route('viaggi.show', $viaggio->id)->with('success', 'Viaggio creato con successo');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $viaggio = Viaggio::findOrFail($id);
        return view('viaggi.show', compact('viaggio'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $viaggio = Viaggio::findOrFail($id);
        return view('viaggi.edit', compact('viaggio'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'titolo' => 'required|string|max:255',
            'descrizione' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $viaggio = Viaggio::findOrFail($id);

        // Gestione dell'immagine
        $imagePath = $viaggio->image;
        if ($request->hasFile('image')) {
            // Elimina l'immagine precedente se esiste
            if ($viaggio->image) {
                \Storage::disk('public')->delete($viaggio->image);
            }
            $imagePath = $request->file('image')->store('viaggi_images', 'public');
        }

        // Aggiornamento dei dati
        $viaggio->update([
            'titolo' => $request->input('titolo'),
            'descrizione' => $request->input('descrizione'),
            'image' => $imagePath,
        ]);

        // Aggiorna le giornate e tappe se fornite (da gestire con logica appropriata)

        return redirect()->route('viaggi.show', $viaggio->id)->with('success', 'Viaggio aggiornato con successo');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $viaggio = Viaggio::findOrFail($id);
        // Elimina l'immagine associata
        if ($viaggio->image) {
            \Storage::disk('public')->delete($viaggio->image);
        }
        $viaggio->delete();
        return redirect()->route('viaggi.index')->with('success', 'Viaggio eliminato con successo');
    }
}