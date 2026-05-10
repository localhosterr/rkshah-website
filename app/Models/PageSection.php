<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class PageSection extends Model
{
    protected $fillable = [
        'page', 'section', 'key', 'value',
        'type', 'label', 'hint', 'sort_order',
    ];

    /**
     * Get a single content value.
     * Usage: PageSection::val('homepage', 'hero', 'title')
     */
    public static function val(string $page, string $section, string $key, string $default = ''): string
    {
        $cacheKey = "ps_{$page}_{$section}_{$key}";
        return Cache::remember($cacheKey, 3600, function () use ($page, $section, $key, $default) {
            return static::where('page', $page)
                ->where('section', $section)
                ->where('key', $key)
                ->value('value') ?? $default;
        });
    }

    /**
     * Get all keys in a section as key=>value array.
     * Usage: PageSection::section('homepage', 'hero')
     * Returns: ['title' => '...', 'subtitle' => '...']
     */
    public static function section(string $page, string $section): array
    {
        $cacheKey = "ps_{$page}_{$section}";
        return Cache::remember($cacheKey, 3600, function () use ($page, $section) {
            return static::where('page', $page)
                ->where('section', $section)
                ->orderBy('sort_order')
                ->pluck('value', 'key')
                ->toArray();
        });
    }

    /**
     * Get all sections of a page.
     * Returns: ['hero' => [...], 'how_it_works' => [...]]
     */
    public static function page(string $page): array
    {
        $cacheKey = "ps_{$page}_all";
        return Cache::remember($cacheKey, 3600, function () use ($page) {
            return static::where('page', $page)
                ->orderBy('sort_order')
                ->get()
                ->groupBy('section')
                ->map(fn($items) => $items->pluck('value', 'key')->toArray())
                ->toArray();
        });
    }

    /**
     * Save a value and clear its cache.
     */
    public static function setValue(string $page, string $section, string $key, string $value): void
    {
        static::updateOrCreate(
            ['page' => $page, 'section' => $section, 'key' => $key],
            ['value' => $value]
        );
        // Clear caches
        Cache::forget("ps_{$page}_{$section}_{$key}");
        Cache::forget("ps_{$page}_{$section}");
        Cache::forget("ps_{$page}_all");
    }

    /**
     * Clear all cache for a page.
     */
    public static function clearPageCache(string $page): void
    {
        // Get all unique sections for this page and clear
        $sections = static::where('page', $page)->distinct()->pluck('section');
        foreach ($sections as $section) {
            Cache::forget("ps_{$page}_{$section}");
            $keys = static::where('page', $page)->where('section', $section)->pluck('key');
            foreach ($keys as $key) {
                Cache::forget("ps_{$page}_{$section}_{$key}");
            }
        }
        Cache::forget("ps_{$page}_all");
    }
}
