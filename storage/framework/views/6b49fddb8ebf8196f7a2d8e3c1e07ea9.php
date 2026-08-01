<?php $__env->startSection('title', 'Forum Diskusi'); ?>
<?php $__env->startSection('header_title', 'Forum Diskusi Sekolah'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-5 md:p-8">
  <div class="mx-auto flex h-[calc(100vh-9rem)] max-w-3xl flex-col card overflow-hidden">
    <div id="ruang-pesan" class="flex-1 space-y-3 overflow-y-auto bg-slate-50 p-5">
      <?php $__empty_1 = true; $__currentLoopData = $chats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php $sendiri = $c->id_pembuat === Auth::id(); ?>
        <div class="flex <?php echo e($sendiri ? 'justify-end' : 'justify-start'); ?>">
          <div class="max-w-[78%] rounded-2xl px-4 py-2.5 <?php echo e($sendiri ? 'brand-gradient text-white' : 'bg-white border border-slate-200 text-slate-700'); ?>">
            <?php if (! ($sendiri)): ?>
              <p class="mb-0.5 text-[11px] font-bold text-brand">
                <?php echo e($c->user?->name); ?> <span class="font-normal text-slate-400">· <?php echo e($c->user?->roleLabel()); ?></span>
              </p>
            <?php endif; ?>
            <p class="whitespace-pre-line break-words text-sm"><?php echo e($c->pesan); ?></p>
            <p class="mt-1 text-right text-[10px] <?php echo e($sendiri ? 'text-white/60' : 'text-slate-400'); ?>"><?php echo e($c->created_at->format('d/m H:i')); ?></p>
          </div>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <p class="py-10 text-center text-sm text-slate-400">Belum ada percakapan. Mulai diskusi pertama Anda.</p>
      <?php endif; ?>
    </div>

    <form method="POST" action="<?php echo e(route('forum.kirim')); ?>" class="flex gap-2 border-t border-slate-200 bg-white p-4">
      <?php echo csrf_field(); ?>
      <input name="pesan" required maxlength="1000" autocomplete="off" class="field flex-1" placeholder="Tulis pesan…" aria-label="Isi pesan">
      <button class="btn-primary !px-6">Kirim</button>
    </form>
  </div>
</div>
<script>
  const ruang = document.getElementById('ruang-pesan');
  if (ruang) ruang.scrollTop = ruang.scrollHeight;
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LEGION\Documents\Kuliah\PENGEMBANGAN APLIKASI BERBASIS WEB\eduxplore\resources\views/forum_diskusi.blade.php ENDPATH**/ ?>