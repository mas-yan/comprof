<?php

namespace Database\Factories;

use App\Models\CompanyProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CompanyProfile>
 */
class CompanyProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'logo' => null,
            'description' => $this->faker->paragraphs(3, true),
            'address' => $this->faker->address(),
            'phone' => $this->faker->numerify('(0##) ###-####'),
            'email' => $this->faker->companyEmail(),
            'facebook_url' => $this->faker->url(),
            'instagram_url' => $this->faker->url(),
            'x_url' => $this->faker->url(),
            'whatsapp_number' => $this->faker->numerify('628##########'),
            'operating_hours' => 'Senin - Jumat, 08.00 - 17.00',
        ];
    }
}
