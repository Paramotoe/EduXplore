@extends('layouts.app')
@section('title', 'Forum Diskusi')
@section('header_title', 'Forum Diskusi Sekolah')

@section('content')
<div class="p-5 md:p-8">
  <div class="mx-auto flex h-[calc(100vh-9rem)] max-w-3xl flex-col card overflow-hidden">
    <div id="ruang-pesan" class="flex-1 space-y-3 overflow-y-auto bg-slate-50 p-5">
      @forelse($chats as $c)
        @php $sendiri = $c->id_pembuat === Auth::id(); @endphp
        <div class="flex {{ $sendiri ? 'justify-end' : 'justify-start' }}">
          <div class="max-w-[78%] rounded-2xl px-4 py-2.5 {{ $sendiri ? 'brand-gradient text-white' : 'bg-white border border-slate-200 text-slate-700' }}">
            @unless($sendiri)
              <p class="mb-0.5 text-[11px] font-bold text-brand">
                {{ $c->user?->name }} <span class="font-normal text-slate-400">· {{ $c->user?->roleLabel() }}</span>
              </p>
            @endunless
            <p class="whitespace-pre-line break-words text-sm">{{ $c->pesan }}</p>
            <p class="mt-1 text-right text-[10px] {{ $sendiri ? 'text-white/60' : 'text-slate-400' }}">{{ $c->created_at->format('d/m H:i') }}</p>
          </div>
        </div>
      @empty
        <p class="py-10 text-center text-sm text-slate-400">Belum ada percakapan. Mulai diskusi pertama Anda.</p>
      @endforelse
    </div>

    <form method="POST" action="{{ route('forum.kirim') }}" class="flex gap-2 border-t border-slate-200 bg-white p-4">
      @csrf
      <input name="pesan" required maxlength="1000" autocomplete="off" class="field flex-1" placeholder="Tulis pesan…" aria-label="Isi pesan">
      <button class="btn-primary !px-6">Kirim</button>
    </form>
  </div>
</div>
<script>
  const ruang = document.getElementById('ruang-pesan');
  if (ruang) ruang.scrollTop = ruang.scrollHeight;
</script>
@endsection
