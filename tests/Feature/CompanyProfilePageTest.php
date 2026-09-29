<?php

use App\Models\Advantage;
use App\Models\CompanyProfile;
use App\Models\Customer;
use App\Models\Faq;
use App\Models\GalleryImage;
use App\Models\NewsletterSubscriber;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;

use function Pest\Laravel\assertDatabaseHas;

uses(RefreshDatabase::class);

test('shows an empty state when no company profile exists', function () {
    $this->get('/')
        ->assertOk()
        ->assertSee('Profil perusahaan belum diisi');
});

test('renders the company profile with seo meta tags', function () {
    $profile = CompanyProfile::factory()->create([
        'name' => 'PT Maju Jaya',
        'description' => 'Perusahaan teknologi terkemuka.',
    ]);

    $this->get('/')
        ->assertOk()
        ->assertSee('PT Maju Jaya')
        ->assertSee('Perusahaan teknologi terkemuka.')
        ->assertSee('<title>PT Maju Jaya - Profil Perusahaan</title>', false)
        ->assertSee('name="description" content="Perusahaan teknologi terkemuka."', false)
        ->assertSee('property="og:title" content="PT Maju Jaya - Profil Perusahaan"', false)
        ->assertSee('application/ld+json', false)
        ->assertSee('"@type":"Organization"', false);
});

test('company profile page has no console-breaking missing fields', function () {
    $profile = CompanyProfile::factory()->create([
        'description' => null,
        'address' => null,
        'phone' => null,
        'email' => null,
        'operating_hours' => null,
        'facebook_url' => null,
        'instagram_url' => null,
        'x_url' => null,
        'whatsapp_number' => null,
    ]);

    $this->get('/')
        ->assertOk()
        ->assertSee($profile->name);
});

test('renders active services in the catalog section but hides inactive ones', function () {
    CompanyProfile::factory()->create();
    $activeService = Service::factory()->create(['name' => 'Jasa Konsultasi IT', 'is_active' => true]);
    $inactiveService = Service::factory()->create(['name' => 'Jasa Lama Tidak Aktif', 'is_active' => false]);

    $this->get('/')
        ->assertOk()
        ->assertSee('Produk & Layanan')
        ->assertSee('Jasa Konsultasi IT')
        ->assertDontSee('Jasa Lama Tidak Aktif');
});

test('renders active gallery images in the carousel but hides inactive ones', function () {
    CompanyProfile::factory()->create();
    Storage::fake('public');
    Storage::disk('public')->put('gallery/active.jpg', 'fake-content');
    Storage::disk('public')->put('gallery/inactive.jpg', 'fake-content');

    GalleryImage::factory()->create([
        'image' => 'gallery/active.jpg',
        'caption' => 'Suasana kantor kami',
        'is_active' => true,
    ]);
    GalleryImage::factory()->create([
        'image' => 'gallery/inactive.jpg',
        'caption' => 'Foto lama',
        'is_active' => false,
    ]);

    $this->get('/')
        ->assertOk()
        ->assertSee('data-carousel', false)
        ->assertSee('Suasana kantor kami')
        ->assertDontSee('Foto lama');
});

test('omits the catalog and carousel sections when there is no data', function () {
    CompanyProfile::factory()->create();

    $this->get('/')
        ->assertOk()
        ->assertDontSee('Produk & Layanan')
        ->assertDontSee('data-carousel', false);
});

test('renders the product slider markup when services exist', function () {
    CompanyProfile::factory()->create();
    Service::factory()->count(2)->create(['is_active' => true]);

    $this->get('/')
        ->assertOk()
        ->assertSee('data-slider', false)
        ->assertSee('data-slider-track', false);
});

test('renders active advantages but hides inactive ones', function () {
    CompanyProfile::factory()->create();
    Advantage::factory()->create(['title' => 'Tim Berpengalaman', 'is_active' => true]);
    Advantage::factory()->create(['title' => 'Keunggulan Lama', 'is_active' => false]);

    $this->get('/')
        ->assertOk()
        ->assertSee('Kenapa Memilih Kami')
        ->assertSee('Tim Berpengalaman')
        ->assertDontSee('Keunggulan Lama');
});

test('renders active customer logos but hides inactive ones', function () {
    CompanyProfile::factory()->create();
    Storage::fake('public');
    Storage::disk('public')->put('customers/active.jpg', 'fake-content');
    Storage::disk('public')->put('customers/inactive.jpg', 'fake-content');

    Customer::factory()->create([
        'name' => 'PT Klien Aktif',
        'logo' => 'customers/active.jpg',
        'is_active' => true,
    ]);
    Customer::factory()->create([
        'name' => 'PT Klien Nonaktif',
        'logo' => 'customers/inactive.jpg',
        'is_active' => false,
    ]);

    $this->get('/')
        ->assertOk()
        ->assertSee('Dipercaya oleh berbagai klien terkemuka')
        ->assertSee('PT Klien Aktif')
        ->assertDontSee('PT Klien Nonaktif');
});

test('omits advantages and customers sections when there is no data', function () {
    CompanyProfile::factory()->create();

    $this->get('/')
        ->assertOk()
        ->assertDontSee('Kenapa Memilih Kami')
        ->assertDontSee('Dipercaya oleh berbagai klien terkemuka');
});

test('renders active testimonials but hides inactive ones', function () {
    CompanyProfile::factory()->create();
    Testimonial::factory()->create(['name' => 'Budi Santoso', 'is_active' => true]);
    Testimonial::factory()->create(['name' => 'Testimoni Lama', 'is_active' => false]);

    $this->get('/')
        ->assertOk()
        ->assertSee('Apa Kata Klien Kami')
        ->assertSee('Budi Santoso')
        ->assertDontSee('Testimoni Lama');
});

test('renders active faqs but hides inactive ones', function () {
    CompanyProfile::factory()->create();
    Faq::factory()->create(['question' => 'Bagaimana cara memesan?', 'is_active' => true]);
    Faq::factory()->create(['question' => 'Pertanyaan lama?', 'is_active' => false]);

    $this->get('/')
        ->assertOk()
        ->assertSee('Bagaimana cara memesan?')
        ->assertDontSee('Pertanyaan lama?');
});

test('renders the hero image when set, falling back to the logo otherwise', function () {
    Storage::fake('public');
    Storage::disk('public')->put('company-profiles/hero/hero.jpg', 'fake-content');

    $profile = CompanyProfile::factory()->create([
        'hero_image' => 'company-profiles/hero/hero.jpg',
    ]);

    $this->get('/')
        ->assertOk()
        ->assertSee($profile->hero_image_url, false);
});

test('omits testimonials and faq sections when there is no data', function () {
    CompanyProfile::factory()->create();

    $this->get('/')
        ->assertOk()
        ->assertDontSee('Apa Kata Klien Kami')
        ->assertDontSee('id="faq"', false);
});

test('can subscribe to the newsletter', function () {
    $this->post(route('newsletter.subscribe'), ['email' => 'subscriber@example.com'])
        ->assertRedirect()
        ->assertSessionHas('newsletter_success');

    assertDatabaseHas(NewsletterSubscriber::class, [
        'email' => 'subscriber@example.com',
    ]);
});

test('newsletter subscription requires a valid unique email', function () {
    NewsletterSubscriber::factory()->create(['email' => 'existing@example.com']);

    $this->post(route('newsletter.subscribe'), ['email' => 'existing@example.com'])
        ->assertSessionHasErrors('email');
});
