<?php if(session('success')): ?>
    <div class="mb-5 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-700">
        <span class="text-lg leading-none">✔</span>
        <span class="font-semibold"><?php echo e(session('success')); ?></span>
    </div>
<?php endif; ?>

<?php if($errors->any()): ?>
    <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-600">
        <p class="font-bold mb-1">Terdapat <?php echo e($errors->count()); ?> kesalahan pada masukan Anda:</p>
        <ul class="list-disc list-inside space-y-0.5">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pesan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($pesan); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>
<?php /**PATH C:\Users\LEGION\Documents\Kuliah\PENGEMBANGAN APLIKASI BERBASIS WEB\eduxplore\resources\views/partials/alerts.blade.php ENDPATH**/ ?>