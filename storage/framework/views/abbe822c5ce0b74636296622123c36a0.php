<?php $__env->startSection('title', $mapel->nama_mapel); ?>
<?php $__env->startSection('header_title', $mapel->nama_mapel); ?>
<?php $__env->startSection('header_subtitle', 'Pengampu: ' . ($mapel->guru?->name ?? '—')); ?>

<?php $__env->startSection('content'); ?>
<?php $peran = Auth::user(); ?>
<div class="space-y-6 p-5 md:p-8">
  <?php echo $__env->make('partials.alerts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

  <a href="<?php echo e(route('mapel.index')); ?>" class="inline-block text-xs font-bold text-brand hover:underline">← Kembali ke daftar mata pelajaran</a>

  <?php if($peran->isGuru() && $mapel->id_guru === $peran->id): ?>
    <form method="POST" action="<?php echo e(route('tugas.store', $mapel->id_mapel)); ?>" class="card space-y-4 p-6">
      <?php echo csrf_field(); ?>
      <h3 class="text-sm font-extrabold text-slate-700">Terbitkan Tugas Baru</h3>
      <div>
        <label class="mb-1.5 block text-xs font-bold text-slate-600">Judul Tugas</label>
        <input name="judul_tugas" value="<?php echo e(old('judul_tugas')); ?>" required minlength="3" maxlength="150"
               class="field <?php echo e($errors->has('judul_tugas') ? 'field-error' : ''); ?>">
        <?php $__errorArgs = ['judul_tugas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-[11px] font-semibold text-red-500"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>
      <div>
        <label class="mb-1.5 block text-xs font-bold text-slate-600">Deskripsi &amp; Instruksi</label>
        <textarea name="deskripsi" rows="4" required maxlength="2000"
                  class="field <?php echo e($errors->has('deskripsi') ? 'field-error' : ''); ?>"><?php echo e(old('deskripsi')); ?></textarea>
        <?php $__errorArgs = ['deskripsi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-[11px] font-semibold text-red-500"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>
      <button class="btn-primary">Terbitkan Tugas</button>
    </form>
  <?php endif; ?>

  <div class="space-y-4">
    <?php $__empty_1 = true; $__currentLoopData = $mapel->tugas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
      <?php $milikSaya = $t->pengumpulan->firstWhere('id_siswa', $peran->id); ?>
      <div class="card p-6">
        <div class="flex flex-wrap items-start justify-between gap-3">
          <div>
            <h4 class="text-base font-extrabold text-slate-800"><?php echo e($t->judul_tugas); ?></h4>
            <p class="mt-1 text-[11px] text-slate-400">Diterbitkan <?php echo e($t->created_at->format('d/m/Y H:i')); ?></p>
          </div>
          <span class="badge bg-slate-100 text-slate-600"><?php echo e($t->pengumpulan->count()); ?> pengumpulan</span>
        </div>
        <p class="mt-3 whitespace-pre-line text-sm leading-relaxed text-slate-600"><?php echo e($t->deskripsi); ?></p>

        <?php if($peran->isSiswa()): ?>
          <div class="mt-5 rounded-xl border border-slate-100 bg-slate-50 p-4">
            <?php if($milikSaya): ?>
              <p class="text-xs font-bold text-emerald-600">✅ Sudah dikumpulkan
                <?php if(! is_null($milikSaya->nilai)): ?>
                  &middot; Nilai: <span class="text-slate-800"><?php echo e($milikSaya->nilai); ?></span>
                <?php else: ?>
                  &middot; menunggu penilaian guru
                <?php endif; ?>
              </p>
            <?php endif; ?>
            <form method="POST" action="<?php echo e(route('tugas.submit', $t->id)); ?>" class="mt-3 space-y-3">
              <?php echo csrf_field(); ?>
              <label class="block text-xs font-bold text-slate-600">Jawaban atau tautan pekerjaan</label>
              <textarea name="jawaban_atau_link" rows="3" required minlength="3" maxlength="2000"
                        class="field"><?php echo e(old('jawaban_atau_link', $milikSaya->jawaban_atau_link ?? '')); ?></textarea>
              <button class="btn-primary !py-2"><?php echo e($milikSaya ? 'Perbarui Pengumpulan' : 'Kumpulkan Tugas'); ?></button>
            </form>
          </div>
        <?php else: ?>
          <div class="mt-5 overflow-x-auto">
            <table class="min-w-full text-sm">
              <thead class="bg-slate-50 text-left text-[11px] uppercase text-slate-500">
                <tr><th class="px-4 py-2">Siswa</th><th class="px-4 py-2">Jawaban</th><th class="px-4 py-2 text-center">Nilai</th></tr>
              </thead>
              <tbody class="divide-y divide-slate-100">
                <?php $__empty_2 = true; $__currentLoopData = $t->pengumpulan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                  <tr>
                    <td class="px-4 py-2 font-bold text-slate-700"><?php echo e($p->siswa?->name); ?></td>
                    <td class="px-4 py-2 max-w-md break-words text-slate-600"><?php echo e($p->jawaban_atau_link); ?></td>
                    <td class="px-4 py-2 text-center font-extrabold text-slate-800"><?php echo e($p->nilai ?? '–'); ?></td>
                  </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                  <tr><td colspan="3" class="px-4 py-4 text-center text-slate-400">Belum ada siswa yang mengumpulkan.</td></tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>
      </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
      <div class="card p-10 text-center text-slate-400">Belum ada tugas pada mata pelajaran ini.</div>
    <?php endif; ?>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LEGION\Documents\Kuliah\PENGEMBANGAN APLIKASI BERBASIS WEB\eduxplore\resources\views/detail_mapel.blade.php ENDPATH**/ ?>