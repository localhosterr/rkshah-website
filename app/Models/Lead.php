<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lead extends Model
{
    protected $fillable = [
        'name', 'phone', 'from_city', 'to_city',
        'travel_date', 'pickup_time', 'car_type', 'trip_type',
        'passengers', 'message', 'status', 'source',
        'estimated_fare', 'follow_up_at',
        'utm_source', 'utm_medium', 'utm_campaign', 'ip_address',
    ];

    protected $casts = [
        'travel_date'    => 'date',
        'follow_up_at'   => 'datetime',
        'estimated_fare' => 'float',
        'passengers'     => 'integer',
    ];

    /* ── Relationships ── */
    public function notes(): HasMany
    {
        return $this->hasMany(LeadNote::class)->latest();
    }

    /* ── Scopes ── */
    public function scopeNewLeads($query)
    {
        return $query->where('status', 'new');
    }

    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month)
                     ->whereYear('created_at',  now()->year);
    }

    public function scopeOverdue($query)
    {
        return $query->whereNotNull('follow_up_at')
                     ->where('follow_up_at', '<=', now())
                     ->whereNotIn('status', ['completed','cancelled']);
    }

    /* ── Accessors ── */
    public function getTimeAgoAttribute(): string
    {
        $diff = now()->diffInMinutes($this->created_at);

        if ($diff < 1)   return 'Just now';
        if ($diff < 60)  return $diff . ' min ago';
        if ($diff < 1440) return round($diff / 60) . ' hr ago';
        if ($diff < 10080) return round($diff / 1440) . ' days ago';

        return $this->created_at->format('d M Y');
    }

    public function getFormattedPhoneAttribute(): string
    {
        $p = preg_replace('/\D/', '', $this->phone);
        return strlen($p) === 10
            ? substr($p, 0, 5) . ' ' . substr($p, 5)
            : $this->phone;
    }

    public function getCarLabelAttribute(): string
    {
        return match($this->car_type) {
            'innova_crysta' => 'Innova Crysta',
            'kia_creta'     => 'Kia Creta',
            'ertiga'        => 'Ertiga',
            'swift_dzire'   => 'Swift Dzire',
            default         => 'Any Car',
        };
    }

    public function getRouteAttribute(): string
    {
        return $this->from_city . ' → ' . $this->to_city;
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'new'       => 'blue',
            'contacted' => 'orange',
            'quoted'    => 'yellow',
            'confirmed' => 'green',
            'completed' => 'navy',
            'cancelled' => 'red',
            default     => 'gray',
        };
    }
}
