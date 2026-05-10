<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = [
        'booking_ref', 'lead_id',
        'customer_name', 'customer_phone',
        'from_city', 'to_city',
        'travel_date', 'pickup_time', 'return_date',
        'car_type', 'driver_name', 'driver_phone',
        'trip_type', 'passengers',
        'total_fare', 'advance_paid', 'advance_method',
        'status', 'notes',
    ];

    protected $casts = [
        'travel_date'  => 'date',
        'return_date'  => 'date',
        'total_fare'   => 'float',
        'advance_paid' => 'float',
        'passengers'   => 'integer',
    ];

    /* ── Auto generate booking reference ── */
    protected static function booted(): void
    {
        static::creating(function (Booking $booking) {
            if (empty($booking->booking_ref)) {
                $last = static::max('id') ?? 0;
                $booking->booking_ref = 'BK-' . str_pad($last + 1, 6, '0', STR_PAD_LEFT);
            }
        });
    }

    /* ── Relationships ── */
    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    /* ── Scopes ── */
    public function scopeUpcoming($query)
    {
        return $query->where('travel_date', '>=', today())
                     ->whereNotIn('status', ['cancelled']);
    }

    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('travel_date', now()->month)
                     ->whereYear('travel_date', now()->year);
    }

    /* ── Accessors ── */
    public function getCarLabelAttribute(): string
    {
        return match($this->car_type) {
            'innova_crysta' => 'Innova Crysta',
            'kia_creta'     => 'Kia Creta',
            'ertiga'        => 'Ertiga',
            'swift_dzire'   => 'Swift Dzire',
            default         => ucfirst($this->car_type),
        };
    }

    public function getCarEmojiAttribute(): string
    {
        return match($this->car_type) {
            'innova_crysta' => '🚙',
            'kia_creta'     => '🚗',
            'ertiga'        => '🚐',
            'swift_dzire'   => '🚕',
            default         => '🚗',
        };
    }

    public function getRouteAttribute(): string
    {
        return $this->from_city . ' → ' . $this->to_city;
    }

    public function getBalanceDueAttribute(): float
    {
        return max(0, $this->total_fare - $this->advance_paid);
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending'     => 'orange',
            'confirmed'   => 'green',
            'in_progress' => 'blue',
            'completed'   => 'navy',
            'cancelled'   => 'red',
            default       => 'gray',
        };
    }

    public function getFormattedDateAttribute(): string
    {
        return $this->travel_date
            ? $this->travel_date->format('d M Y')
            : '—';
    }

    public function getTripTypeAttribute($value): string
    {
        return $value;
    }

    public function getTripTypeLabelAttribute(): string
    {
        return match($this->trip_type) {
            'one_way'    => 'One Way',
            'round_trip' => 'Round Trip',
            'airport'    => 'Airport',
            'hourly'     => 'Hourly',
            default      => ucfirst($this->trip_type),
        };
    }
}
