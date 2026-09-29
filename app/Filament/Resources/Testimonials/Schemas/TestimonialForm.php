<?php

namespace App\Filament\Resources\Testimonials\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TestimonialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama')
                    ->required()
                    ->maxLength(255),
                TextInput::make('position')
                    ->label('Jabatan/Perusahaan')
                    ->maxLength(255)
                    ->placeholder('mis. CEO, PT Contoh Sukses'),
                FileUpload::make('avatar')
                    ->label('Foto (opsional)')
                    ->image()
                    ->avatar()
                    ->disk('public')
                    ->directory('testimonials')
                    ->visibility('public'),
                Select::make('rating')
                    ->label('Rating')
                    ->options([
                        5 => '★★★★★ (5)',
                        4 => '★★★★☆ (4)',
                        3 => '★★★☆☆ (3)',
                        2 => '★★☆☆☆ (2)',
                        1 => '★☆☆☆☆ (1)',
                    ])
                    ->native(false)
                    ->required()
                    ->default(5),
                Textarea::make('content')
                    ->label('Ulasan')
                    ->required()
                    ->rows(4)
                    ->columnSpanFull(),
                Toggle::make('is_active')
                    ->label('Tampilkan di halaman utama')
                    ->default(true),
            ]);
    }
}
