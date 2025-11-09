<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Compte;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $client = Client::factory()->create();

        Compte::factory()->create([
            'client_id' => $client->id
        ]);
    }
}
