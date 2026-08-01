@extends('layouts.app')
@section('title', $mapel->nama_mapel)
@section('header_title', $mapel->nama_mapel)
@section('header_subtitle', 'Pengampu: ' . ($mapel->guru?->name ?? '—'))

@section('content')
@php $peran = Auth::user(); @endphp
<div class="space-y-6 p-5 md:p-8">
  @include('partials.alerts')

  <a href="{{ route('mapel.index') }}" class="inline-block text-xs font-bold text-brand hover:underline">← Kembali ke daftar mata pelajaran</a>

  @if($peran->isGuru() && $mapel->id_guru === $peran->id)
    <form method="POST" action="{{ route('tugas.store', $mapel->id_mapel) }}" class="card space-y-4 p-6">
      @csrf
      <h3 class="text-sm font-extrabold text-slate-700">Terbitkan Tugas Baru</h3>
      <div>
        <label class="mb-1.5 block text-xs font-bold text-slate-600">Judul Tugas</label>
        <input name="judul_tugas" value="{{ old('judul_tugas') }}" required minlength="3" maxlength="150"
               class="field {{ $errors->has('judul_tugas') ? 'field-error' : '' }}">
        @error('judul_tugas')<p class="mt-1 text-[11px] font-semibold text-red-500">{{ $message }}</p>@enderror
      </div>
      <div>
        <label class="mb-1.5 block text-xs font-bold text-slate-600">Deskripsi &amp; Instruksi</label>
        <textarea name="deskripsi" rows="4" required maxlength="2000"
                  class="field {{ $errors->has('deskripsi') ? 'field-error' : '' }}">{{ old('deskripsi') }}</textarea>
        @error('deskripsi')<p class="mt-1 text-[11px] font-semibold text-red-500">{{ $message }}</p>@enderror
      </div>
      <button class="btn-primary">Terbitkan Tugas</button>
    </form>
  @endif

  <div class="space-y-4">
    @forelse($mapel->tugas as $t)
      @php $milikSaya = $t->pengumpulan->firstWhere('id_siswa', $peran->id); @endphp
      <div class="card p-6">
        <div class="flex flex-wrap items-start justify-between gap-3">
          <div>
            <h4 class="text-base font-extrabold text-slate-800">{{ $t->judul_tugas }}</h4>
            <p class="mt-1 text-[11px] text-slate-400">Diterbitkan {{ $t->created_at->format('d/m/Y H:i') }}</p>
          </div>
          <span class="badge bg-slate-100 text-slate-600">{{ $t->pengumpulan->count() }} pengumpulan</span>
        </div>
        <p class="mt-3 whitespace-pre-line text-sm leading-relaxed text-slate-600">{{ $t->deskripsi }}</p>

        @if($peran->isSiswa())
          <div class="mt-5 rounded-xl border border-slate-100 bg-slate-50 p-4">
            @if($milikSaya)
              <p class="text-xs font-bold text-emerald-600">✅ Sudah dikumpulkan
                @if(! is_null($milikSaya->nilai))
                  &middot; Nilai: <span class="text-slate-800">{{ $milikSaya->nilai }}</span>
                @else
                  &middot; menunggu penilaian guru
                @endif
              </p>
            @endif
            <form method="POST" action="{{ route('tugas.submit', $t->id) }}" class="mt-3 space-y-3">
              @csrf
              <label class="block text-xs font-bold text-slate-600">Jawaban atau tautan pekerjaan</label>
              <textarea name="jawaban_atau_link" rows="3" required minlength="3" maxlength="2000"
                        class="field">{{ old('jawaban_atau_link', $milikSaya->jawaban_atau_link ?? '') }}</textarea>
              <button class="btn-primary !py-2">{{ $milikSaya ? 'Perbarui Pengumpulan' : 'Kumpulkan Tugas' }}</button>
            </form>
          </div>
        @else
          <div class="mt-5 overflow-x-auto">
            <table class="min-w-full text-sm">
              <thead class="bg-slate-50 text-left text-[11px] uppercase text-slate-500">
                <tr><th class="px-4 py-2">Siswa</th><th class="px-4 py-2">Jawaban</th><th class="px-4 py-2 text-center">Nilai</th></tr>
              </thead>
              <tbody class="divide-y divide-slate-100">
                @forelse($t->pengumpulan as $p)
                  <tr>
                    <td class="px-4 py-2 font-bold text-slate-700">{{ $p->siswa?->name }}</td>
                    <td class="px-4 py-2 max-w-md break-words text-slate-600">{{ $p->jawaban_atau_link }}</td>
                    <td class="px-4 py-2 text-center font-extrabold text-slate-800">{{ $p->nilai ?? '–' }}</td>
                  </tr>
                @empty
                  <tr><td colspan="3" class="px-4 py-4 text-center text-slate-400">Belum ada siswa yang mengumpulkan.</td></tr>
                @endforelse
              </tbody>
            </table>
          </div>
        @endif
      </div>
    @empty
      <div class="card p-10 text-center text-slate-400">Belum ada tugas pada mata pelajaran ini.</div>
    @endforelse
  </div>
</div>
@endsection
