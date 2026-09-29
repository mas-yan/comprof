<?php

namespace Database\Seeders\Concerns;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

trait SeedsSampleImages
{
    /**
     * The sample image already uploaded on the public disk, used as a stand-in
     * for demo images across seeded records.
     */
    protected string $sampleImagePath = 'services/01M33YQB4HD1GMJFHKRTK61M8Y.png';

    /**
     * Copy the sample image into the given directory under a fresh filename
     * and return the new disk path.
     */
    protected function copySampleImage(string $directory): string
    {
        if (! Storage::disk('public')->exists($this->sampleImagePath)) {
            throw new RuntimeException(
                "Sample image not found at storage/app/public/{$this->sampleImagePath}. Upload a file there first before running this seeder."
            );
        }

        $destination = trim($directory, '/').'/'.Str::ulid().'.png';

        Storage::disk('public')->copy($this->sampleImagePath, $destination);

        return $destination;
    }
}
