<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public const ROLE_SUPER_ADMIN = 'super_admin';
    public const ROLE_ADMIN       = 'admin';
    public const ROLE_GURU        = 'guru';
    public const ROLE_SISWA       = 'siswa';

    /** Seluruh peran yang dikenal sistem beserta labelnya. */
    public const ROLES = [
        self::ROLE_SUPER_ADMIN => 'Super Admin',
        self::ROLE_ADMIN       => 'Admin Sekolah',
        self::ROLE_GURU        => 'Guru',
        self::ROLE_SISWA       => 'Siswa',
    ];

    protected $fillable = [
        'name', 'email', 'password', 'identity', 'phone',
        'photo', 'kelas', 'role', 'is_active',
        'last_login_at', 'last_login_ip',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at'     => 'datetime',
            'is_active'         => 'boolean',
            'password'          => 'hashed',
        ];
    }

    /* ===================== HELPER PERAN (RBAC) ===================== */

    public function hasRole(string ...$roles): bool
    {
        return in_array($this->role, $roles, true);
    }

    public function isSuperAdmin(): bool { return $this->role === self::ROLE_SUPER_ADMIN; }
    public function isAdmin(): bool      { return $this->role === self::ROLE_ADMIN; }
    public function isGuru(): bool       { return $this->role === self::ROLE_GURU; }
    public function isSiswa(): bool      { return $this->role === self::ROLE_SISWA; }

    /** Peran administratif (Super Admin & Admin Sekolah). */
    public function isStaff(): bool
    {
        return $this->hasRole(self::ROLE_SUPER_ADMIN, self::ROLE_ADMIN);
    }

    public function roleLabel(): string
    {
        return self::ROLES[$this->role] ?? 'Pengguna';
    }

    /** Rute beranda sesuai peran pengguna. */
    public function homeRoute(): string
    {
        return match ($this->role) {
            self::ROLE_SUPER_ADMIN => 'superadmin.dashboard',
            self::ROLE_ADMIN       => 'admin.dashboard',
            self::ROLE_GURU        => 'guru.dashboard',
            default                => 'siswa.dashboard',
        };
    }

    /** URL foto profil; memakai avatar inisial bila belum diunggah. */
    public function photoUrl(): string
    {
        if ($this->photo && Storage::disk('public')->exists($this->photo)) {
            return Storage::url($this->photo);
        }

        return 'https://ui-avatars.com/api/?background=1d4ed8&color=fff&bold=true&name='
            . urlencode($this->name);
    }

    public function initial(): string
    {
        return strtoupper(mb_substr($this->name ?? 'U', 0, 1));
    }

    /* ===================== RELASI ===================== */

    public function mataPelajaran()
    {
        return $this->hasMany(MataPelajaran::class, 'id_guru');
    }

    public function pengumpulan()
    {
        return $this->hasMany(Pengumpulan::class, 'id_siswa');
    }
}
