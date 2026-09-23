<?php

namespace App\Filament\Resources\Properties\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PropertyForm
{
    // Liste prédéfinie d'équipements courants
    private const AMENITIES_OPTIONS = [
        'Piscine privée', 'Piscine chauffée', 'Jacuzzi', 'Sauna',
        'Wi-Fi haut débit', 'Climatisation', 'Chauffage', 'Cheminée',
        'Cuisine équipée', 'Lave-vaisselle', 'Machine à laver', 'Sèche-linge',
        'Télévision', 'Home cinéma', 'Barbecue', 'Terrasse', 'Jardin',
        'Parking privé', 'Garage', 'Ascenseur', 'Accès handicapés',
        'Animaux acceptés', 'Vue sur mer', 'Vue sur montagne', 'Vue sur piscine',
    ];

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Informations générales
                Section::make('Informations générales')
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
                            ->label('Description courte (accroche)')
                            ->rows(2)
                            ->maxLength(200)
                            ->helperText('Apparaît sous le titre sur la page d\'accueil'),

                        Textarea::make('description')
                            ->label('Description détaillée')
                            ->rows(6)
                            ->maxLength(5000)
                            ->columnSpanFull()
                            ->helperText('Description complète visible sur la page de détail'),
                    ])->columns(2),

                // Capacité et pièces
                Section::make('Capacité et pièces')
                    ->schema([
                        TextInput::make('max_guests')
                            ->label('Nombre maximum de voyageurs')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(20)
                            ->required(),

                        TextInput::make('bedrooms')
                            ->label('Chambres')
                            ->numeric()
                            ->minValue(0)
                            ->required(),

                        TextInput::make('bathrooms')
                            ->label('Salles de bain')
                            ->numeric()
                            ->minValue(0)
                            ->step(0.5)
                            ->required(),

                        TextInput::make('base_price')
                            ->label('Prix par nuit (€)')
                            ->numeric()
                            ->prefix('€')
                            ->minValue(0)
                            ->step(0.01)
                            ->required(),
                    ])->columns(4),

                // Équipements
                Section::make('Équipements')
                    ->description('Sélectionnez les équipements disponibles')
                    ->schema([
                        TagsInput::make('amenities')
                            ->label('Équipements')
                            ->suggestions(self::AMENITIES_OPTIONS)
                            ->placeholder('Ajouter un équipement...')
                            ->columnSpanFull(),
                    ])->columns(1),

                // Localisation
                Section::make('Localisation')
                    ->schema([
                        TextInput::make('address')
                            ->label('Adresse')
                            ->maxLength(255),

                        TextInput::make('city')
                            ->label('Ville')
                            ->maxLength(100),

                        TextInput::make('latitude')
                            ->label('Latitude')
                            ->numeric()
                            ->step(0.0000001),

                        TextInput::make('longitude')
                            ->label('Longitude')
                            ->numeric()
                            ->step(0.0000001),
                    ])->columns(2),

                // Images
                Section::make('Images')
                    ->description('Téléchargez les visuels de la propriété')
                    ->schema([
                        FileUpload::make('main_image')
                            ->label('Image principale (Hero)')
                            ->directory('properties/main')
                            ->disk('public')
                            ->image()
                            ->imageEditor()
                            ->maxSize(7320)
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
                                    ->maxSize(7320)
                                    ->required(),
                            ])
                            ->collapsible()
                            ->reorderable()
                            ->cloneable()
                            ->itemLabel(fn (array $state): ?string => $state['url'] ?? 'Nouvelle image')
                            ->columnSpanFull(),
                    ])->columns(1),

                // Statut
                Section::make('Statut')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Propriété active')
                            ->default(true)
                            ->helperText('Décochez pour masquer la propriété du site public'),
                    ])->columns(1),
            ]);
    }
}