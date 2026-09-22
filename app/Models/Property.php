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
            'images'     => 'array',
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
     * Récupère toutes les images (principale + galerie) pour le frontend.
     */
    public function getAllImages(): array
    {
        $images = $this->images ?? [];
        
        // Si les images sont stockées au format Repeater [{url: '...'}, ...]
        if (isset($images[0]) && is_array($images[0]) && isset($images[0]['url'])) {
            $images = array_column($images, 'url');
        }
        
        if ($this->main_image) {
            array_unshift($images, $this->main_image);
        }
        
        return array_filter($images);
    }
}