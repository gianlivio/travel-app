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
        ]);

        // Aggiungi l'ID dell'utente al nuovo viaggio
        $viaggio = Viaggio::create([
            'titolo' => $request->titolo,
            'descrizione' => $request->descrizione,
            'user_id' => Auth::id(), 
        ]);

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
        ]);
    
        $viaggio = Viaggio::findOrFail($id);
        $viaggio->update($request->all());
    
        return redirect()->route('viaggi.show', $viaggio->id)->with('success', 'Viaggio aggiornato con successo');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $viaggio->delete();
        return response()->json(null, 204);
    }
}
