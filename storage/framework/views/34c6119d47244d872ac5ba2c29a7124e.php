<!DOCTYPE html>
<html lang="id">
<head>
  <?php echo $__env->make('partials.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  <?php $__env->startSection('title', 'Masuk'); ?>
</head>
<body class="min-h-screen bg-slate-100">
<div class="grid min-h-screen lg:grid-cols-2">

  <section class="relative hidden lg:flex flex-col justify-between brand-gradient p-12 text-white">
    <div class="flex items-center gap-3">
      <div class="h-11 w-11 rounded-2xl bg-white/15 grid place-items-center text-xl">🎓</div>
      <span class="text-2xl font-extrabold tracking-tight">EduXplore</span>
    </div>
    <div class="max-w-md">
      <h1 class="text-4xl font-extrabold leading-tight">Ruang belajar digital untuk SMA &amp; SMK Indonesia.</h1>
      <p class="mt-4 text-white/70 leading-relaxed">
        Satu platform untuk mengelola kelas, materi, tugas, penilaian, dan komunikasi warga sekolah
        dengan keamanan data tingkat lembaga.
      </p>
      <ul class="mt-8 space-y-3 text-sm text-white/80">
        <li class="flex gap-3"><span>🛡️</span> Empat tingkat hak akses: Super Admin, Admin, Guru, Siswa</li>
        <li class="flex gap-3"><span>🔐</span> Kata sandi terenkripsi bcrypt &amp; proteksi CSRF di setiap formulir</li>
        <li class="flex gap-3"><span>📈</span> Rekap nilai dan jejak audit aktivitas sistem</li>
      </ul>
    </div>
    <p class="text-xs text-white/50">&copy; <?php echo e(date('Y')); ?> EduXplore &middot; <?php echo e($namaSekolah ?? 'Sekolah Menengah'); ?></p>
  </section>

  <section class="flex items-center justify-center p-6 sm:p-10">
    <div class="w-full max-w-md">
      <div class="lg:hidden mb-8 text-center">
        <span class="text-2xl font-extrabold text-brand">EduXplore</span>
      </div>

      <h2 class="text-2xl font-extrabold text-slate-800">Masuk ke akun Anda</h2>
      <p class="mt-1 text-sm text-slate-500">Gunakan NIS/NIP atau email sekolah yang terdaftar.</p>

      <div class="mt-6"><?php echo $__env->make('partials.alerts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></div>

      <form action="<?php echo e(route('proses_login')); ?>" method="POST" class="space-y-4" novalidate>
        <?php echo csrf_field(); ?>
        <div>
          <label for="identity" class="mb-1.5 block text-xs font-bold text-slate-600">NIS / NIP / Email</label>
          <input id="identity" type="text" name="identity" value="<?php echo e(old('identity')); ?>" required autofocus
                 class="field <?php echo e($errors->has('identity') || $errors->has('login_error') ? 'field-error' : ''); ?>"
                 placeholder="2024010001">
        </div>

        <div>
          <label for="password" class="mb-1.5 block text-xs font-bold text-slate-600">Kata Sandi</label>
          <div class="relative">
            <input id="password" type="password" name="password" required
                   class="field pr-16 <?php echo e($errors->has('password') || $errors->has('login_error') ? 'field-error' : ''); ?>"
                   placeholder="••••••••">
            <button type="button" onclick="const p=document.getElementById('password');p.type=p.type==='password'?'text':'password';this.textContent=p.type==='password'?'Lihat':'Tutup';"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-[11px] font-bold text-brand">Lihat</button>
          </div>
        </div>

        <label class="flex items-center gap-2 text-xs text-slate-500">
          <input type="checkbox" name="remember" value="1" class="rounded border-slate-300"> Ingat perangkat ini
        </label>

        <button type="submit" class="btn-primary w-full">MASUK</button>
      </form>

      <p class="mt-6 text-center text-sm text-slate-500">
        Siswa baru belum punya akun?
        <a href="<?php echo e(route('register_view')); ?>" class="font-bold text-brand hover:underline">Daftar di sini</a>
      </p>

      <div class="mt-8 rounded-xl border border-slate-200 bg-white p-4 text-[11px] leading-relaxed text-slate-500">
        <p class="font-bold text-slate-600 mb-1">Akun demonstrasi</p>
        Super Admin <code>1000000001</code> &middot; Admin <code>1000000002</code> &middot;
        Guru <code>1980051020</code> &middot; Siswa <code>2024010001</code><br>
        Kata sandi seluruh akun demo: <code>Password123</code>
      </div>
    </div>
  </section>
</div>
</body>
</html>
<?php /**PATH C:\Users\LEGION\Documents\Kuliah\PENGEMBANGAN APLIKASI BERBASIS WEB\eduxplore\resources\views/login.blade.php ENDPATH**/ ?>