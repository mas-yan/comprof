<?php

namespace Database\Seeders;

use App\Models\GalleryImage;
use Database\Seeders\Concerns\SeedsSampleImages;
use Illuminate\Database\Seeder;

class GalleryImageSeeder extends Seeder
{
    use SeedsSampleImages;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $captions = [
            'Kantor Pusat Kami',
            'Suasana Tim Bekerja',
            'Diskusi Bersama Klien',
            'Ruang Kolaborasi Tim',
            'Acara Perusahaan',
        ];

        foreach ($captions as $index => $caption) {
            GalleryImage::factory()->create([
                'image' => $this->copySampleImage('gallery'),
                'caption' => $caption,
                'is_active' => true,
                'sort_order' => $index,
            ]);
        }
    }
}
