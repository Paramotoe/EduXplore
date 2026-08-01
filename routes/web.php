<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AkademikController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Peta Rute Aplikasi EduXplore
|--------------------------------------------------------------------------
| Seluruh rute privat dilindungi middleware 'auth' dan 'role' (RBAC).
| Setiap formulir POST otomatis diverifikasi token CSRF oleh Laravel.
*/

/* ---------- 1. AUTENTIKASI (PUBLIK) ---------- */
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLogin'])->name('login');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register_view');
    Route::post('/proses-register', [AuthController::class, 'register'])->name('proses_register');
    Route::post('/proses-login', [AuthController::class, 'login'])->name('proses_login');
});
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

/* ---------- 2. RUTE BERSAMA SEMUA PERAN ---------- */
Route::middleware(['auth', 'role'])->group(function () {
    Route::get('/profil', [ProfileController::class, 'index'])->name('profil.index');
    Route::post('/profil/update', [ProfileController::class, 'updateSelf'])->name('profil.update');
    Route::post('/profil/password', [ProfileController::class, 'updatePassword'])->name('profil.password');
    Route::post('/profil/delete', [ProfileController::class, 'deleteSelf'])->name('profil.delete');

    Route::get('/mata-pelajaran', [AkademikController::class, 'indexMapel'])->name('mapel.index');
    Route::get('/mata-pelajaran/{id}', [AkademikController::class, 'detailMapel'])->name('mapel.detail');

    Route::get('/forum-diskusi', [AkademikController::class, 'indexForum'])->name('forum.index');
    Route::post('/forum-diskusi/kirim', [AkademikController::class, 'kirimPesan'])->name('forum.kirim');
});

/* ---------- 3. SUPER ADMIN ---------- */
Route::middleware(['auth', 'role:super_admin'])->prefix('super-admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('superadmin.dashboard');
    Route::get('/audit-trail', [DashboardController::class, 'audit'])->name('superadmin.audit');
});

/* ---------- 4. ADMIN SEKOLAH & SUPER ADMIN ---------- */
Route::middleware(['auth', 'role:admin,super_admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/pengguna', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/pengguna/tambah', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/pengguna', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/pengguna/{id}/ubah', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::post('/pengguna/{id}', [UserController::class, 'update'])->name('admin.users.update');
    Route::post('/pengguna/{id}/status', [UserController::class, 'toggle'])->name('admin.users.toggle');
    Route::post('/pengguna/{id}/hapus', [UserController::class, 'destroy'])->name('admin.users.destroy');

    Route::get('/konfigurasi', [DashboardController::class, 'settings'])->name('admin.settings');
    Route::post('/konfigurasi', [DashboardController::class, 'updateSettings'])->name('admin.settings.update');
});

/* ---------- 5. GURU ---------- */
Route::middleware(['auth', 'role:guru'])->prefix('guru')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'guru'])->name('guru.dashboard');

    Route::post('/mata-pelajaran/tambah', [AkademikController::class, 'storeMapel'])->name('mapel.store');
    Route::post('/mata-pelajaran/{id}/hapus', [AkademikController::class, 'deleteMapel'])->name('mapel.delete');
    Route::post('/tugas/{id_mapel}/tambah', [AkademikController::class, 'storeTugas'])->name('tugas.store');

    Route::get('/daftar-siswa', [ProfileController::class, 'kelolaSiswa'])->name('guru.kelola_siswa');

    Route::get('/pengumuman', [AkademikController::class, 'indexPengumuman'])->name('guru.pengumuman');
    Route::post('/pengumuman/tambah', [AkademikController::class, 'storePengumuman'])->name('pengumuman.store');
    Route::post('/pengumuman/{id}/hapus', [AkademikController::class, 'deletePengumuman'])->name('pengumuman.delete');

    Route::get('/rekap-nilai', [AkademikController::class, 'indexNilai'])->name('guru.nilai');
    Route::post('/rekap-nilai/{id}/simpan', [AkademikController::class, 'beriNilai'])->name('nilai.store');
});

/* ---------- 6. SISWA ---------- */
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'siswa'])->name('siswa.dashboard');
    Route::post('/tugas/{id_tugas}/kumpul', [AkademikController::class, 'submitTugas'])->name('tugas.submit');
    Route::get('/lihat-nilai', [AkademikController::class, 'lihatNilaiSiswa'])->name('siswa.nilai');
});
