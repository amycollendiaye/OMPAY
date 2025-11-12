<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCompte;
use App\Http\Resources\CompteRessource;
use App\Models\Compte;
use App\Services\CompteService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Stmt\Return_;

/**
 * @OA\Info(
 *     title="OMPAY API",
 *     version="1.0.0",
 *     description="API pour la gestion des comptes OMPAY"
 * )
 *
 * @OA\Server(
 *     url="http://localhost:8000",
 *     description="Serveur de production"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 *
 * @OA\Security(
 *     {"bearerAuth": {}}
 * )
 */
class CompteController extends Controller
{
    use ApiResponse;
    protected  CompteService $serviceCompte;
    public function __construct(CompteService $serviceCompte)
    {
        $this->serviceCompte = $serviceCompte;
    }
    // ArchiveTransactionsJob::dispatch();


    /**
     * @OA\Post(
     *     path="/api/v1/comptes",
     *     summary="Créer un nouveau compte",
     *     description="Crée un nouveau compte bancaire pour un client. Si le client n'existe pas, il sera créé automatiquement.",
     *     operationId="createCompte",
     *     tags={"Comptes"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"client","type"},
     *             @OA\Property(
     *                 property="client",
     *                 type="object",
     *                 description="Informations du client",
     *                 @OA\Property(property="nom", type="string", example="Doe", description="Nom du client"),
     *                 @OA\Property(property="prenom", type="string", example="John", description="Prénom du client"),
     *                 @OA\Property(property="adresse", type="string", example="123 Main St", description="Adresse du client"),
     *                 @OA\Property(property="telephone", type="string", example="771234567", description="Numéro de téléphone"),
     *                 @OA\Property(property="cni", type="string", example="1234567890123", description="Numéro CNI"),
     *                 @OA\Property(property="code_secret", type="string", example="1234", description="Code secret")
     *             ),
     *             @OA\Property(
     *                 property="type",
     *                 type="string",
     *                 enum={"client", "distributeur"},
     *                 example="client",
     *                 description="Type de compte"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Compte créé avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="compte creer avec succes"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="string", example="uuid", description="ID unique du compte"),
     *                 @OA\Property(property="numeroCompte", type="string", example="123456789", description="Numéro du compte"),
     *                 @OA\Property(property="titulaire", type="string", example="John Doe", description="Nom complet du titulaire"),
     *                 @OA\Property(property="telephone", type="string", example="771234567", description="Téléphone du client"),
     *                 @OA\Property(property="cni", type="string", example="1234567890123", description="CNI du client"),
     *                 @OA\Property(property="type", type="string", example="client", description="Type de compte"),
     *                 @OA\Property(property="solde", type="number", example=0, description="Solde du compte"),
     *                 @OA\Property(property="statut", type="string", example="actif", description="Statut du compte"),
     *                 @OA\Property(property="devise", type="string", example="FCFA", description="Devise"),
     *                 @OA\Property(property="plafond", type="boolean", example=false, description="Plafond activé"),
     *                 @OA\Property(property="dateCreation", type="string", format="date-time", example="2025-11-09T10:00:00.000000Z"),
     *                 @OA\Property(
     *                     property="metadata",
     *                     type="object",
     *                     @OA\Property(property="derniereModification", type="string", format="date-time"),
     *                     @OA\Property(property="version", type="integer", example=1)
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Erreur de validation"),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(property="client.nom", type="array", @OA\Items(type="string", example="Le nom est obligatoire.")),
     *                 @OA\Property(property="client.telephone", type="array", @OA\Items(type="string", example="Le téléphone est invalide."))
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur serveur",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Erreur serveur"),
     *             @OA\Property(property="errors", type="string", nullable=true)
     *         )
     *     )
     * )
     */
    public function store(CreateCompte $request)
    {
        try {
            $validatedData = $request->validated();

            // Debug: Log the validated data
            Log::info('Validated data:', $validatedData);

            $compte =  $this->serviceCompte->create($validatedData);
            $compteRessource = new CompteRessource($compte);
            return $this->successResponse("compte creer avec succes", $compteRessource, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }

    }

    /**
     * @OA\Get(
     *     path="/api/v1/comptes/{numero}/solde",
     *     tags={"Comptes"},
     *     summary="Afficher le solde d’un compte",
     *     description="Retourne le solde actuel d’un compte à partir de son numéro de compte.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="numero",
     *         in="path",
     *         required=true,
     *         description="Numéro du compte (ex: OMPAY-732281)",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Solde du compte récupéré avec succès",
     *         @OA\JsonContent(
     *             example={
     *                 "status": "success",
     *                 "compte": {
     *                     "numero_compte": "OMPAY-732281",
     *                     "type": "client",
     *                     "solde": 10000
     *                 }
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Compte non trouvé",
     *         @OA\JsonContent(
     *             example={"status": "error", "message": "Compte non trouvé."}
     *         )
     *     )
     * )
     */
    public function getSolde($numero)
{
    // Récupérer le compte demandé
    $compte = Compte::where('numero_compte', $numero)->first();

    if (!$compte) {
        return response()->json([
            'status' => 'error',
            'message' => 'Compte non trouvé.'
        ], 404);
    }

    // Vérifier si l'utilisateur connecté peut voir ce compte
    $this->authorize('showSolde', $compte);

    return response()->json([
        'status' => 'success',
        'compte' => [
            'numero_compte' => $compte->numero_compte,
            'type' => $compte->type,
            'solde' => $compte->solde,
        ]
    ]);
}

    /**
     * @OA\Get(
     *     path="/api/v1/solde",
     *     tags={"Comptes"},
     *     summary="Afficher le solde du client connecté",
     *     description="Retourne le solde du compte du client authentifié.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Solde récupéré avec succès",
     *         @OA\JsonContent(
     *             example={
     *                 "status": "success",
     *                 "solde": 10000
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Non autorisé",
     *         @OA\JsonContent(
     *             example={"status": "error", "message": "Unauthenticated."}
     *         )
     *     )
     * )
     */
    public function getMySolde()
    {
        $compte = auth()->user()->compte;

        if (!$compte) {
            return response()->json([
                'status' => 'error',
                'message' => 'Aucun compte trouvé.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'solde' => $compte->solde,
        ]);
    }
}


