<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    // key is the primary key — not an auto-increment id
    protected $primaryKey = 'key';
    public    $incrementing = false;
    protected $keyType      = 'string';

    protected $fillable = ['key', 'value', 'type', 'description', 'is_public'];

    protected $casts = [
        'is_public' => 'boolean',
    ];

    /* ── Static helpers ── */

    /**
     * Get a setting value by key, cast to its correct type.
     * Falls back to $default if key doesn't exist.
     *
     * Usage:  Setting::get('rate_innova', 14)
     *         Setting::get('business_name', 'RK Shah Car Rental')
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $setting = Cache::remember("setting_{$key}", 3600, function () use ($key) {
            return static::where('key', $key)->first();
        });

        if (!$setting) return $default;

        return match($setting->type) {
            'number'  => is_float($setting->value + 0)
                            ? (float) $setting->value
                            : (int)   $setting->value,
            'boolean' => filter_var($setting->value, FILTER_VALIDATE_BOOLEAN),
            'json'    => json_decode($setting->value, true),
            default   => $setting->value,
        };
    }

    /**
     * Set a setting value.
     * Clears cache automatically.
     *
     * Usage:  Setting::set('rate_innova', 15)
     */
    public static function set(string $key, mixed $value): void
    {
        static::updateOrCreate(
            ['key' => $key],
            ['value' => is_array($value) ? json_encode($value) : (string) $value]
        );
        Cache::forget("setting_{$key}");
    }

    /**
     * Get all public settings as a simple key => value array.
     * Used to expose settings to the website frontend.
     */
    public static function allPublic(): array
    {
        return Cache::remember('settings_public', 3600, function () {
            return static::where('is_public', true)
                ->get()
                ->mapWithKeys(fn($s) => [$s->key => static::castValue($s)])
                ->toArray();
        });
    }

    /**
     * Get ALL settings as key => value (for CMS use only).
     */
    public static function allSettings(): array
    {
        return static::all()
            ->mapWithKeys(fn($s) => [$s->key => static::castValue($s)])
            ->toArray();
    }

    /**
     * Clear all settings cache.
     */
    public static function clearCache(): void
    {
        $keys = static::pluck('key');
        foreach ($keys as $key) {
            Cache::forget("setting_{$key}");
        }
        Cache::forget('settings_public');
    }

    private static function castValue(self $setting): mixed
    {
        return match($setting->type) {
            'number'  => is_float($setting->value + 0)
                            ? (float) $setting->value
                            : (int)   $setting->value,
            'boolean' => filter_var($setting->value, FILTER_VALIDATE_BOOLEAN),
            'json'    => json_decode($setting->value, true),
            default   => $setting->value,
        };
    }
}
