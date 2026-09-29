<?php

namespace App\Filament\Resources\Customers\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CustomerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Perusahaan/Klien')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                FileUpload::make('logo')
                    ->label('Logo')
                    ->image()
                    ->required()
                    ->disk('public')
                    ->directory('customers')
                    ->visibility('public')
                    ->imageEditor()
                    ->columnSpanFull(),
                TextInput::make('website_url')
                    ->label('Website (opsional)')
                    ->url()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Toggle::make('is_active')
                    ->label('Tampilkan di halaman utama')
                    ->default(true),
            ]);
    }
}
