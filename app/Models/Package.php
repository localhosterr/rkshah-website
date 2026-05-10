<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'name', 'slug', 'nights', 'days', 'price',
        'badge', 'emoji', 'bg_class',
        'featured_image',
        'destinations', 'includes', 'description', 'itinerary',
        'seo_title', 'seo_description',
        'is_published', 'sort_order',
    ];

    protected $casts = [
        'nights'       => 'integer',
        'days'         => 'integer',
        'price'        => 'float',
        'destinations' => 'array',
        'includes'     => 'array',
        'itinerary'    => 'array',
        'is_published' => 'boolean',
        'sort_order'   => 'integer',
    ];

    /* ── Accessors ── */
    public function getImageUrlAttribute(): ?string
    {
        return $this->featured_image
            ? asset('storage/' . $this->featured_image)
            : null;
    }

    /* ── Scopes ── */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderByDesc('id');
    }

    /* ── Accessors ── */
    public function getFormattedPriceAttribute(): string
    {
        return $this->price > 0
            ? 'Starting ₹' . number_format($this->price)
            : 'Custom pricing';
    }

    public function getDurationAttribute(): string
    {
        return $this->nights > 0
            ? "{$this->nights} Nights / {$this->days} Days"
            : 'Custom Duration';
    }

    public function getRouteLinkAttribute(): string
    {
        return route('packages.show', $this->slug);
    }
}
