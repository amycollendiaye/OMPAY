<?php

namespace App\Repositories;

use App\Models\Client;
use App\Models\Compte;

class CompteRepository  implements IRepositoryCompte
{

    public function findByClient(string $client_id)
    {
        return Compte::where('client_id', $client_id)->first();
    }

    public function create(array $data)

    {
        $exits = $this->findByClient($data["client_id"]);
        if ($exits) {
            return $exits;
        }
        return  Compte::create($data);
    }
}
