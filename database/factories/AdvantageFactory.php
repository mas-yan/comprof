<?php

namespace Database\Factories;

use App\Models\Advantage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Advantage>
 */
class AdvantageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->words(3, true),
            'icon' => $this->faker->randomElement(['shield-check', 'bolt', 'users', 'clock', 'currency-dollar', 'star', 'chat-bubble']),
            'description' => $this->faker->sentence(12),
            'is_active' => true,
            'sort_order' => 0,
        ];
    }
}
