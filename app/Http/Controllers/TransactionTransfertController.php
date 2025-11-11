<?php

namespace App\Http\Controllers;

use App\Http\Resources\TransactionResource;
use App\Models\Compte;
use App\Services\DestinataireCompte;
use App\Services\TransactionTransfertService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 * @OA\Tag(
 *     name="Transferts",
 *     description="API pour les transferts entre comptes"
 * )
 */
class TransactionTransfertController extends Controller
{
    use ApiResponse;
    protected $transfertService;
    protected $destinataireService;

    public function __construct(
        TransactionTransfertService $transfertService,
        DestinataireCompte $destinataireService
    ) {
        $this->transfertService = $transfertService;
        $this->destinataireService = $destinataireService;
    }



    /**
     * @OA\Post(
     *     path="/api/v1/transactions/transfer",
     *     tags={"Transferts"},
     *     summary="Effectuer un transfert",
     *     description="Permet à un client d'effectuer un transfert vers un autre client ou distributeur en utilisant le numéro de téléphone",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"destinataire_telephone","montant"},
     *             @OA\Property(property="destinataire_telephone", type="string", description="Numéro de téléphone du destinataire"),
     *             @OA\Property(property="montant", type="number", format="float", description="Montant du transfert", minimum=1)
     *         )
     *     ),
     *     @OA\Response(
      *         response=200,
      *         description="Transfert effectué avec succès",
      *         @OA\JsonContent(
      *             @OA\Property(property="success", type="boolean", example=true),
      *             @OA\Property(property="message", type="string", example="Transfert effectué avec succès"),
      *             @OA\Property(property="data", ref="#/components/schemas/TransactionResource")
      *         )
      *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Non autorisé"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Solde insuffisant"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Destinataire introuvable",
     *         @OA\MediaType(
     *             mediaType="text/plain",
     *             @OA\Schema(
     *                 type="string",
     *                 example="Erreur: Aucun destinataire trouvé avec le numéro '771234567'."
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
     public function transfert(Request $request)
    {
        $validated = $request->validate([
            'destinataire_telephone' => 'required|string',
            'montant' => 'required|numeric|min:1',
        ]);

        $emetteur = auth()->user()->compte;
        $this->authorize('transfer', $emetteur);

        $destinataireCompte = $this->destinataireService->resolveByTelephone($validated['destinataire_telephone']);

        if ($emetteur->id === $destinataireCompte->id) {
            throw ValidationException::withMessages([
                'destinataire' => 'Vous ne pouvez pas vous transférer de l’argent à vous-même.'
            ]);
        }

        $transaction = $this->transfertService->transfert(
            $emetteur,
            $destinataireCompte,
            $validated['montant']
        );

        $transaction = new TransactionResource($transaction);
        return  $this->successResponse('Transfert effectué avec succès', $transaction, 200);
    }
}

