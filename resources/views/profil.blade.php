@extends('layouts.app')
@section('title', 'Profil Akun')
@section('header_title', 'Profil Akun')

@section('content')
<div class="p-5 md:p-8">
  <div class="mx-auto max-w-3xl space-y-6">
    @include('partials.alerts')

    <div class="card brand-gradient flex flex-col items-center gap-4 p-6 text-center text-white sm:flex-row sm:text-left">
      <img src="{{ $user->photoUrl() }}" alt="Foto profil {{ $user->name }}" class="h-20 w-20 rounded-2xl border-2 border-white/30 object-cover">
      <div>
        <h2 class="text-xl font-extrabold">{{ $user->name }}</h2>
        <p class="text-sm text-white/70">{{ $user->identity }} &middot; {{ $user->roleLabel() }} &middot; {{ $user->kelas ?? 'Tanpa kelas' }}</p>
        <p class="mt-1 text-xs text-white/50">Bergabung {{ $user->created_at->format('d F Y') }}</p>
      </div>
    </div>

    <form method="POST" action="{{ route('profil.update') }}" enctype="multipart/form-data" class="card space-y-5 p-6">
      @csrf
      <h3 class="text-sm font-extrabold text-slate-700">Data Pribadi</h3>
      <div class="grid gap-5 sm:grid-cols-2">
        <div>
          <label class="mb-1.5 block text-xs font-bold text-slate-600">Nama Lengkap</label>
          <input name="name" value="{{ old('name', $user->name) }}" required class="field {{ $errors->has('name') ? 'field-error' : '' }}">
          @error('name')<p class="mt-1 text-[11px] font-semibold text-red-500">{{ $message }}</p>@enderror
        </div>
        <div>
          <label class="mb-1.5 block text-xs font-bold text-slate-600">Email</label>
          <input name="email" type="email" value="{{ old('email', $user->email) }}" required class="field {{ $errors->has('email') ? 'field-error' : '' }}">
          @error('email')<p class="mt-1 text-[11px] font-semibold text-red-500">{{ $message }}</p>@enderror
        </div>
        <div>
          <label class="mb-1.5 block text-xs font-bold text-slate-600">Nomor Telepon</label>
          <input name="phone" value="{{ old('phone', $user->phone) }}" required oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                 class="field {{ $errors->has('phone') ? 'field-error' : '' }}">
          @error('phone')<p class="mt-1 text-[11px] font-semibold text-red-500">{{ $message }}</p>@enderror
        </div>
        <div>
          <label class="mb-1.5 block text-xs font-bold text-slate-600">Ganti Foto Profil</label>
          <input name="photo" type="file" accept=".jpg,.jpeg,.png" class="field p-2 {{ $errors->has('photo') ? 'field-error' : '' }}">
          <p class="mt-1 text-[11px] text-slate-400">JPG/JPEG/PNG, maksimal 2 MB.</p>
          @error('photo')<p class="mt-1 text-[11px] font-semibold text-red-500">{{ $message }}</p>@enderror
        </div>
      </div>
      <button class="btn-primary">Simpan Perubahan</button>
    </form>

    <form method="POST" action="{{ route('profil.password') }}" class="card space-y-5 p-6">
      @csrf
      <h3 class="text-sm font-extrabold text-slate-700">Keamanan Akun</h3>
      <div class="grid gap-5 sm:grid-cols-3">
        <div>
          <label class="mb-1.5 block text-xs font-bold text-slate-600">Kata Sandi Saat Ini</label>
          <input name="current_password" type="password" required class="field {{ $errors->has('current_password') ? 'field-error' : '' }}">
          @error('current_password')<p class="mt-1 text-[11px] font-semibold text-red-500">{{ $message }}</p>@enderror
        </div>
        <div>
          <label class="mb-1.5 block text-xs font-bold text-slate-600">Kata Sandi Baru</label>
          <input name="password" type="password" required minlength="8" class="field {{ $errors->has('password') ? 'field-error' : '' }}">
          @error('password')<p class="mt-1 text-[11px] font-semibold text-red-500">{{ $message }}</p>@enderror
        </div>
        <div>
          <label class="mb-1.5 block text-xs font-bold text-slate-600">Konfirmasi Sandi Baru</label>
          <input name="password_confirmation" type="password" required minlength="8" class="field">
        </div>
      </div>
      <button class="btn-primary">Perbarui Kata Sandi</button>
    </form>

    @unless($user->isSuperAdmin())
      <div class="card border-red-200 p-6">
        <h3 class="text-sm font-extrabold text-red-600">Zona Berbahaya</h3>
        <p class="mt-1 text-xs leading-relaxed text-slate-500">
          Menghapus akun bersifat permanen. Seluruh data profil dan riwayat akademik pribadi Anda tidak dapat dipulihkan.
        </p>
        <form method="POST" action="{{ route('profil.delete') }}" class="mt-4"
              onsubmit="return confirm('Hapus akun Anda secara permanen? Tindakan ini tidak dapat dibatalkan.');">
          @csrf
          <button class="btn-ghost !border-red-300 !text-red-600">Hapus Akun Saya</button>
        </form>
      </div>
    @endunless
  </div>
</div>
@endsection
