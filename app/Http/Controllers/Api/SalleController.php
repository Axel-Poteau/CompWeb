<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Salle;
use HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

class SalleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $salles=Salle::all();
        return response()->json([
            'status'=>true,
            'message'=>"Salles Index successfully",
            'salles'=>$salles
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $salle=new Salle();
        $salle->nom=$request->nom;
        $salle->adresse=$request->adresse;
        $salle->code_postal=$request->code_postal;
        $salle->ville=$request->ville;
        $salle->save();
        return response()->json([
            'status'=>true,
            'message'=>"Salle Store successfully",
            'salle'=>$salle
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $salle=Salle::findOrFail($id);
        return response()->json([
            'status'=>true,
            'message'=>"Salles Show successfully",
            'salles'=>$salle
        ],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $salle=Salle::findOrFail($id);
        $salle->update($request->all());
        return response()->json([
            'status'=>true,
            'message'=>"Salle Update successfully",
            'salle'=>$salle
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $salle=Salle::findOrFail($id);
        $salle->delete();
        return response()->json([
            'status'=>true,
            'message'=>"Salles Delete successfully",
            'salle'=>$salle
        ],200);
    }
}
