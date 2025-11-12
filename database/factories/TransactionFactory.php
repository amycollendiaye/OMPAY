<?php

namespace Database\Factories;

use App\Models\Compte;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => (string) Str::uuid(),
            'type' => $this->faker->randomElement(['paiement', 'transfert']),
            'montant' => $this->faker->randomFloat(2, 1000, 500000),
            'date_transaction' => now(),
            'numero_reference' => 'REF-' . strtoupper(Str::random(8)),
            'code_marchand' => $this->faker->optional()->numerify('MCH-###'),
            'compte_emetteur_id' => Compte::inRandomOrder()->first()?->id,
            'compte_beneficiaire_id' => Compte::inRandomOrder()->first()?->id,
            'statut' => $this->faker->randomElement(['valide', 'en_attente', 'annule']),
            'archive'=>false,
        ];
    }
}
