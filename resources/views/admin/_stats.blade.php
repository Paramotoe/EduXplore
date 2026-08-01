<div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
  @foreach([
      ['Total Siswa', $statistik['siswa'], '🎓', 'from-blue-500 to-blue-600'],
      ['Total Guru', $statistik['guru'], '👨‍🏫', 'from-emerald-500 to-emerald-600'],
      ['Mata Pelajaran', $statistik['mapel'], '📚', 'from-amber-500 to-orange-500'],
      ['Akun Nonaktif', $statistik['nonaktif'], '🚫', 'from-rose-500 to-rose-600'],
  ] as [$judul, $nilai, $ikon, $warna])
    <div class="card p-5">
      <div class="flex items-start justify-between">
        <div>
          <p class="text-[11px] font-bold uppercase tracking-wide text-slate-400">{{ $judul }}</p>
          <p class="mt-2 text-3xl font-extrabold text-slate-800">{{ $nilai }}</p>
        </div>
        <div class="grid h-10 w-10 place-items-center rounded-xl bg-gradient-to-br {{ $warna }} text-lg text-white">{{ $ikon }}</div>
      </div>
    </div>
  @endforeach
</div>
