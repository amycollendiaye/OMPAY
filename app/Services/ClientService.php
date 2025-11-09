<?php

namespace App\Services;

use App\Repositories\IRepository;
use App\Repositories\IRepositoryClient;

class ClientService
{
    protected $repoClient;
    public function __construct(IRepositoryClient $repoClient)
    {
        $this->repoClient = $repoClient;
    }
    public function create(array $data)
    {
        return $this->repoClient->create($data);
    }
    public function findById(string $id)
    {
        return $this->repoClient->findById($id);
    }
}
