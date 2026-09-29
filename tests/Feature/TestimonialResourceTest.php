<?php

use App\Filament\Resources\Testimonials\Pages\CreateTestimonial;
use App\Filament\Resources\Testimonials\Pages\EditTestimonial;
use App\Filament\Resources\Testimonials\Pages\ListTestimonials;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;

uses(RefreshDatabase::class);

beforeEach(function () {
    actingAs(User::factory()->create());
});

test('can list testimonials', function () {
    $testimonials = Testimonial::factory()->count(3)->create();

    Livewire::test(ListTestimonials::class)
        ->assertOk()
        ->assertCanSeeTableRecords($testimonials);
});

test('can create a testimonial', function () {
    $newTestimonial = Testimonial::factory()->make();

    Livewire::test(CreateTestimonial::class)
        ->fillForm([
            'name' => $newTestimonial->name,
            'position' => $newTestimonial->position,
            'rating' => 5,
            'content' => $newTestimonial->content,
            'is_active' => true,
        ])
        ->call('create')
        ->assertNotified()
        ->assertRedirect();

    assertDatabaseHas(Testimonial::class, [
        'name' => $newTestimonial->name,
    ]);
});

test('requires a name and content to create a testimonial', function () {
    Livewire::test(CreateTestimonial::class)
        ->fillForm(['name' => null, 'content' => null])
        ->call('create')
        ->assertHasFormErrors(['name' => 'required', 'content' => 'required']);
});

test('can update a testimonial', function () {
    $testimonial = Testimonial::factory()->create();
    $newData = Testimonial::factory()->make();

    Livewire::test(EditTestimonial::class, [
        'record' => $testimonial->getRouteKey(),
    ])
        ->fillForm([
            'name' => $newData->name,
        ])
        ->call('save')
        ->assertNotified();

    expect($testimonial->refresh()->name)->toBe($newData->name);
});
