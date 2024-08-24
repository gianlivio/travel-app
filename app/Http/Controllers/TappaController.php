<?php

namespace App\Http\Controllers;

use App\Models\Tappa;
use Illuminate\Http\Request;

class TappaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tappe = Tappa::all();
        return response()->json($tappe);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'giornata_id' => 'required|exists:giornate,id',
            'titolo' => 'required|string|max:255',
            'descrizione' => 'nullable|string',
            'immagine' => 'nullable|string',
            'cibo' => 'nullable|string',
            'curiosita' => 'nullable|string',
        ]);

        $tappa = Tappa::create($request->all());
        return response()->json($tappa, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json($tappa);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'titolo' => 'required|string|max:255',
            'descrizione' => 'nullable|string',
            'immagine' => 'nullable|string',
            'cibo' => 'nullable|string',
            'curiosita' => 'nullable|string',
        ]);

        $tappa->update($request->all());
        return response()->json($tappa);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tappa->delete();
        return response()->json(null, 204);
    }
}
