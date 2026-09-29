<?php

use App\Filament\Resources\Advantages\Pages\CreateAdvantage;
use App\Filament\Resources\Advantages\Pages\EditAdvantage;
use App\Filament\Resources\Advantages\Pages\ListAdvantages;
use App\Models\Advantage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;

uses(RefreshDatabase::class);

beforeEach(function () {
    actingAs(User::factory()->create());
});

test('can list advantages', function () {
    $advantages = Advantage::factory()->count(3)->create();

    Livewire::test(ListAdvantages::class)
        ->assertOk()
        ->assertCanSeeTableRecords($advantages);
});

test('can create an advantage', function () {
    $newAdvantage = Advantage::factory()->make();

    Livewire::test(CreateAdvantage::class)
        ->fillForm([
            'title' => $newAdvantage->title,
            'icon' => $newAdvantage->icon,
            'description' => $newAdvantage->description,
            'is_active' => true,
        ])
        ->call('create')
        ->assertNotified()
        ->assertRedirect();

    assertDatabaseHas(Advantage::class, [
        'title' => $newAdvantage->title,
        'icon' => $newAdvantage->icon,
    ]);
});

test('requires a title to create an advantage', function () {
    Livewire::test(CreateAdvantage::class)
        ->fillForm(['title' => null])
        ->call('create')
        ->assertHasFormErrors(['title' => 'required']);
});

test('can update an advantage', function () {
    $advantage = Advantage::factory()->create();
    $newData = Advantage::factory()->make();

    Livewire::test(EditAdvantage::class, [
        'record' => $advantage->getRouteKey(),
    ])
        ->fillForm([
            'title' => $newData->title,
        ])
        ->call('save')
        ->assertNotified();

    expect($advantage->refresh()->title)->toBe($newData->title);
});
