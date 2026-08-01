@extends('layouts.app')
@section('title', 'Pengumuman')
@section('header_title', 'Pengumuman Sekolah')

@section('content')
<div class="grid gap-6 p-5 md:p-8 lg:grid-cols-3">
  <div class="lg:col-span-1">
    <form method="POST" action="{{ route('pengumuman.store') }}" class="card p-6 space-y-4">
      @csrf
      <h3 class="text-sm font-extrabold text-slate-700">Siarkan Pengumuman</h3>
      <div>
        <label class="mb-1.5 block text-xs font-bold text-slate-600">Judul</label>
        <input name="judul" value="{{ old('judul') }}" required maxlength="150"
               class="field {{ $errors->has('judul') ? 'field-error' : '' }}">
        @error('judul')<p class="mt-1 text-[11px] font-semibold text-red-500">{{ $message }}</p>@enderror
      </div>
      <div>
        <label class="mb-1.5 block text-xs font-bold text-slate-600">Isi Pengumuman</label>
        <textarea name="isi" rows="5" required maxlength="2000"
                  class="field {{ $errors->has('isi') ? 'field-error' : '' }}">{{ old('isi') }}</textarea>
        @error('isi')<p class="mt-1 text-[11px] font-semibold text-red-500">{{ $message }}</p>@enderror
      </div>
      <button class="btn-primary w-full">Terbitkan</button>
    </form>
  </div>

  <div class="space-y-4 lg:col-span-2">
    @include('partials.alerts')
    @forelse($pengumuman as $p)
      <div class="card p-5">
        <div class="flex items-start justify-between gap-4">
          <div class="min-w-0">
            <h4 class="text-sm font-extrabold text-slate-800">{{ $p->judul }}</h4>
            <p class="mt-2 whitespace-pre-line text-sm leading-relaxed text-slate-600">{{ $p->isi }}</p>
            <p class="mt-3 text-[11px] text-slate-400">{{ $p->guru?->name }} &middot; {{ $p->created_at->format('d/m/Y H:i') }}</p>
          </div>
          @if($p->id_guru === Auth::id())
            <form method="POST" action="{{ route('pengumuman.delete', $p->id) }}" onsubmit="return confirm('Hapus pengumuman ini?');">
              @csrf
              <button class="btn-ghost !py-1.5 !px-3 !border-red-200 !text-red-600">Hapus</button>
            </form>
          @endif
        </div>
      </div>
    @empty
      <div class="card p-10 text-center text-slate-400">Belum ada pengumuman yang diterbitkan.</div>
    @endforelse
  </div>
</div>
@endsection
