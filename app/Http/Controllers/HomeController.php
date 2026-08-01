<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use App\Models\Pengumpulan;
use App\Models\Pengumuman;
use App\Models\Tugas;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

/**
 * Beranda peran guru dan siswa. Seluruh kueri dibatasi pada
 * data yang menjadi hak akses pengguna yang sedang masuk.
 */
class HomeController extends Controller
{
    /** Beranda guru: ringkasan kelas ampuan dan pekerjaan yang belum dinilai. */
    public function guru()
    {
        $idGuru = Auth::id();

        $mapel = MataPelajaran::where('id_guru', $idGuru)
            ->withCount('tugas')
            ->orderBy('nama_mapel')
            ->get();

        $idMapel = $mapel->pluck('id_mapel');
        $idTugas = Tugas::whereIn('id_mapel', $idMapel)->pluck('id');

        $belumDinilai = Pengumpulan::whereIn('id_tugas', $idTugas)
            ->whereNull('nilai')
            ->with(['siswa', 'tugas.mapel'])
            ->latest()
            ->take(6)
            ->get();

        return view('guru.dashboard', [
            'mapel'        => $mapel,
            'belumDinilai' => $belumDinilai,
            'statistik'    => [
                'mapel'   => $mapel->count(),
                'tugas'   => $idTugas->count(),
                'siswa'   => User::where('role', User::ROLE_SISWA)->where('is_active', true)->count(),
                'antrian' => Pengumpulan::whereIn('id_tugas', $idTugas)->whereNull('nilai')->count(),
            ],
        ]);
    }

    /** Beranda siswa: progres pengumpulan tugas dan pengumuman terbaru. */
    public function siswa()
    {
        $idSiswa = Auth::id();

        $totalTugas  = Tugas::count();
        $pengumpulan = Pengumpulan::where('id_siswa', $idSiswa)->get();
        $dinilai     = $pengumpulan->whereNotNull('nilai');

        $sudahIds = $pengumpulan->pluck('id_tugas');
        $tugasBelum = Tugas::whereNotIn('id', $sudahIds)
            ->with('mapel')
            ->latest()
            ->take(6)
            ->get();

        return view('siswa.dashboard', [
            'tugasBelum' => $tugasBelum,
            'pengumuman' => Pengumuman::with('guru')->latest()->take(4)->get(),
            'statistik'  => [
                'tugas'     => $totalTugas,
                'terkumpul' => $pengumpulan->count(),
                'dinilai'   => $dinilai->count(),
                'rata'      => $dinilai->count() ? round($dinilai->avg('nilai'), 1) : 0,
            ],
        ]);
    }
}
