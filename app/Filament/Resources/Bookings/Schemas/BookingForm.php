<?php

namespace App\Filament\Resources\Bookings\Schemas;

use App\Models\Property;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BookingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informations client')
                    ->schema([
                        TextInput::make('guest_name')
                            ->label('Nom du client')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('guest_email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(255),

                        TextInput::make('guest_phone')
                            ->label('Téléphone')
                            ->tel()
                            ->maxLength(20),
                    ])->columns(3),

                Section::make('Détails de la réservation')
                    ->schema([
                        Select::make('property_id')
                            ->label('Propriété')
                            ->options(Property::active()->pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                if ($state) {
                                    $property = Property::find($state);
                                    if ($property) {
                                        $checkIn = $get('check_in');
                                        $checkOut = $get('check_out');
                                        $guests = $get('guests') ?? 1;
                                        
                                        if ($checkIn && $checkOut) {
                                            $total = $property->calculateTotalPrice($checkIn, $checkOut);
                                            $set('total_price', $total);
                                        }
                                    }
                                }
                            }),

                        DatePicker::make('check_in')
                            ->label('Date d\'arrivée')
                            ->required()
                            ->minDate(today())
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                $propertyId = $get('property_id');
                                $checkOut = $get('check_out');
                                
                                if ($propertyId && $state && $checkOut) {
                                    $property = Property::find($propertyId);
                                    if ($property) {
                                        $total = $property->calculateTotalPrice($state, $checkOut);
                                        $set('total_price', $total);
                                    }
                                }
                            }),

                        DatePicker::make('check_out')
                            ->label('Date de départ')
                            ->required()
                            ->minDate(fn (callable $get) => $get('check_in') ?? today())
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                $propertyId = $get('property_id');
                                $checkIn = $get('check_in');
                                
                                if ($propertyId && $state && $checkIn) {
                                    $property = Property::find($propertyId);
                                    if ($property) {
                                        $total = $property->calculateTotalPrice($checkIn, $state);
                                        $set('total_price', $total);
                                    }
                                }
                            }),

                        TextInput::make('guests')
                            ->label('Nombre de voyageurs')
                            ->numeric()
                            ->minValue(1)
                            ->required(),

                        TextInput::make('total_price')
                            ->label('Prix total (€)')
                            ->numeric()
                            ->prefix('€')
                            ->minValue(0)
                            ->step(0.01)
                            ->required()
                            ->disabled(fn (callable $get) => $get('property_id') && $get('check_in') && $get('check_out')),
                    ])->columns(2),

                Section::make('Statut et notes')
                    ->schema([
                        ToggleButtons::make('status')
                            ->label('Statut')
                            ->options([
                                'pending'   => 'En attente',
                                'confirmed' => 'Confirmée',
                                'cancelled' => 'Annulée',
                                'completed' => 'Terminée',
                            ])
                            ->inline()
                            ->default('pending')
                            ->required(),

                        DateTimePicker::make('confirmed_at')
                            ->label('Confirmée le')
                            ->disabled(),

                        DateTimePicker::make('cancelled_at')
                            ->label('Annulée le')
                            ->disabled(),

                        Textarea::make('notes')
                            ->label('Notes du client')
                            ->rows(3)
                            ->columnSpanFull(),

                        Textarea::make('admin_notes')
                            ->label('Notes administratives')
                            ->rows(2)
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }
}