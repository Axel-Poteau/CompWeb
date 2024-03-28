<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

//use App\Http\Requests\UserRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use OpenApi\Attributes as OA;

class AuthController extends Controller {
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    #[OA\Post(
        path: "/login",
        operationId: "login",
        description: "Connexion à l'application",
        security: [],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(properties: [
                new OA\Property(property: 'email', type: 'string'),
                new OA\Property(property: 'password', type: 'string'),
            ]),
        ),
        tags: ["Auth"],
        responses: [
            new OA\Response(response: 200,
                description: "Connexion",
                content: new OA\JsonContent(properties: [
                    new OA\Property(property: "status", type: "string"),
                    new OA\Property(property: "user", ref: "#/components/schemas/User", type: "object"),
                    new OA\Property(property: "authorisation", properties: [
                        new OA\Property(property: 'token', type: 'string'),
                        new OA\Property(property: 'type', type: 'string')
                    ], type: "object")
                ], type: "object")),
            new OA\Response(response: 401,
                description: "Connexion invalide",
                content: new OA\JsonContent(properties: [
                    new OA\Property(property: "status", type: "string"),
                    new OA\Property(property: "message", type: "string"),
                ], type: "object")),
            new OA\Response(response: 422,
                description: "Connexion avec information invalide",
                content: new OA\JsonContent(properties: [
                    new OA\Property(property: "message", type: "string"),
                    new OA\Property(property: "error", properties: [
                        new OA\Property(property: "message", type: "array", items: new OA\Items(type: 'string'))
                    ], type: "object"),
                ], type: "object"))
        ]
    )]
    public function login(Request $request) {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:6',
        ], [
            'required' => 'Le champ :attribute est obligatoire',
            'email' => 'L\'adresse mail n\'est pas correcte',
            'min' => 'Le champ :attribute doit contenir au minimum :min caractères.',
        ]);
        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
            'status' => 'success',
            'user' => new UserResource($user),
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    #[OA\Post(
        path: "/register",
        operationId: "register",
        description: "Enregistrement d'un utilisateur à l'application",
        security: [],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(properties: [
                new OA\Property(property: 'name', type: 'string'),
                new OA\Property(property: 'email', type: 'string'),
                new OA\Property(property: 'password', type: 'string'),
            ]),
        ),
        tags: ["Auth"],
        responses: [
            new OA\Response(response: 200,
                description: "Connexion",
                content: new OA\JsonContent(properties: [
                    new OA\Property(property: "status", type: "string"),
                    new OA\Property(property: "message", type: "string"),
                    new OA\Property(property: "user", ref: "#/components/schemas/User", type: "object"),
                    new OA\Property(property: "authorisation", properties: [
                        new OA\Property(property: 'token', type: 'string'),
                        new OA\Property(property: 'type', type: 'string')
                    ], type: "object")
                ], type: "object")),
            new OA\Response(response: 422,
                description: "Connexion avec information invalide",
                content: new OA\JsonContent(properties: [
                    new OA\Property(property: "message", type: "string"),
                    new OA\Property(property: "error", properties: [
                        new OA\Property(property: "message", type: "array", items: new OA\Items(type: 'string'))
                    ], type: "object"),
                ], type: "object"))

        ]
    )]
    public function register(UserRequest $request) {
        DB::beginTransaction();
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $roleVisiteur = Role::where('nom', Role::VISITEUR)->first();
        $user->roles()->attach([$roleVisiteur->id]);
        $token = auth()->tokenById($user->id);
        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => new UserResource($user),
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    #[OA\Post(
        path: "/logout",
        operationId: "logout",
        description: "déconnexion d'un utilisateur à l'application",
        security: [["bearerAuth" => ['role' => 'visiteur']],],
        tags: ["Auth"],
        responses: [
            new OA\Response(response: 200,
                description: "Déconnexion valide",
                content: new OA\JsonContent(properties: [
                    new OA\Property(property: "status", type: "string"),
                    new OA\Property(property: "message", type: "string"),
                ])
            ),
            new OA\Response(response: 401,
                description: "Déconnexion invalide",
                content: new OA\JsonContent(properties: [
                    new OA\Property(property: "message", type: "string"),
                ]))
        ]
    )]
    public function logout() {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    #[OA\Post(
        path: "/refresh",
        operationId: "refresh",
        description: "Récupère un nouveau token",
        security: [["bearerAuth" => []],],
        tags: ["Auth"],
        responses: [
            new OA\Response(response: 200,
                description: "Refresh Valide",
                content: new OA\JsonContent(properties: [
                    new OA\Property(property: "status", type: "string"),
                    new OA\Property(property: "user", ref: "#/components/schemas/User", type: "object"),
                ], type: "object")),

            new OA\Response(response: 401,
                description: "Refresh invalide",
                content: new OA\JsonContent(properties: [
                    new OA\Property(property: "message", type: "string"),
                ]))
        ]
    )]
    public function refresh() {
        return response()->json([
            'status' => 'success',
            'user' => new UserResource(Auth::user()),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

    #[OA\Post(
        path: "/me",
        operationId: "me",
        description: "Information sur l'utilisateur connecté",
        security: [["bearerAuth" => []],],
        tags: ["Auth"],
        responses: [
            new OA\Response(response: 200,
                description: "Utilisateur connecté",
                content: new OA\JsonContent(properties: [
                    new OA\Property(property: "status", type: "string"),
                    new OA\Property(property: "user", ref: "#/components/schemas/User", type: "object"),
                ], type: "object")),
            new OA\Response(response: 401,
                description: "Utilisateur invalide",
                content: new OA\JsonContent(properties: [
                    new OA\Property(property: "message", type: "string"),
                ]))
        ]
    )]
    public function me() {
        return response()->json([
            'status' => 'success',
            'user' => new UserResource(Auth::user()),
        ]);
    }
}
