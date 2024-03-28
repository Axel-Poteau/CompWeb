<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class ClientController extends Controller
{
    #[OA\Get(
        path: '/api/client',
        description: 'Get a list of clients.',
        tags: ['Client']
    )]
    #[OA\Response(response: '200', description: 'Successful operation')]
    public function index()
    {
        $this->authorize('viewAny', Client::class);
        $clients=Client::all();
        return response()->json([
            'status' => true,
            'message' => "Salles Index successfully",
            'clients' => $clients
        ], 200);
    }

    #[OA\Post(
        path: '/api/client',
        description: 'Create a new client.',
        tags: ['Client']
    )]
    #[OA\Parameter(
        name: 'nom',
        description: 'firstname of client',
        in: 'query',
        schema: new OA\Schema(
            type: 'string',
        )
    )]
    #[OA\Parameter(
        name: 'prenom',
        description: 'lastname of client',
        in: 'query',
        schema: new OA\Schema(
            type: 'string',
        )
    )]
    #[OA\Parameter(
        name: 'adresse',
        description: 'adresse of client',
        in: 'query',
        schema: new OA\Schema(
            type: 'string',
        )
    )]
    #[OA\Parameter(
        name: 'code_postal',
        description: 'code postal of client',
        in: 'query',
        schema: new OA\Schema(
            type: 'string',
        )
    )]
    #[OA\Parameter(
        name: 'ville',
        description: 'city of client',
        in: 'query',
        schema: new OA\Schema(
            type: 'string',
        )
    )]
    #[OA\Response(response: '200', description: 'Successful operation')]
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Client::class);
        $client = new Client();
        $client->nom = $request->nom;
        $client->prenom = $request->prenom;
        $client->adresse = $request->adresse;
        $client->code_postal = $request->code_postal;
        $client->ville = $request->ville;
        $client->valide = true;

        $client->save();
    }

    #[OA\Get(
        path: '/api/client/{id}',
        description: 'Get a specific client.',
        tags: ['Client']
    )]
    #[OA\Response(response: '200', description: 'Successful operation')]
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $client = Client::findOrFail($id);
        return response()->json([
            'status' => true,
            'message' => "Salle details retrieved successfully",
            'client' => $client
        ], 200);
    }

    #[OA\Put(
        path: '/api/client/{id}',
        description: 'Update a specific client.',
        tags: ['Client']
    )]
    #[OA\Parameter(
        name: 'client id',
        description: 'ID of client',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Parameter(
        name: 'client',
        description: 'ID of client',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer')

    )]
    #[OA\Parameter(
        name: 'nom',
        description: 'firstname of client',
        in: 'query',
        schema: new OA\Schema(
            type: 'string',
        )
    )]
    #[OA\Parameter(
        name: 'prenom',
        description: 'lastname of client',
        in: 'query',
        schema: new OA\Schema(
            type: 'string',
        )
    )]
    #[OA\Parameter(
        name: 'adresse',
        description: 'adresse of client',
        in: 'query',
        schema: new OA\Schema(
            type: 'string',
        )
    )]
    #[OA\Parameter(
        name: 'code_postal',
        description: 'code postal of client',
        in: 'query',
        schema: new OA\Schema(
            type: 'string',
        )
    )]
    #[OA\Parameter(
        name: 'ville',
        description: 'city of client',
        in: 'query',
        schema: new OA\Schema(
            type: 'string',
        )
    )]

    #[OA\Response(response: '200', description: 'Successful operation')]
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $client = Client::findOrFail($id);
        $this->authorize('update', $client);
        $client->update($request->all());

        return response()->json([
            'status' => true,
            'message' => "Salle updated successfully",
            'client' => $client
        ], 200);
    }

    #[OA\Delete(
        path: '/api/client/{id}',
        description: 'Delete a specific client.',
        tags: ['Client']
    )]
    #[OA\Parameter(
        name: 'client id',
        description: 'ID of client',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Response(response: '200', description: 'Successful operation')]
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = Client::findOrFail($id);
        $this->authorize('delete', $client);
        $client->valide=false;
        $client->save();

        return response()->json([
            'status' => true,
            'message' => "Salle deleted successfully",
            'client' => $client
        ], 200);
    }
}
