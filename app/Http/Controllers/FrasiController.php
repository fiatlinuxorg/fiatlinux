<?php

namespace App\Http\Controllers;

use App\Models\Frase;
use Illuminate\Http\Request;

class FrasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Frase::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'frase' => 'required',
            'autore' => 'required'
        ]);

        $frase = new Frase();
        $frase->frase = $request->frase;
        $frase->autore = $request->autore;
        $frase->aggiunto_da = $request->aggiunto_da;
        $frase->save();
        return response()->json($frase, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Frase $frase)
    {
        return $frase;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Frase $frase)
    {
        $frase->frase = $request->frase;
        $frase->autore = $request->autore;
        $frase->aggiunto_da = $request->aggiunto_da;
        $frase->save();
        return response()->json($frase, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Frase $frase)
    {
        $frase->delete();
        return response()->json(null, 204);
    }

    /**
     * Get a random resource from storage.
     */
    public function random()
    {
        return Frase::inRandomOrder()->first();
    }
}
