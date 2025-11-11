<?php

namespace App\Services;

use App\Events\CreateCompte;
use App\Repositories\CompteRepository;
use App\Repositories\IRepository;
use App\Repositories\IRepositoryClient;
use App\Repositories\IRepositoryCompte;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CompteService
{
    protected $repoCompte;
    protected $repoClient;

    public function __construct(IRepositoryCompte $repoCompte, IRepositoryClient $repoClient)
    {
        $this->repoCompte = $repoCompte;
        $this->repoClient = $repoClient;
    }
  
public function create(array $data)
{
    return DB::transaction(function () use ($data) {
        // Rechercher ou créer le client
        $client = $this->repoClient->findByTelephone($data['client']['telephone']);
        if (!$client) {
            Log::info('Création d’un nouveau client', $data['client']);

            $client = $this->repoClient->create([
                'nom' => $data['client']['nom'],
                'prenom' => $data['client']['prenom'],
                'telephone' => $data['client']['telephone'],
                'cni' => $data['client']['cni'],
                'adresse' => $data['client']['adresse'],
                'code_secret' => $data['client']['code_secret'],
            ]);
        } else {
            // Vérifier si le client a déjà un compte
            $existingCompte = $this->repoCompte->findByClient($client->id);
            if ($existingCompte) {
                throw new \Exception('Le client a déjà un compte actif.');
            }
        }

        //  Créer le compte pour le client
        Log::info('Création d’un nouveau compte pour le client.');

        $compte = $this->repoCompte->create([
            'client_id' => $client->id,
            'type' => $data['type'],
            'statut' => 'actif',
            'plafond' => false
        ]);
        Log::info('TWILIO_SID: ' . env('TWILIO_SID'));
Log::info('TWILIO_TOKEN: ' . env('TWILIO_TOKEN'));
Log::info('TWILIO_FROM: ' . env('TWILIO_FROM'));

        // Déclencher l'événement après la création du compte
        event(new CreateCompte($compte, $client));

        return $compte;
    });
}

}
