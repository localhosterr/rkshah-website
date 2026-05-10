<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $fillable = [
        'from_city', 'to_city', 'slug',
        'distance_km', 'duration_hrs', 'highway',
        'highlight', 'tag', 'accent_color',
        'price_dzire', 'price_ertiga', 'price_creta', 'price_innova',
        'featured_image',
        'seo_title', 'seo_description',
        'is_published', 'sort_order',
    ];

    protected $casts = [
        'distance_km'   => 'integer',
        'duration_hrs'  => 'float',
        'price_dzire'   => 'float',
        'price_ertiga'  => 'float',
        'price_creta'   => 'float',
        'price_innova'  => 'float',
        'is_published'  => 'boolean',
        'sort_order'    => 'integer',
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

    public function scopeFromDelhi($query)
    {
        return $query->where('from_city', 'Delhi');
    }

    public function scopeByTag($query, string $tag)
    {
        return $query->where('tag', $tag);
    }

    /* ── Accessors ── */

    // Returns the lowest available price across all cars
    public function getMinPriceAttribute(): ?float
    {
        $prices = array_filter([
            $this->price_dzire,
            $this->price_ertiga,
            $this->price_creta,
            $this->price_innova,
        ]);

        return !empty($prices) ? min($prices) : null;
    }

    // Returns all available car prices as an array
    public function getPricesAttribute(): array
    {
        return array_filter([
            'dzire'  => $this->price_dzire,
            'ertiga' => $this->price_ertiga,
            'creta'  => $this->price_creta,
            'innova' => $this->price_innova,
        ]);
    }

    // The "starting from" display string  e.g.  "Starting ₹2,200"
    public function getStartingPriceAttribute(): string
    {
        $min = $this->min_price;
        return $min ? 'Starting ₹' . number_format($min) : 'Get Quote';
    }

    public function getFullRouteAttribute(): string
    {
        return $this->from_city . ' → ' . $this->to_city;
    }

    public function getRouteLinkAttribute(): string
    {
        return route('routes.show', $this->slug);
    }
}
