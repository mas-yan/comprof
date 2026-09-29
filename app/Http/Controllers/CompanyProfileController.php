<?php

namespace App\Http\Controllers;

use App\Models\Advantage;
use App\Models\CompanyProfile;
use App\Models\Customer;
use App\Models\Faq;
use App\Models\GalleryImage;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CompanyProfileController extends Controller
{
    public function index(): View
    {
        $profile = CompanyProfile::latest()->first();

        $galleryImages = GalleryImage::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $services = Service::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $advantages = Advantage::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $customers = Customer::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $testimonials = Testimonial::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $faqs = Faq::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('company-profile.show', [
            'profile' => $profile,
            'galleryImages' => $galleryImages,
            'services' => $services,
            'advantages' => $advantages,
            'customers' => $customers,
            'testimonials' => $testimonials,
            'faqs' => $faqs,
            'metaTitle' => $profile ? "{$profile->name} - Profil Perusahaan" : config('app.name'),
            'metaDescription' => $profile?->description
                ? Str::limit(strip_tags($profile->description), 160)
                : 'Profil perusahaan.',
            'jsonLd' => $profile ? $this->organizationJsonLd($profile) : null,
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    protected function organizationJsonLd(CompanyProfile $profile): array
    {
        return array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => $profile->name,
            'description' => $profile->description,
            'url' => url('/'),
            'logo' => $profile->logo_url,
            'email' => $profile->email,
            'telephone' => $profile->phone,
            'address' => $profile->address ? [
                '@type' => 'PostalAddress',
                'streetAddress' => $profile->address,
            ] : null,
            'sameAs' => array_values(array_filter([
                $profile->facebook_url,
                $profile->instagram_url,
                $profile->x_url,
            ])) ?: null,
        ]);
    }
}
