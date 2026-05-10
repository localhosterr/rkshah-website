<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'customer_name', 'initials', 'rating',
        'review_text', 'trip_route', 'car_used',
        'source', 'is_published', 'sort_order',
    ];

    protected $casts = [
        'rating'       => 'integer',
        'is_published' => 'boolean',
        'sort_order'   => 'integer',
    ];

    /* ── Scopes ── */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    /* ── Accessors ── */
    public function getStarsAttribute(): string
    {
        return str_repeat('★', $this->rating);
    }
}
