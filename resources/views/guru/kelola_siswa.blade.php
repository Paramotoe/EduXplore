@extends('layouts.app')
@section('title', 'Daftar Siswa')
@section('header_title', 'Daftar Siswa')

@section('content')
<div class="space-y-6 p-5 md:p-8">
  <div class="rounded-xl border border-blue-100 bg-blue-50 p-4 text-xs font-semibold text-blue-700">
    Guru memiliki hak akses baca terhadap data siswa. Perubahan data akun hanya dapat dilakukan oleh Admin sekolah.
  </div>

  <div class="card overflow-hidden">
    <div class="overflow-x-auto">
      <table class="min-w-full text-sm">
        <thead class="bg-slate-50 text-left text-[11px] uppercase tracking-wide text-slate-500">
          <tr>
            <th class="px-5 py-3">Siswa</th>
            <th class="px-5 py-3">NIS</th>
            <th class="px-5 py-3">Kelas</th>
            <th class="px-5 py-3">Email</th>
            <th class="px-5 py-3">Status</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          @forelse($siswa as $s)
            <tr class="hover:bg-slate-50/60">
              <td class="px-5 py-3">
                <div class="flex items-center gap-3">
                  <img src="{{ $s->photoUrl() }}" alt="Foto {{ $s->name }}" class="h-9 w-9 rounded-full object-cover">
                  <span class="font-bold text-slate-700">{{ $s->name }}</span>
                </div>
              </td>
              <td class="px-5 py-3 font-mono text-xs text-slate-600">{{ $s->identity }}</td>
              <td class="px-5 py-3 text-slate-600">{{ $s->kelas ?? '—' }}</td>
              <td class="px-5 py-3 text-xs text-slate-500">{{ $s->email }}</td>
              <td class="px-5 py-3">
                <span class="badge {{ $s->is_active ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">
                  {{ $s->is_active ? 'Aktif' : 'Nonaktif' }}
                </span>
              </td>
            </tr>
          @empty
            <tr><td colspan="5" class="px-5 py-10 text-center text-slate-400">Belum ada data siswa.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
