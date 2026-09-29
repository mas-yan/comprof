<?php

namespace App\Filament\Resources\Advantages\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AdvantageForm
{
    /**
     * @return array<string, string>
     */
    public static function iconOptions(): array
    {
        return [
            'shield-check' => 'Perisai (Jaminan/Kualitas)',
            'bolt' => 'Petir (Cepat/Responsif)',
            'users' => 'Orang (Tim/Pengalaman)',
            'clock' => 'Jam (Tepat Waktu)',
            'currency-dollar' => 'Uang (Harga Kompetitif)',
            'star' => 'Bintang (Rating/Favorit)',
            'chat-bubble' => 'Chat (Layanan/Support)',
        ];
    }

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Judul')
                    ->required()
                    ->maxLength(255),
                Select::make('icon')
                    ->label('Ikon')
                    ->options(self::iconOptions())
                    ->native(false)
                    ->required()
                    ->default('star'),
                Textarea::make('description')
                    ->label('Deskripsi')
                    ->rows(3)
                    ->columnSpanFull(),
                Toggle::make('is_active')
                    ->label('Tampilkan di halaman utama')
                    ->default(true),
            ]);
    }
}
