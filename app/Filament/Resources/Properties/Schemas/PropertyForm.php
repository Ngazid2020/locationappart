<?php

namespace App\Filament\Resources\Properties\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
// use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PropertyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Section : Informations générales
                Section::make('Informations générales')
                    ->description('Détails principaux de la propriété')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nom de la propriété')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(
                                fn (Set $set, ?string $state) =>
                                    $set('slug', Str::slug($state))
                            ),

                        TextInput::make('slug')
                            ->label('Slug (URL)')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Textarea::make('short_description')
                            ->label('Description courte')
                            ->rows(3)
                            ->maxLength(500)
                            ->columnSpanFull(),

                        TextInput::make('base_price')
                            ->label('Prix par nuit (€)')
                            ->numeric()
                            ->prefix('€')
                            ->minValue(0)
                            ->step(0.01),
                    ])
                    ->columns(2),

                // Section : Images
                Section::make('Images')
                    ->description('Téléchargez les visuels de la propriété')
                    ->schema([
                        FileUpload::make('main_image')
                            ->label('Image principale (Hero)')
                            ->directory('properties/main')
                            ->disk('public')
                            ->image()
                            ->imageEditor()
                            ->maxSize(5120) // 5 MB
                            ->required()
                            ->columnSpanFull(),

                        Repeater::make('images')
                            ->label('Galerie d\'images')
                            ->schema([
                                FileUpload::make('url')
                                    ->label('Image')
                                    ->directory('properties/gallery')
                                    ->disk('public')
                                    ->image()
                                    ->imageEditor()
                                    ->maxSize(5120)
                                    ->required(),
                            ])
                            ->collapsible()
                            ->reorderable()
                            ->cloneable()
                            ->itemLabel(fn (array $state): ?string => $state['url'] ?? 'Nouvelle image')
                            ->columnSpanFull(),
                    ])
                    ->columns(1),

                // Section : Statut
                Section::make('Statut')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Propriété active')
                            ->default(true)
                            ->helperText('Décochez pour masquer la propriété du site public'),
                    ])
                    ->columns(1),
            ]);
    }
}