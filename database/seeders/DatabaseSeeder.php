<?php

namespace Database\Seeders;

use App\Models\ForumDiskusi;
use App\Models\MataPelajaran;
use App\Models\Pengumpulan;
use App\Models\Pengumuman;
use App\Models\Setting;
use App\Models\Tugas;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Data awal (demonstrasi) Sistem EduXplore.
 */
class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        foreach (Setting::DEFAULTS as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        $akun = [
            ['1000000001', 'Dr. Bagas Prakoso, M.Kom.', 'superadmin@eduxplore.sch.id', '081234567801', User::ROLE_SUPER_ADMIN, null],
            ['1000000002', 'Rina Kusumawati, S.Kom.',   'admin@eduxplore.sch.id',      '081234567802', User::ROLE_ADMIN, null],
            ['1980051020', 'Drs. Hendra Wijaya',        'hendra.guru@eduxplore.sch.id','081234567803', User::ROLE_GURU, null],
            ['1985071122', 'Sri Lestari, S.Pd.',        'sri.guru@eduxplore.sch.id',   '081234567804', User::ROLE_GURU, null],
            ['2024010001', 'Ahmad Fauzan Ramadhan',     'ahmad.siswa@eduxplore.sch.id','081234567805', User::ROLE_SISWA, 'XI IPA 1'],
            ['2024010002', 'Nabila Putri Anggraini',    'nabila.siswa@eduxplore.sch.id','081234567806', User::ROLE_SISWA, 'XI IPA 1'],
            ['2024010003', 'Dimas Aditya Nugroho',      'dimas.siswa@eduxplore.sch.id','081234567807', User::ROLE_SISWA, 'XI IPA 2'],
        ];

        foreach ($akun as [$identity, $name, $email, $phone, $role, $kelas]) {
            User::updateOrCreate(['identity' => $identity], [
                'name'      => $name,
                'email'     => $email,
                'phone'     => $phone,
                'role'      => $role,
                'kelas'     => $kelas,
                'is_active' => true,
                'password'  => Hash::make('Password123'),
            ]);
        }

        $hendra = User::where('identity', '1980051020')->first();
        $sri    = User::where('identity', '1985071122')->first();
        $siswa  = User::where('role', User::ROLE_SISWA)->get();

        $mapelData = [
            ['Matematika Wajib XI', $hendra->id],
            ['Fisika XI IPA', $hendra->id],
            ['Bahasa Indonesia XI', $sri->id],
        ];

        foreach ($mapelData as [$nama, $idGuru]) {
            $mapel = MataPelajaran::firstOrCreate(['nama_mapel' => $nama], ['id_guru' => $idGuru]);

            $tugas = Tugas::firstOrCreate(
                ['id_mapel' => $mapel->id_mapel, 'judul_tugas' => 'Tugas Harian 1 - ' . $nama],
                ['deskripsi' => 'Kerjakan latihan pada modul bab pertama, lalu unggah tautan hasil pekerjaan Anda.']
            );

            foreach ($siswa->take(2) as $index => $s) {
                Pengumpulan::firstOrCreate(
                    ['id_tugas' => $tugas->id, 'id_siswa' => $s->id],
                    [
                        'jawaban_atau_link' => 'https://drive.google.com/file/tugas-' . $s->identity,
                        'nilai'             => $index === 0 ? 92 : null,
                    ]
                );
            }
        }

        Pengumuman::firstOrCreate(
            ['judul' => 'Jadwal Penilaian Tengah Semester'],
            [
                'isi'     => 'Penilaian Tengah Semester dilaksanakan pada 15-20 September 2026. Siswa wajib hadir 15 menit sebelum ujian dimulai.',
                'id_guru' => $hendra->id,
            ]
        );

        ForumDiskusi::firstOrCreate(
            ['pesan' => 'Selamat datang di forum diskusi EduXplore. Gunakan ruang ini untuk bertanya seputar materi pelajaran.'],
            ['id_pembuat' => $sri->id]
        );
    }
}
