@extends('layouts.app')
@section('title', 'Dashboard Guru')
@section('header_title', 'Beranda Guru')

@section('content')
<div class="space-y-6 p-5 md:p-8">
  @include('partials.alerts')

  <div class="card brand-gradient p-6 text-white">
    <p class="text-xs uppercase tracking-widest text-white/60">Ruang Kerja Pendidik</p>
    <h2 class="mt-2 text-2xl font-extrabold">Selamat mengajar, {{ Auth::user()->name }}</h2>
    <p class="mt-1 text-sm text-white/70">Kelola kelas ampuan, terbitkan tugas, dan berikan penilaian tepat waktu.</p>
  </div>

  <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
    @foreach([
      ['Kelas Diampu', $statistik['mapel'], '📚'],
      ['Tugas Terbit', $statistik['tugas'], '📝'],
      ['Siswa Aktif', $statistik['siswa'], '🎓'],
      ['Menunggu Nilai', $statistik['antrian'], '⏳'],
    ] as [$judul, $nilai, $ikon])
      <div class="card p-5">
        <div class="flex items-start justify-between">
          <div>
            <p class="text-[11px] font-bold uppercase tracking-wide text-slate-400">{{ $judul }}</p>
            <p class="mt-2 text-3xl font-extrabold text-slate-800">{{ $nilai }}</p>
          </div>
          <span class="text-xl">{{ $ikon }}</span>
        </div>
      </div>
    @endforeach
  </div>

  <div class="grid gap-6 lg:grid-cols-2">
    <div class="card p-6">
      <h3 class="mb-4 text-sm font-extrabold text-slate-700">Kelas yang Anda Ampu</h3>
      <div class="space-y-2">
        @forelse($mapel as $m)
          <a href="{{ route('mapel.detail', $m->id_mapel) }}"
             class="flex items-center justify-between rounded-xl border border-slate-100 p-3 transition hover:border-brand/40 hover:bg-slate-50">
            <div>
              <p class="text-sm font-bold text-slate-700">{{ $m->nama_mapel }}</p>
              <p class="text-[11px] text-slate-400">{{ $m->tugas_count }} tugas aktif</p>
            </div>
            <span class="text-brand">→</span>
          </a>
        @empty
          <p class="text-sm text-slate-400">Anda belum menambahkan mata pelajaran.</p>
          <a href="{{ route('mapel.index') }}" class="btn-ghost mt-3 inline-block">Tambah mata pelajaran</a>
        @endforelse
      </div>
    </div>

    <div class="card p-6">
      <div class="mb-4 flex items-center justify-between">
        <h3 class="text-sm font-extrabold text-slate-700">Menunggu Penilaian</h3>
        <a href="{{ route('guru.nilai') }}" class="text-xs font-bold text-brand hover:underline">Rekap nilai →</a>
      </div>
      <div class="space-y-2">
        @forelse($belumDinilai as $p)
          <div class="rounded-xl border border-amber-100 bg-amber-50/60 p-3">
            <p class="text-sm font-bold text-slate-700">{{ $p->siswa?->name ?? 'Siswa' }}</p>
            <p class="text-[11px] text-slate-500">{{ $p->tugas?->judul_tugas }} &middot; {{ $p->tugas?->mapel?->nama_mapel }}</p>
          </div>
        @empty
          <p class="text-sm text-slate-400">Seluruh pekerjaan siswa sudah dinilai. Kerja bagus!</p>
        @endforelse
      </div>
    </div>
  </div>
</div>
@endsection
