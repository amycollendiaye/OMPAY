<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    public function toArray($request)
    {
        $client = $this->additional['client'] ?? null;
        $destinataire = $this->additional['destinataire'] ?? null;
        $soldeAvant = $this->additional['solde_avant'] ?? null;
        $soldeApres = $this->additional['solde_apres'] ?? null;

        return [
            'message' => 'Paiement effectué avec succès ',

            'transaction' => [
                'id' => $this->id,
                'type' => $this->type,
                'montant' => $this->montant,
                'code_marchand' => $this->code_marchand,
                'date_transaction' => $this->date_transaction,
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
