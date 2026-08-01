@extends('layouts.app')
@section('title', 'Manajemen Pengguna')
@section('header_title', 'Manajemen Pengguna')

@section('content')
<div class="space-y-6 p-5 md:p-8">
  @include('partials.alerts')

  <div class="card p-5">
    <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col gap-3 md:flex-row md:items-end">
      <div class="flex-1">
        <label for="q" class="mb-1.5 block text-xs font-bold text-slate-600">Cari pengguna</label>
        <input id="q" name="q" value="{{ $keyword }}" class="field" placeholder="Nama, NIS/NIP, atau email">
      </div>
      <div class="w-full md:w-56">
        <label for="role" class="mb-1.5 block text-xs font-bold text-slate-600">Peran</label>
        <select id="role" name="role" class="field">
          <option value="">Semua peran</option>
          @foreach(\App\Models\User::ROLES as $kode => $label)
            @if($kode !== 'super_admin' || Auth::user()->isSuperAdmin())
              <option value="{{ $kode }}" @selected($role === $kode)>{{ $label }}</option>
            @endif
          @endforeach
        </select>
      </div>
      <button class="btn-primary">Terapkan</button>
      <a href="{{ route('admin.users.create') }}" class="btn-ghost text-center">+ Tambah Pengguna</a>
    </form>
  </div>

  <div class="card overflow-hidden">
    <div class="overflow-x-auto">
      <table class="min-w-full text-sm">
        <thead class="bg-slate-50 text-left text-[11px] uppercase tracking-wide text-slate-500">
          <tr>
            <th class="px-5 py-3">Pengguna</th>
            <th class="px-5 py-3">NIS / NIP</th>
            <th class="px-5 py-3">Kontak</th>
            <th class="px-5 py-3">Peran</th>
            <th class="px-5 py-3">Status</th>
            <th class="px-5 py-3 text-right">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          @forelse($users as $p)
          <tr class="hover:bg-slate-50/60">
            <td class="px-5 py-3">
              <div class="flex items-center gap-3">
                <img src="{{ $p->photoUrl() }}" alt="Foto {{ $p->name }}" class="h-9 w-9 rounded-full object-cover">
                <div>
                  <p class="font-bold text-slate-700">{{ $p->name }}</p>
                  <p class="text-[11px] text-slate-400">{{ $p->kelas ?? '—' }}</p>
                </div>
              </div>
            </td>
            <td class="px-5 py-3 font-mono text-xs text-slate-600">{{ $p->identity }}</td>
            <td class="px-5 py-3 text-xs text-slate-500">
              {{ $p->email }}<br><span class="text-slate-400">{{ $p->phone ?? '—' }}</span>
            </td>
            <td class="px-5 py-3">
              <span class="badge {{ $p->isStaff() ? 'bg-indigo-50 text-indigo-600' : ($p->isGuru() ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-600') }}">
                {{ $p->roleLabel() }}
              </span>
            </td>
            <td class="px-5 py-3">
              <span class="badge {{ $p->is_active ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">
                {{ $p->is_active ? 'Aktif' : 'Nonaktif' }}
              </span>
            </td>
            <td class="px-5 py-3">
              <div class="flex justify-end gap-2">
                <a href="{{ route('admin.users.edit', $p->id) }}" class="btn-ghost !py-1.5 !px-3">Ubah</a>
                <form method="POST" action="{{ route('admin.users.toggle', $p->id) }}">
                  @csrf
                  <button class="btn-ghost !py-1.5 !px-3">{{ $p->is_active ? 'Nonaktifkan' : 'Aktifkan' }}</button>
                </form>
                <form method="POST" action="{{ route('admin.users.destroy', $p->id) }}"
                      onsubmit="return confirm('Hapus permanen akun {{ $p->name }}?');">
                  @csrf
                  <button class="btn-ghost !py-1.5 !px-3 !border-red-200 !text-red-600">Hapus</button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr><td colspan="6" class="px-5 py-10 text-center text-slate-400">Tidak ada pengguna yang cocok dengan pencarian.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="border-t border-slate-100 p-4">{{ $users->links() }}</div>
  </div>
</div>
@endsection
