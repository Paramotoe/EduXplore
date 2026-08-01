<!DOCTYPE html>
<html lang="id">
<head>@include('partials.head')</head>
<body class="grid min-h-screen place-items-center bg-slate-100 p-6">
  <div class="card w-full max-w-md p-8 text-center">
    <div class="mx-auto grid h-16 w-16 place-items-center rounded-2xl brand-gradient text-2xl text-white">@yield('ikon', '⚠️')</div>
    <p class="mt-5 text-5xl font-extrabold text-slate-800">@yield('kode')</p>
    <h1 class="mt-2 text-lg font-extrabold text-slate-700">@yield('judul')</h1>
    <p class="mt-2 text-sm leading-relaxed text-slate-500">@yield('pesan')</p>
    <div class="mt-6 flex justify-center gap-2">
      @auth
        <a href="{{ route(Auth::user()->homeRoute()) }}" class="btn-primary">Kembali ke Beranda</a>
      @else
        <a href="{{ route('login') }}" class="btn-primary">Halaman Masuk</a>
      @endauth
    </div>
  </div>
</body>
</html>
