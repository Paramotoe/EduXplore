@if(session('success'))
    <div class="mb-5 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-700">
        <span class="text-lg leading-none">✔</span>
        <span class="font-semibold">{{ session('success') }}</span>
    </div>
@endif

@if($errors->any())
    <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-600">
        <p class="font-bold mb-1">Terdapat {{ $errors->count() }} kesalahan pada masukan Anda:</p>
        <ul class="list-disc list-inside space-y-0.5">
            @foreach($errors->all() as $pesan)
                <li>{{ $pesan }}</li>
            @endforeach
        </ul>
    </div>
@endif
