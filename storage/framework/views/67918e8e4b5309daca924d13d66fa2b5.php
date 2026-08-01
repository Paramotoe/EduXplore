<?php $__env->startSection('title', 'Rekap Nilai'); ?>
<?php $__env->startSection('header_title', 'Rekapitulasi & Penilaian'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6 p-5 md:p-8">
  <?php echo $__env->make('partials.alerts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

  <?php $__empty_1 = true; $__currentLoopData = $mapel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="card p-6">
      <h3 class="text-sm font-extrabold text-slate-700"><?php echo e($m->nama_mapel); ?></h3>

      <?php $__empty_2 = true; $__currentLoopData = $m->tugas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
        <div class="mt-5">
          <p class="text-xs font-bold uppercase tracking-wide text-slate-400"><?php echo e($t->judul_tugas); ?></p>
          <div class="mt-2 overflow-x-auto">
            <table class="min-w-full text-sm">
              <thead class="bg-slate-50 text-left text-[11px] uppercase text-slate-500">
                <tr>
                  <th class="px-4 py-2">Siswa</th>
                  <th class="px-4 py-2">Jawaban / Tautan</th>
                  <th class="px-4 py-2 w-56">Nilai (0–100)</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100">
                <?php $__empty_3 = true; $__currentLoopData = $t->pengumpulan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_3 = false; ?>
                  <tr>
                    <td class="px-4 py-2">
                      <p class="font-bold text-slate-700"><?php echo e($p->siswa?->name); ?></p>
                      <p class="text-[11px] text-slate-400"><?php echo e($p->siswa?->identity); ?></p>
                    </td>
                    <td class="px-4 py-2 max-w-md break-words text-slate-600"><?php echo e($p->jawaban_atau_link); ?></td>
                    <td class="px-4 py-2">
                      <form method="POST" action="<?php echo e(route('nilai.store', $p->id)); ?>" class="flex gap-2">
                        <?php echo csrf_field(); ?>
                        <input type="number" name="nilai" min="0" max="100" step="1" required
                               value="<?php echo e($p->nilai); ?>" class="field !py-2" aria-label="Nilai untuk <?php echo e($p->siswa?->name); ?>">
                        <button class="btn-primary !py-2 !px-4">Simpan</button>
                      </form>
                    </td>
                  </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_3): ?>
                  <tr><td colspan="3" class="px-4 py-4 text-center text-slate-400">Belum ada pengumpulan untuk tugas ini.</td></tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
        <p class="mt-3 text-sm text-slate-400">Belum ada tugas pada mata pelajaran ini.</p>
      <?php endif; ?>
    </div>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="card p-10 text-center text-slate-400">Anda belum mengampu mata pelajaran apa pun.</div>
  <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LEGION\Documents\Kuliah\PENGEMBANGAN APLIKASI BERBASIS WEB\eduxplore\resources\views/guru/nilai.blade.php ENDPATH**/ ?>