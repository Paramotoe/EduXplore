@extends('layouts.app')
@section('title', 'Nilai Saya')
@section('header_title', 'Rekapitulasi Nilai Saya')

@section('content')
<div class="space-y-6 p-5 md:p-8">
  @include('partials.alerts')

  <div class="card overflow-hidden">
    <div class="overflow-x-auto">
      <table class="min-w-full text-sm">
        <thead class="bg-slate-50 text-left text-[11px] uppercase tracking-wide text-slate-500">
          <tr>
            <th class="px-5 py-3">Mata Pelajaran</th>
            <th class="px-5 py-3">Tugas</th>
            <th class="px-5 py-3">Dikumpulkan</th>
            <th class="px-5 py-3 text-center">Nilai</th>
            <th class="px-5 py-3">Predikat</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          @forelse($pengumpulan as $p)
            @php
              $n = $p->nilai;
              $predikat = is_null($n) ? ['Belum dinilai', 'bg-slate-100 text-slate-500']
                        : ($n >= 90 ? ['A — Sangat Baik', 'bg-emerald-50 text-emerald-600']
                        : ($n >= 80 ? ['B — Baik', 'bg-blue-50 text-blue-600']
                        : ($n >= 70 ? ['C — Cukup', 'bg-amber-50 text-amber-600']
                        : ['D — Perlu Perbaikan', 'bg-rose-50 text-rose-600'])));
            @endphp
            <tr class="hover:bg-slate-50/60">
              <td class="px-5 py-3 font-bold text-slate-700">{{ $p->tugas?->mapel?->nama_mapel ?? '—' }}</td>
              <td class="px-5 py-3 text-slate-600">{{ $p->tugas?->judul_tugas ?? '—' }}</td>
              <td class="px-5 py-3 text-xs text-slate-400">{{ $p->created_at?->format('d/m/Y H:i') }}</td>
              <td class="px-5 py-3 text-center text-lg font-extrabold text-slate-800">{{ $n ?? '–' }}</td>
              <td class="px-5 py-3"><span class="badge {{ $predikat[1] }}">{{ $predikat[0] }}</span></td>
            </tr>
          @empty
            <tr><td colspan="5" class="px-5 py-10 text-center text-slate-400">Anda belum mengumpulkan tugas apa pun.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
