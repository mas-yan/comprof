<?php

namespace App\Filament\Resources\CompanyProfiles\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CompanyProfileForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Perusahaan')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Perusahaan')
                            ->helperText('Opsional. Jika dikosongkan, nama aplikasi akan digunakan sebagai gantinya.')
                            ->maxLength(255)
                            ->columnSpanFull(),
                        FileUpload::make('logo')
                            ->label('Logo')
                            ->image()
                            ->disk('public')
                            ->directory('company-profiles/logos')
                            ->visibility('public')
                            ->imageEditor()
                            ->columnSpanFull(),
                        FileUpload::make('hero_image')
                            ->label('Gambar Hero (opsional)')
                            ->helperText('Gambar besar yang tampil di sisi kanan bagian hero pada halaman utama.')
                            ->image()
                            ->disk('public')
                            ->directory('company-profiles/hero')
                            ->visibility('public')
                            ->imageEditor()
                            ->columnSpanFull(),
                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(5)
                            ->columnSpanFull(),
                    ]),

                Section::make('Kontak')
                    ->schema([
                        Textarea::make('address')
                            ->label('Alamat')
                            ->rows(3)
                            ->columnSpanFull(),
                        TextInput::make('phone')
                            ->label('Telepon')
                            ->tel()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->maxLength(255),
                        TextInput::make('operating_hours')
                            ->label('Jam Operasional')
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Sosial Media')
                    ->schema([
                        TextInput::make('facebook_url')
                            ->label('Facebook')
                            ->url()
                            ->maxLength(255),
                        TextInput::make('instagram_url')
                            ->label('Instagram')
                            ->url()
                            ->maxLength(255),
                        TextInput::make('x_url')
                            ->label('X (Twitter)')
                            ->url()
                            ->maxLength(255),
                        TextInput::make('whatsapp_number')
                            ->label('WhatsApp')
                            ->tel()
                            ->maxLength(255),
                    ])
                    ->columns(2),
            ]);
    }
}
