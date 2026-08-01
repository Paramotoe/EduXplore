@extends('layouts.app')
@section('title', 'Rekap Nilai')
@section('header_title', 'Rekapitulasi & Penilaian')

@section('content')
<div class="space-y-6 p-5 md:p-8">
  @include('partials.alerts')

  @forelse($mapel as $m)
    <div class="card p-6">
      <h3 class="text-sm font-extrabold text-slate-700">{{ $m->nama_mapel }}</h3>

      @forelse($m->tugas as $t)
        <div class="mt-5">
          <p class="text-xs font-bold uppercase tracking-wide text-slate-400">{{ $t->judul_tugas }}</p>
          <div class="mt-2 overflow-x-auto">
            <table class="min-w-full text-sm">
              <thead class="bg-slate-50 text-left text-[11px] uppercase text-slate-500">
                <tr>
                  <th class="px-4 py-2">Siswa</th>
                  <th class="px-4 py-2">Jawaban / Tautan</th>
                  <th class="px-4 py-2 w-56">Nilai (0–100)</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100">
                @forelse($t->pengumpulan as $p)
                  <tr>
                    <td class="px-4 py-2">
                      <p class="font-bold text-slate-700">{{ $p->siswa?->name }}</p>
                      <p class="text-[11px] text-slate-400">{{ $p->siswa?->identity }}</p>
                    </td>
                    <td class="px-4 py-2 max-w-md break-words text-slate-600">{{ $p->jawaban_atau_link }}</td>
                    <td class="px-4 py-2">
                      <form method="POST" action="{{ route('nilai.store', $p->id) }}" class="flex gap-2">
                        @csrf
                        <input type="number" name="nilai" min="0" max="100" step="1" required
                               value="{{ $p->nilai }}" class="field !py-2" aria-label="Nilai untuk {{ $p->siswa?->name }}">
                        <button class="btn-primary !py-2 !px-4">Simpan</button>
                      </form>
                    </td>
                  </tr>
                @empty
                  <tr><td colspan="3" class="px-4 py-4 text-center text-slate-400">Belum ada pengumpulan untuk tugas ini.</td></tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      @empty
        <p class="mt-3 text-sm text-slate-400">Belum ada tugas pada mata pelajaran ini.</p>
      @endforelse
    </div>
  @empty
    <div class="card p-10 text-center text-slate-400">Anda belum mengampu mata pelajaran apa pun.</div>
  @endforelse
</div>
@endsection
