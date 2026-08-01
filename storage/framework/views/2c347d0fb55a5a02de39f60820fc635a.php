<?php $__env->startSection('title', 'Dashboard Admin'); ?>
<?php $__env->startSection('header_title', 'Dashboard Admin Sekolah'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6 p-5 md:p-8">
  <?php echo $__env->make('partials.alerts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

  <div class="card brand-gradient p-6 text-white">
    <p class="text-xs uppercase tracking-widest text-white/60">Panel Operator Sekolah</p>
    <h2 class="mt-2 text-2xl font-extrabold"><?php echo e($namaSekolah); ?></h2>
    <p class="mt-1 text-sm text-white/70">Kelola akun warga sekolah, konfigurasi sistem, dan pantau aktivitas pembelajaran.</p>
  </div>

  <?php echo $__env->make('admin._stats', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

  <div class="grid gap-6 lg:grid-cols-3">
    <div class="card p-6 lg:col-span-2">
      <h3 class="mb-4 text-sm font-extrabold text-slate-700">Pengguna Terbaru</h3>
      <div class="space-y-3">
        <?php $__empty_1 = true; $__currentLoopData = $terbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <div class="flex items-center gap-3 rounded-xl border border-slate-100 p-3">
            <img src="<?php echo e($p->photoUrl()); ?>" alt="Foto <?php echo e($p->name); ?>" class="h-9 w-9 rounded-full object-cover">
            <div class="min-w-0 flex-1">
              <p class="truncate text-sm font-bold text-slate-700"><?php echo e($p->name); ?></p>
              <p class="text-[11px] text-slate-400"><?php echo e($p->identity); ?> &middot; <?php echo e($p->roleLabel()); ?></p>
            </div>
            <span class="badge <?php echo e($p->is_active ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600'); ?>">
              <?php echo e($p->is_active ? 'Aktif' : 'Nonaktif'); ?>

            </span>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <p class="text-sm text-slate-400">Belum ada data pengguna.</p>
        <?php endif; ?>
      </div>
      <a href="<?php echo e(route('admin.users.index')); ?>" class="mt-4 inline-block text-xs font-bold text-brand hover:underline">Lihat seluruh pengguna →</a>
    </div>

    <div class="card p-6">
      <h3 class="mb-4 text-sm font-extrabold text-slate-700">Ringkasan Akademik</h3>
      <dl class="space-y-3 text-sm">
        <?php $__currentLoopData = [['Tugas diterbitkan', $statistik['tugas']], ['Pengumpulan tugas', $statistik['pengumpulan']], ['Pesan forum', $statistik['diskusi']], ['Akun administratif', $statistik['admin']]]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$label, $nilai]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="flex items-center justify-between border-b border-slate-100 pb-2">
            <dt class="text-slate-500"><?php echo e($label); ?></dt>
            <dd class="font-extrabold text-slate-800"><?php echo e($nilai); ?></dd>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </dl>
      <a href="<?php echo e(route('admin.settings')); ?>" class="btn-ghost mt-5 block text-center">Buka Konfigurasi</a>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LEGION\Documents\Kuliah\PENGEMBANGAN APLIKASI BERBASIS WEB\eduxplore\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>