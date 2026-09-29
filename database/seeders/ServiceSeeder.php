<?php

namespace Database\Seeders;

use App\Models\Service;
use Database\Seeders\Concerns\SeedsSampleImages;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    use SeedsSampleImages;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name' => 'Konsultasi IT',
                'description' => 'Membantu bisnis Anda menentukan strategi dan arsitektur teknologi yang tepat sesuai kebutuhan dan anggaran.',
                'price' => 'Hubungi Kami',
            ],
            [
                'name' => 'Pengembangan Aplikasi Web',
                'description' => 'Membangun aplikasi web yang cepat, aman, dan mudah dikembangkan menggunakan teknologi terkini.',
                'price' => 'Mulai Rp 15.000.000',
            ],
            [
                'name' => 'Pengembangan Aplikasi Mobile',
                'description' => 'Membuat aplikasi mobile Android & iOS yang responsif dan siap diluncurkan ke Play Store maupun App Store.',
                'price' => 'Mulai Rp 20.000.000',
            ],
            [
                'name' => 'Cloud & DevOps',
                'description' => 'Migrasi, konfigurasi, dan otomatisasi infrastruktur cloud agar sistem Anda lebih andal dan mudah diskalakan.',
                'price' => 'Mulai Rp 8.000.000',
            ],
            [
                'name' => 'UI/UX Design',
                'description' => 'Merancang antarmuka yang intuitif dan pengalaman pengguna yang menyenangkan untuk produk digital Anda.',
                'price' => 'Mulai Rp 5.000.000',
            ],
            [
                'name' => 'Maintenance & Support',
                'description' => 'Dukungan berkelanjutan untuk memastikan sistem Anda tetap berjalan optimal, aman, dan terupdate.',
                'price' => 'Mulai Rp 2.000.000/bulan',
            ],
        ];

        foreach ($services as $index => $service) {
            Service::factory()->create([
                'name' => $service['name'],
                'image' => $this->copySampleImage('services'),
                'description' => $service['description'],
                'price' => $service['price'],
                'is_active' => true,
                'sort_order' => $index,
            ]);
        }
    }
}
