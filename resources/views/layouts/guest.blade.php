<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#0b0f19] text-slate-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'CashMind - Masuk & Daftar' }}</title>

    <!-- Google Fonts: Plus Jakarta Sans & Figtree -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Tailwind CSS & Alpine.js CDN -->
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'Figtree', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="h-full bg-[#0b0f19] text-slate-100 font-sans antialiased selection:bg-emerald-500 selection:text-white">
    <div class="min-h-screen flex flex-col justify-center items-center p-4 relative overflow-hidden">
        <!-- Glow Decorative Background Elements -->
        <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <!-- Logo Header -->
        <div class="mb-6 text-center">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-3 group">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-emerald-500 to-teal-400 flex items-center justify-center shadow-lg shadow-emerald-500/20 group-hover:scale-105 transition-transform duration-200">
                    <i class="fa-solid fa-wallet text-slate-950 text-2xl font-bold"></i>
                </div>
                <div class="flex flex-col text-left">
                    <span class="text-2xl font-extrabold tracking-tight bg-gradient-to-r from-white via-slate-200 to-emerald-400 bg-clip-text text-transparent">CashMind</span>
                    <span class="text-[10px] font-medium text-slate-400 uppercase tracking-widest -mt-1">Keuangan 2026</span>
                </div>
            </a>
        </div>

        <!-- Guest Card Body -->
        <div class="w-full sm:max-w-md bg-slate-900/90 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-2xl backdrop-blur-xl relative z-10">
            {{ $slot }}
        </div>

        <!-- Back to Landing Link -->
        <div class="mt-6 text-center">
            <a href="{{ url('/') }}" class="text-xs text-slate-400 hover:text-emerald-400 transition flex items-center gap-1.5 justify-center">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Kembali ke Landing Page</span>
            </a>
        </div>
    </div>
</body>
</html>
