<?php

namespace App\Repositories;

use App\Models\Client;

class ClientRepository  implements IRepositoryClient
{


    public function findById(string $id): ?Client
    {
        // Cherche le client dans la table clients
        return Client::where('id', $id)->first();
    }
    public function create(array $data)
    {
        return  Client::create($data);
    }
    public function findByTelephone(string $telephone)
    {
        return Client::where('telephone', $telephone)->first();
    }
}
