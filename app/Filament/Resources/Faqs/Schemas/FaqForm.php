<?php

namespace App\Filament\Resources\Faqs\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class FaqForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('question')
                    ->label('Pertanyaan')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Textarea::make('answer')
                    ->label('Jawaban')
                    ->required()
                    ->rows(4)
                    ->columnSpanFull(),
                Toggle::make('is_active')
                    ->label('Tampilkan di halaman utama')
                    ->default(true),
            ]);
    }
}
