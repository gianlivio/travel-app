<?php

namespace App\Http\Controllers;

use App\Models\Giornata;
use Illuminate\Http\Request;

class GiornataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $giornate = Giornata::with('tappe')->get();
        return response()->json($giornate);
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
            'viaggio_id' => 'required|exists:viaggi,id',
            'data' => 'required|date',
        ]);

        $giornata = Giornata::create($request->all());
        return response()->json($giornata, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json($giornata->load('tappe'));
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
            'data' => 'required|date',
        ]);

        $giornata->update($request->all());
        return response()->json($giornata);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $giornata->delete();
        return response()->json(null, 204);
    }
}
