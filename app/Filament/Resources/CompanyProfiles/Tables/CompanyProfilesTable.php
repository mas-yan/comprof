<?php

namespace App\Filament\Resources\CompanyProfiles\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CompanyProfilesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')
                    ->label('Logo')
                    ->circular(),
                TextColumn::make('name')
                    ->label('Nama Perusahaan')
                    ->searchable(),
                TextColumn::make('phone')
                    ->label('Telepon')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                TextColumn::make('operating_hours')
                    ->label('Jam Operasional')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('facebook_url')
                    ->label('Facebook')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('instagram_url')
                    ->label('Instagram')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('x_url')
                    ->label('X (Twitter)')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('whatsapp_number')
                    ->label('WhatsApp')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
