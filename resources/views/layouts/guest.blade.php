<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50 text-slate-900 antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'CashMind — Sign In' }}</title>

    <!-- Google Fonts: Plus Jakarta Sans & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">

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
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    },
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="h-full bg-slate-50 text-slate-900 font-sans antialiased selection:bg-emerald-500 selection:text-white">
    <!-- Komentar Bahasa Indonesia: Layout Otentikasi Split-Screen Horizon -->
    <div class="min-h-screen grid grid-cols-1 lg:grid-cols-12 bg-slate-50">
        
        <!-- LEFT PANEL: VISUAL FEATURE CANVAS & SHOWCASE (LG ONLY) -->
        <div class="hidden lg:flex lg:col-span-5 bg-gradient-to-br from-slate-900 via-slate-800 to-emerald-950 p-12 flex-col justify-between relative overflow-hidden text-white">
            <div class="absolute -right-16 -top-16 w-80 h-80 rounded-full bg-emerald-500/10 blur-3xl"></div>
            <div class="absolute -left-16 -bottom-16 w-80 h-80 rounded-full bg-teal-500/10 blur-3xl"></div>

            <!-- Brand Logo Header -->
            <div class="relative z-10">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-emerald-500 to-teal-400 text-white flex items-center justify-center font-bold text-lg shadow-lg group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                    <div>
                        <span class="text-xl font-extrabold tracking-tight text-white block leading-none">CashMind</span>
                        <span class="text-[10px] text-emerald-400 font-mono font-bold uppercase tracking-widest mt-1 block">Enterprise Operating System</span>
                    </div>
                </a>
            </div>

            <!-- Hero Feature Cards Preview -->
            <div class="relative z-10 space-y-6 max-w-sm">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 text-xs font-semibold backdrop-blur-md">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Multi-Role Management System</span>
                </div>
                
                <h2 class="text-3xl font-extrabold tracking-tight leading-tight">
                    Pencatatan Keuangan Presisi untuk Personal & Corporate.
                </h2>
                
                <p class="text-slate-300 text-xs leading-relaxed font-medium">
                    Atur persentase alokasi anggaran, pantau grafik realisasi pengeluaran, dan buat laporan keuangan resmi siap cetak dalam hitungan detik.
                </p>

                <div class="p-4 rounded-2xl bg-white/10 border border-white/20 backdrop-blur-md space-y-2">
                    <div class="flex items-center justify-between text-xs font-mono font-bold">
                        <span class="text-slate-300">Total Arus Kas Terkelola</span>
                        <span class="text-emerald-400">Rp 4.28 Milyar</span>
                    </div>
                    <div class="w-full h-1.5 rounded-full bg-white/20 overflow-hidden">
                        <div class="h-full bg-emerald-400 w-3/4 rounded-full"></div>
                    </div>
                </div>
            </div>

            <!-- Footer Badge -->
            <div class="relative z-10 text-[11px] text-slate-400 font-medium">
                CashMind System &copy; 2026 — Secure 256-Bit Financial Encryption
            </div>
        </div>

        <!-- RIGHT PANEL: INTERACTIVE FORM CONTAINER -->
        <div class="lg:col-span-7 flex flex-col justify-center items-center p-6 sm:p-12 relative">
            <div class="w-full max-w-md space-y-6">
                <!-- Mobile Logo Header -->
                <div class="lg:hidden text-center mb-6">
                    <a href="{{ url('/') }}" class="inline-flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-emerald-600 text-white flex items-center justify-center font-bold text-lg shadow-md">
                            <i class="fa-solid fa-wallet"></i>
                        </div>
                        <span class="text-2xl font-extrabold text-slate-900">CashMind</span>
                    </a>
                </div>

                {{ $slot }}

                <!-- Back Link -->
                <div class="text-center pt-2">
                    <a href="{{ url('/') }}" class="text-xs text-slate-500 hover:text-slate-900 font-bold transition inline-flex items-center gap-2">
                        <i class="fa-solid fa-arrow-left text-[10px]"></i>
                        <span>Kembali ke Halaman Utama</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
