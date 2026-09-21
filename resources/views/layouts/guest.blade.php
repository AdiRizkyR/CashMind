<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#F1F5F9] text-[#0F172A] antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'CashMind | Sign In' }}</title>

    <!-- Google Fonts: Space Grotesk & Manrope -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS & Alpine.js CDN -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Manrope', 'sans-serif'],
                        display: ['Space Grotesk', 'sans-serif'],
                    },
                    colors: {
                        cm: {
                            dark: '#0B132B',
                            bg: '#F1F5F9',
                            surface: '#FFFFFF',
                            text: '#0F172A',
                            accent: '#059669',
                            border: '#E2E8F0',
                        }
                    }
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Manrope', sans-serif; }
        .font-display { font-family: 'Space Grotesk', sans-serif; }
    </style>
</head>
<body class="h-full bg-[#F1F5F9] text-[#0F172A] font-sans antialiased selection:bg-[#059669] selection:text-white">
    <div class="min-h-screen grid grid-cols-1 lg:grid-cols-12 bg-[#F1F5F9]">
        
        <!-- LEFT PANEL: RICH DARK NAVY SHOWCASE (DESKTOP) -->
        <div class="hidden lg:flex lg:col-span-5 bg-gradient-to-br from-[#0B132B] via-[#0F172A] to-[#1C2541] p-12 flex-col justify-between relative overflow-hidden text-white shadow-2xl border-r border-[#1C2541]">
            <div class="absolute top-1/3 left-1/2 -translate-x-1/2 w-80 h-80 rounded-full bg-[#059669]/20 blur-3xl pointer-events-none"></div>

            <!-- Brand Header -->
            <div class="relative z-10">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-3">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-[#059669] to-[#047857] text-white flex items-center justify-center font-bold text-lg shadow-lg shadow-[#059669]/30">
                        <svg class="w-6 h-6 text-[#A7F3D0]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-xl font-bold font-display tracking-tight text-white block leading-none">CashMind</span>
                        <span class="text-[10px] text-[#34D399] font-bold uppercase tracking-wider mt-1 block">Ledger OS</span>
                    </div>
                </a>
            </div>

            <!-- Product Preview Showcase Card -->
            <div class="relative z-10 space-y-6 max-w-sm">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#059669]/20 border border-[#059669]/40 text-xs font-bold text-[#A7F3D0]">
                    <span class="w-2 h-2 rounded-full bg-[#34D399]"></span>
                    <span>Private Personal Finance</span>
                </div>
                
                <h2 class="text-3xl font-bold font-display tracking-tight leading-snug">
                    Pencatatan Keuangan Presisi dengan Privasi Mutlak.
                </h2>
                
                <p class="text-slate-300 text-xs leading-relaxed font-medium">
                    Kelola pemasukan, pengeluaran, transfer, dan anggaran bulanan dalam satu ruang personal. Data Anda 100% terisolasi dari pihak manapun.
                </p>

                <div class="p-4 rounded-2xl bg-[#090D16] border border-[#1C2541] space-y-2">
                    <div class="flex items-center justify-between text-xs font-mono font-bold">
                        <span class="text-slate-400">Financial Snapshot</span>
                        <span class="text-[#34D399]">+ Rp 2.750.000</span>
                    </div>
                    <div class="w-full h-2 rounded-full bg-[#1C2541] overflow-hidden">
                        <div class="h-full bg-[#059669] w-3/4 rounded-full"></div>
                    </div>
                </div>
            </div>

            <!-- Footer Badge -->
            <div class="relative z-10 text-[11px] text-slate-400 font-medium">
                CashMind &copy; 2026 | Private by Design Financial System
            </div>
        </div>

        <!-- RIGHT PANEL: AUTH FORM CONTAINER -->
        <div class="lg:col-span-7 flex flex-col justify-center items-center p-6 sm:p-12 relative">
            <div class="w-full max-w-md space-y-6">
                <!-- Mobile Logo Header -->
                <div class="lg:hidden text-center mb-6">
                    <a href="{{ url('/') }}" class="inline-flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-[#0B132B] text-white flex items-center justify-center font-bold text-base shadow-md">
                            <svg class="w-6 h-6 text-[#34D399]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <span class="text-2xl font-bold font-display text-[#0F172A]">CashMind</span>
                    </a>
                </div>

                {{ $slot }}

                <!-- Back Link -->
                <div class="text-center pt-2">
                    <a href="{{ url('/') }}" class="text-xs text-[#64748B] hover:text-[#0F172A] font-bold transition inline-flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        <span>Kembali ke Halaman Utama</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
