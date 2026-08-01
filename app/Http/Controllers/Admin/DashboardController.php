<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\ForumDiskusi;
use App\Models\MataPelajaran;
use App\Models\Pengumpulan;
use App\Models\Setting;
use App\Models\Tugas;
use App\Models\User;
use App\Support\Audit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Dashboard, konfigurasi sistem, dan audit trail.
 */
class DashboardController extends Controller
{
    public function index()
    {
        $statistik = [
            'siswa'       => User::where('role', User::ROLE_SISWA)->count(),
            'guru'        => User::where('role', User::ROLE_GURU)->count(),
            'admin'       => User::whereIn('role', [User::ROLE_ADMIN, User::ROLE_SUPER_ADMIN])->count(),
            'nonaktif'    => User::where('is_active', false)->count(),
            'mapel'       => MataPelajaran::count(),
            'tugas'       => Tugas::count(),
            'pengumpulan' => Pengumpulan::count(),
            'diskusi'     => ForumDiskusi::count(),
        ];

        $view = Auth::user()->isSuperAdmin() ? 'superadmin.dashboard' : 'admin.dashboard';

        return view($view, [
            'statistik'   => $statistik,
            'terbaru'     => User::latest()->take(5)->get(),
            'aktivitas'   => AuditLog::latest()->take(8)->get(),
            'namaSekolah' => Setting::get('nama_sekolah'),
        ]);
    }

    public function settings()
    {
        return view('admin.settings', [
            'settings' => [
                'nama_sekolah'    => Setting::get('nama_sekolah'),
                'tahun_ajaran'    => Setting::get('tahun_ajaran'),
                'panjang_nis'     => Setting::get('panjang_nis'),
                'registrasi_buka' => Setting::get('registrasi_buka'),
            ],
        ]);
    }

    public function updateSettings(Request $request)
    {
        $data = $request->validate([
            'nama_sekolah'    => ['required', 'string', 'max:120'],
            'tahun_ajaran'    => ['required', 'string', 'regex:/^\d{4}\/\d{4}$/'],
            'panjang_nis'     => ['required', 'integer', 'min:5', 'max:20'],
            'registrasi_buka' => ['nullable', 'boolean'],
        ], [
            'tahun_ajaran.regex' => 'Format tahun ajaran harus seperti 2025/2026.',
            'panjang_nis.min'    => 'Panjang NIS minimal 5 digit.',
        ]);

        foreach ($data as $key => $value) {
            Setting::put($key, (string) $value);
        }
        Setting::put('registrasi_buka', $request->boolean('registrasi_buka') ? '1' : '0');

        Audit::log('UBAH_KONFIGURASI', 'Memperbarui konfigurasi inti sekolah');

        return back()->with('success', 'Konfigurasi sistem berhasil disimpan.');
    }

    /** Audit trail — khusus Super Admin. */
    public function audit(Request $request)
    {
        $aksi = trim((string) $request->query('action', ''));

        $query = AuditLog::query()->latest();
        if ($aksi !== '') {
            $query->where('action', $aksi);
        }

        return view('superadmin.audit', [
            'logs'       => $query->paginate(20)->withQueryString(),
            'aksi'       => $aksi,
            'daftarAksi' => AuditLog::query()->distinct()->orderBy('action')->pluck('action'),
        ]);
    }
}
