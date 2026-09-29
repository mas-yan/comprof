<?php

namespace App\Filament\Resources\Services\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Produk/Layanan')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                FileUpload::make('image')
                    ->label('Gambar')
                    ->image()
                    ->disk('public')
                    ->directory('services')
                    ->visibility('public')
                    ->imageEditor()
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->label('Deskripsi')
                    ->rows(4)
                    ->columnSpanFull(),
                TextInput::make('price')
                    ->label('Harga')
                    ->maxLength(255)
                    ->placeholder('mis. Rp 500.000 atau Hubungi Kami'),
                Toggle::make('is_active')
                    ->label('Tampilkan di halaman utama')
                    ->default(true),
            ]);
    }
}
