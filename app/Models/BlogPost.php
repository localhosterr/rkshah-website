<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    protected $table = 'blog_posts';

    protected $fillable = [
        'title', 'slug', 'category', 'excerpt', 'content',
        'featured_image', 'emoji', 'bg_class',
        'seo_title', 'seo_description',
        'status', 'published_at', 'views',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'views'        => 'integer',
    ];

    /* ── Scopes ── */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                     ->whereNotNull('published_at')
                     ->where('published_at', '<=', now());
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('published_at', 'desc');
    }

    /* ── Accessors ── */

    // Calculate read time from word count
    public function getReadTimeAttribute(): string
    {
        $wordCount = str_word_count(strip_tags($this->content ?? ''));
        $minutes   = max(1, (int) ceil($wordCount / 200)); // avg 200 words/min
        return $minutes . ' min read';
    }

    // Formatted published date
    public function getFormattedDateAttribute(): string
    {
        return $this->published_at
            ? $this->published_at->format('d F Y')
            : '—';
    }

    // Short date for cards
    public function getShortDateAttribute(): string
    {
        return $this->published_at
            ? $this->published_at->format('d M Y')
            : '—';
    }

    // Auto-assign emoji from category if not set
    public function getDisplayEmojiAttribute(): string
    {
        if ($this->emoji) return $this->emoji;

        return match(strtolower($this->category ?? '')) {
            'route guide'    => '🗺️',
            'travel tips'    => '💡',
            'budget guide'   => '💰',
            'destination'    => '📍',
            'seasonal guide' => '🌤️',
            'pilgrimage'     => '🕉️',
            default          => '✍️',
        };
    }

    // Auto-assign bg class from category if not set
    public function getDisplayBgAttribute(): string
    {
        if ($this->bg_class) return $this->bg_class;

        return match(strtolower($this->category ?? '')) {
            'route guide'    => 'blog-b1',
            'travel tips'    => 'blog-b2',
            'budget guide'   => 'blog-b3',
            'destination'    => 'blog-b4',
            'seasonal guide' => 'blog-b5',
            default          => 'blog-b1',
        };
    }

    // Increment views safely
    public function incrementViews(): void
    {
        $this->increment('views');
    }
}
