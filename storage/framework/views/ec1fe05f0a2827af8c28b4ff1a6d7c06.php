<?php $__env->startSection('title', 'Jejak Audit'); ?>
<?php $__env->startSection('header_title', 'Jejak Audit Sistem'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6 p-5 md:p-8">
  <div class="card p-5">
    <form method="GET" class="flex flex-col gap-3 sm:flex-row sm:items-end">
      <div class="flex-1">
        <label class="mb-1.5 block text-xs font-bold text-slate-600">Saring berdasarkan jenis aksi</label>
        <select name="action" class="field">
          <option value="">Semua aksi</option>
          <?php $__currentLoopData = $daftarAksi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($a); ?>" <?php if($aksi === $a): echo 'selected'; endif; ?>><?php echo e($a); ?></option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
      </div>
      <button class="btn-primary">Terapkan</button>
    </form>
  </div>

  <div class="card overflow-hidden">
    <div class="overflow-x-auto">
      <table class="min-w-full text-sm">
        <thead class="bg-slate-50 text-left text-[11px] uppercase tracking-wide text-slate-500">
          <tr>
            <th class="px-5 py-3">Waktu</th>
            <th class="px-5 py-3">Pelaku</th>
            <th class="px-5 py-3">Aksi</th>
            <th class="px-5 py-3">Keterangan</th>
            <th class="px-5 py-3">Alamat IP</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr class="hover:bg-slate-50/60">
              <td class="px-5 py-3 whitespace-nowrap text-xs text-slate-500"><?php echo e($log->created_at->format('d/m/Y H:i:s')); ?></td>
              <td class="px-5 py-3">
                <p class="font-bold text-slate-700"><?php echo e($log->actor_name); ?></p>
                <p class="text-[11px] text-slate-400"><?php echo e($log->actor_role); ?></p>
              </td>
              <td class="px-5 py-3"><span class="badge bg-slate-100 text-slate-600"><?php echo e($log->action); ?></span></td>
              <td class="px-5 py-3 text-slate-600"><?php echo e($log->description); ?></td>
              <td class="px-5 py-3 font-mono text-xs text-slate-500"><?php echo e($log->ip_address); ?></td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="5" class="px-5 py-10 text-center text-slate-400">Belum ada catatan audit.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
    <div class="border-t border-slate-100 p-4"><?php echo e($logs->links()); ?></div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LEGION\Documents\Kuliah\PENGEMBANGAN APLIKASI BERBASIS WEB\eduxplore\resources\views/superadmin/audit.blade.php ENDPATH**/ ?>