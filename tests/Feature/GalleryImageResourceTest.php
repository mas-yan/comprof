<?php

use App\Filament\Resources\GalleryImages\Pages\CreateGalleryImage;
use App\Filament\Resources\GalleryImages\Pages\EditGalleryImage;
use App\Filament\Resources\GalleryImages\Pages\ListGalleryImages;
use App\Models\GalleryImage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;

uses(RefreshDatabase::class);

beforeEach(function () {
    Storage::fake('public');
    actingAs(User::factory()->create());
});

test('can list gallery images', function () {
    $images = GalleryImage::factory()->count(3)->create();

    Livewire::test(ListGalleryImages::class)
        ->assertOk()
        ->assertCanSeeTableRecords($images);
});

test('can create a gallery image', function () {
    $file = UploadedFile::fake()->image('gallery.jpg');

    Livewire::test(CreateGalleryImage::class)
        ->fillForm([
            'image' => $file,
            'caption' => 'Kantor pusat kami',
            'is_active' => true,
        ])
        ->call('create')
        ->assertNotified()
        ->assertRedirect();

    assertDatabaseHas(GalleryImage::class, [
        'caption' => 'Kantor pusat kami',
    ]);
});

test('requires an image to create a gallery image', function () {
    Livewire::test(CreateGalleryImage::class)
        ->fillForm(['image' => null])
        ->call('create')
        ->assertHasFormErrors(['image' => 'required']);
});

test('can update a gallery image', function () {
    Storage::disk('public')->put('gallery/existing.jpg', 'fake-content');
    $image = GalleryImage::factory()->create(['image' => 'gallery/existing.jpg']);

    Livewire::test(EditGalleryImage::class, [
        'record' => $image->getRouteKey(),
    ])
        ->fillForm([
            'caption' => 'Caption baru',
        ])
        ->call('save')
        ->assertNotified();

    expect($image->refresh()->caption)->toBe('Caption baru');
});
