<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Compte;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompteControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_creates_compte_successfully()
    {
        $data = [
            'client' => [
                'nom' => 'Doe',
                'prenom' => 'John',
                'adresse' => '123 Main St',
                'telephone' => '771234567',
                'cni' => '1234567890123',
                'code_secret' => '1234'
            ],
            'type' => 'client'
        ];

        $response = $this->postJson('/api/v1/comptes', $data);

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'compte creer avec succes'
                 ]);

        $this->assertDatabaseHas('clients', [
            'nom' => 'Doe',
            'prenom' => 'John',
            'telephone' => '771234567',
            'code_secret' => '1234'
        ]);

        $this->assertDatabaseHas('comptes', [
            'type' => 'client',
            'statut' => 'actif'
        ]);
    }

    public function test_store_returns_existing_compte_if_client_already_has_one()
    {
        $client = Client::create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'nom' => 'Doe',
            'prenom' => 'John',
            'telephone' => '771234567',
            'cni' => '1234567890123',
            'adresse' => '123 Main St',
            'code_secret' => '1234'
        ]);

        $compte = Compte::create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'numero_compte' => '123456789',
            'type' => 'client',
            'statut' => 'actif',
            'client_id' => $client->id,
            'plafond' => false
        ]);

        $data = [
            'client' => [
                'nom' => 'Doe',
                'prenom' => 'John',
                'adresse' => '123 Main St',
                'telephone' => '771234567',
                'cni' => '1234567890123',
                'code_secret' => '1234'
            ],
            'type' => 'client'
        ];

        $response = $this->postJson('/api/v1/comptes', $data);

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'compte creer avec succes'
                 ]);

        $this->assertDatabaseCount('comptes', 1);
    }
}