<?php $__env->startSection('title', 'Profil Akun'); ?>
<?php $__env->startSection('header_title', 'Profil Akun'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-5 md:p-8">
  <div class="mx-auto max-w-3xl space-y-6">
    <?php echo $__env->make('partials.alerts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="card brand-gradient flex flex-col items-center gap-4 p-6 text-center text-white sm:flex-row sm:text-left">
      <img src="<?php echo e($user->photoUrl()); ?>" alt="Foto profil <?php echo e($user->name); ?>" class="h-20 w-20 rounded-2xl border-2 border-white/30 object-cover">
      <div>
        <h2 class="text-xl font-extrabold"><?php echo e($user->name); ?></h2>
        <p class="text-sm text-white/70"><?php echo e($user->identity); ?> &middot; <?php echo e($user->roleLabel()); ?> &middot; <?php echo e($user->kelas ?? 'Tanpa kelas'); ?></p>
        <p class="mt-1 text-xs text-white/50">Bergabung <?php echo e($user->created_at->format('d F Y')); ?></p>
      </div>
    </div>

    <form method="POST" action="<?php echo e(route('profil.update')); ?>" enctype="multipart/form-data" class="card space-y-5 p-6">
      <?php echo csrf_field(); ?>
      <h3 class="text-sm font-extrabold text-slate-700">Data Pribadi</h3>
      <div class="grid gap-5 sm:grid-cols-2">
        <div>
          <label class="mb-1.5 block text-xs font-bold text-slate-600">Nama Lengkap</label>
          <input name="name" value="<?php echo e(old('name', $user->name)); ?>" required class="field <?php echo e($errors->has('name') ? 'field-error' : ''); ?>">
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
          <label class="mb-1.5 block text-xs font-bold text-slate-600">Email</label>
          <input name="email" type="email" value="<?php echo e(old('email', $user->email)); ?>" required class="field <?php echo e($errors->has('email') ? 'field-error' : ''); ?>">
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
          <label class="mb-1.5 block text-xs font-bold text-slate-600">Nomor Telepon</label>
          <input name="phone" value="<?php echo e(old('phone', $user->phone)); ?>" required oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                 class="field <?php echo e($errors->has('phone') ? 'field-error' : ''); ?>">
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
          <label class="mb-1.5 block text-xs font-bold text-slate-600">Ganti Foto Profil</label>
          <input name="photo" type="file" accept=".jpg,.jpeg,.png" class="field p-2 <?php echo e($errors->has('photo') ? 'field-error' : ''); ?>">
          <p class="mt-1 text-[11px] text-slate-400">JPG/JPEG/PNG, maksimal 2 MB.</p>
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
      <button class="btn-primary">Simpan Perubahan</button>
    </form>

    <form method="POST" action="<?php echo e(route('profil.password')); ?>" class="card space-y-5 p-6">
      <?php echo csrf_field(); ?>
      <h3 class="text-sm font-extrabold text-slate-700">Keamanan Akun</h3>
      <div class="grid gap-5 sm:grid-cols-3">
        <div>
          <label class="mb-1.5 block text-xs font-bold text-slate-600">Kata Sandi Saat Ini</label>
          <input name="current_password" type="password" required class="field <?php echo e($errors->has('current_password') ? 'field-error' : ''); ?>">
          <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-[11px] font-semibold text-red-500"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div>
          <label class="mb-1.5 block text-xs font-bold text-slate-600">Kata Sandi Baru</label>
          <input name="password" type="password" required minlength="8" class="field <?php echo e($errors->has('password') ? 'field-error' : ''); ?>">
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
          <label class="mb-1.5 block text-xs font-bold text-slate-600">Konfirmasi Sandi Baru</label>
          <input name="password_confirmation" type="password" required minlength="8" class="field">
        </div>
      </div>
      <button class="btn-primary">Perbarui Kata Sandi</button>
    </form>

    <?php if (! ($user->isSuperAdmin())): ?>
      <div class="card border-red-200 p-6">
        <h3 class="text-sm font-extrabold text-red-600">Zona Berbahaya</h3>
        <p class="mt-1 text-xs leading-relaxed text-slate-500">
          Menghapus akun bersifat permanen. Seluruh data profil dan riwayat akademik pribadi Anda tidak dapat dipulihkan.
        </p>
        <form method="POST" action="<?php echo e(route('profil.delete')); ?>" class="mt-4"
              onsubmit="return confirm('Hapus akun Anda secara permanen? Tindakan ini tidak dapat dibatalkan.');">
          <?php echo csrf_field(); ?>
          <button class="btn-ghost !border-red-300 !text-red-600">Hapus Akun Saya</button>
        </form>
      </div>
    <?php endif; ?>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LEGION\Documents\Kuliah\PENGEMBANGAN APLIKASI BERBASIS WEB\eduxplore\resources\views/profil.blade.php ENDPATH**/ ?>