<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompteRessource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'numeroCompte' => $this->numero_compte,
            'titulaire' => $this->client->prenom . ' ' . $this->client->nom,
            'telephone' => $this->client->telephone,
            'cni' => $this->client->cni,
            'type' => $this->type,
            'solde' =>   0,
            'statut' => $this->statut,

            'devise' => 'FCFA',
            "plafond" => $this->plafond,
            'dateCreation' => $this->created_at->toIso8601String(),
            'metadata' => [
                'derniereModification' => $this->updated_at->toIso8601String(),
                'version' => 1,
            ]
        ];

        // if ($this->statut === 'bloque') {
        //     $data['motifBlocage'] = $this->motif_blocage;
        //     $data['dateDebutBlocage'] = $this->date_debut_blocage;
        //     $data['dateFinBlocage'] = $this->date_fin_blocage;
        // }

        return $data;
    }
}
