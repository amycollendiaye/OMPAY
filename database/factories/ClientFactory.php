<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
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
            "nom"=>fake()->name(),
            "prenom"=>fake()->lastName(),
            'telephone' => $this->faker->phoneNumber(),
            'adresse' => $this->faker->address(),
            'cni' => strtoupper(Str::random(10)),
            "code_secret"=>1611,
            

        ];
    }
}
