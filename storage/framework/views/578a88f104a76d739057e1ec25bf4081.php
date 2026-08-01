<?php $__env->startSection('title', 'Akses Ditolak'); ?>
<?php $__env->startSection('ikon', '🔒'); ?>
<?php $__env->startSection('kode', '403'); ?>
<?php $__env->startSection('judul', 'Akses Ditolak'); ?>
<?php $__env->startSection('pesan', $exception?->getMessage() ?: 'Peran akun Anda tidak memiliki wewenang untuk membuka halaman ini. Percobaan akses tercatat pada jejak audit sistem.'); ?>

<?php echo $__env->make('errors.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LEGION\Documents\Kuliah\PENGEMBANGAN APLIKASI BERBASIS WEB\eduxplore\resources\views/errors/403.blade.php ENDPATH**/ ?>