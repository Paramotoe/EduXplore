<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="robots" content="noindex, nofollow">
<title>@yield('title', 'EduXplore') &middot; EduXplore</title>
<link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
<style>
    :root {
        --brand-900: #0b2545;
        --brand-700: #14396b;
        --brand-500: #1d4ed8;
        --brand-100: #e0e9fb;
        --accent-500: #0f9d76;
    }
    body { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; }
    .bg-brand { background-color: var(--brand-500); }
    .bg-brand-dark { background-color: var(--brand-900); }
    .text-brand { color: var(--brand-500); }
    .border-brand { border-color: var(--brand-500); }
    .brand-gradient { background-image: linear-gradient(135deg, #0b2545 0%, #14396b 45%, #1d4ed8 100%); }
    .card { background:#fff; border:1px solid #e8ecf3; border-radius:1rem; box-shadow:0 1px 2px rgba(16,24,40,.05); }
    .field { width:100%; background:#f8fafc; border:1px solid #e2e8f0; border-radius:.75rem; padding:.7rem 1rem; font-size:.875rem; transition:.15s; }
    .field:focus { outline:none; background:#fff; border-color:var(--brand-500); box-shadow:0 0 0 3px rgba(29,78,216,.12); }
    .field-error { border-color:#ef4444; background:#fef2f2; }
    .btn-primary { background:var(--brand-500); color:#fff; font-weight:700; padding:.7rem 1.4rem; border-radius:.75rem; font-size:.875rem; transition:.15s; }
    .btn-primary:hover { background:var(--brand-700); }
    .btn-ghost { border:1px solid #e2e8f0; color:#334155; font-weight:600; padding:.65rem 1.2rem; border-radius:.75rem; font-size:.8125rem; background:#fff; }
    .btn-ghost:hover { background:#f1f5f9; }
    .badge { font-size:.65rem; font-weight:800; letter-spacing:.04em; text-transform:uppercase; padding:.2rem .55rem; border-radius:.5rem; }
</style>
