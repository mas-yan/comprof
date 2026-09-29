<?php

namespace Database\Factories;

use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Testimonial>
 */
class TestimonialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'position' => $this->faker->jobTitle(),
            'avatar' => null,
            'rating' => 5,
            'content' => $this->faker->paragraph(3),
            'is_active' => true,
            'sort_order' => 0,
        ];
    }
}
