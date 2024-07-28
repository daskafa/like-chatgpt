<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserPremium>
 */
class UserPremiumFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'device_uuid' => fake()->uuid(),
            'product_id' => fake()->uuid(),
            'remaining_chat_credit' => fake()->numberBetween(1, 100),
            'receipt_token' => fake()->words(3, true),
            'is_active' => true,
        ];
    }
}
