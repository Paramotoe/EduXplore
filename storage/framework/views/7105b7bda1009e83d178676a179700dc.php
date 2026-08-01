<?php $__env->startSection('title', 'Mata Pelajaran'); ?>
<?php $__env->startSection('header_title', Auth::user()->isGuru() ? 'Kelas yang Saya Ampu' : 'Mata Pelajaran'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6 p-5 md:p-8">
  <?php echo $__env->make('partials.alerts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

  <?php if(Auth::user()->isGuru()): ?>
    <form method="POST" action="<?php echo e(route('mapel.store')); ?>" class="card flex flex-col gap-3 p-5 sm:flex-row sm:items-end">
      <?php echo csrf_field(); ?>
      <div class="flex-1">
        <label class="mb-1.5 block text-xs font-bold text-slate-600">Nama Mata Pelajaran Baru</label>
        <input name="nama_mapel" value="<?php echo e(old('nama_mapel')); ?>" required minlength="3" maxlength="100"
               class="field <?php echo e($errors->has('nama_mapel') ? 'field-error' : ''); ?>" placeholder="Pemrograman Web Dasar">
        <?php $__errorArgs = ['nama_mapel'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-[11px] font-semibold text-red-500"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>
      <button class="btn-primary">+ Tambah Kelas</button>
    </form>
  <?php endif; ?>

  <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
    <?php $__empty_1 = true; $__currentLoopData = $mapel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
      <div class="card flex flex-col p-5">
        <div class="mb-4 flex items-start justify-between">
          <div class="grid h-11 w-11 place-items-center rounded-xl brand-gradient text-lg text-white">📘</div>
          <span class="badge bg-slate-100 text-slate-600"><?php echo e($m->tugas_count); ?> tugas</span>
        </div>
        <h3 class="text-base font-extrabold text-slate-800"><?php echo e($m->nama_mapel); ?></h3>
        <p class="mt-1 text-xs text-slate-400">Pengampu: <?php echo e($m->guru?->name ?? 'Belum ditentukan'); ?></p>

        <div class="mt-5 flex gap-2">
          <a href="<?php echo e(route('mapel.detail', $m->id_mapel)); ?>" class="btn-primary flex-1 text-center !py-2">Buka Kelas</a>
          <?php if(Auth::user()->isGuru() && $m->id_guru === Auth::id()): ?>
            <form method="POST" action="<?php echo e(route('mapel.delete', $m->id_mapel)); ?>"
                  onsubmit="return confirm('Hapus mata pelajaran <?php echo e($m->nama_mapel); ?> beserta tugasnya?');">
              <?php echo csrf_field(); ?>
              <button class="btn-ghost !py-2 !px-3 !border-red-200 !text-red-600">Hapus</button>
            </form>
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
      <div class="card col-span-full p-10 text-center text-slate-400">Belum ada mata pelajaran yang terdaftar.</div>
    <?php endif; ?>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LEGION\Documents\Kuliah\PENGEMBANGAN APLIKASI BERBASIS WEB\eduxplore\resources\views/mata_pelajaran.blade.php ENDPATH**/ ?>