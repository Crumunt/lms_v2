<?php

namespace Database\Factories;

use App\UserStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserDetails>
 */
class UserDetailsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'full_name' => fake()->name(),
            'address' => fake()->address(),
            'status' => fake()->randomElement(UserStatus::cases())->value, // or use ->randomElement(['pending', 'active', ...])
        ];
    }
}
