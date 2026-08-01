<?php $__env->startSection('title', 'Konfigurasi Sistem'); ?>
<?php $__env->startSection('header_title', 'Konfigurasi Sistem'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-5 md:p-8">
  <div class="mx-auto max-w-2xl space-y-6">
    <?php echo $__env->make('partials.alerts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <form method="POST" action="<?php echo e(route('admin.settings.update')); ?>" class="card p-6 sm:p-8 space-y-5">
      <?php echo csrf_field(); ?>
      <div>
        <h3 class="text-sm font-extrabold text-slate-700">Identitas Sekolah</h3>
        <p class="text-xs text-slate-400">Ditampilkan pada seluruh halaman dan dokumen sistem.</p>
      </div>

      <div>
        <label class="mb-1.5 block text-xs font-bold text-slate-600">Nama Sekolah</label>
        <input name="nama_sekolah" value="<?php echo e(old('nama_sekolah', $settings['nama_sekolah'])); ?>" class="field" required>
      </div>

      <div class="grid gap-5 sm:grid-cols-2">
        <div>
          <label class="mb-1.5 block text-xs font-bold text-slate-600">Tahun Ajaran</label>
          <input name="tahun_ajaran" value="<?php echo e(old('tahun_ajaran', $settings['tahun_ajaran'])); ?>" class="field" placeholder="2025/2026" required>
        </div>
        <div>
          <label class="mb-1.5 block text-xs font-bold text-slate-600">Panjang Digit NIS</label>
          <input name="panjang_nis" type="number" min="5" max="20" value="<?php echo e(old('panjang_nis', $settings['panjang_nis'])); ?>" class="field" required>
          <p class="mt-1 text-[11px] text-slate-400">Dipakai sebagai aturan validasi formulir registrasi siswa.</p>
        </div>
      </div>

      <label class="flex items-center gap-2 text-sm text-slate-600">
        <input type="checkbox" name="registrasi_buka" value="1" <?php if(old('registrasi_buka', $settings['registrasi_buka']) == '1'): echo 'checked'; endif; ?> class="rounded border-slate-300">
        Buka pendaftaran mandiri siswa baru
      </label>

      <button class="btn-primary">Simpan Konfigurasi</button>
    </form>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LEGION\Documents\Kuliah\PENGEMBANGAN APLIKASI BERBASIS WEB\eduxplore\resources\views/admin/settings.blade.php ENDPATH**/ ?>