<?php $__env->startSection('title', 'Nilai Saya'); ?>
<?php $__env->startSection('header_title', 'Rekapitulasi Nilai Saya'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6 p-5 md:p-8">
  <?php echo $__env->make('partials.alerts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

  <div class="card overflow-hidden">
    <div class="overflow-x-auto">
      <table class="min-w-full text-sm">
        <thead class="bg-slate-50 text-left text-[11px] uppercase tracking-wide text-slate-500">
          <tr>
            <th class="px-5 py-3">Mata Pelajaran</th>
            <th class="px-5 py-3">Tugas</th>
            <th class="px-5 py-3">Dikumpulkan</th>
            <th class="px-5 py-3 text-center">Nilai</th>
            <th class="px-5 py-3">Predikat</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          <?php $__empty_1 = true; $__currentLoopData = $pengumpulan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
              $n = $p->nilai;
              $predikat = is_null($n) ? ['Belum dinilai', 'bg-slate-100 text-slate-500']
                        : ($n >= 90 ? ['A — Sangat Baik', 'bg-emerald-50 text-emerald-600']
                        : ($n >= 80 ? ['B — Baik', 'bg-blue-50 text-blue-600']
                        : ($n >= 70 ? ['C — Cukup', 'bg-amber-50 text-amber-600']
                        : ['D — Perlu Perbaikan', 'bg-rose-50 text-rose-600'])));
            ?>
            <tr class="hover:bg-slate-50/60">
              <td class="px-5 py-3 font-bold text-slate-700"><?php echo e($p->tugas?->mapel?->nama_mapel ?? '—'); ?></td>
              <td class="px-5 py-3 text-slate-600"><?php echo e($p->tugas?->judul_tugas ?? '—'); ?></td>
              <td class="px-5 py-3 text-xs text-slate-400"><?php echo e($p->created_at?->format('d/m/Y H:i')); ?></td>
              <td class="px-5 py-3 text-center text-lg font-extrabold text-slate-800"><?php echo e($n ?? '–'); ?></td>
              <td class="px-5 py-3"><span class="badge <?php echo e($predikat[1]); ?>"><?php echo e($predikat[0]); ?></span></td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="5" class="px-5 py-10 text-center text-slate-400">Anda belum mengumpulkan tugas apa pun.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LEGION\Documents\Kuliah\PENGEMBANGAN APLIKASI BERBASIS WEB\eduxplore\resources\views/siswa/nilai.blade.php ENDPATH**/ ?>