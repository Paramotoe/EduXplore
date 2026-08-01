<?php $__env->startSection('title', $user->exists ? 'Ubah Pengguna' : 'Tambah Pengguna'); ?>
<?php $__env->startSection('header_title', $user->exists ? 'Ubah Data Pengguna' : 'Tambah Pengguna Baru'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-5 md:p-8">
  <div class="mx-auto max-w-3xl">
    <?php echo $__env->make('partials.alerts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <form method="POST" enctype="multipart/form-data" class="card p-6 sm:p-8 space-y-5"
          action="<?php echo e($user->exists ? route('admin.users.update', $user->id) : route('admin.users.store')); ?>">
      <?php echo csrf_field(); ?>

      <div class="grid gap-5 sm:grid-cols-2">
        <div>
          <label class="mb-1.5 block text-xs font-bold text-slate-600">Nomor Induk (NIS/NIP) <span class="text-red-500">*</span></label>
          <input name="identity" value="<?php echo e(old('identity', $user->identity)); ?>" required
                 oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                 class="field <?php echo e($errors->has('identity') ? 'field-error' : ''); ?>">
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
          <label class="mb-1.5 block text-xs font-bold text-slate-600">Nama Lengkap <span class="text-red-500">*</span></label>
          <input name="name" value="<?php echo e(old('name', $user->name)); ?>" required
                 class="field <?php echo e($errors->has('name') ? 'field-error' : ''); ?>">
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
          <label class="mb-1.5 block text-xs font-bold text-slate-600">Email <span class="text-red-500">*</span></label>
          <input name="email" type="email" value="<?php echo e(old('email', $user->email)); ?>" required
                 class="field <?php echo e($errors->has('email') ? 'field-error' : ''); ?>">
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
          <label class="mb-1.5 block text-xs font-bold text-slate-600">Nomor Telepon <span class="text-red-500">*</span></label>
          <input name="phone" value="<?php echo e(old('phone', $user->phone)); ?>" required
                 oninput="this.value=this.value.replace(/[^0-9]/g,'')"
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
          <label class="mb-1.5 block text-xs font-bold text-slate-600">Peran <span class="text-red-500">*</span></label>
          <select name="role" class="field" <?php echo e($user->exists && $user->id === Auth::id() ? 'disabled' : ''); ?>>
            <?php $__currentLoopData = \App\Models\User::ROLES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kode => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <?php if($kode !== 'super_admin' || Auth::user()->isSuperAdmin()): ?>
                <option value="<?php echo e($kode); ?>" <?php if(old('role', $user->role) === $kode): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
              <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
          <?php if($user->exists && $user->id === Auth::id()): ?>
            <input type="hidden" name="role" value="<?php echo e($user->role); ?>">
            <p class="mt-1 text-[11px] text-slate-400">Peran akun sendiri tidak dapat diubah.</p>
          <?php endif; ?>
        </div>
        <div>
          <label class="mb-1.5 block text-xs font-bold text-slate-600">Kelas / Unit</label>
          <input name="kelas" value="<?php echo e(old('kelas', $user->kelas)); ?>" class="field" placeholder="XI IPA 1">
        </div>
        <div>
          <label class="mb-1.5 block text-xs font-bold text-slate-600">
            Kata Sandi <?php echo $user->exists ? '<span class="text-slate-400">(kosongkan bila tidak diubah)</span>' : '<span class="text-red-500">*</span>'; ?>

          </label>
          <input name="password" type="password" class="field <?php echo e($errors->has('password') ? 'field-error' : ''); ?>" placeholder="Minimal 8 karakter">
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
          <label class="mb-1.5 block text-xs font-bold text-slate-600">Foto Profil</label>
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

      <label class="flex items-center gap-2 text-sm text-slate-600">
        <input type="checkbox" name="is_active" value="1" <?php if(old('is_active', $user->exists ? $user->is_active : true)): echo 'checked'; endif; ?> class="rounded border-slate-300">
        Akun aktif dan dapat masuk ke sistem
      </label>

      <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-between">
        <a href="<?php echo e(route('admin.users.index')); ?>" class="btn-ghost text-center">Batal</a>
        <button class="btn-primary"><?php echo e($user->exists ? 'Simpan Perubahan' : 'Simpan Pengguna'); ?></button>
      </div>
    </form>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LEGION\Documents\Kuliah\PENGEMBANGAN APLIKASI BERBASIS WEB\eduxplore\resources\views/admin/users/form.blade.php ENDPATH**/ ?>