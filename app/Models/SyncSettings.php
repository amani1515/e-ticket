<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SyncSettings extends Model
{
    protected $table = 'sync_settings';
    
    protected $fillable = ['key', 'value'];
    
    public static function get(string $key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }
    
    public static function set(string $key, $value): void
    {
        self::updateOrCreate(['key' => $key], ['value' => $value]);
    }
}