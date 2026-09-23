<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'user_id',
        'guest_name',
        'guest_email',
        'guest_phone',
        'check_in',
        'check_out',
        'guests',
        'total_price',
        'status',
        'notes',
        'admin_notes',
        'confirmed_at',
        'cancelled_at',
    ];

    protected function casts(): array
    {
        return [
            'total_price'  => 'decimal:2',
            'check_in'     => 'date',
            'check_out'    => 'date',
            'confirmed_at' => 'datetime',
            'cancelled_at' => 'datetime',
        ];
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Calcule le nombre de nuits
     */
    public function getNightsAttribute(): int
    {
        return $this->check_in->diffInDays($this->check_out);
    }

    /**
     * Prix par nuit moyen
     */
    public function getPricePerNightAttribute(): float
    {
        return $this->nights > 0 ? $this->total_price / $this->nights : 0;
    }

    /**
     * Vérifie si la réservation est confirmée
     */
    public function isConfirmed(): bool
    {
        return $this->status === 'confirmed';
    }

    /**
     * Vérifie si la réservation est en attente
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Confirme la réservation
     */
    public function confirm(): void
    {
        $this->update([
            'status'       => 'confirmed',
            'confirmed_at' => now(),
        ]);
    }

    /**
     * Annule la réservation
     */
    public function cancel(): void
    {
        $this->update([
            'status'       => 'cancelled',
            'cancelled_at' => now(),
        ]);
    }
}
