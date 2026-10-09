<?php

use App\Filament\Resources\CompanyProfiles\CompanyProfileResource;
use App\Filament\Resources\CompanyProfiles\Pages\CreateCompanyProfile;
use App\Filament\Resources\CompanyProfiles\Pages\EditCompanyProfile;
use App\Filament\Resources\CompanyProfiles\Pages\ListCompanyProfiles;
use App\Models\CompanyProfile;
use App\Models\User;
use Filament\Actions\CreateAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;

uses(RefreshDatabase::class);

beforeEach(function () {
    actingAs(User::factory()->create());
});

test('can list company profiles', function () {
    $profiles = CompanyProfile::factory()->count(3)->create();

    Livewire::test(ListCompanyProfiles::class)
        ->assertOk()
        ->assertCanSeeTableRecords($profiles);
});

test('can render create page', function () {
    Livewire::test(CreateCompanyProfile::class)
        ->assertOk();
});

test('can create a company profile', function () {
    $newProfile = CompanyProfile::factory()->make();

    Livewire::test(CreateCompanyProfile::class)
        ->fillForm([
            'name' => $newProfile->name,
            'description' => $newProfile->description,
            'address' => $newProfile->address,
            'phone' => $newProfile->phone,
            'email' => $newProfile->email,
            'facebook_url' => $newProfile->facebook_url,
            'instagram_url' => $newProfile->instagram_url,
            'x_url' => $newProfile->x_url,
            'whatsapp_number' => $newProfile->whatsapp_number,
            'operating_hours' => $newProfile->operating_hours,
        ])
        ->call('create')
        ->assertNotified()
        ->assertRedirect();

    assertDatabaseHas(CompanyProfile::class, [
        'name' => $newProfile->name,
        'email' => $newProfile->email,
    ]);
});

test('can create a company profile without a name', function () {
    Livewire::test(CreateCompanyProfile::class)
        ->fillForm(['name' => null])
        ->call('create')
        ->assertHasNoFormErrors()
        ->assertNotified()
        ->assertRedirect();

    assertDatabaseHas(CompanyProfile::class, [
        'name' => null,
    ]);
});

test('shows the create action when no company profile exists yet', function () {
    Livewire::test(ListCompanyProfiles::class)
        ->assertActionVisible(CreateAction::class);
});

test('hides the create action and blocks the create page once a company profile exists', function () {
    CompanyProfile::factory()->create();

    Livewire::test(ListCompanyProfiles::class)
        ->assertActionHidden(CreateAction::class);

    $this->get(CompanyProfileResource::getUrl('create'))->assertForbidden();
});

test('can render edit page', function () {
    $profile = CompanyProfile::factory()->create();

    Livewire::test(EditCompanyProfile::class, [
        'record' => $profile->getRouteKey(),
    ])
        ->assertOk();
});

test('can update a company profile', function () {
    $profile = CompanyProfile::factory()->create();
    $newData = CompanyProfile::factory()->make();

    Livewire::test(EditCompanyProfile::class, [
        'record' => $profile->getRouteKey(),
    ])
        ->fillForm([
            'name' => $newData->name,
            'email' => $newData->email,
        ])
        ->call('save')
        ->assertNotified();

    expect($profile->refresh())
        ->name->toBe($newData->name)
        ->email->toBe($newData->email);
});
