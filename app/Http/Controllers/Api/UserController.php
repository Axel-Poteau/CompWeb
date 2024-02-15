<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use OpenApi\Attributes as OA;

class UserController extends Controller {
    #[OA\Delete(
        path: "/users/{id}",
        operationId: "destroy-user",
        description: "Supprime un utilisateur",
        security: [["bearerAuth" => ["role" => "admin"]],],
        tags: ["Users"],
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "Identifiant de l'utilisateur",
                in: "path", required: "true",
                schema: new OA\Schema(type: "integer", format: 'int64'))
        ],
        responses: [
            new OA\Response(response: 200,
                description: "Supprime un utilisateur",
                content: new OA\JsonContent(properties: [
                    new OA\Property(property: "status", type: "boolean"),
                    new OA\Property(property: "message", type: "string"),
                ], type: "object")
            ),
            new OA\Response(response: 401, description: "Non autorisé",
                content: new OA\JsonContent(properties: [
                    new OA\Property(property: "message", type: "string"),
                    ], type: "object")),
            new OA\Response(response: 404, description: "Utilisateur non trouvée",
                content: new OA\JsonContent(properties: [
                    new OA\Property(property: "message", type: "string"),
                ], type: "object"))
        ]
    )]
    public function destroy(string $id) {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json([
            'status' => true,
            'message' => "User Destroyed successfully!",
        ], 200);
    }
}
