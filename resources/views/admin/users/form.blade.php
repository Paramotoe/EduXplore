@extends('layouts.app')
@section('title', $user->exists ? 'Ubah Pengguna' : 'Tambah Pengguna')
@section('header_title', $user->exists ? 'Ubah Data Pengguna' : 'Tambah Pengguna Baru')

@section('content')
<div class="p-5 md:p-8">
  <div class="mx-auto max-w-3xl">
    @include('partials.alerts')

    <form method="POST" enctype="multipart/form-data" class="card p-6 sm:p-8 space-y-5"
          action="{{ $user->exists ? route('admin.users.update', $user->id) : route('admin.users.store') }}">
      @csrf

      <div class="grid gap-5 sm:grid-cols-2">
        <div>
          <label class="mb-1.5 block text-xs font-bold text-slate-600">Nomor Induk (NIS/NIP) <span class="text-red-500">*</span></label>
          <input name="identity" value="{{ old('identity', $user->identity) }}" required
                 oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                 class="field {{ $errors->has('identity') ? 'field-error' : '' }}">
          @error('identity')<p class="mt-1 text-[11px] font-semibold text-red-500">{{ $message }}</p>@enderror
        </div>
        <div>
          <label class="mb-1.5 block text-xs font-bold text-slate-600">Nama Lengkap <span class="text-red-500">*</span></label>
          <input name="name" value="{{ old('name', $user->name) }}" required
                 class="field {{ $errors->has('name') ? 'field-error' : '' }}">
          @error('name')<p class="mt-1 text-[11px] font-semibold text-red-500">{{ $message }}</p>@enderror
        </div>
        <div>
          <label class="mb-1.5 block text-xs font-bold text-slate-600">Email <span class="text-red-500">*</span></label>
          <input name="email" type="email" value="{{ old('email', $user->email) }}" required
                 class="field {{ $errors->has('email') ? 'field-error' : '' }}">
          @error('email')<p class="mt-1 text-[11px] font-semibold text-red-500">{{ $message }}</p>@enderror
        </div>
        <div>
          <label class="mb-1.5 block text-xs font-bold text-slate-600">Nomor Telepon <span class="text-red-500">*</span></label>
          <input name="phone" value="{{ old('phone', $user->phone) }}" required
                 oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                 class="field {{ $errors->has('phone') ? 'field-error' : '' }}">
          @error('phone')<p class="mt-1 text-[11px] font-semibold text-red-500">{{ $message }}</p>@enderror
        </div>
        <div>
          <label class="mb-1.5 block text-xs font-bold text-slate-600">Peran <span class="text-red-500">*</span></label>
          <select name="role" class="field" {{ $user->exists && $user->id === Auth::id() ? 'disabled' : '' }}>
            @foreach(\App\Models\User::ROLES as $kode => $label)
              @if($kode !== 'super_admin' || Auth::user()->isSuperAdmin())
                <option value="{{ $kode }}" @selected(old('role', $user->role) === $kode)>{{ $label }}</option>
              @endif
            @endforeach
          </select>
          @if($user->exists && $user->id === Auth::id())
            <input type="hidden" name="role" value="{{ $user->role }}">
            <p class="mt-1 text-[11px] text-slate-400">Peran akun sendiri tidak dapat diubah.</p>
          @endif
        </div>
        <div>
          <label class="mb-1.5 block text-xs font-bold text-slate-600">Kelas / Unit</label>
          <input name="kelas" value="{{ old('kelas', $user->kelas) }}" class="field" placeholder="XI IPA 1">
        </div>
        <div>
          <label class="mb-1.5 block text-xs font-bold text-slate-600">
            Kata Sandi {!! $user->exists ? '<span class="text-slate-400">(kosongkan bila tidak diubah)</span>' : '<span class="text-red-500">*</span>' !!}
          </label>
          <input name="password" type="password" class="field {{ $errors->has('password') ? 'field-error' : '' }}" placeholder="Minimal 8 karakter">
          @error('password')<p class="mt-1 text-[11px] font-semibold text-red-500">{{ $message }}</p>@enderror
        </div>
        <div>
          <label class="mb-1.5 block text-xs font-bold text-slate-600">Foto Profil</label>
          <input name="photo" type="file" accept=".jpg,.jpeg,.png" class="field p-2 {{ $errors->has('photo') ? 'field-error' : '' }}">
          <p class="mt-1 text-[11px] text-slate-400">JPG/JPEG/PNG, maksimal 2 MB.</p>
          @error('photo')<p class="mt-1 text-[11px] font-semibold text-red-500">{{ $message }}</p>@enderror
        </div>
      </div>

      <label class="flex items-center gap-2 text-sm text-slate-600">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $user->exists ? $user->is_active : true)) class="rounded border-slate-300">
        Akun aktif dan dapat masuk ke sistem
      </label>

      <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-between">
        <a href="{{ route('admin.users.index') }}" class="btn-ghost text-center">Batal</a>
        <button class="btn-primary">{{ $user->exists ? 'Simpan Perubahan' : 'Simpan Pengguna' }}</button>
      </div>
    </form>
  </div>
</div>
@endsection
