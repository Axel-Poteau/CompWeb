<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SalleRequest;
use App\Http\Resources\SalleResource;
use App\Models\Salle;
use Illuminate\Http\Request;

class SalleController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $salles = Salle::all();
        return SalleResource::collection($salles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SalleRequest $request) {
        // Ici, seulement si la requête est correcte
        $salle = Salle::create($request->input());
        return response()->json([
            'status'=> true,
            'message' => 'Salle créée avec succès',
            'salle' => new SalleResource($salle)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {
        $salle = Salle::findOrFail($id);
        return new SalleResource($salle);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SalleRequest $request, string $id) {
        // Ici, seulement si la requête est correcte
        $salle = Salle::findOrfail($id);
        $salle->update($request->input());
        return response()->json([
            'status'=> true,
            'message' => 'Salle modifiée avec succès',
            'salle' => new SalleResource($salle)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {
        $salle = Salle::findOrFail($id);
        $salle->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Salle supprimée avec succès'
        ]);
    }
}
