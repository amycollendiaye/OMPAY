<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiResponse;
    /**
     * @OA\Post(
     *     path="/api/v1/auth",
     *     summary="Authentification d'un client",
     *     description="Authentifie un client en utilisant uniquement son numéro de téléphone",
     *     operationId="login",
     *     tags={"Authentification"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"telephone"},
     *             @OA\Property(property="telephone", type="string", example="781030848", description="Numéro de téléphone du client")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Authentification réussie",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", example="Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9...", description="Token d'accès"),
     *             @OA\Property(
     *                 property="user",
     *                 type="object",
     *                 @OA\Property(property="id", type="string", example="uuid", description="ID du client"),
     *                 @OA\Property(property="nom", type="string", example="Doe", description="Nom du client"),
     *                 @OA\Property(property="prenom", type="string", example="John", description="Prénom du client"),
     *                 @OA\Property(property="telephone", type="string", example="771234567", description="Téléphone"),
     *                 @OA\Property(property="cni", type="string", example="1234567890123", description="CNI"),
     *                 @OA\Property(property="adresse", type="string", example="123 Main St", description="Adresse")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Authentification échouée",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthorized")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(property="telephone", type="array", @OA\Items(type="string", example="Le téléphone est obligatoire."))
     *             )
     *         )
     *     )
     * )
     */
    public function login(Request $request)
    {
        $request->validate([
            'telephone' => 'required|string'
        ]);

        $client = Client::where('telephone', $request->telephone)->first();

        if (!$client) {
            return $this->errorResponse("desole  mais vous n'est pas autorisé!!!!", 401);
        }

        $accessToken = $client->createToken('access_token', ['access'])->accessToken;
        $refreshToken = $client->createToken('refresh_token', ['refresh'])->accessToken;

        return $this->successResponse("connnexion reussi", [
            'token' => $accessToken,

            'refresh' => $refreshToken,
            'expires_in' => 900,


        ], 200);
    }
    /**
     * @OA\Get(
     *     path="/api/v1/me",
     *     summary="Récupérer les informations de l'utilisateur connecté",
     *     description="Retourne les informations de l'utilisateur authentifié",
     *     operationId="me",
     *     tags={"Authentification"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Informations de l'utilisateur, compte, solde et transactions",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(
     *                 property="user",
     *                 type="object",
     *                 @OA\Property(property="id", type="string", example="uuid", description="ID du client"),
     *                 @OA\Property(property="nom", type="string", example="Doe", description="Nom du client"),
     *                 @OA\Property(property="prenom", type="string", example="John", description="Prénom du client"),
     *                 @OA\Property(property="telephone", type="string", example="776598037", description="Téléphone"),
     *                 @OA\Property(property="cni", type="string", example="1234567890123", description="CNI"),
     *                 @OA\Property(property="adresse", type="string", example="123 Main St", description="Adresse"),
     *                 @OA\Property(property="qr_code", type="string", example="path/to/qr.png", description="QR Code"),
     *                 @OA\Property(property="password", type="string", description="Mot de passe (hashé)"),
     *                 @OA\Property(property="must_change_password", type="boolean", example=false, description="Doit changer le mot de passe")
     *             ),
     *             @OA\Property(
     *                 property="compte",
     *                 type="object",
     *                 @OA\Property(property="id", type="string", example="uuid", description="ID du compte"),
     *                 @OA\Property(property="numero_compte", type="string", example="123456789", description="Numéro de compte"),
     *                 @OA\Property(property="type", type="string", example="courant", description="Type de compte"),
     *                 @OA\Property(property="statut", type="string", example="actif", description="Statut du compte"),
     *                 @OA\Property(property="date_creation", type="string", format="date", example="2023-01-01", description="Date de création"),
     *                 @OA\Property(property="plafond", type="number", example=100000, description="Plafond du compte")
     *             ),
     *             @OA\Property(property="solde", type="number", example=15000, description="Solde actuel du compte"),
     *             @OA\Property(
     *                 property="transactions",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="string", example="uuid", description="ID de la transaction"),
     *                     @OA\Property(property="type", type="string", example="transfert", description="Type de transaction"),
     *                     @OA\Property(property="montant", type="number", example=5000, description="Montant de la transaction"),
     *                     @OA\Property(property="date_transaction", type="string", format="date-time", example="2023-01-01T12:00:00Z", description="Date de la transaction"),
     *                     @OA\Property(property="numero_reference", type="string", example="REF123", description="Numéro de référence"),
     *                     @OA\Property(property="code_marchand", type="string", example="MARCHAND001", description="Code marchand")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Token invalide",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     )
     * )
     */
   public function me(Request $request)
{
    $user = $request->user();
    $user->load(['compte.transactions']); // Charge le compte et ses transactions

    $compte = $user->compte;

    return response()->json([
        'status' => 'success',
        'user' => [
            'id' => $user->id,
            'nom' => $user->nom,
            'prenom' => $user->prenom ?? null,
            'cni' => $user->cni ?? null,
            'telephone' => $user->telephone,
            'adresse' => $user->adresse ?? null,

            // Infos du compte
            'compte' => $compte ? [
                'id' => $compte->id,
                'numero_compte' => $compte->numero_compte,
                'solde' => $compte->solde,
                'type' => $compte->type,
                'statut' => $compte->statut,
                'date_creation' => $compte->created_at,
            ] : null,

            // Infos des transactions associées
            'transactions' => $compte ? $compte->transactions->map(function ($t) {
                return [
                    'id' => $t->id,
                    'type' => $t->type,
                    'montant' => $t->montant,
                    'type' => $t->type,
                    'referennce' => $t->numero_reference,
                ];
            }) : [],
        ]
    ]);
}

    /**
     * @OA\Post(
     *     path="/api/v1/logout",
     *     summary="Déconnexion",
     *     description="Révoque le token d'accès actuel",
     *     operationId="logout",
     *     tags={"Authentification"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Déconnexion réussie",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Logged out")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Token invalide",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     )
     * )
     */
    //    public function refresh()
    // {
    //     try {
    //         $newToken = JWTAuth::parseToken()->refresh();
    //         return $this->successResponse("Token rafraîchi avec succès", [
    //             'access_token' => $newToken,
    //             'token_type' => 'bearer',
    //             'expires_in' => 30, // en secondes
    //         ], 200);
    //     } catch (JWTException $e) {
    //         return $this->errorResponse("Token invalide ou expiré", 401);
    //     } catch (\Exception $e) {
    //         return $this->errorResponse("Erreur lors du rafraîchissement du token", 500);
    //     }
    // }
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['message' => 'Logged out']);
    }
}
