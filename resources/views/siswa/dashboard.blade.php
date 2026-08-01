@extends('layouts.app')
@section('title', 'Dashboard Siswa')
@section('header_title', 'Beranda Siswa')

@section('content')
<div class="space-y-6 p-5 md:p-8">
  @include('partials.alerts')

  <div class="card brand-gradient p-6 text-white">
    <p class="text-xs uppercase tracking-widest text-white/60">Ruang Belajar</p>
    <h2 class="mt-2 text-2xl font-extrabold">Halo, {{ Auth::user()->name }}</h2>
    <p class="mt-1 text-sm text-white/70">
      Kelas {{ Auth::user()->kelas ?? '—' }} &middot; NIS {{ Auth::user()->identity }}
    </p>
  </div>

  <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
    @foreach([
      ['Total Tugas', $statistik['tugas'], '📚'],
      ['Sudah Dikumpul', $statistik['terkumpul'], '✅'],
      ['Sudah Dinilai', $statistik['dinilai'], '📊'],
      ['Rata-rata Nilai', $statistik['rata'], '⭐'],
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
      <h3 class="mb-4 text-sm font-extrabold text-slate-700">Tugas Belum Dikumpulkan</h3>
      <div class="space-y-2">
        @forelse($tugasBelum as $t)
          <a href="{{ route('mapel.detail', $t->id_mapel) }}"
             class="block rounded-xl border border-rose-100 bg-rose-50/50 p-3 transition hover:bg-rose-50">
            <p class="text-sm font-bold text-slate-700">{{ $t->judul_tugas }}</p>
            <p class="text-[11px] text-slate-500">{{ $t->mapel?->nama_mapel }}</p>
          </a>
        @empty
          <p class="text-sm text-slate-400">Tidak ada tugas tertunda. Pertahankan!</p>
        @endforelse
      </div>
    </div>

    <div class="card p-6">
      <h3 class="mb-4 text-sm font-extrabold text-slate-700">Pengumuman Sekolah</h3>
      <div class="space-y-2">
        @forelse($pengumuman as $p)
          <div class="rounded-xl border border-slate-100 p-3">
            <p class="text-sm font-bold text-slate-700">{{ $p->judul }}</p>
            <p class="mt-1 text-xs leading-relaxed text-slate-500">{{ $p->isi }}</p>
            <p class="mt-2 text-[11px] text-slate-400">{{ $p->guru?->name }} &middot; {{ $p->created_at->format('d/m/Y') }}</p>
          </div>
        @empty
          <p class="text-sm text-slate-400">Belum ada pengumuman.</p>
        @endforelse
      </div>
    </div>
  </div>
</div>
@endsection
