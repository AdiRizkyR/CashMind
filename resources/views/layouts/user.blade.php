<!DOCTYPE html>
<html lang="id" class="h-full bg-[#F1F5F9] text-[#0F172A] antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'CashMind | Studio Finansial Personal' }}</title>

    <!-- Google Fonts: Space Grotesk & Manrope -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Tailwind CSS & Alpine.js CDN -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Manrope', 'Inter', 'sans-serif'],
                        display: ['Space Grotesk', 'Manrope', 'sans-serif'],
                    },
                    colors: {
                        cm: {
                            dark: '#0B132B',
                            darkSoft: '#1C2541',
                            bg: '#F1F5F9',
                            surface: '#FFFFFF',
                            ink: '#090D16',
                            text: '#0F172A',
                            border: '#E2E8F0',
                            primary: '#0F172A',
                            accent: '#059669',
                            accentSoft: '#ECFDF5',
                            income: '#059669',
                            expense: '#E11D48',
                            warning: '#D97706',
                        }
                    }
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: #F1F5F9; }
        ::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 9999px; }
        ::-webkit-scrollbar-thumb:hover { background: #059669; }
        
        .financial-number { font-variant-numeric: tabular-nums; letter-spacing: -0.02em; }
        .font-display { font-family: 'Space Grotesk', sans-serif; }

        .cm-panel {
            background-color: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 16px;
            box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05);
        }
        
        .cm-input {
            background-color: #FFFFFF;
            border: 1px solid #CBD5E1;
            color: #0F172A;
            border-radius: 12px;
            padding: 0 16px;
            height: 46px;
            font-size: 0.875rem;
            width: 100%;
            transition: all 0.18s ease-in-out;
        }
        @media (max-width: 768px) {
            .cm-input { height: 48px; }
        }
        .cm-input:focus {
            outline: none;
            border-color: #059669;
            box-shadow: 0 0 0 4px rgba(5, 150, 105, 0.14);
        }

        .btn-primary {
            background-color: #0F172A;
            color: #FFFFFF;
            font-weight: 600;
            border-radius: 12px;
            height: 44px;
            padding: 0 20px;
            font-size: 0.875rem;
            transition: all 0.18s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-primary:hover { background-color: #1E293B; }

        .btn-emerald {
            background-color: #059669;
            color: #FFFFFF;
            font-weight: 600;
            border-radius: 12px;
            height: 44px;
            padding: 0 20px;
            font-size: 0.875rem;
            transition: all 0.18s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 14px rgba(5, 150, 105, 0.25);
        }
        .btn-emerald:hover { background-color: #047857; }

        .btn-secondary {
            background-color: #FFFFFF;
            border: 1px solid #CBD5E1;
            color: #334155;
            font-weight: 600;
            border-radius: 12px;
            height: 44px;
            padding: 0 20px;
            font-size: 0.875rem;
            transition: all 0.18s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-secondary:hover { background-color: #F8FAFC; color: #0F172A; }
    </style>
</head>
<body x-data="{ 
    openSideSheet: false, 
    openMobileMenu: false,
    quickType: 'expense',
    quickRawAmount: '',
    quickFormattedAmount: '',
    toastMessage: '{{ session('success') }}',
    showToast: {{ session('success') ? 'true' : 'false' }},
    init() {
        if (this.showToast) {
            setTimeout(() => { this.showToast = false; }, 3500);
        }
    },
    formatRupiah(val) {
        let digits = String(val).replace(/[^0-9]/g, '');
        this.quickRawAmount = digits;
        this.quickFormattedAmount = digits ? 'Rp ' + Number(digits).toLocaleString('id-ID') : '';
    }
}" class="h-full bg-[#F1F5F9] text-[#0F172A] font-sans antialiased selection:bg-[#059669] selection:text-white">
    <div class="min-h-screen flex flex-col md:flex-row">

        <!-- DESKTOP RICH DARK NAVIGATION RAIL (72px - Studio Finansial Modern) -->
        <aside class="w-[76px] bg-[#0B132B] text-slate-300 border-r border-[#1C2541] flex-col justify-between hidden md:flex fixed inset-y-0 z-30 shadow-xl">
            <div class="flex flex-col items-center">
                <!-- Brand Logo Header -->
                <div class="h-20 w-full flex items-center justify-center border-b border-[#1C2541]">
                    <a href="{{ route('user.dashboard') }}" class="w-11 h-11 rounded-2xl bg-gradient-to-br from-[#059669] to-[#047857] text-white flex items-center justify-center font-bold shadow-lg shadow-[#059669]/30 hover:scale-105 transition-transform" title="CashMind Ledger OS">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 12V7H5a2 2 0 0 1 0-4h14v4"/>
                            <path d="M3 5v14a2 2 0 0 0 2 2h16v-5"/>
                            <path d="M18 12a2 2 0 0 0 0 4h4v-4Z"/>
                        </svg>
                    </a>
                </div>

                <!-- Navigation Rail Menu -->
                <nav class="py-6 space-y-3 w-full flex flex-col items-center">
                    <!-- Dashboard -->
                    <a href="{{ route('user.dashboard') }}" class="relative w-12 h-12 rounded-xl flex items-center justify-center transition-all group {{ request()->routeIs('user.dashboard') ? 'bg-[#1C2541] text-[#10B981] font-bold shadow-md' : 'text-slate-400 hover:bg-[#1C2541]/70 hover:text-white' }}" title="Dashboard">
                        @if(request()->routeIs('user.dashboard'))
                            <div class="absolute left-0 top-2 bottom-2 w-1.5 bg-[#10B981] rounded-r-full shadow-sm shadow-[#10B981]"></div>
                        @endif
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="7" height="9" x="3" y="3" rx="1"/>
                            <rect width="7" height="5" x="14" y="3" rx="1"/>
                            <rect width="7" height="9" x="14" y="12" rx="1"/>
                            <rect width="7" height="5" x="3" y="16" rx="1"/>
                        </svg>
                    </a>

                    <!-- Transactions -->
                    <a href="{{ route('user.transactions.index') }}" class="relative w-12 h-12 rounded-xl flex items-center justify-center transition-all group {{ request()->routeIs('user.transactions.*') ? 'bg-[#1C2541] text-[#10B981] font-bold shadow-md' : 'text-slate-400 hover:bg-[#1C2541]/70 hover:text-white' }}" title="Transaksi">
                        @if(request()->routeIs('user.transactions.*'))
                            <div class="absolute left-0 top-2 bottom-2 w-1.5 bg-[#10B981] rounded-r-full shadow-sm shadow-[#10B981]"></div>
                        @endif
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                            <line x1="16" y1="13" x2="8" y2="13"/>
                            <line x1="16" y1="17" x2="8" y2="17"/>
                        </svg>
                    </a>

                    <!-- Accounts -->
                    <a href="{{ route('user.accounts.index') }}" class="relative w-12 h-12 rounded-xl flex items-center justify-center transition-all group {{ request()->routeIs('user.accounts.*') ? 'bg-[#1C2541] text-[#10B981] font-bold shadow-md' : 'text-slate-400 hover:bg-[#1C2541]/70 hover:text-white' }}" title="Rekening">
                        @if(request()->routeIs('user.accounts.*'))
                            <div class="absolute left-0 top-2 bottom-2 w-1.5 bg-[#10B981] rounded-r-full shadow-sm shadow-[#10B981]"></div>
                        @endif
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="20" height="12" x="2" y="6" rx="2"/>
                            <circle cx="12" cy="12" r="2"/>
                        </svg>
                    </a>

                    <!-- Budget -->
                    <a href="{{ route('user.budget.index') }}" class="relative w-12 h-12 rounded-xl flex items-center justify-center transition-all group {{ request()->routeIs('user.budget.*') ? 'bg-[#1C2541] text-[#10B981] font-bold shadow-md' : 'text-slate-400 hover:bg-[#1C2541]/70 hover:text-white' }}" title="Anggaran">
                        @if(request()->routeIs('user.budget.*'))
                            <div class="absolute left-0 top-2 bottom-2 w-1.5 bg-[#10B981] rounded-r-full shadow-sm shadow-[#10B981]"></div>
                        @endif
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="4" x2="20" y1="12" y2="12"/>
                            <line x1="4" x2="20" y1="6" y2="6"/>
                            <line x1="4" x2="20" y1="18" y2="18"/>
                            <circle cx="8" cy="12" r="2"/>
                            <circle cx="16" cy="6" r="2"/>
                            <circle cx="12" cy="18" r="2"/>
                        </svg>
                    </a>

                    <!-- Goals -->
                    <a href="{{ route('user.goals.index') }}" class="relative w-12 h-12 rounded-xl flex items-center justify-center transition-all group {{ request()->routeIs('user.goals.*') ? 'bg-[#1C2541] text-[#10B981] font-bold shadow-md' : 'text-slate-400 hover:bg-[#1C2541]/70 hover:text-white' }}" title="Target Keuangan">
                        @if(request()->routeIs('user.goals.*'))
                            <div class="absolute left-0 top-2 bottom-2 w-1.5 bg-[#10B981] rounded-r-full shadow-sm shadow-[#10B981]"></div>
                        @endif
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <circle cx="12" cy="12" r="6"/>
                            <circle cx="12" cy="12" r="2"/>
                        </svg>
                    </a>

                    <!-- Reports -->
                    <a href="{{ route('user.reports.index') }}" class="relative w-12 h-12 rounded-xl flex items-center justify-center transition-all group {{ request()->routeIs('user.reports.*') ? 'bg-[#1C2541] text-[#10B981] font-bold shadow-md' : 'text-slate-400 hover:bg-[#1C2541]/70 hover:text-white' }}" title="Laporan">
                        @if(request()->routeIs('user.reports.*'))
                            <div class="absolute left-0 top-2 bottom-2 w-1.5 bg-[#10B981] rounded-r-full shadow-sm shadow-[#10B981]"></div>
                        @endif
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 3v18h18"/>
                            <path d="m19 9-5 5-4-4-3 3"/>
                        </svg>
                    </a>
                    <!-- User Profile & ML Settings -->
                    <a href="{{ route('user.profile.index') }}" class="relative w-12 h-12 rounded-xl flex items-center justify-center transition-all group {{ request()->routeIs('user.profile.*') ? 'bg-[#1C2541] text-[#10B981] font-bold shadow-md' : 'text-slate-400 hover:bg-[#1C2541]/70 hover:text-white' }}" title="Profil Saya & ML Settings">
                        @if(request()->routeIs('user.profile.*'))
                            <div class="absolute left-0 top-2 bottom-2 w-1.5 bg-[#10B981] rounded-r-full shadow-sm shadow-[#10B981]"></div>
                        @endif
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                    </a>
                </nav>
            </div>

            <!-- Profile / Logout Actions -->
            <div class="p-3 flex flex-col items-center border-t border-[#1C2541] gap-3">
                <a href="{{ route('user.profile.index') }}" class="w-10 h-10 rounded-xl flex items-center justify-center {{ request()->routeIs('user.profile.*') ? 'bg-[#1C2541] text-[#10B981]' : 'text-slate-400 hover:bg-[#1C2541] hover:text-white' }} transition-colors" title="Profil Finansial Saya">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-10 h-10 rounded-xl flex items-center justify-center text-slate-400 hover:text-rose-400 hover:bg-rose-950/40 transition-colors" title="Keluar">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    </button>
                </form>
            </div>
        </aside>

        <!-- MAIN CONTAINER -->
        <div class="flex-1 md:ml-[76px] flex flex-col min-w-0 pb-24 md:pb-8">
            
            <!-- TOP HEADER (68px) -->
            <header class="h-[68px] bg-white border-b border-[#E2E8F0] px-4 md:px-8 flex items-center justify-between sticky top-0 z-20 shadow-xs">
                <div class="flex items-center gap-3">
                    <span class="text-xs font-semibold text-[#475467]">
                        {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                    </span>
                    <span class="hidden sm:inline-block w-1.5 h-1.5 rounded-full bg-[#CBD5E1]"></span>
                    <span class="text-[11px] font-bold text-[#059669] hidden sm:inline-flex items-center gap-1.5 bg-[#ECFDF5] px-3 py-1 rounded-full border border-[#A7F3D0]">
                        <span class="w-2 h-2 rounded-full bg-[#059669]"></span>
                        Private Studio Workspace
                    </span>
                </div>

                <div class="flex items-center gap-3">
                    <button @click="openSideSheet = true" class="btn-emerald">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="5" x2="12" y2="19"/>
                            <line x1="5" y1="12" x2="19" y2="12"/>
                        </svg>
                        <span>Catat Transaksi</span>
                    </button>
                </div>
            </header>

            <!-- TOAST NOTIFICATION CONTAINER -->
            <div x-show="showToast" x-cloak transition:enter="transition ease-out duration-200" transition:enter-start="opacity-0 translate-y-[-10px]" transition:enter-end="opacity-100 translate-y-0" transition:leave="transition ease-in duration-150" transition:leave-start="opacity-100 translate-y-0" transition:leave-end="opacity-0 translate-y-[-10px]" class="fixed bottom-5 right-5 md:top-auto z-50 w-full max-w-[360px] bg-white border border-[#E2E8F0] rounded-xl p-4 shadow-2xl flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-[#ECFDF5] text-[#059669] flex items-center justify-center flex-shrink-0">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <span class="text-xs font-semibold text-[#0F172A] block" x-text="toastMessage"></span>
                </div>
                <button @click="showToast = false" class="text-[#94A3B8] hover:text-[#0F172A]">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>

            <!-- INLINE ERROR ALERT -->
            @if($errors->any())
                <div class="px-4 md:px-8 pt-6">
                    <div class="p-4 rounded-xl bg-[#FFF1F2] border border-[#FECDD3] text-[#E11D48] text-xs font-semibold space-y-1">
                        <div class="flex items-center gap-2 mb-1">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/>
                                <line x1="12" y1="8" x2="12" y2="12"/>
                                <line x1="12" y1="16" x2="12.01" y2="16"/>
                            </svg>
                            <span>Mohon periksa kembali inputan Anda:</span>
                        </div>
                        <ul class="list-disc list-inside text-xs font-normal pl-2 space-y-0.5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- MAIN CONTENT AREA -->
            <main class="w-full max-w-[1360px] mx-auto p-4 md:p-8 flex-1">
                @yield('content')
            </main>
        </div>

        <!-- MOBILE FIXED BOTTOM NAVIGATION BAR -->
        <div class="md:hidden fixed bottom-0 inset-x-0 bg-[#0B132B] text-slate-300 border-t border-[#1C2541] h-16 z-40 flex items-center justify-around px-2 pb-[env(safe-area-inset-bottom)] shadow-2xl">
            <a href="{{ route('user.dashboard') }}" class="flex flex-col items-center justify-center w-14 py-1 {{ request()->routeIs('user.dashboard') ? 'text-[#10B981] font-bold' : 'text-slate-400' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                <span class="text-[10px] mt-1">Dashboard</span>
            </a>

            <a href="{{ route('user.transactions.index') }}" class="flex flex-col items-center justify-center w-14 py-1 {{ request()->routeIs('user.transactions.*') ? 'text-[#10B981] font-bold' : 'text-slate-400' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                <span class="text-[10px] mt-1">Transaksi</span>
            </a>

            <!-- Mobile Center Floating Action Button -->
            <button @click="openSideSheet = true" class="w-13 h-13 rounded-full bg-gradient-to-br from-[#059669] to-[#047857] text-white flex items-center justify-center shadow-lg shadow-[#059669]/40 hover:scale-105 active:scale-95 -mt-5 border-4 border-[#0B132B]">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            </button>

            <a href="{{ route('user.budget.index') }}" class="flex flex-col items-center justify-center w-14 py-1 {{ request()->routeIs('user.budget.*') ? 'text-[#10B981] font-bold' : 'text-slate-400' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/><circle cx="8" cy="12" r="2"/><circle cx="16" cy="6" r="2"/><circle cx="12" cy="18" r="2"/></svg>
                <span class="text-[10px] mt-1">Anggaran</span>
            </a>

            <button @click="openMobileMenu = true" class="flex flex-col items-center justify-center w-14 py-1 text-slate-400">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>
                <span class="text-[10px] mt-1">Lainnya</span>
            </button>
        </div>

        <!-- MOBILE MENU BOTTOM SHEET -->
        <div x-show="openMobileMenu" x-cloak class="fixed inset-0 z-50 flex items-end bg-[#090D16]/60 backdrop-blur-xs md:hidden">
            <div @click.away="openMobileMenu = false" class="bg-white rounded-t-3xl w-full p-6 space-y-4">
                <div class="w-12 h-1.5 bg-[#E2E8F0] rounded-full mx-auto mb-2"></div>
                <h3 class="text-sm font-bold text-[#0F172A] font-display">Menu Studio Keuangan</h3>

                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('user.accounts.index') }}" class="p-4 rounded-2xl border border-[#E2E8F0] bg-[#F8FAFC] flex items-center gap-3">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="12" x="2" y="6" rx="2"/><circle cx="12" cy="12" r="2"/></svg>
                        <span class="text-xs font-bold text-[#0F172A]">Rekening</span>
                    </a>
                    <a href="{{ route('user.goals.index') }}" class="p-4 rounded-2xl border border-[#E2E8F0] bg-[#F8FAFC] flex items-center gap-3">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
                        <span class="text-xs font-bold text-[#0F172A]">Target</span>
                    </a>
                    <a href="{{ route('user.reconciliation.index') }}" class="p-4 rounded-2xl border border-[#E2E8F0] bg-[#F8FAFC] flex items-center gap-3">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m16 16 3-8 3 8c-.87.65-1.92 1-3 1s-2.13-.35-3-1Z"/><path d="m2 16 3-8 3 8c-.87.65-1.92 1-3 1s-2.13-.35-3-1Z"/><path d="M7 21h10"/><path d="M12 3v18"/><path d="M3 7h18"/></svg>
                        <span class="text-xs font-bold text-[#0F172A]">Rekonsiliasi</span>
                    </a>
                    <a href="{{ route('user.reports.index') }}" class="p-4 rounded-2xl border border-[#E2E8F0] bg-[#F8FAFC] flex items-center gap-3">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/></svg>
                        <span class="text-xs font-bold text-[#0F172A]">Laporan</span>
                    </a>
                    <a href="{{ route('user.profile.index') }}" class="p-4 rounded-2xl border border-[#A7F3D0] bg-[#ECFDF5] flex items-center gap-3 col-span-2">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        <div class="truncate">
                            <span class="text-xs font-bold text-[#0F172A] block leading-tight">Profil Finansial & ML Settings</span>
                            <span class="text-[10px] text-[#059669] font-medium block">Atur Pendapatan & Jadwal Rekomendasi</span>
                        </div>
                    </a>
                    <a href="{{ route('user.categories.index') }}" class="p-4 rounded-2xl border border-[#E2E8F0] bg-[#F8FAFC] flex items-center gap-3 col-span-2">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 5 4 4"/><path d="M13 2 3 12v7a2 2 0 0 0 2 2h7l10-10V4a2 2 0 0 0-2-2z"/><circle cx="7.5" cy="7.5" r=".5" fill="currentColor"/></svg>
                        <span class="text-xs font-bold text-[#0F172A]">Kategori Keuangan</span>
                    </a>
                </div>

                <button @click="openMobileMenu = false" class="btn-secondary w-full justify-center">Tutup</button>
            </div>
        </div>

        <!-- FORM SIDE SHEET DESKTOP & FULL SCREEN SHEET MOBILE -->
        <div x-show="openSideSheet" x-cloak class="fixed inset-0 z-50 flex justify-end bg-[#090D16]/60 backdrop-blur-xs">
            <div @click.away="openSideSheet = false" class="bg-white w-full md:w-[480px] h-full flex flex-col justify-between shadow-2xl overflow-y-auto">
                
                <!-- Side Sheet Header -->
                <div class="h-[72px] px-6 bg-[#0B132B] text-white flex items-center justify-between sticky top-0 z-10 shadow-md">
                    <div>
                        <h3 class="text-base font-bold font-display">Tambah Transaksi</h3>
                        <p class="text-[11px] text-slate-300">Catat transaksi pemasukan, pengeluaran, atau transfer.</p>
                    </div>
                    <button @click="openSideSheet = false" class="text-slate-400 hover:text-white">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </button>
                </div>

                <!-- Form Content -->
                <form method="POST" action="{{ route('user.transactions.store') }}" class="p-6 space-y-5 flex-1">
                    @csrf
                    
                    <!-- Segmented Transaction Type -->
                    <div>
                        <label class="block text-xs font-bold text-[#344054] mb-2 uppercase tracking-wider">Jenis Transaksi <span class="text-[#E11D48]">*</span></label>
                        <div class="grid grid-cols-3 gap-1 p-1 bg-[#F1F5F9] rounded-2xl border border-[#E2E8F0]">
                            <button type="button" @click="quickType = 'expense'" :class="quickType === 'expense' ? 'bg-[#E11D48] text-white font-bold shadow-md' : 'text-[#64748B] hover:text-[#0F172A]'" class="py-2.5 px-3 rounded-xl text-xs transition-all">
                                Pengeluaran
                            </button>
                            <button type="button" @click="quickType = 'income'" :class="quickType === 'income' ? 'bg-[#059669] text-white font-bold shadow-md' : 'text-[#64748B] hover:text-[#0F172A]'" class="py-2.5 px-3 rounded-xl text-xs transition-all">
                                Pemasukan
                            </button>
                            <button type="button" @click="quickType = 'transfer'" :class="quickType === 'transfer' ? 'bg-[#0F172A] text-white font-bold shadow-md' : 'text-[#64748B] hover:text-[#0F172A]'" class="py-2.5 px-3 rounded-xl text-xs transition-all">
                                Transfer
                            </button>
                        </div>
                        <input type="hidden" name="type" :value="quickType">
                    </div>

                    <!-- Nominal Amount -->
                    <div>
                        <label class="block text-xs font-bold text-[#344054] mb-2 uppercase tracking-wider">Nominal <span class="text-[#E11D48]">*</span></label>
                        <div class="relative">
                            <input type="text" 
                                   x-model="quickFormattedAmount" 
                                   @input="formatRupiah($event.target.value)" 
                                   inputmode="numeric"
                                   placeholder="Rp 0" 
                                   required 
                                   class="cm-input text-2xl font-bold text-[#0F172A] financial-number h-14 border-[#CBD5E1]">
                            <input type="hidden" name="amount" x-model="quickRawAmount">
                        </div>
                    </div>

                    <!-- Source Account -->
                    <div>
                        <label class="block text-xs font-bold text-[#344054] mb-1.5 uppercase tracking-wider" x-text="quickType === 'transfer' ? 'Rekening Asal *' : 'Rekening *'"></label>
                        <select name="account_id" required class="cm-input">
                            <option value="">Pilih rekening</option>
                            @foreach(Auth::user()->accounts()->where('is_active', true)->get() as $acc)
                                <option value="{{ $acc->id }}">{{ $acc->name }} (Rp {{ number_format($acc->balance, 0, ',', '.') }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Destination Account (For Transfer) -->
                    <div x-show="quickType === 'transfer'">
                        <label class="block text-xs font-bold text-[#344054] mb-1.5 uppercase tracking-wider">Rekening Tujuan <span class="text-[#E11D48]">*</span></label>
                        <select name="destination_account_id" class="cm-input">
                            <option value="">Pilih rekening tujuan</option>
                            @foreach(Auth::user()->accounts()->where('is_active', true)->get() as $acc)
                                <option value="{{ $acc->id }}">{{ $acc->name }} (Rp {{ number_format($acc->balance, 0, ',', '.') }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Category -->
                    <div x-show="quickType !== 'transfer'">
                        <label class="block text-xs font-bold text-[#344054] mb-1.5 uppercase tracking-wider">Kategori</label>
                        <select name="category_id" class="cm-input">
                            <option value="">Pilih kategori</option>
                            @php
                                $disabledCatIds = \App\Models\UserCategoryToggle::where('user_id', Auth::id())->where('is_active', false)->pluck('category_id')->toArray();
                                $activeCats = Auth::user()->categories()->get()->concat(\App\Models\Category::where('is_system', true)->whereNotIn('id', $disabledCatIds)->get());
                            @endphp
                            @foreach($activeCats as $cat)
                                <option value="{{ $cat->id }}" x-show="quickType === '{{ $cat->type }}'">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Date -->
                    <div>
                        <label class="block text-xs font-bold text-[#344054] mb-1.5 uppercase tracking-wider">Tanggal <span class="text-[#E11D48]">*</span></label>
                        <input type="date" name="transaction_date" value="{{ date('Y-m-d') }}" required class="cm-input">
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-xs font-bold text-[#344054] mb-1.5 uppercase tracking-wider">Uraian Transaksi <span class="text-[#E11D48]">*</span></label>
                        <input type="text" name="description" placeholder="Contoh: Makan siang meeting" required class="cm-input">
                    </div>

                    <!-- Detail Note -->
                    <div>
                        <label class="block text-xs font-bold text-[#344054] mb-1.5 uppercase tracking-wider">Catatan Detail (Opsional)</label>
                        <input type="text" name="note" placeholder="Contoh: Pembayaran via QRIS BCA" class="cm-input">
                    </div>

                    <!-- Sticky Action Footer -->
                    <div class="pt-4 border-t border-[#E2E8F0] flex justify-end gap-3 sticky bottom-0 bg-white pb-2">
                        <button type="button" @click="openSideSheet = false" class="btn-secondary">Batal</button>
                        <button type="submit" class="btn-emerald">Simpan Transaksi</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</body>
</html>
