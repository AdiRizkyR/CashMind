<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#09090b] text-zinc-100 antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'CashMind — Sign In' }}</title>

    <!-- Google Fonts: Plus Jakarta Sans & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Tailwind CSS & Alpine.js CDN -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="h-full bg-[#09090b] text-zinc-100 font-sans antialiased selection:bg-emerald-500 selection:text-zinc-950">
    <div class="min-h-screen flex flex-col justify-center items-center p-4 relative">
        
        <!-- Logo Header -->
        <div class="mb-6 text-center">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2.5 group">
                <div class="w-9 h-9 rounded-xl bg-emerald-500/10 border border-emerald-500/30 flex items-center justify-center text-emerald-400 font-bold text-base group-hover:scale-105 transition-transform">
                    <i class="fa-solid fa-wallet"></i>
                </div>
                <span class="text-xl font-extrabold tracking-tight text-zinc-100">CashMind</span>
            </a>
        </div>

        <!-- Guest Card Shell -->
        <div class="w-full sm:max-w-sm bg-[#12131c] border border-zinc-800/80 rounded-2xl p-6 shadow-2xl backdrop-blur-xl relative z-10">
            {{ $slot }}
        </div>

        <!-- Back to Landing Link -->
        <div class="mt-6 text-center">
            <a href="{{ url('/') }}" class="text-xs text-zinc-500 hover:text-zinc-300 transition flex items-center gap-1.5 justify-center">
                <i class="fa-solid fa-arrow-left text-[10px]"></i>
                <span>Kembali ke Halaman Utama</span>
            </a>
        </div>
    </div>
</body>
</html>
