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
            'numero_reference' => $this->numero_reference,
            'date_transaction' => $this->date_transaction,
            'montant' => $this->montant,
            'solde_apres' => $this->additional['solde_apres'] ?? null,
            'type' => $this->type,

            
                'telephone' => $this->compteEmetteur->client->telephone ?? null,
            

                'Beneficiaire' => $this->compteBeneficiaire->client
                    ? $this->compteBeneficiaire->client->telephone
                    : $this->compteBeneficiaire->distributeur->telephone ?? null,
        ];
    }
}
