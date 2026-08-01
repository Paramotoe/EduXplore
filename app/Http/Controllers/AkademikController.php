<?php

namespace App\Http\Controllers;

use App\Models\ForumDiskusi;
use App\Models\MataPelajaran;
use App\Models\Pengumpulan;
use App\Models\Pengumuman;
use App\Models\Tugas;
use App\Models\User;
use App\Support\Audit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Modul akademik: mata pelajaran, tugas, pengumpulan, penilaian,
 * pengumuman, dan forum diskusi.
 */
class AkademikController extends Controller
{
    /* ==================== MATA PELAJARAN ==================== */

    public function indexMapel()
    {
        $user = Auth::user();

        // Guru hanya melihat kelas yang diampunya; siswa & staf melihat seluruh kelas.
        $query = MataPelajaran::with('guru')->withCount('tugas');
        if ($user->isGuru()) {
            $query->where('id_guru', $user->id);
        }

        return view('mata_pelajaran', ['mapel' => $query->orderBy('nama_mapel')->get()]);
    }

    public function storeMapel(Request $request)
    {
        $request->validate(
            ['nama_mapel' => ['required', 'string', 'min:3', 'max:100']],
            ['nama_mapel.required' => 'Nama mata pelajaran wajib diisi.']
        );

        $mapel = MataPelajaran::create([
            'nama_mapel' => $request->string('nama_mapel')->trim()->value(),
            'id_guru'    => Auth::id(),
        ]);

        Audit::log('TAMBAH_MAPEL', 'Menambahkan mata pelajaran: ' . $mapel->nama_mapel);

        return back()->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    public function deleteMapel(string $id)
    {
        $mapel = $this->mapelMilikGuru($id);
        $nama  = $mapel->nama_mapel;
        $mapel->delete();

        Audit::log('HAPUS_MAPEL', 'Menghapus mata pelajaran: ' . $nama);

        return back()->with('success', 'Mata pelajaran berhasil dihapus.');
    }

    /* ==================== TUGAS ==================== */

    public function detailMapel(string $id)
    {
        $mapel = MataPelajaran::with(['guru', 'tugas.pengumpulan.siswa'])->findOrFail($id);
        $user  = Auth::user();

        if ($user->isGuru() && (int) $mapel->id_guru !== (int) $user->id) {
            abort(403, 'Anda hanya dapat membuka mata pelajaran yang Anda ampu.');
        }

        return view('detail_mapel', compact('mapel'));
    }

    public function storeTugas(Request $request, string $id_mapel)
    {
        $mapel = $this->mapelMilikGuru($id_mapel);

        $data = $request->validate([
            'judul_tugas' => ['required', 'string', 'min:3', 'max:150'],
            'deskripsi'   => ['required', 'string', 'max:2000'],
        ], [
            'judul_tugas.required' => 'Judul tugas wajib diisi.',
            'deskripsi.required'   => 'Deskripsi tugas wajib diisi.',
        ]);

        Tugas::create([
            'id_mapel'    => $mapel->id_mapel,
            'judul_tugas' => $data['judul_tugas'],
            'deskripsi'   => $data['deskripsi'],
        ]);

        Audit::log('TAMBAH_TUGAS', 'Tugas baru pada mapel: ' . $mapel->nama_mapel);

        return back()->with('success', 'Tugas berhasil diberikan kepada siswa.');
    }

    public function submitTugas(Request $request, string $id_tugas)
    {
        $data = $request->validate([
            'jawaban_atau_link' => ['required', 'string', 'min:3', 'max:2000'],
        ], [
            'jawaban_atau_link.required' => 'Jawaban atau tautan tugas wajib diisi.',
        ]);

        $tugas = Tugas::findOrFail($id_tugas);

        // Cegah pengumpulan ganda: perbarui jawaban bila sudah pernah dikumpulkan.
        Pengumpulan::updateOrCreate(
            ['id_tugas' => $tugas->id, 'id_siswa' => Auth::id()],
            ['jawaban_atau_link' => $data['jawaban_atau_link']]
        );

        Audit::log('KUMPUL_TUGAS', 'Mengumpulkan tugas: ' . $tugas->judul_tugas);

        return back()->with('success', 'Tugas berhasil dikumpulkan.');
    }

    /* ==================== FORUM DISKUSI ==================== */

    public function indexForum()
    {
        return view('forum_diskusi', [
            'chats' => ForumDiskusi::with('user')->orderBy('created_at')->get(),
        ]);
    }

    public function kirimPesan(Request $request)
    {
        $request->validate(
            ['pesan' => ['required', 'string', 'max:1000']],
            ['pesan.required' => 'Pesan tidak boleh kosong.']
        );

        ForumDiskusi::create([
            'id_pembuat' => Auth::id(),
            'pesan'      => $request->string('pesan')->trim()->value(),
        ]);

        return back();
    }

    /* ==================== PENGUMUMAN ==================== */

    public function indexPengumuman()
    {
        return view('guru.pengumuman', [
            'pengumuman' => Pengumuman::with('guru')->latest()->get(),
        ]);
    }

    public function storePengumuman(Request $request)
    {
        $data = $request->validate([
            'judul' => ['required', 'string', 'min:3', 'max:150'],
            'isi'   => ['required', 'string', 'max:2000'],
        ], [
            'judul.required' => 'Judul pengumuman wajib diisi.',
            'isi.required'   => 'Isi pengumuman wajib diisi.',
        ]);

        Pengumuman::create($data + ['id_guru' => Auth::id()]);
        Audit::log('TAMBAH_PENGUMUMAN', 'Menyiarkan pengumuman: ' . $data['judul']);

        return back()->with('success', 'Pengumuman berhasil disiarkan.');
    }

    public function deletePengumuman(string $id)
    {
        $pengumuman = Pengumuman::findOrFail($id);

        if (Auth::user()->isGuru() && (int) $pengumuman->id_guru !== (int) Auth::id()) {
            abort(403, 'Anda hanya dapat menghapus pengumuman yang Anda buat.');
        }

        $pengumuman->delete();
        Audit::log('HAPUS_PENGUMUMAN', 'Menghapus pengumuman #' . $id);

        return back()->with('success', 'Pengumuman berhasil dihapus.');
    }

    /* ==================== PENILAIAN ==================== */

    public function indexNilai()
    {
        return view('guru.nilai', [
            'mapel' => MataPelajaran::where('id_guru', Auth::id())
                ->with('tugas.pengumpulan.siswa')
                ->get(),
        ]);
    }

    public function beriNilai(Request $request, string $id_pengumpulan)
    {
        $request->validate(
            ['nilai' => ['required', 'numeric', 'min:0', 'max:100']],
            ['nilai.required' => 'Nilai wajib diisi.', 'nilai.max' => 'Nilai maksimal 100.']
        );

        $pengumpulan = Pengumpulan::with('tugas.mapel')->findOrFail($id_pengumpulan);

        // Guru hanya boleh menilai pekerjaan pada mata pelajaran yang diampunya.
        if ((int) optional($pengumpulan->tugas?->mapel)->id_guru !== (int) Auth::id()) {
            abort(403, 'Anda tidak berwenang menilai pekerjaan pada mata pelajaran ini.');
        }

        $pengumpulan->update(['nilai' => $request->input('nilai')]);
        Audit::log('BERI_NILAI', 'Menilai pengumpulan #' . $id_pengumpulan);

        return back()->with('success', 'Nilai berhasil disimpan.');
    }

    public function lihatNilaiSiswa()
    {
        return view('siswa.nilai', [
            'pengumpulan' => Pengumpulan::where('id_siswa', Auth::id())
                ->with(['tugas.mapel'])
                ->latest()
                ->get(),
        ]);
    }

    /* ==================== UTILITAS ==================== */

    private function mapelMilikGuru(string $id): MataPelajaran
    {
        $mapel = MataPelajaran::findOrFail($id);

        if ((int) $mapel->id_guru !== (int) Auth::id()) {
            abort(403, 'Anda hanya dapat mengelola mata pelajaran yang Anda ampu.');
        }

        return $mapel;
    }
}
