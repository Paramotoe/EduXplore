<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $primaryKey = 'key';
    public $incrementing  = false;
    protected $keyType    = 'string';
    protected $fillable   = ['key', 'value'];

    /** Nilai bawaan konfigurasi sekolah. */
    public const DEFAULTS = [
        'nama_sekolah'     => 'SMA Negeri 1 Nusantara',
        'tahun_ajaran'     => '2025/2026',
        'panjang_nis'      => '10',
        'registrasi_buka'  => '1',
    ];

    public static function get(string $key, ?string $fallback = null): ?string
    {
        $all = Cache::remember('app_settings', 300, function () {
            return static::query()->pluck('value', 'key')->all();
        });

        return $all[$key] ?? $fallback ?? (self::DEFAULTS[$key] ?? null);
    }

    public static function put(string $key, ?string $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget('app_settings');
    }
}
