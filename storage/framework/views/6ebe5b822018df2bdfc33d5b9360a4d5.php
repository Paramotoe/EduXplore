<?php $__env->startSection('title', 'Pengumuman'); ?>
<?php $__env->startSection('header_title', 'Pengumuman Sekolah'); ?>

<?php $__env->startSection('content'); ?>
<div class="grid gap-6 p-5 md:p-8 lg:grid-cols-3">
  <div class="lg:col-span-1">
    <form method="POST" action="<?php echo e(route('pengumuman.store')); ?>" class="card p-6 space-y-4">
      <?php echo csrf_field(); ?>
      <h3 class="text-sm font-extrabold text-slate-700">Siarkan Pengumuman</h3>
      <div>
        <label class="mb-1.5 block text-xs font-bold text-slate-600">Judul</label>
        <input name="judul" value="<?php echo e(old('judul')); ?>" required maxlength="150"
               class="field <?php echo e($errors->has('judul') ? 'field-error' : ''); ?>">
        <?php $__errorArgs = ['judul'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-[11px] font-semibold text-red-500"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>
      <div>
        <label class="mb-1.5 block text-xs font-bold text-slate-600">Isi Pengumuman</label>
        <textarea name="isi" rows="5" required maxlength="2000"
                  class="field <?php echo e($errors->has('isi') ? 'field-error' : ''); ?>"><?php echo e(old('isi')); ?></textarea>
        <?php $__errorArgs = ['isi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-[11px] font-semibold text-red-500"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>
      <button class="btn-primary w-full">Terbitkan</button>
    </form>
  </div>

  <div class="space-y-4 lg:col-span-2">
    <?php echo $__env->make('partials.alerts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php $__empty_1 = true; $__currentLoopData = $pengumuman; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
      <div class="card p-5">
        <div class="flex items-start justify-between gap-4">
          <div class="min-w-0">
            <h4 class="text-sm font-extrabold text-slate-800"><?php echo e($p->judul); ?></h4>
            <p class="mt-2 whitespace-pre-line text-sm leading-relaxed text-slate-600"><?php echo e($p->isi); ?></p>
            <p class="mt-3 text-[11px] text-slate-400"><?php echo e($p->guru?->name); ?> &middot; <?php echo e($p->created_at->format('d/m/Y H:i')); ?></p>
          </div>
          <?php if($p->id_guru === Auth::id()): ?>
            <form method="POST" action="<?php echo e(route('pengumuman.delete', $p->id)); ?>" onsubmit="return confirm('Hapus pengumuman ini?');">
              <?php echo csrf_field(); ?>
              <button class="btn-ghost !py-1.5 !px-3 !border-red-200 !text-red-600">Hapus</button>
            </form>
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
      <div class="card p-10 text-center text-slate-400">Belum ada pengumuman yang diterbitkan.</div>
    <?php endif; ?>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LEGION\Documents\Kuliah\PENGEMBANGAN APLIKASI BERBASIS WEB\eduxplore\resources\views/guru/pengumuman.blade.php ENDPATH**/ ?>