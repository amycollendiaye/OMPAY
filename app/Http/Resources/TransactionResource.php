<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="TransactionResource",
 *     type="object",
 *     title="TransactionResource",
 *     description="Ressource représentant une transaction"
 * )
 */

class TransactionResource extends JsonResource
{
   public function toArray($request)
{
    return [
        'date_transaction' => $this->date_transaction,
        'montant' => $this->montant,
        'numero_reference' => $this->numero_reference,
        'type' => $this->type,
        'telephone_emetteur' => $this->compteEmetteur->client->telephone ?? null,
        'telephone_beneficiaire' => $this->compteBeneficiaire->client
            ? $this->compteBeneficiaire->client->telephone
            : $this->compteBeneficiaire->distributeur->telephone ?? null,
    ];
}

}
