<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

#[Fillable(['group', 'key', 'value'])]
class Setting extends Model
{
    use SoftDeletes;

    protected function casts(): array
    {
        return [
            'value' => 'json',
        ];
    }

    protected static function booted(): void
    {
        // Any change invalidates the settings cache.
        static::saved(fn () => Cache::forget('site_settings'));
        static::deleted(fn () => Cache::forget('site_settings'));
    }

    /**
     * Read a setting as "group.key" from a single cached map,
     * e.g. Setting::get('contact.email').
     */
    public static function get(string $groupAndKey, mixed $default = null): mixed
    {
        [$group, $key] = array_pad(explode('.', $groupAndKey, 2), 2, null);

        return static::allCached()[$group][$key] ?? $default;
    }

    public static function set(string $groupAndKey, mixed $value): void
    {
        [$group, $key] = array_pad(explode('.', $groupAndKey, 2), 2, null);

        static::updateOrCreate(['group' => $group, 'key' => $key], ['value' => $value]);
    }

    /**
     * All settings grouped, cached for a day.
     *
     * @return array<string, array<string, mixed>>
     */
    public static function allCached(): array
    {
        return Cache::remember('site_settings', now()->addDay(), function () {
            return static::query()
                ->get()
                ->groupBy('group')
                ->map(fn ($items) => $items->pluck('value', 'key')->all())
                ->all();
        });
    }
}
