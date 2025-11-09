<?php
namespace App\Repositories;

interface IRepositoryCompte extends IRepository{
    public function  create(array $data);
    public function findByClient(string $client_id);
}