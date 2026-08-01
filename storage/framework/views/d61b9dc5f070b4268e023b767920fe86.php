<?php $__env->startSection('title', 'Dashboard Siswa'); ?>
<?php $__env->startSection('header_title', 'Beranda Siswa'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6 p-5 md:p-8">
  <?php echo $__env->make('partials.alerts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

  <div class="card brand-gradient p-6 text-white">
    <p class="text-xs uppercase tracking-widest text-white/60">Ruang Belajar</p>
    <h2 class="mt-2 text-2xl font-extrabold">Halo, <?php echo e(Auth::user()->name); ?></h2>
    <p class="mt-1 text-sm text-white/70">
      Kelas <?php echo e(Auth::user()->kelas ?? '—'); ?> &middot; NIS <?php echo e(Auth::user()->identity); ?>

    </p>
  </div>

  <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
    <?php $__currentLoopData = [
      ['Total Tugas', $statistik['tugas'], '📚'],
      ['Sudah Dikumpul', $statistik['terkumpul'], '✅'],
      ['Sudah Dinilai', $statistik['dinilai'], '📊'],
      ['Rata-rata Nilai', $statistik['rata'], '⭐'],
    ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$judul, $nilai, $ikon]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="card p-5">
        <div class="flex items-start justify-between">
          <div>
            <p class="text-[11px] font-bold uppercase tracking-wide text-slate-400"><?php echo e($judul); ?></p>
            <p class="mt-2 text-3xl font-extrabold text-slate-800"><?php echo e($nilai); ?></p>
          </div>
          <span class="text-xl"><?php echo e($ikon); ?></span>
        </div>
      </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </div>

  <div class="grid gap-6 lg:grid-cols-2">
    <div class="card p-6">
      <h3 class="mb-4 text-sm font-extrabold text-slate-700">Tugas Belum Dikumpulkan</h3>
      <div class="space-y-2">
        <?php $__empty_1 = true; $__currentLoopData = $tugasBelum; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <a href="<?php echo e(route('mapel.detail', $t->id_mapel)); ?>"
             class="block rounded-xl border border-rose-100 bg-rose-50/50 p-3 transition hover:bg-rose-50">
            <p class="text-sm font-bold text-slate-700"><?php echo e($t->judul_tugas); ?></p>
            <p class="text-[11px] text-slate-500"><?php echo e($t->mapel?->nama_mapel); ?></p>
          </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <p class="text-sm text-slate-400">Tidak ada tugas tertunda. Pertahankan!</p>
        <?php endif; ?>
      </div>
    </div>

    <div class="card p-6">
      <h3 class="mb-4 text-sm font-extrabold text-slate-700">Pengumuman Sekolah</h3>
      <div class="space-y-2">
        <?php $__empty_1 = true; $__currentLoopData = $pengumuman; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <div class="rounded-xl border border-slate-100 p-3">
            <p class="text-sm font-bold text-slate-700"><?php echo e($p->judul); ?></p>
            <p class="mt-1 text-xs leading-relaxed text-slate-500"><?php echo e($p->isi); ?></p>
            <p class="mt-2 text-[11px] text-slate-400"><?php echo e($p->guru?->name); ?> &middot; <?php echo e($p->created_at->format('d/m/Y')); ?></p>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <p class="text-sm text-slate-400">Belum ada pengumuman.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LEGION\Documents\Kuliah\PENGEMBANGAN APLIKASI BERBASIS WEB\eduxplore\resources\views/siswa/dashboard.blade.php ENDPATH**/ ?>