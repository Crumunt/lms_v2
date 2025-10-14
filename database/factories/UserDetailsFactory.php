<?php

namespace Database\Factories;

use App\Models\UserDetails;
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

    protected $model = UserDetails::class;
    public function definition(): array
    {
        return [
            'user_id' => null,
            'full_name' => fake()->name(),
            'address' => fake()->address(),
            'status' => fake()->randomElement(UserStatus::cases())->value, // or use ->randomElement(['pending', 'active', ...])
        ];
    }
}
