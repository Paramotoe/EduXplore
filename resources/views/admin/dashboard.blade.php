@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('header_title', 'Dashboard Admin Sekolah')

@section('content')
<div class="space-y-6 p-5 md:p-8">
  @include('partials.alerts')

  <div class="card brand-gradient p-6 text-white">
    <p class="text-xs uppercase tracking-widest text-white/60">Panel Operator Sekolah</p>
    <h2 class="mt-2 text-2xl font-extrabold">{{ $namaSekolah }}</h2>
    <p class="mt-1 text-sm text-white/70">Kelola akun warga sekolah, konfigurasi sistem, dan pantau aktivitas pembelajaran.</p>
  </div>

  @include('admin._stats')

  <div class="grid gap-6 lg:grid-cols-3">
    <div class="card p-6 lg:col-span-2">
      <h3 class="mb-4 text-sm font-extrabold text-slate-700">Pengguna Terbaru</h3>
      <div class="space-y-3">
        @forelse($terbaru as $p)
          <div class="flex items-center gap-3 rounded-xl border border-slate-100 p-3">
            <img src="{{ $p->photoUrl() }}" alt="Foto {{ $p->name }}" class="h-9 w-9 rounded-full object-cover">
            <div class="min-w-0 flex-1">
              <p class="truncate text-sm font-bold text-slate-700">{{ $p->name }}</p>
              <p class="text-[11px] text-slate-400">{{ $p->identity }} &middot; {{ $p->roleLabel() }}</p>
            </div>
            <span class="badge {{ $p->is_active ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">
              {{ $p->is_active ? 'Aktif' : 'Nonaktif' }}
            </span>
          </div>
        @empty
          <p class="text-sm text-slate-400">Belum ada data pengguna.</p>
        @endforelse
      </div>
      <a href="{{ route('admin.users.index') }}" class="mt-4 inline-block text-xs font-bold text-brand hover:underline">Lihat seluruh pengguna →</a>
    </div>

    <div class="card p-6">
      <h3 class="mb-4 text-sm font-extrabold text-slate-700">Ringkasan Akademik</h3>
      <dl class="space-y-3 text-sm">
        @foreach([['Tugas diterbitkan', $statistik['tugas']], ['Pengumpulan tugas', $statistik['pengumpulan']], ['Pesan forum', $statistik['diskusi']], ['Akun administratif', $statistik['admin']]] as [$label, $nilai])
          <div class="flex items-center justify-between border-b border-slate-100 pb-2">
            <dt class="text-slate-500">{{ $label }}</dt>
            <dd class="font-extrabold text-slate-800">{{ $nilai }}</dd>
          </div>
        @endforeach
      </dl>
      <a href="{{ route('admin.settings') }}" class="btn-ghost mt-5 block text-center">Buka Konfigurasi</a>
    </div>
  </div>
</div>
@endsection
