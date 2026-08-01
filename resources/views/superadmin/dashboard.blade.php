@extends('layouts.app')
@section('title', 'Dashboard Super Admin')
@section('header_title', 'Dashboard Super Admin')

@section('content')
<div class="space-y-6 p-5 md:p-8">
  @include('partials.alerts')

  <div class="card brand-gradient p-6 text-white">
    <p class="text-xs uppercase tracking-widest text-white/60">Kendali Penuh Sistem</p>
    <h2 class="mt-2 text-2xl font-extrabold">Selamat datang, {{ Auth::user()->name }}</h2>
    <p class="mt-1 text-sm text-white/70">
      Anda memiliki akses tanpa batas terhadap seluruh modul, data sensitif, pengaturan peran, dan jejak audit sistem.
    </p>
  </div>

  @include('admin._stats')

  <div class="grid gap-6 lg:grid-cols-3">
    <div class="card p-6 lg:col-span-2">
      <div class="mb-4 flex items-center justify-between">
        <h3 class="text-sm font-extrabold text-slate-700">Aktivitas Sistem Terkini</h3>
        <a href="{{ route('superadmin.audit') }}" class="text-xs font-bold text-brand hover:underline">Semua jejak audit →</a>
      </div>
      <div class="space-y-2">
        @forelse($aktivitas as $log)
          <div class="flex items-start gap-3 rounded-xl border border-slate-100 p-3">
            <span class="badge bg-slate-100 text-slate-600">{{ $log->action }}</span>
            <div class="min-w-0 flex-1">
              <p class="truncate text-sm text-slate-700">{{ $log->description }}</p>
              <p class="text-[11px] text-slate-400">{{ $log->actor_name }} &middot; {{ $log->created_at->format('d/m/Y H:i') }} &middot; IP {{ $log->ip_address }}</p>
            </div>
          </div>
        @empty
          <p class="text-sm text-slate-400">Belum ada aktivitas tercatat.</p>
        @endforelse
      </div>
    </div>

    <div class="card p-6">
      <h3 class="mb-4 text-sm font-extrabold text-slate-700">Aksi Cepat</h3>
      <div class="space-y-2">
        <a href="{{ route('admin.users.create') }}" class="btn-ghost block text-center">Tambah Akun Pengguna</a>
        <a href="{{ route('admin.users.index') }}" class="btn-ghost block text-center">Kelola Peran Pengguna</a>
        <a href="{{ route('admin.settings') }}" class="btn-ghost block text-center">Konfigurasi Inti Sistem</a>
        <a href="{{ route('superadmin.audit') }}" class="btn-ghost block text-center">Audit Keamanan</a>
      </div>
    </div>
  </div>
</div>
@endsection
