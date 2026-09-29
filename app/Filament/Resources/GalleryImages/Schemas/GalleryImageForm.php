<?php

namespace App\Filament\Resources\GalleryImages\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class GalleryImageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('image')
                    ->label('Gambar')
                    ->image()
                    ->required()
                    ->disk('public')
                    ->directory('gallery')
                    ->visibility('public')
                    ->imageEditor()
                    ->columnSpanFull(),
                TextInput::make('caption')
                    ->label('Keterangan')
                    ->maxLength(255)
                    ->columnSpanFull(),
                Toggle::make('is_active')
                    ->label('Tampilkan di carousel')
                    ->default(true),
            ]);
    }
}
