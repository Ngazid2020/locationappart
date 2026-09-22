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
        'description',
        'base_price',
        'max_guests',
        'bedrooms',
        'bathrooms',
        'main_image',
        'images',
        'amenities',
        'address',
        'city',
        'latitude',
        'longitude',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'base_price' => 'decimal:2',
            'images'     => 'array',
            'amenities'  => 'array',
            'is_active'  => 'boolean',
            'latitude'   => 'decimal:7',
            'longitude'  => 'decimal:7',
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
            if (empty($property->amenities)) {
                $property->amenities = [];
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

    public function getAllImages(): array
    {
        $images = $this->images ?? [];
        
        if (isset($images[0]) && is_array($images[0]) && isset($images[0]['url'])) {
            $images = array_column($images, 'url');
        }
        
        if ($this->main_image) {
            array_unshift($images, $this->main_image);
        }
        
        return array_filter($images);
    }

    /**
     * Calcule le prix total pour une période donnée
     */
    public function calculateTotalPrice(string $checkIn, string $checkOut): float
    {
        $start = \Carbon\Carbon::parse($checkIn);
        $end = \Carbon\Carbon::parse($checkOut);
        $nights = $start->diffInDays($end);
        
        return (float) $this->base_price * $nights;
    }
}