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

        $companyName = $profile?->name ?: config('app.name');

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
            'companyName' => $companyName,
            'galleryImages' => $galleryImages,
            'services' => $services,
            'advantages' => $advantages,
            'customers' => $customers,
            'testimonials' => $testimonials,
            'faqs' => $faqs,
            'metaTitle' => $profile ? "{$companyName} - Profil Perusahaan" : config('app.name'),
            'metaDescription' => $profile?->description
                ? Str::limit(strip_tags($profile->description), 160)
                : 'Profil perusahaan.',
            'jsonLd' => $profile ? $this->organizationJsonLd($profile, $companyName) : null,
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    protected function organizationJsonLd(CompanyProfile $profile, string $companyName): array
    {
        return array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => $companyName,
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
