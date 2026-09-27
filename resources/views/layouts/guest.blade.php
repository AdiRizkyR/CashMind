<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#F8FAFC] text-[#0F172A] antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'CashMind | Studio Finansial Personal & Autentikasi' }}</title>

    <!-- Google Fonts: Inter & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS & Alpine.js CDN -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['Plus Jakarta Sans', 'Inter', 'sans-serif'],
                    },
                    colors: {
                        cm: {
                            dark: '#0F172A',
                            darkSoft: '#1E293B',
                            bg: '#F8FAFC',
                            surface: '#FFFFFF',
                            ink: '#0F172A',
                            primary: '#4F46E5',
                            accent: '#10B981',
                        }
                    }
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Plus Jakarta Sans', sans-serif; }
        .financial-number { font-variant-numeric: tabular-nums; letter-spacing: -0.01em; }

        .cm-input {
            background-color: #FFFFFF;
            border: 1px solid #CBD5E1;
            color: #0F172A;
            border-radius: 0.75rem;
            padding: 0 1rem;
            height: 46px;
            font-size: 0.875rem;
            font-weight: 500;
            width: 100%;
            transition: all 0.15s ease-in-out;
            box-sizing: border-box;
        }
        .cm-input:focus {
            outline: none;
            border-color: #4F46E5;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.12);
        }
        .cm-input::placeholder {
            color: #94A3B8;
        }

        .btn-primary {
            background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
            color: #FFFFFF;
            font-weight: 600;
            border-radius: 0.75rem;
            height: 46px;
            padding: 0 1.25rem;
            font-size: 0.875rem;
            transition: all 0.18s cubic-bezier(0.16, 1, 0.3, 1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.15);
            cursor: pointer;
            width: 100%;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #1E293B 0%, #334155 100%);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(15, 23, 42, 0.22);
        }

        .btn-indigo {
            background: linear-gradient(135deg, #4F46E5 0%, #4338CA 100%);
            color: #FFFFFF;
            font-weight: 600;
            border-radius: 0.75rem;
            height: 46px;
            padding: 0 1.25rem;
            font-size: 0.875rem;
            transition: all 0.18s cubic-bezier(0.16, 1, 0.3, 1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            box-shadow: 0 4px 14px rgba(79, 70, 229, 0.3);
            cursor: pointer;
            width: 100%;
        }
        .btn-indigo:hover {
            background: linear-gradient(135deg, #4338CA 0%, #3730A3 100%);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4);
        }
    </style>
</head>
<body class="h-full bg-[#F8FAFC] text-[#0F172A] font-sans antialiased selection:bg-[#4F46E5] selection:text-white">
    <div class="min-h-screen grid grid-cols-1 lg:grid-cols-12 bg-[#F8FAFC]">
        
        <!-- LEFT PANEL: RICH DARK SLATE SHOWCASE (DESKTOP) -->
        <div class="hidden lg:flex lg:col-span-5 bg-gradient-to-br from-[#0F172A] via-[#1E293B] to-[#0F172A] p-12 flex-col justify-between relative overflow-hidden text-white shadow-2xl border-r border-[#334155]">
            <!-- Glowing Accent Background Effects -->
            <div class="absolute top-1/4 left-1/2 -translate-x-1/2 w-80 h-80 rounded-full bg-[#4F46E5]/20 blur-3xl pointer-events-none"></div>
            <div class="absolute bottom-10 right-10 w-64 h-64 rounded-full bg-[#10B981]/15 blur-3xl pointer-events-none"></div>

            <!-- Brand Header -->
            <div class="relative z-10">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-3 group">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-[#4F46E5] to-[#3730A3] text-white flex items-center justify-center font-bold text-lg shadow-lg shadow-[#4F46E5]/30 group-hover:scale-105 transition-transform duration-200">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="20" height="14" x="2" y="5" rx="2"/>
                            <line x1="2" x2="22" y1="10" y2="10"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-xl font-extrabold font-display tracking-tight text-white block leading-none">CashMind</span>
                        <span class="text-[10px] text-[#A5B4FC] font-bold uppercase tracking-wider mt-1 block">Financial Control OS</span>
                    </div>
                </a>
            </div>

            <!-- Product Feature Showcase Card -->
            <div class="relative z-10 space-y-6 max-w-sm">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#10B981]/20 border border-[#10B981]/40 text-xs font-bold text-[#6EE7B7]">
                    <span class="w-2 h-2 rounded-full bg-[#10B981] animate-pulse"></span>
                    <span>100% Private Personal Workspace</span>
                </div>
                
                <h2 class="text-3xl font-extrabold font-display tracking-tight leading-snug">
                    Pencatatan Keuangan Presisi dengan Kendali Mutlak.
                </h2>
                
                <p class="text-slate-300 text-xs leading-relaxed font-medium">
                    Kelola arus kas bulanan, alokasi budget per kategori, transfer antar rekening, dan deteksi selisih saldo dalam studio finansial pribadi Anda.
                </p>

                <!-- Financial Snapshot Mock Card -->
                <div class="p-4 rounded-2xl bg-white/5 border border-white/10 space-y-3 backdrop-blur-md">
                    <div class="flex items-center justify-between text-xs font-bold">
                        <span class="text-slate-300">Ringkasan Arus Kas</span>
                        <span class="text-[#6EE7B7] financial-number">+ Rp 8.500.000</span>
                    </div>
                    <div class="w-full h-2 rounded-full bg-slate-800 overflow-hidden">
                        <div class="h-full bg-[#10B981] w-3/4 rounded-full"></div>
                    </div>
                    <div class="flex justify-between text-[11px] text-slate-400 font-medium">
                        <span>Pengeluaran: Rp 3.250.000</span>
                        <span class="text-[#6EE7B7]">Surplus: 61.7%</span>
                    </div>
                </div>
            </div>

            <!-- Footer Credit -->
            <div class="relative z-10 text-[11px] text-slate-400 font-medium">
                CashMind &copy; {{ date('Y') }} | System Management Control Center
            </div>
        </div>

        <!-- RIGHT PANEL: AUTH FORM CONTAINER -->
        <div class="lg:col-span-7 flex flex-col justify-center items-center p-6 sm:p-12 relative min-h-screen lg:min-h-0">
            <div class="w-full max-w-md space-y-6">
                <!-- Mobile Brand Header -->
                <div class="lg:hidden text-center mb-6">
                    <a href="{{ url('/') }}" class="inline-flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-[#0F172A] text-white flex items-center justify-center font-bold text-base shadow-md">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect width="20" height="14" x="2" y="5" rx="2"/>
                                <line x1="2" x2="22" y1="10" y2="10"/>
                            </svg>
                        </div>
                        <span class="text-2xl font-extrabold font-display text-[#0F172A]">CashMind</span>
                    </a>
                </div>

                {{ $slot }}

                <!-- Back Link -->
                <div class="text-center pt-2">
                    <a href="{{ url('/') }}" class="text-xs text-[#64748B] hover:text-[#4F46E5] font-semibold transition inline-flex items-center gap-1.5">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="19" y1="12" x2="5" y2="12"/>
                            <polyline points="12 19 5 12 12 5"/>
                        </svg>
                        <span>Kembali ke Halaman Utama</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
