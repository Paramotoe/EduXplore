<?php $__env->startSection('title', 'Dashboard Guru'); ?>
<?php $__env->startSection('header_title', 'Beranda Guru'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6 p-5 md:p-8">
  <?php echo $__env->make('partials.alerts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

  <div class="card brand-gradient p-6 text-white">
    <p class="text-xs uppercase tracking-widest text-white/60">Ruang Kerja Pendidik</p>
    <h2 class="mt-2 text-2xl font-extrabold">Selamat mengajar, <?php echo e(Auth::user()->name); ?></h2>
    <p class="mt-1 text-sm text-white/70">Kelola kelas ampuan, terbitkan tugas, dan berikan penilaian tepat waktu.</p>
  </div>

  <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
    <?php $__currentLoopData = [
      ['Kelas Diampu', $statistik['mapel'], '📚'],
      ['Tugas Terbit', $statistik['tugas'], '📝'],
      ['Siswa Aktif', $statistik['siswa'], '🎓'],
      ['Menunggu Nilai', $statistik['antrian'], '⏳'],
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
      <h3 class="mb-4 text-sm font-extrabold text-slate-700">Kelas yang Anda Ampu</h3>
      <div class="space-y-2">
        <?php $__empty_1 = true; $__currentLoopData = $mapel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <a href="<?php echo e(route('mapel.detail', $m->id_mapel)); ?>"
             class="flex items-center justify-between rounded-xl border border-slate-100 p-3 transition hover:border-brand/40 hover:bg-slate-50">
            <div>
              <p class="text-sm font-bold text-slate-700"><?php echo e($m->nama_mapel); ?></p>
              <p class="text-[11px] text-slate-400"><?php echo e($m->tugas_count); ?> tugas aktif</p>
            </div>
            <span class="text-brand">→</span>
          </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <p class="text-sm text-slate-400">Anda belum menambahkan mata pelajaran.</p>
          <a href="<?php echo e(route('mapel.index')); ?>" class="btn-ghost mt-3 inline-block">Tambah mata pelajaran</a>
        <?php endif; ?>
      </div>
    </div>

    <div class="card p-6">
      <div class="mb-4 flex items-center justify-between">
        <h3 class="text-sm font-extrabold text-slate-700">Menunggu Penilaian</h3>
        <a href="<?php echo e(route('guru.nilai')); ?>" class="text-xs font-bold text-brand hover:underline">Rekap nilai →</a>
      </div>
      <div class="space-y-2">
        <?php $__empty_1 = true; $__currentLoopData = $belumDinilai; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <div class="rounded-xl border border-amber-100 bg-amber-50/60 p-3">
            <p class="text-sm font-bold text-slate-700"><?php echo e($p->siswa?->name ?? 'Siswa'); ?></p>
            <p class="text-[11px] text-slate-500"><?php echo e($p->tugas?->judul_tugas); ?> &middot; <?php echo e($p->tugas?->mapel?->nama_mapel); ?></p>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <p class="text-sm text-slate-400">Seluruh pekerjaan siswa sudah dinilai. Kerja bagus!</p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LEGION\Documents\Kuliah\PENGEMBANGAN APLIKASI BERBASIS WEB\eduxplore\resources\views/guru/dashboard.blade.php ENDPATH**/ ?>