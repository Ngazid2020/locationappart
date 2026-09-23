<?php

namespace App\Filament\Resources\Bookings\Tables;

use App\Models\Property;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class BookingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('guest_name')
                    ->label('Client')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('property.name')
                    ->label('Propriété')
                    ->searchable(),

                TextColumn::make('check_in')
                    ->label('Arrivée')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('check_out')
                    ->label('Départ')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('guests')
                    ->label('Voyageurs')
                    ->sortable(),

                TextColumn::make('total_price')
                    ->label('Total')
                    ->money('EUR')
                    ->sortable(),

                BadgeColumn::make('status')
                    ->label('Statut')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'confirmed',
                        'danger'  => 'cancelled',
                        'primary' => 'completed',
                    ])
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'pending'   => 'En attente',
                        'confirmed' => 'Confirmée',
                        'cancelled' => 'Annulée',
                        'completed' => 'Terminée',
                    }),

                TextColumn::make('created_at')
                    ->label('Créée le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending'   => 'En attente',
                        'confirmed' => 'Confirmée',
                        'cancelled' => 'Annulée',
                        'completed' => 'Terminée',
                    ]),

                SelectFilter::make('property_id')
                    ->label('Propriété')
                    ->options(fn() => Property::active()->pluck('name', 'id')),
            ])
            ->actions([
                EditAction::make(),
                Action::make('confirm')
                    ->label('Confirmer')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(fn($record) => $record->confirm())
                    ->visible(fn($record) => $record->isPending()),

                Action::make('cancel')
                    ->label('Annuler')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(fn($record) => $record->cancel())
                    ->visible(fn($record) => $record->isPending() || $record->isConfirmed()),
            ])
            ->defaultSort('check_in', 'asc');
    }
}
