<?php $__env->startSection('title', 'Daftar Siswa'); ?>
<?php $__env->startSection('header_title', 'Daftar Siswa'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6 p-5 md:p-8">
  <div class="rounded-xl border border-blue-100 bg-blue-50 p-4 text-xs font-semibold text-blue-700">
    Guru memiliki hak akses baca terhadap data siswa. Perubahan data akun hanya dapat dilakukan oleh Admin sekolah.
  </div>

  <div class="card overflow-hidden">
    <div class="overflow-x-auto">
      <table class="min-w-full text-sm">
        <thead class="bg-slate-50 text-left text-[11px] uppercase tracking-wide text-slate-500">
          <tr>
            <th class="px-5 py-3">Siswa</th>
            <th class="px-5 py-3">NIS</th>
            <th class="px-5 py-3">Kelas</th>
            <th class="px-5 py-3">Email</th>
            <th class="px-5 py-3">Status</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          <?php $__empty_1 = true; $__currentLoopData = $siswa; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr class="hover:bg-slate-50/60">
              <td class="px-5 py-3">
                <div class="flex items-center gap-3">
                  <img src="<?php echo e($s->photoUrl()); ?>" alt="Foto <?php echo e($s->name); ?>" class="h-9 w-9 rounded-full object-cover">
                  <span class="font-bold text-slate-700"><?php echo e($s->name); ?></span>
                </div>
              </td>
              <td class="px-5 py-3 font-mono text-xs text-slate-600"><?php echo e($s->identity); ?></td>
              <td class="px-5 py-3 text-slate-600"><?php echo e($s->kelas ?? '—'); ?></td>
              <td class="px-5 py-3 text-xs text-slate-500"><?php echo e($s->email); ?></td>
              <td class="px-5 py-3">
                <span class="badge <?php echo e($s->is_active ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600'); ?>">
                  <?php echo e($s->is_active ? 'Aktif' : 'Nonaktif'); ?>

                </span>
              </td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="5" class="px-5 py-10 text-center text-slate-400">Belum ada data siswa.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LEGION\Documents\Kuliah\PENGEMBANGAN APLIKASI BERBASIS WEB\eduxplore\resources\views/guru/kelola_siswa.blade.php ENDPATH**/ ?>