<?php

namespace Database\Factories;

use App\Constant\TshirtEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Walker>
 */
class WalkerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'registration_id' => rand(1, 9999),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'city' => fake()->city(),
            'country' => fake()->country(),
            'date_of_birth' => fake()->date(),
            'gdpr_accepted' => fake()->boolean(1),
        ];
    }
}
