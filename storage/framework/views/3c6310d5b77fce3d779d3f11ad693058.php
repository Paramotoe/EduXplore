<?php $__env->startSection('title', 'Manajemen Pengguna'); ?>
<?php $__env->startSection('header_title', 'Manajemen Pengguna'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6 p-5 md:p-8">
  <?php echo $__env->make('partials.alerts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

  <div class="card p-5">
    <form method="GET" action="<?php echo e(route('admin.users.index')); ?>" class="flex flex-col gap-3 md:flex-row md:items-end">
      <div class="flex-1">
        <label for="q" class="mb-1.5 block text-xs font-bold text-slate-600">Cari pengguna</label>
        <input id="q" name="q" value="<?php echo e($keyword); ?>" class="field" placeholder="Nama, NIS/NIP, atau email">
      </div>
      <div class="w-full md:w-56">
        <label for="role" class="mb-1.5 block text-xs font-bold text-slate-600">Peran</label>
        <select id="role" name="role" class="field">
          <option value="">Semua peran</option>
          <?php $__currentLoopData = \App\Models\User::ROLES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kode => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($kode !== 'super_admin' || Auth::user()->isSuperAdmin()): ?>
              <option value="<?php echo e($kode); ?>" <?php if($role === $kode): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
            <?php endif; ?>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
      </div>
      <button class="btn-primary">Terapkan</button>
      <a href="<?php echo e(route('admin.users.create')); ?>" class="btn-ghost text-center">+ Tambah Pengguna</a>
    </form>
  </div>

  <div class="card overflow-hidden">
    <div class="overflow-x-auto">
      <table class="min-w-full text-sm">
        <thead class="bg-slate-50 text-left text-[11px] uppercase tracking-wide text-slate-500">
          <tr>
            <th class="px-5 py-3">Pengguna</th>
            <th class="px-5 py-3">NIS / NIP</th>
            <th class="px-5 py-3">Kontak</th>
            <th class="px-5 py-3">Peran</th>
            <th class="px-5 py-3">Status</th>
            <th class="px-5 py-3 text-right">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr class="hover:bg-slate-50/60">
            <td class="px-5 py-3">
              <div class="flex items-center gap-3">
                <img src="<?php echo e($p->photoUrl()); ?>" alt="Foto <?php echo e($p->name); ?>" class="h-9 w-9 rounded-full object-cover">
                <div>
                  <p class="font-bold text-slate-700"><?php echo e($p->name); ?></p>
                  <p class="text-[11px] text-slate-400"><?php echo e($p->kelas ?? '—'); ?></p>
                </div>
              </div>
            </td>
            <td class="px-5 py-3 font-mono text-xs text-slate-600"><?php echo e($p->identity); ?></td>
            <td class="px-5 py-3 text-xs text-slate-500">
              <?php echo e($p->email); ?><br><span class="text-slate-400"><?php echo e($p->phone ?? '—'); ?></span>
            </td>
            <td class="px-5 py-3">
              <span class="badge <?php echo e($p->isStaff() ? 'bg-indigo-50 text-indigo-600' : ($p->isGuru() ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-600')); ?>">
                <?php echo e($p->roleLabel()); ?>

              </span>
            </td>
            <td class="px-5 py-3">
              <span class="badge <?php echo e($p->is_active ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600'); ?>">
                <?php echo e($p->is_active ? 'Aktif' : 'Nonaktif'); ?>

              </span>
            </td>
            <td class="px-5 py-3">
              <div class="flex justify-end gap-2">
                <a href="<?php echo e(route('admin.users.edit', $p->id)); ?>" class="btn-ghost !py-1.5 !px-3">Ubah</a>
                <form method="POST" action="<?php echo e(route('admin.users.toggle', $p->id)); ?>">
                  <?php echo csrf_field(); ?>
                  <button class="btn-ghost !py-1.5 !px-3"><?php echo e($p->is_active ? 'Nonaktifkan' : 'Aktifkan'); ?></button>
                </form>
                <form method="POST" action="<?php echo e(route('admin.users.destroy', $p->id)); ?>"
                      onsubmit="return confirm('Hapus permanen akun <?php echo e($p->name); ?>?');">
                  <?php echo csrf_field(); ?>
                  <button class="btn-ghost !py-1.5 !px-3 !border-red-200 !text-red-600">Hapus</button>
                </form>
              </div>
            </td>
          </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr><td colspan="6" class="px-5 py-10 text-center text-slate-400">Tidak ada pengguna yang cocok dengan pencarian.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
    <div class="border-t border-slate-100 p-4"><?php echo e($users->links()); ?></div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LEGION\Documents\Kuliah\PENGEMBANGAN APLIKASI BERBASIS WEB\eduxplore\resources\views/admin/users/index.blade.php ENDPATH**/ ?>