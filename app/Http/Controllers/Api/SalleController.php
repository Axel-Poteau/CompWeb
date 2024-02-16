<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Salle;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Info(version: "0.1", title: "My First API")]
#[OA\Server(url: "http://127.0.0.1:8000")]
class SalleController extends Controller
{
    #[OA\Get(
        path: '/api/salle',
        description: 'Get a list of salles.',
        tags: ['Salle']
    )]
    #[OA\Response(response: '200', description: 'Successful operation')]
    public function index()
    {
        $salles = Salle::all();
        return response()->json([
            'status' => true,
            'message' => "Salles Index successfully",
            'salles' => $salles
        ], 200);
    }

    #[OA\Post(
        path: '/api/salle',
        description: 'Create a new salle.',
        tags: ['Salle'],
    )]
    #[OA\Parameter(
        name: 'nom',
        description: 'name of salle',
        in: 'query',
        required: true,
        schema: new OA\Schema(
            type: 'string',
        )
    )]
    #[OA\Parameter(
        name: 'adresse',
        description: 'adresse of salle',
        in: 'query',
        required: true,
        schema: new OA\Schema(
            type: 'string',
        )
    )]
    #[OA\Parameter(
        name: 'code_postal',
        description: 'code postal of salle',
        in: 'query',
        required: true,
        schema: new OA\Schema(
            type: 'string',
        )
    )]
    #[OA\Parameter(
        name: 'ville',
        description: 'city of salle',
        in: 'query',
        required: true,
        schema: new OA\Schema(
            type: 'string',
        )
    )]
    #[OA\Response(response: '200', description: 'Successful operation')]
    public function store(Request $request)
    {
        $salle = new Salle();
        $salle->nom = $request->nom;
        $salle->adresse = $request->adresse;
        $salle->code_postal = $request->code_postal;
        $salle->ville = $request->ville;
        $salle->save();

        return response()->json([
            'status' => true,
            'message' => "Salle stored successfully",
            'salle' => $salle
        ], 200);
    }

    #[OA\Get(
        path: '/api/salle/{salle}',
        description: 'Get information about a specific salle.',
        tags: ['Salle']
    )]
    #[OA\Parameter(
        name: 'salle',
        description: 'ID of salle',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Response(response: '200', description: 'Successful operation')]
    public function show(string $id)
    {
        $salle = Salle::findOrFail($id);
        return response()->json([
            'status' => true,
            'message' => "Salle details retrieved successfully",
            'salle' => $salle
        ], 200);
    }

    #[OA\Put(
        path: '/api/salle/{salle}',
        description: 'Update information about a specific salle.',
        tags: ['Salle']
    )]
    #[OA\Parameter(
        name: 'salle',
        description: 'ID of salle',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer')

    )]
    #[OA\Parameter(
        name: 'nom',
        description: 'name of salle',
        in: 'query',
        schema: new OA\Schema(
            type: 'string',
        )
    )]
    #[OA\Parameter(
        name: 'adresse',
        description: 'adresse of salle',
        in: 'query',
        schema: new OA\Schema(
            type: 'string',
        )
    )]
    #[OA\Parameter(
        name: 'code_postal',
        description: 'code postal of salle',
        in: 'query',
        schema: new OA\Schema(
            type: 'string',
        )
    )]
    #[OA\Parameter(
        name: 'ville',
        description: 'city of salle',
        in: 'query',
        schema: new OA\Schema(
            type: 'string',
        )
    )]
    #[OA\Response(response: '200', description: 'Successful operation')]
    public function update(Request $request, string $id)
    {
        $salle = Salle::findOrFail($id);
        $salle->update($request->all());

        return response()->json([
            'status' => true,
            'message' => "Salle updated successfully",
            'salle' => $salle
        ], 200);
    }

    #[OA\Delete(
        path: '/api/salle/{salle}',
        description: 'Delete a specific salle.',
        tags: ['Salle']
    )]
    #[OA\Parameter(
        name: 'salle',
        description: 'ID of salle',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Response(response: '200', description: 'Successful operation')]
    public function destroy(string $id)
    {
        $salle = Salle::findOrFail($id);
        $salle->delete();

        return response()->json([
            'status' => true,
            'message' => "Salle deleted successfully",
            'salle' => $salle
        ], 200);
    }
}
