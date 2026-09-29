<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'image' => null,
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->boolean(70) ? 'Rp '.number_format($this->faker->numberBetween(50, 500) * 1000, 0, ',', '.') : null,
            'is_active' => true,
            'sort_order' => 0,
        ];
    }
}
