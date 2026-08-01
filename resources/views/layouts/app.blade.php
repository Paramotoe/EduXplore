<!DOCTYPE html>
<html lang="id">
<head>
  @include('partials.head')
</head>
<body class="bg-slate-100 min-h-screen">
@php
    /** @var \App\Models\User $u */
    $u = Auth::user();
    $menu = match ($u->role) {
        'super_admin' => [
            ['superadmin.dashboard', '🏠', 'Beranda'],
            ['admin.users.index',    '👥', 'Manajemen Pengguna'],
            ['admin.settings',       '⚙️', 'Konfigurasi Sistem'],
            ['superadmin.audit',     '🛡️', 'Jejak Audit'],
            ['mapel.index',          '📚', 'Mata Pelajaran'],
            ['forum.index',          '💬', 'Forum Diskusi'],
            ['profil.index',         '👤', 'Profil Akun'],
        ],
        'admin' => [
            ['admin.dashboard',   '🏠', 'Beranda'],
            ['admin.users.index', '👥', 'Manajemen Pengguna'],
            ['admin.settings',    '⚙️', 'Konfigurasi Sekolah'],
            ['mapel.index',       '📚', 'Mata Pelajaran'],
            ['forum.index',       '💬', 'Forum Diskusi'],
            ['profil.index',      '👤', 'Profil Akun'],
        ],
        'guru' => [
            ['guru.dashboard',     '🏠', 'Beranda'],
            ['mapel.index',        '📚', 'Kelas Saya'],
            ['guru.nilai',         '📊', 'Rekap Nilai'],
            ['guru.pengumuman',    '📢', 'Pengumuman'],
            ['guru.kelola_siswa',  '🎓', 'Daftar Siswa'],
            ['forum.index',        '💬', 'Forum Diskusi'],
            ['profil.index',       '👤', 'Profil Akun'],
        ],
        default => [
            ['siswa.dashboard', '🏠', 'Beranda'],
            ['mapel.index',     '📚', 'Mata Pelajaran'],
            ['siswa.nilai',     '📊', 'Nilai Saya'],
            ['forum.index',     '💬', 'Forum Diskusi'],
            ['profil.index',    '👤', 'Profil Akun'],
        ],
    };
@endphp

<div class="flex min-h-screen">
  <aside class="hidden md:flex flex-col w-64 brand-gradient text-white fixed inset-y-0 left-0 z-40">
    <div class="px-6 py-6 border-b border-white/10">
      <div class="flex items-center gap-2">
        <div class="h-9 w-9 rounded-xl bg-white/15 grid place-items-center text-lg">🎓</div>
        <div>
          <p class="text-lg font-extrabold leading-none tracking-tight">EduXplore</p>
          <p class="text-[10px] text-white/60 mt-1">Sistem Pembelajaran Sekolah</p>
        </div>
      </div>
    </div>

    <div class="px-6 py-5 border-b border-white/10 flex items-center gap-3">
      <img src="{{ $u->photoUrl() }}" alt="Foto profil {{ $u->name }}" class="h-11 w-11 rounded-full object-cover border-2 border-white/30">
      <div class="min-w-0">
        <p class="text-sm font-bold truncate">{{ $u->name }}</p>
        <span class="badge bg-white/15 text-white/90 inline-block mt-1">{{ $u->roleLabel() }}</span>
      </div>
    </div>

    <nav class="flex-1 overflow-y-auto p-4 space-y-1">
      @foreach($menu as [$rute, $ikon, $label])
        @php $aktif = request()->routeIs($rute) || request()->routeIs(str_replace('.index', '.*', $rute)); @endphp
        <a href="{{ route($rute) }}"
           class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition {{ $aktif ? 'bg-white text-[#0b2545] shadow' : 'text-white/75 hover:bg-white/10 hover:text-white' }}">
          <span class="text-base">{{ $ikon }}</span><span>{{ $label }}</span>
        </a>
      @endforeach
    </nav>

    <div class="p-4 border-t border-white/10">
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="w-full rounded-xl bg-red-500/90 hover:bg-red-500 py-2.5 text-sm font-bold transition">Keluar</button>
      </form>
    </div>
  </aside>

  <main class="flex-1 md:ml-64 w-full pb-24 md:pb-0">
    <header class="sticky top-0 z-30 flex h-16 items-center justify-between border-b border-slate-200 bg-white/90 px-5 md:px-8 backdrop-blur">
      <div>
        <h1 class="text-base md:text-lg font-extrabold text-slate-800">@yield('header_title', 'EduXplore')</h1>
        <p class="hidden md:block text-[11px] text-slate-400">@yield('header_subtitle', \App\Models\Setting::get('nama_sekolah') . ' · Tahun Ajaran ' . \App\Models\Setting::get('tahun_ajaran'))</p>
      </div>
      <a href="{{ route('profil.index') }}" class="flex items-center gap-3">
        <div class="hidden sm:block text-right">
          <p class="text-xs font-bold text-slate-700 leading-none">{{ $u->name }}</p>
          <p class="text-[10px] text-slate-400 mt-1">{{ $u->identity }}</p>
        </div>
        <img src="{{ $u->photoUrl() }}" alt="Foto profil {{ $u->name }}" class="h-9 w-9 rounded-full object-cover border border-slate-200">
      </a>
    </header>

    @yield('content')
  </main>

  <nav class="md:hidden fixed bottom-0 inset-x-0 z-50 flex justify-around border-t border-slate-200 bg-white px-2 py-2">
    @foreach(array_slice($menu, 0, 5) as [$rute, $ikon, $label])
      <a href="{{ route($rute) }}" class="flex flex-col items-center gap-0.5 px-2 {{ request()->routeIs($rute) ? 'text-brand' : 'text-slate-400' }}">
        <span class="text-lg">{{ $ikon }}</span>
        <span class="text-[9px] font-bold">{{ \Illuminate\Support\Str::limit($label, 9, '') }}</span>
      </a>
    @endforeach
  </nav>
</div>
</body>
</html>
