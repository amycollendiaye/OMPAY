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

        $token = $client->createToken('API Token')->accessToken;

        return response()->json([
            'token' => $token,
            'user' => [
                "nom" => $client->nom,
                "prenom" =>  $client->prenom,
                "nin" =>   $client->nin,
                "adresse" => $client->adresse,
                "qr_code" =>  $client->qr_code,



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
