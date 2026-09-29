<?php

namespace App\Models;

use Database\Factories\CompanyProfileFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CompanyProfile extends Model
{
    /** @use HasFactory<CompanyProfileFactory> */
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'logo',
        'hero_image',
        'description',
        'address',
        'phone',
        'email',
        'facebook_url',
        'instagram_url',
        'x_url',
        'whatsapp_number',
        'operating_hours',
    ];

    /**
     * The public URL of the logo, without disturbing the raw disk path
     * that Filament's FileUpload field relies on.
     */
    protected function logoUrl(): Attribute
    {
        return Attribute::make(
            get: fn (): ?string => $this->logo ? Storage::disk('public')->url($this->logo) : null,
        );
    }

    protected function heroImageUrl(): Attribute
    {
        return Attribute::make(
            get: fn (): ?string => $this->hero_image ? Storage::disk('public')->url($this->hero_image) : null,
        );
    }
}
