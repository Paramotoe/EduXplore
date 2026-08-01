<!DOCTYPE html>
<html lang="id">
<head><?php echo $__env->make('partials.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></head>
<body class="grid min-h-screen place-items-center bg-slate-100 p-6">
  <div class="card w-full max-w-md p-8 text-center">
    <div class="mx-auto grid h-16 w-16 place-items-center rounded-2xl brand-gradient text-2xl text-white"><?php echo $__env->yieldContent('ikon', '⚠️'); ?></div>
    <p class="mt-5 text-5xl font-extrabold text-slate-800"><?php echo $__env->yieldContent('kode'); ?></p>
    <h1 class="mt-2 text-lg font-extrabold text-slate-700"><?php echo $__env->yieldContent('judul'); ?></h1>
    <p class="mt-2 text-sm leading-relaxed text-slate-500"><?php echo $__env->yieldContent('pesan'); ?></p>
    <div class="mt-6 flex justify-center gap-2">
      <?php if(auth()->guard()->check()): ?>
        <a href="<?php echo e(route(Auth::user()->homeRoute())); ?>" class="btn-primary">Kembali ke Beranda</a>
      <?php else: ?>
        <a href="<?php echo e(route('login')); ?>" class="btn-primary">Halaman Masuk</a>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
<?php /**PATH C:\Users\LEGION\Documents\Kuliah\PENGEMBANGAN APLIKASI BERBASIS WEB\eduxplore\resources\views/errors/layout.blade.php ENDPATH**/ ?>