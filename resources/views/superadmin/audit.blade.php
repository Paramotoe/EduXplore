@extends('layouts.app')
@section('title', 'Jejak Audit')
@section('header_title', 'Jejak Audit Sistem')

@section('content')
<div class="space-y-6 p-5 md:p-8">
  <div class="card p-5">
    <form method="GET" class="flex flex-col gap-3 sm:flex-row sm:items-end">
      <div class="flex-1">
        <label class="mb-1.5 block text-xs font-bold text-slate-600">Saring berdasarkan jenis aksi</label>
        <select name="action" class="field">
          <option value="">Semua aksi</option>
          @foreach($daftarAksi as $a)
            <option value="{{ $a }}" @selected($aksi === $a)>{{ $a }}</option>
          @endforeach
        </select>
      </div>
      <button class="btn-primary">Terapkan</button>
    </form>
  </div>

  <div class="card overflow-hidden">
    <div class="overflow-x-auto">
      <table class="min-w-full text-sm">
        <thead class="bg-slate-50 text-left text-[11px] uppercase tracking-wide text-slate-500">
          <tr>
            <th class="px-5 py-3">Waktu</th>
            <th class="px-5 py-3">Pelaku</th>
            <th class="px-5 py-3">Aksi</th>
            <th class="px-5 py-3">Keterangan</th>
            <th class="px-5 py-3">Alamat IP</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          @forelse($logs as $log)
            <tr class="hover:bg-slate-50/60">
              <td class="px-5 py-3 whitespace-nowrap text-xs text-slate-500">{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
              <td class="px-5 py-3">
                <p class="font-bold text-slate-700">{{ $log->actor_name }}</p>
                <p class="text-[11px] text-slate-400">{{ $log->actor_role }}</p>
              </td>
              <td class="px-5 py-3"><span class="badge bg-slate-100 text-slate-600">{{ $log->action }}</span></td>
              <td class="px-5 py-3 text-slate-600">{{ $log->description }}</td>
              <td class="px-5 py-3 font-mono text-xs text-slate-500">{{ $log->ip_address }}</td>
            </tr>
          @empty
            <tr><td colspan="5" class="px-5 py-10 text-center text-slate-400">Belum ada catatan audit.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="border-t border-slate-100 p-4">{{ $logs->links() }}</div>
  </div>
</div>
@endsection
