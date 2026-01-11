<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'group', 'type'];

    protected $casts = [
        'value' => 'json',
    ];

    /**
     * Get a setting value by key.
     *
     * @param string $key The setting key
     * @param mixed $default Default value if not found
     * @return mixed
     */
    public static function get($key, $default = null)
    {
        $setting = Cache::remember("setting.{$key}", 3600, function () use ($key) {
            return static::where('key', $key)->first();
        });

        return $setting ? $setting->value : $default;
    }

    /**
     * Set a setting value.
     *
     * @param string $key The setting key
     * @param mixed $value The value to store
     * @param string $group The settings group
     * @param string $type The value type (string, boolean, integer, json)
     * @return Setting
     */
    public static function set($key, $value, $group = 'general', $type = 'string')
    {
        Cache::forget("setting.{$key}");
        
        return static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'group' => $group, 'type' => $type]
        );
    }

    /**
     * Get all settings for a group.
     *
     * @param string $group
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getGroup($group)
    {
        return static::where('group', $group)->get();
    }

    /**
     * Check if a setting exists.
     *
     * @param string $key
     * @return bool
     */
    public static function has($key): bool
    {
        return static::where('key', $key)->exists();
    }

    /**
     * Remove a setting.
     *
     * @param string $key
     * @return bool
     */
    public static function remove($key): bool
    {
        Cache::forget("setting.{$key}");
        return static::where('key', $key)->delete() > 0;
    }

    /**
     * Get all settings as key-value array.
     *
     * @return array
     */
    public static function getAllAsArray(): array
    {
        return static::pluck('value', 'key')->toArray();
    }
}
