<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'base_price',
        'main_image',
        'images',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'base_price' => 'decimal:2',
            'images'     => 'array', // Cast automatique JSON vers tableau PHP
            'is_active'  => 'boolean',
        ];
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Property $property) {
            if (empty($property->slug)) {
                $property->slug = Str::slug($property->name);
            }
            if (empty($property->images)) {
                $property->images = [];
            }
        });

        static::updating(function (Property $property) {
            if ($property->isDirty('name')) {
                $property->slug = Str::slug($property->name);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Obtient toutes les images (principale + galerie)
     */
    public function getAllImages(): array
    {
        $images = $this->images ?? [];
        if ($this->main_image) {
            array_unshift($images, $this->main_image);
        }
        return array_filter($images); // Retire les valeurs null/vides
    }
}