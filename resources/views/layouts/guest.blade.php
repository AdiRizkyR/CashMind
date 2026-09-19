<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#F4F6F8] text-[#101828] antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'CashMind — Sign In' }}</title>

    <!-- Google Font: Manrope -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS & Alpine.js CDN -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Manrope', 'sans-serif'],
                        mono: ['ui-monospace', 'SFMono-Regular', 'Menlo', 'Monaco', 'Consolas', 'monospace'],
                    },
                    colors: {
                        cm: {
                            bg: '#F4F6F8',
                            ink: '#101828',
                            primary: '#0F172A',
                            accent: '#0F766E',
                            border: '#E4E7EC',
                            muted: '#667085',
                            income: '#15803D',
                            expense: '#B42318',
                            warning: '#B54708',
                        }
                    }
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Manrope', sans-serif; }
    </style>
</head>
<body class="h-full bg-[#F4F6F8] text-[#101828] font-sans antialiased selection:bg-[#0F766E] selection:text-white">
    <!-- Guideline Section 82 & 83: Split-Screen Auth (Desktop) / Single-Column (Mobile) -->
    <div class="min-h-screen grid grid-cols-1 lg:grid-cols-12 bg-[#F4F6F8]">
        
        <!-- LEFT PANEL: PRODUCT PREVIEW & PRIVACY HIGHLIGHT (LG ONLY) -->
        <div class="hidden lg:flex lg:col-span-5 bg-[#0F172A] p-12 flex-col justify-between relative overflow-hidden text-white">
            <!-- Brand Header -->
            <div class="relative z-10">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-[#0F766E] text-white flex items-center justify-center font-bold text-lg shadow-xs">
                        <svg class="w-6 h-6 text-[#99F6E4]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-xl font-bold tracking-tight text-white block leading-none">CashMind</span>
                        <span class="text-[10px] text-[#99F6E4] font-semibold uppercase tracking-wider mt-1 block">Ledger OS</span>
                    </div>
                </a>
            </div>

            <!-- Product Preview Card Showcase -->
            <div class="relative z-10 space-y-6 max-w-sm">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#1E293B] border border-[#334155] text-xs font-semibold text-[#99F6E4]">
                    <span class="w-2 h-2 rounded-full bg-[#0F766E]"></span>
                    <span>Private Personal Finance</span>
                </div>
                
                <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight leading-snug">
                    Pencatatan Keuangan Presisi dengan Privasi Mutlak.
                </h2>
                
                <p class="text-[#94A3B8] text-xs leading-relaxed font-medium">
                    Kelola pemasukan, pengeluaran, transfer, dan anggaran bulanan dalam satu ruang personal. Data Anda 100% terisolasi dari pihak manapun.
                </p>

                <div class="p-4 rounded-xl bg-[#1E293B] border border-[#334155] space-y-2">
                    <div class="flex items-center justify-between text-xs font-mono font-semibold">
                        <span class="text-[#94A3B8]">Financial Snapshot Preview</span>
                        <span class="text-[#15803D]">+ Rp 2.750.000</span>
                    </div>
                    <div class="w-full h-1.5 rounded-full bg-[#334155] overflow-hidden">
                        <div class="h-full bg-[#0F766E] w-3/4 rounded-full"></div>
                    </div>
                </div>
            </div>

            <!-- Footer Badge -->
            <div class="relative z-10 text-[11px] text-[#64748B] font-medium">
                CashMind &copy; 2026 — Private by Design Financial System
            </div>
        </div>

        <!-- RIGHT PANEL: AUTH FORM CONTAINER -->
        <div class="lg:col-span-7 flex flex-col justify-center items-center p-6 sm:p-12 relative">
            <div class="w-full max-w-md space-y-6">
                <!-- Mobile Logo Header -->
                <div class="lg:hidden text-center mb-6">
                    <a href="{{ url('/') }}" class="inline-flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-[#0F172A] text-white flex items-center justify-center font-bold text-base shadow-xs">
                            <svg class="w-5 h-5 text-[#99F6E4]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-[#0F172A]">CashMind</span>
                    </a>
                </div>

                {{ $slot }}

                <!-- Back Link -->
                <div class="text-center pt-2">
                    <a href="{{ url('/') }}" class="text-xs text-[#667085] hover:text-[#0F172A] font-semibold transition inline-flex items-center gap-1.5">
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
