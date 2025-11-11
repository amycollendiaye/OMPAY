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
        $isListing = !isset($this->additional['client']); // Si pas de additional, c'est une liste

        if ($isListing) {
            return [
                'id' => $this->id,
                'type' => $this->type,
                'montant' => $this->montant,
                'code_marchand' => $this->code_marchand,
                'date_transaction' => $this->date_transaction,
                'numero_reference' => $this->numero_reference,
                'emetteur' => $this->compteEmetteur ? [
                    'nom' => $this->compteEmetteur->client->nom,
                    'prenom' => $this->compteEmetteur->client->prenom,
                    'telephone' => $this->compteEmetteur->client->telephone,
                ] : null,
                'beneficiaire' => $this->compteBeneficiaire ? [
                    'type' => $this->compteBeneficiaire->client ? 'client' : 'distributeur',
                    'nom' => $this->compteBeneficiaire->client ? $this->compteBeneficiaire->client->nom : $this->compteBeneficiaire->distributeur->nom,
                    'prenom' => $this->compteBeneficiaire->client ? $this->compteBeneficiaire->client->prenom : null,
                    'telephone' => $this->compteBeneficiaire->client ? $this->compteBeneficiaire->client->telephone : $this->compteBeneficiaire->distributeur->telephone,
                    'code_marchand' => $this->compteBeneficiaire->distributeur->code_marchand ?? null,
                ] : null,
            ];
        }

        // Pour les détails après création
        $client = $this->additional['client'] ?? null;
        $destinataire = $this->additional['destinataire'] ?? null;
        $soldeAvant = $this->additional['solde_avant'] ?? null;
        $soldeApres = $this->additional['solde_apres'] ?? null;

        return [
            'transaction' => [
                'id' => $this->id,
                'type' => $this->type,
                'montant' => $this->montant,
                'code_marchand' => $this->code_marchand,
                'date_transaction' => $this->date_transaction,
                'numero_reference' => $this->numero_reference,
            ],
            'client' => $client ? [
                'nom' => $client->nom,
                'telephone' => $client->telephone,
                'solde_avant' => $soldeAvant,
                'solde_apres' => $soldeApres,
            ] : null,
            'destinataire' => $destinataire ? [
                'type' => $destinataire instanceof \App\Models\Client ? 'client' : 'distributeur',
                'nom' => $destinataire->nom,
                'prenom' => $destinataire->prenom ?? null,
                'telephone' => $destinataire->telephone,
                'code_marchand' => $destinataire->code_marchand ?? null,
            ] : null,
        ];
    }
}
