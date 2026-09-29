<?php

use App\Filament\Resources\Customers\Pages\CreateCustomer;
use App\Filament\Resources\Customers\Pages\EditCustomer;
use App\Filament\Resources\Customers\Pages\ListCustomers;
use App\Models\Customer;
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

test('can list customers', function () {
    $customers = Customer::factory()->count(3)->create();

    Livewire::test(ListCustomers::class)
        ->assertOk()
        ->assertCanSeeTableRecords($customers);
});

test('can create a customer', function () {
    $file = UploadedFile::fake()->image('logo.jpg');

    Livewire::test(CreateCustomer::class)
        ->fillForm([
            'name' => 'PT Contoh Klien',
            'logo' => $file,
            'website_url' => 'https://contoh-klien.test',
            'is_active' => true,
        ])
        ->call('create')
        ->assertNotified()
        ->assertRedirect();

    assertDatabaseHas(Customer::class, [
        'name' => 'PT Contoh Klien',
    ]);
});

test('requires a logo to create a customer', function () {
    Livewire::test(CreateCustomer::class)
        ->fillForm(['name' => 'PT Tanpa Logo', 'logo' => null])
        ->call('create')
        ->assertHasFormErrors(['logo' => 'required']);
});

test('can update a customer', function () {
    Storage::disk('public')->put('customers/existing.jpg', 'fake-content');
    $customer = Customer::factory()->create(['logo' => 'customers/existing.jpg']);

    Livewire::test(EditCustomer::class, [
        'record' => $customer->getRouteKey(),
    ])
        ->fillForm([
            'name' => 'Nama Baru',
        ])
        ->call('save')
        ->assertNotified();

    expect($customer->refresh()->name)->toBe('Nama Baru');
});
