<?php

namespace App\Http\Controllers;

use App\Services\TransactionPayementService;
use App\Services\TransactionTransfertService;
use Illuminate\Http\Request;
use App\Http\Resources\TransactionResource;
use App\Traits\ApiResponse;

/**
 * @OA\Tag(
 *     name="Paiements",
 *     description="API pour les paiements vers les clients ou distributeurs"
 * )
 */

class TransactionPayementControlle extends Controller
{
    use     ApiResponse;
    protected $payementService;
    public  function __construct(TransactionPayementService $payementService)
    {
        $this->payementService = $payementService;
    }
    /**
     * @OA\Post(
     *     path="/api/v1/transactions/pay",
     *     tags={"Paiements"},
     *     summary="Effectuer un paiement",
     *     description="Permet à un client d'effectuer un paiement vers un autre client (via numéro de téléphone) ou vers un distributeur (via numéro de téléphone ou code marchand)",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"recipient","montant"},
     *             @OA\Property(property="recipient", type="string", description="Numéro de téléphone (commence par 7 ou 8) ou code marchand du destinataire"),
     *             @OA\Property(property="montant", type="number", format="float", description="Montant du paiement", minimum=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Paiement effectué avec succès",
     *         @OA\MediaType(
     *             mediaType="text/plain",
     *             @OA\Schema(
     *                 type="string",
     *                 example="Client: John Doe\nSolde avant: 10000 FCFA\nDistributeur: Simonis LLC (Code: 19823394)\nPaiement réussi!\nSolde après: 9500 FCFA\nTransaction créée:\n- ID: uuid-transaction\n- Type: paiement\n- Montant: 500.00\n- Code marchand: 19823394\n- Émetteur: uuid-emetteur\n- Bénéficiaire: uuid-beneficiaire"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Non autorisé"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
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
     *                 example="Erreur: Code marchand '123456' introuvable."
     *             )
     *         )
     *     )
     * )
     */

    public function paiement(Request $request)
    {
        $validated = $request->validate([
            'recipient' => 'required|string',
            'montant' => 'required|numeric|min:1',
        ]);

        // Déterminer le type basé sur le destinataire
        $type = (str_starts_with($validated['recipient'], '7') || str_starts_with($validated['recipient'], '8')) ? 'telephone' : 'code_marchand';

        $compte = auth()->user()->compte;
        $this->authorize('pay', $compte);

        $data = $this->payementService->payAndGetDetails(
            $compte,
            $validated['recipient'],
            $validated['montant'],
            $type
        );
        $transaction = (new TransactionResource($data['transaction']))
            ->additional([
                'client' => $data['client'],
                'destinataire' => $data['destinataire'],
                'solde_avant' => $data['solde_avant'],
                'solde_apres' => $data['solde_apres'],
            ]);
        return  $this->successResponse('Transfert effectué avec succès', $transaction, 200);
    }
}
