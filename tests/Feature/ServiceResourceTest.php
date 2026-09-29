<?php

use App\Filament\Resources\Services\Pages\CreateService;
use App\Filament\Resources\Services\Pages\EditService;
use App\Filament\Resources\Services\Pages\ListServices;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;

uses(RefreshDatabase::class);

beforeEach(function () {
    actingAs(User::factory()->create());
});

test('can list services', function () {
    $services = Service::factory()->count(3)->create();

    Livewire::test(ListServices::class)
        ->assertOk()
        ->assertCanSeeTableRecords($services);
});

test('can create a service', function () {
    $newService = Service::factory()->make();

    Livewire::test(CreateService::class)
        ->fillForm([
            'name' => $newService->name,
            'description' => $newService->description,
            'price' => $newService->price,
            'is_active' => true,
        ])
        ->call('create')
        ->assertNotified()
        ->assertRedirect();

    assertDatabaseHas(Service::class, [
        'name' => $newService->name,
        'price' => $newService->price,
    ]);
});

test('requires a name to create a service', function () {
    Livewire::test(CreateService::class)
        ->fillForm(['name' => null])
        ->call('create')
        ->assertHasFormErrors(['name' => 'required']);
});

test('can update a service', function () {
    $service = Service::factory()->create();
    $newData = Service::factory()->make();

    Livewire::test(EditService::class, [
        'record' => $service->getRouteKey(),
    ])
        ->fillForm([
            'name' => $newData->name,
        ])
        ->call('save')
        ->assertNotified();

    expect($service->refresh()->name)->toBe($newData->name);
});
