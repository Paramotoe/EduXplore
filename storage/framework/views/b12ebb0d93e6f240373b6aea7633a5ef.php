<!DOCTYPE html>
<html lang="id">
<head>
  <?php echo $__env->make('partials.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  <?php $__env->startSection('title', 'Registrasi Siswa Baru'); ?>
</head>
<body class="min-h-screen bg-slate-100 py-10">
<div class="mx-auto w-full max-w-3xl px-5">

  <div class="mb-8 text-center">
    <span class="text-2xl font-extrabold text-brand">EduXplore</span>
    <h1 class="mt-3 text-2xl font-extrabold text-slate-800">Formulir Registrasi Siswa Baru</h1>
    <p class="mt-1 text-sm text-slate-500"><?php echo e($namaSekolah); ?> &middot; Seluruh isian bertanda <span class="text-red-500">*</span> wajib diisi.</p>
  </div>

  <div class="card p-6 sm:p-8">
    <?php echo $__env->make('partials.alerts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php if (! ($registrasiBuka)): ?>
      <div class="rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm font-semibold text-amber-700">
        Pendaftaran mandiri sedang ditutup oleh Admin sekolah. Silakan hubungi bagian Tata Usaha.
      </div>
    <?php else: ?>
    <form action="<?php echo e(route('proses_register')); ?>" method="POST" enctype="multipart/form-data" class="space-y-5" novalidate>
      <?php echo csrf_field(); ?>

      <div class="grid gap-5 sm:grid-cols-2">
        <div>
          <label for="identity" class="mb-1.5 block text-xs font-bold text-slate-600">NIS / NIM <span class="text-red-500">*</span></label>
          <input id="identity" name="identity" type="text" inputmode="numeric" maxlength="<?php echo e($panjangNis); ?>"
                 value="<?php echo e(old('identity')); ?>" required
                 oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                 class="field <?php echo e($errors->has('identity') ? 'field-error' : ''); ?>" placeholder="<?php echo e(str_repeat('0', $panjangNis)); ?>">
          <p class="mt-1 text-[11px] text-slate-400">Wajib angka, tepat <?php echo e($panjangNis); ?> digit sesuai ketentuan sekolah.</p>
          <?php $__errorArgs = ['identity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-[11px] font-semibold text-red-500"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
          <label for="name" class="mb-1.5 block text-xs font-bold text-slate-600">Nama Lengkap <span class="text-red-500">*</span></label>
          <input id="name" name="name" type="text" value="<?php echo e(old('name')); ?>" required maxlength="100"
                 oninput="this.value=this.value.replace(/[^A-Za-z\s\.\']/g,'')"
                 class="field <?php echo e($errors->has('name') ? 'field-error' : ''); ?>" placeholder="Ahmad Fauzan Ramadhan">
          <p class="mt-1 text-[11px] text-slate-400">Hanya huruf dan spasi.</p>
          <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-[11px] font-semibold text-red-500"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
          <label for="email" class="mb-1.5 block text-xs font-bold text-slate-600">Email Aktif <span class="text-red-500">*</span></label>
          <input id="email" name="email" type="email" value="<?php echo e(old('email')); ?>" required maxlength="255"
                 class="field <?php echo e($errors->has('email') ? 'field-error' : ''); ?>" placeholder="nama@sekolah.sch.id">
          <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-[11px] font-semibold text-red-500"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
          <label for="phone" class="mb-1.5 block text-xs font-bold text-slate-600">Nomor Telepon <span class="text-red-500">*</span></label>
          <input id="phone" name="phone" type="text" inputmode="numeric" minlength="10" maxlength="15"
                 value="<?php echo e(old('phone')); ?>" required
                 oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                 class="field <?php echo e($errors->has('phone') ? 'field-error' : ''); ?>" placeholder="081234567890">
          <p class="mt-1 text-[11px] text-slate-400">Hanya angka, 10–15 digit.</p>
          <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-[11px] font-semibold text-red-500"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
          <label for="password" class="mb-1.5 block text-xs font-bold text-slate-600">Kata Sandi <span class="text-red-500">*</span></label>
          <input id="password" name="password" type="password" required minlength="8"
                 class="field <?php echo e($errors->has('password') ? 'field-error' : ''); ?>" placeholder="Minimal 8 karakter">
          <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-[11px] font-semibold text-red-500"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
          <label for="password_confirmation" class="mb-1.5 block text-xs font-bold text-slate-600">Ulangi Kata Sandi <span class="text-red-500">*</span></label>
          <input id="password_confirmation" name="password_confirmation" type="password" required minlength="8"
                 class="field" placeholder="Ketik ulang kata sandi">
        </div>

        <div>
          <label for="kelas" class="mb-1.5 block text-xs font-bold text-slate-600">Kelas</label>
          <input id="kelas" name="kelas" type="text" value="<?php echo e(old('kelas')); ?>" maxlength="20"
                 class="field <?php echo e($errors->has('kelas') ? 'field-error' : ''); ?>" placeholder="X TKJ 1">
        </div>

        <div>
          <label for="photo" class="mb-1.5 block text-xs font-bold text-slate-600">Foto Profil <span class="text-red-500">*</span></label>
          <input id="photo" name="photo" type="file" accept=".jpg,.jpeg,.png,image/jpeg,image/png" required
                 onchange="const f=this.files[0]; const p=document.getElementById('pratinjau'); if(f){ document.getElementById('info-foto').textContent = f.name + ' (' + (f.size/1048576).toFixed(2) + ' MB)'; p.src=URL.createObjectURL(f); p.classList.remove('hidden'); }"
                 class="field p-2 <?php echo e($errors->has('photo') ? 'field-error' : ''); ?>">
          <p class="mt-1 text-[11px] text-slate-400">Format JPG, JPEG, atau PNG. Ukuran maksimal 2 MB.</p>
          <p id="info-foto" class="mt-1 text-[11px] font-semibold text-brand"></p>
          <img id="pratinjau" alt="Pratinjau foto profil" class="mt-2 hidden h-20 w-20 rounded-xl object-cover border border-slate-200">
          <?php $__errorArgs = ['photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-[11px] font-semibold text-red-500"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
      </div>

      <div class="rounded-xl bg-slate-50 border border-slate-200 p-4 text-[11px] leading-relaxed text-slate-500">
        Data yang Anda kirim disimpan menggunakan <em>prepared statement</em>, kata sandi dienkripsi dengan algoritma
        bcrypt, dan seluruh tampilan data disaring untuk mencegah serangan XSS.
      </div>

      <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-between">
        <a href="<?php echo e(route('login')); ?>" class="btn-ghost text-center">Kembali ke halaman masuk</a>
        <button type="submit" class="btn-primary">DAFTAR SEKARANG</button>
      </div>
    </form>
    <?php endif; ?>
  </div>
</div>
</body>
</html>
<?php /**PATH C:\Users\LEGION\Documents\Kuliah\PENGEMBANGAN APLIKASI BERBASIS WEB\eduxplore\resources\views/register.blade.php ENDPATH**/ ?>