<div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
  <?php $__currentLoopData = [
      ['Total Siswa', $statistik['siswa'], '🎓', 'from-blue-500 to-blue-600'],
      ['Total Guru', $statistik['guru'], '👨‍🏫', 'from-emerald-500 to-emerald-600'],
      ['Mata Pelajaran', $statistik['mapel'], '📚', 'from-amber-500 to-orange-500'],
      ['Akun Nonaktif', $statistik['nonaktif'], '🚫', 'from-rose-500 to-rose-600'],
  ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$judul, $nilai, $ikon, $warna]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="card p-5">
      <div class="flex items-start justify-between">
        <div>
          <p class="text-[11px] font-bold uppercase tracking-wide text-slate-400"><?php echo e($judul); ?></p>
          <p class="mt-2 text-3xl font-extrabold text-slate-800"><?php echo e($nilai); ?></p>
        </div>
        <div class="grid h-10 w-10 place-items-center rounded-xl bg-gradient-to-br <?php echo e($warna); ?> text-lg text-white"><?php echo e($ikon); ?></div>
      </div>
    </div>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php /**PATH C:\Users\LEGION\Documents\Kuliah\PENGEMBANGAN APLIKASI BERBASIS WEB\eduxplore\resources\views/admin/_stats.blade.php ENDPATH**/ ?>