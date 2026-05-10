<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimelineItem extends Model
{
    protected $fillable = [
        'year', 'title', 'description',
        'icon', 'color', 'is_published', 'sort_order',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'sort_order'   => 'integer',
    ];

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('year');
    }
}
