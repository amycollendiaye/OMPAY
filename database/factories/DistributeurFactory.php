<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Distributeur>
 */
class DistributeurFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => $this->faker->company(),
            'telephone' => $this->faker->unique()->phoneNumber(),
            'adresse' => $this->faker->address(),
            'code_secret' => $this->faker->password(4, 4),
            'code_marchand' => $this->faker->unique()->randomNumber(8),
        ];
    }
}
