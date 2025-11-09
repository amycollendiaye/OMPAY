<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Compte>
 */
class CompteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => Str::uuid(),
            'numero_compte' => strtoupper('CPT-' . $this->faker->unique()->numerify('########')),
            'type' => $this->faker->randomElement(['client', 'distributeur']),
            'statut' => $this->faker->randomElement(['actif', 'suspendu']),
            'date_creation' => now()->toDateString(),
            'plafond' => $this->faker->boolean(),
            'client_id' => null,
        ];
    }
}
