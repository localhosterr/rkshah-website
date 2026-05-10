<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fleet extends Model
{
    protected $table = 'fleet';

    protected $fillable = [
        'name', 'slug', 'type', 'fuel', 'model_year',
        'seats', 'luggage', 'rate_per_km', 'driver_allowance',
        'min_km', 'badge', 'emoji', 'bg_class',
        'featured_image',
        'features', 'best_for', 'description',
        'is_active', 'sort_order',
    ];

    protected $casts = [
        'features'         => 'array',
        'rate_per_km'      => 'float',
        'driver_allowance' => 'float',
        'min_km'           => 'integer',
        'seats'            => 'integer',
        'is_active'        => 'boolean',
        'sort_order'       => 'integer',
    ];

    /* ── Scopes ── */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderByDesc('id');
    }

    /* ── Accessors ── */

    // Returns the car key used in the fare calculator (dzire, ertiga, creta, innova)
    // Returns the full public URL of the car image, or null if none
    public function getImageUrlAttribute(): ?string
    {
        return $this->featured_image
            ? asset('storage/' . $this->featured_image)
            : null;
    }

    public function getFareKeyAttribute(): string
    {
        return match($this->slug) {
            'swift-dzire'   => 'dzire',
            'ertiga'        => 'ertiga',
            'kia-creta'     => 'creta',
            'innova-crysta' => 'innova',
            default         => 'dzire',
        };
    }

    // Estimate fare for a given distance (one way)
    public function estimateFare(int $km, bool $roundTrip = false): array
    {
        $multiplier = $roundTrip ? 2 : 1;
        $base       = $km * $this->rate_per_km * $multiplier;
        $da         = $this->driver_allowance * $multiplier;
        $total      = $base + $da;
        $margin     = $total * 0.10; // ±10% range

        return [
            'base_fare' => round($base),
            'driver_da' => round($da),
            'total'     => round($total),
            'min'       => round($total - $margin),
            'max'       => round($total + $margin),
        ];
    }

    public function getRouteLinkAttribute(): string
    {
        return route('fleet.show', $this->slug);
    }
}
