<?php

namespace Database\Seeders;

use App\Models\CompanyProfile;
use Database\Seeders\Concerns\SeedsSampleImages;
use Illuminate\Database\Seeder;

class CompanyProfileSeeder extends Seeder
{
    use SeedsSampleImages;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CompanyProfile::factory()->create([
            'name' => 'PT Sinergi Teknologi Indonesia',
            'logo' => $this->copySampleImage('company-profiles/logos'),
            'description' => "PT Sinergi Teknologi Indonesia adalah perusahaan teknologi yang berfokus pada pengembangan solusi digital untuk membantu bisnis bertumbuh. Sejak berdiri, kami telah dipercaya oleh berbagai klien dari berbagai industri untuk mewujudkan produk digital yang andal, aman, dan mudah digunakan.\n\nDidukung oleh tim yang berpengalaman, kami berkomitmen memberikan layanan terbaik mulai dari konsultasi, pengembangan, hingga dukungan purna jual.",
            'address' => "Jl. Sudirman No. 45, Lantai 8\nJakarta Selatan, DKI Jakarta 12190",
            'phone' => '(021) 555-0123',
            'email' => 'halo@sinergiteknologi.id',
            'facebook_url' => 'https://facebook.com/sinergiteknologi',
            'instagram_url' => 'https://instagram.com/sinergiteknologi',
            'x_url' => 'https://x.com/sinergiteknologi',
            'whatsapp_number' => '6281234567890',
            'operating_hours' => 'Senin - Jumat, 08.00 - 17.00 WIB',
        ]);
    }
}
