<?php

use App\Filament\Resources\Faqs\Pages\CreateFaq;
use App\Filament\Resources\Faqs\Pages\EditFaq;
use App\Filament\Resources\Faqs\Pages\ListFaqs;
use App\Models\Faq;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;

uses(RefreshDatabase::class);

beforeEach(function () {
    actingAs(User::factory()->create());
});

test('can list faqs', function () {
    $faqs = Faq::factory()->count(3)->create();

    Livewire::test(ListFaqs::class)
        ->assertOk()
        ->assertCanSeeTableRecords($faqs);
});

test('can create a faq', function () {
    $newFaq = Faq::factory()->make();

    Livewire::test(CreateFaq::class)
        ->fillForm([
            'question' => $newFaq->question,
            'answer' => $newFaq->answer,
            'is_active' => true,
        ])
        ->call('create')
        ->assertNotified()
        ->assertRedirect();

    assertDatabaseHas(Faq::class, [
        'question' => $newFaq->question,
    ]);
});

test('requires a question and answer to create a faq', function () {
    Livewire::test(CreateFaq::class)
        ->fillForm(['question' => null, 'answer' => null])
        ->call('create')
        ->assertHasFormErrors(['question' => 'required', 'answer' => 'required']);
});

test('can update a faq', function () {
    $faq = Faq::factory()->create();
    $newData = Faq::factory()->make();

    Livewire::test(EditFaq::class, [
        'record' => $faq->getRouteKey(),
    ])
        ->fillForm([
            'question' => $newData->question,
        ])
        ->call('save')
        ->assertNotified();

    expect($faq->refresh()->question)->toBe($newData->question);
});
