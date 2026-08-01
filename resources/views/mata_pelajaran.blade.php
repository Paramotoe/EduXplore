@extends('layouts.app')
@section('title', 'Mata Pelajaran')
@section('header_title', Auth::user()->isGuru() ? 'Kelas yang Saya Ampu' : 'Mata Pelajaran')

@section('content')
<div class="space-y-6 p-5 md:p-8">
  @include('partials.alerts')

  @if(Auth::user()->isGuru())
    <form method="POST" action="{{ route('mapel.store') }}" class="card flex flex-col gap-3 p-5 sm:flex-row sm:items-end">
      @csrf
      <div class="flex-1">
        <label class="mb-1.5 block text-xs font-bold text-slate-600">Nama Mata Pelajaran Baru</label>
        <input name="nama_mapel" value="{{ old('nama_mapel') }}" required minlength="3" maxlength="100"
               class="field {{ $errors->has('nama_mapel') ? 'field-error' : '' }}" placeholder="Pemrograman Web Dasar">
        @error('nama_mapel')<p class="mt-1 text-[11px] font-semibold text-red-500">{{ $message }}</p>@enderror
      </div>
      <button class="btn-primary">+ Tambah Kelas</button>
    </form>
  @endif

  <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
    @forelse($mapel as $m)
      <div class="card flex flex-col p-5">
        <div class="mb-4 flex items-start justify-between">
          <div class="grid h-11 w-11 place-items-center rounded-xl brand-gradient text-lg text-white">📘</div>
          <span class="badge bg-slate-100 text-slate-600">{{ $m->tugas_count }} tugas</span>
        </div>
        <h3 class="text-base font-extrabold text-slate-800">{{ $m->nama_mapel }}</h3>
        <p class="mt-1 text-xs text-slate-400">Pengampu: {{ $m->guru?->name ?? 'Belum ditentukan' }}</p>

        <div class="mt-5 flex gap-2">
          <a href="{{ route('mapel.detail', $m->id_mapel) }}" class="btn-primary flex-1 text-center !py-2">Buka Kelas</a>
          @if(Auth::user()->isGuru() && $m->id_guru === Auth::id())
            <form method="POST" action="{{ route('mapel.delete', $m->id_mapel) }}"
                  onsubmit="return confirm('Hapus mata pelajaran {{ $m->nama_mapel }} beserta tugasnya?');">
              @csrf
              <button class="btn-ghost !py-2 !px-3 !border-red-200 !text-red-600">Hapus</button>
            </form>
          @endif
        </div>
      </div>
    @empty
      <div class="card col-span-full p-10 text-center text-slate-400">Belum ada mata pelajaran yang terdaftar.</div>
    @endforelse
  </div>
</div>
@endsection
