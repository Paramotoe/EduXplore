<?php $__env->startSection('title', 'Dashboard Super Admin'); ?>
<?php $__env->startSection('header_title', 'Dashboard Super Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6 p-5 md:p-8">
  <?php echo $__env->make('partials.alerts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

  <div class="card brand-gradient p-6 text-white">
    <p class="text-xs uppercase tracking-widest text-white/60">Kendali Penuh Sistem</p>
    <h2 class="mt-2 text-2xl font-extrabold">Selamat datang, <?php echo e(Auth::user()->name); ?></h2>
    <p class="mt-1 text-sm text-white/70">
      Anda memiliki akses tanpa batas terhadap seluruh modul, data sensitif, pengaturan peran, dan jejak audit sistem.
    </p>
  </div>

  <?php echo $__env->make('admin._stats', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

  <div class="grid gap-6 lg:grid-cols-3">
    <div class="card p-6 lg:col-span-2">
      <div class="mb-4 flex items-center justify-between">
        <h3 class="text-sm font-extrabold text-slate-700">Aktivitas Sistem Terkini</h3>
        <a href="<?php echo e(route('superadmin.audit')); ?>" class="text-xs font-bold text-brand hover:underline">Semua jejak audit →</a>
      </div>
      <div class="space-y-2">
        <?php $__empty_1 = true; $__currentLoopData = $aktivitas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <div class="flex items-start gap-3 rounded-xl border border-slate-100 p-3">
            <span class="badge bg-slate-100 text-slate-600"><?php echo e($log->action); ?></span>
            <div class="min-w-0 flex-1">
              <p class="truncate text-sm text-slate-700"><?php echo e($log->description); ?></p>
              <p class="text-[11px] text-slate-400"><?php echo e($log->actor_name); ?> &middot; <?php echo e($log->created_at->format('d/m/Y H:i')); ?> &middot; IP <?php echo e($log->ip_address); ?></p>
            </div>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <p class="text-sm text-slate-400">Belum ada aktivitas tercatat.</p>
        <?php endif; ?>
      </div>
    </div>

    <div class="card p-6">
      <h3 class="mb-4 text-sm font-extrabold text-slate-700">Aksi Cepat</h3>
      <div class="space-y-2">
        <a href="<?php echo e(route('admin.users.create')); ?>" class="btn-ghost block text-center">Tambah Akun Pengguna</a>
        <a href="<?php echo e(route('admin.users.index')); ?>" class="btn-ghost block text-center">Kelola Peran Pengguna</a>
        <a href="<?php echo e(route('admin.settings')); ?>" class="btn-ghost block text-center">Konfigurasi Inti Sistem</a>
        <a href="<?php echo e(route('superadmin.audit')); ?>" class="btn-ghost block text-center">Audit Keamanan</a>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LEGION\Documents\Kuliah\PENGEMBANGAN APLIKASI BERBASIS WEB\eduxplore\resources\views/superadmin/dashboard.blade.php ENDPATH**/ ?>