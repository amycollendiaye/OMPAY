<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCompte;
use App\Http\Resources\CompteRessource;
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
 *     url="http://127.0.0.1:8000",
 *     description="Serveur de production"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
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
}
