<?php
namespace App\Repositories;

interface IRepositoryClient extends IRepository
{
         public function findById(string $id);
         public function findByTelephone(string $telephone);

}