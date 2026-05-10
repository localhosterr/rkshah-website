<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $fillable = [
        'category', 'category_icon', 'question',
        'answer', 'is_published', 'sort_order',
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
        return $query->orderBy('sort_order')->orderBy('id');
    }

    /**
     * Get all published FAQs grouped by category.
     * Returns array compatible with the FAQ blade template.
     */
    public static function grouped(): array
    {
        $faqs = static::published()->ordered()->get();

        return $faqs->groupBy('category')->map(function ($items, $category) {
            return [
                'title' => $category,
                'icon'  => $items->first()->category_icon,
                'faqs'  => $items->map(fn($f) => [
                    'q' => $f->question,
                    'a' => $f->answer,
                ])->all(),
            ];
        })->values()->all();
    }
}
