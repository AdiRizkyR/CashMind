<!DOCTYPE html>
<html lang="id" class="h-full bg-[#F8FAFC] text-[#0F172A] antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'CashMind | Studio Pencatatan & Pengendalian Keuangan' }}</title>

    <!-- Google Fonts: Inter & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
                            text: '#334155',
                            border: '#E2E8F0',
                            primary: '#4F46E5', // Indigo primary
                            accent: '#059669', // Green success
                            accentSoft: '#ECFDF5',
                            income: '#10B981',
                            expense: '#EF4444',
                            warning: '#F59E0B',
                        }
                    }
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #F8FAFC; }
        ::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 9999px; }
        ::-webkit-scrollbar-thumb:hover { background: #64748B; }
        
        .financial-number { font-variant-numeric: tabular-nums; letter-spacing: -0.01em; }
        .font-display { font-family: 'Plus Jakarta Sans', sans-serif; }

        .cm-panel {
            background-color: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 16px;
            box-shadow: 0 4px 18px -2px rgba(15, 23, 42, 0.04);
        }
        
        .cm-input {
            background-color: #FFFFFF;
            border: 1px solid #CBD5E1;
            color: #0F172A;
            border-radius: 12px;
            padding: 0 16px;
            height: 44px;
            font-size: 0.875rem;
            width: 100%;
            transition: all 0.18s ease-in-out;
            box-sizing: border-box;
        }
        .cm-input:focus {
            outline: none;
            border-color: #4F46E5;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.12);
        }

        /* Prevent select dropdown arrow from overlapping text */
        select.cm-input, select.cm-select, select {
            padding-right: 2.75rem !important;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%23475467' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M6 8l4 4 4-4'/%3e%3c/svg%3e") !important;
            background-position: right 0.75rem center !important;
            background-repeat: no-repeat !important;
            background-size: 1.25rem 1.25rem !important;
            appearance: none !important;
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
        }

        .btn-primary {
            background-color: #4F46E5;
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
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
            cursor: pointer;
        }
        .btn-primary:hover { background-color: #4338CA; }

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
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.2);
            cursor: pointer;
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
            cursor: pointer;
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
    quickRawAdminFee: '',
    quickFormattedAdminFee: '',
    toastMessage: '{{ session('success') }}',
    showToast: {{ session('success') ? 'true' : 'false' }},
    init() {
        if (this.showToast) {
            setTimeout(() => { this.showToast = false; }, 3500);
        }
    },
    formatRupiah(val, field) {
        let digits = String(val).replace(/[^0-9]/g, '');
        if (field === 'amount') {
            this.quickRawAmount = digits;
            this.quickFormattedAmount = digits ? 'Rp ' + Number(digits).toLocaleString('id-ID') : '';
        } else if (field === 'admin_fee') {
            this.quickRawAdminFee = digits;
            this.quickFormattedAdminFee = digits ? 'Rp ' + Number(digits).toLocaleString('id-ID') : '';
        }
    }
}" class="h-full bg-[#F8FAFC] text-[#0F172A] font-sans antialiased selection:bg-[#4F46E5] selection:text-white">
    <div class="min-h-screen flex flex-col md:flex-row">

        <!-- DESKTOP SIDEBAR NAVIGATION (76px - CashMind v2 System Rail) -->
        <aside class="w-[76px] bg-[#0F172A] text-slate-300 border-r border-[#1E293B] flex-col justify-between hidden md:flex fixed inset-y-0 z-30 shadow-2xl">
            <div class="flex flex-col items-center">
                <!-- Brand Logo Header -->
                <div class="h-[68px] w-full flex items-center justify-center border-b border-[#1E293B]">
                    <a href="{{ route('user.dashboard') }}" class="w-11 h-11 rounded-2xl bg-gradient-to-br from-[#4F46E5] to-[#3730A3] text-white flex items-center justify-center font-bold shadow-lg shadow-[#4F46E5]/30 hover:scale-105 transition-transform" title="CashMind Financial Control Center">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="20" height="14" x="2" y="5" rx="2"/>
                            <line x1="2" x2="22" y1="10" y2="10"/>
                        </svg>
                    </a>
                </div>

                <!-- 5 Core System Menus Navigation -->
                <nav class="py-6 space-y-3.5 w-full flex flex-col items-center">
                    <!-- 1. Dashboard -->
                    <a href="{{ route('user.dashboard') }}" class="relative w-12 h-12 rounded-xl flex items-center justify-center transition-all group {{ request()->routeIs('user.dashboard') ? 'bg-[#1E293B] text-[#818CF8] font-bold shadow-md' : 'text-slate-400 hover:bg-[#1E293B]/80 hover:text-white' }}" title="1. Dashboard (Overview)">
                        @if(request()->routeIs('user.dashboard'))
                            <div class="absolute left-0 top-2 bottom-2 w-1.5 bg-[#818CF8] rounded-r-full shadow-sm"></div>
                        @endif
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="7" height="9" x="3" y="3" rx="1"/>
                            <rect width="7" height="5" x="14" y="3" rx="1"/>
                            <rect width="7" height="9" x="14" y="12" rx="1"/>
                            <rect width="7" height="5" x="3" y="16" rx="1"/>
                        </svg>
                    </a>

                    <!-- 2. Income & Expenses -->
                    <a href="{{ route('user.transactions.index') }}" class="relative w-12 h-12 rounded-xl flex items-center justify-center transition-all group {{ request()->routeIs('user.transactions.*') ? 'bg-[#1E293B] text-[#818CF8] font-bold shadow-md' : 'text-slate-400 hover:bg-[#1E293B]/80 hover:text-white' }}" title="2. Income & Expenses">
                        @if(request()->routeIs('user.transactions.*'))
                            <div class="absolute left-0 top-2 bottom-2 w-1.5 bg-[#818CF8] rounded-r-full shadow-sm"></div>
                        @endif
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" x2="12" y1="2" y2="22"/>
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                        </svg>
                    </a>

                    <!-- 3. Master Data -->
                    <a href="{{ route('user.master-data.index') }}" class="relative w-12 h-12 rounded-xl flex items-center justify-center transition-all group {{ request()->routeIs('user.master-data.*') || request()->routeIs('user.categories.*') || request()->routeIs('user.accounts.*') ? 'bg-[#1E293B] text-[#818CF8] font-bold shadow-md' : 'text-slate-400 hover:bg-[#1E293B]/80 hover:text-white' }}" title="3. Master Data">
                        @if(request()->routeIs('user.master-data.*') || request()->routeIs('user.categories.*') || request()->routeIs('user.accounts.*'))
                            <div class="absolute left-0 top-2 bottom-2 w-1.5 bg-[#818CF8] rounded-r-full shadow-sm"></div>
                        @endif
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                            <ellipse cx="12" cy="5" rx="9" ry="3"/>
                            <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/>
                            <path d="M3 12c0 1.66 4 3 9 3s9-1.34 9-3"/>
                        </svg>
                    </a>

                    <!-- 4. Usage Summary -->
                    <a href="{{ route('user.reports.index') }}" class="relative w-12 h-12 rounded-xl flex items-center justify-center transition-all group {{ request()->routeIs('user.reports.*') ? 'bg-[#1E293B] text-[#818CF8] font-bold shadow-md' : 'text-slate-400 hover:bg-[#1E293B]/80 hover:text-white' }}" title="4. Usage Summary">
                        @if(request()->routeIs('user.reports.*'))
                            <div class="absolute left-0 top-2 bottom-2 w-1.5 bg-[#818CF8] rounded-r-full shadow-sm"></div>
                        @endif
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 3v18h18"/>
                            <path d="m19 9-5 5-4-4-3 3"/>
                        </svg>
                    </a>

                    <!-- 5. Missing Budget -->
                    <a href="{{ route('user.reconciliation.index') }}" class="relative w-12 h-12 rounded-xl flex items-center justify-center transition-all group {{ request()->routeIs('user.reconciliation.*') ? 'bg-[#1E293B] text-[#818CF8] font-bold shadow-md' : 'text-slate-400 hover:bg-[#1E293B]/80 hover:text-white' }}" title="5. Missing Budget">
                        @if(request()->routeIs('user.reconciliation.*'))
                            <div class="absolute left-0 top-2 bottom-2 w-1.5 bg-[#818CF8] rounded-r-full shadow-sm"></div>
                        @endif
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m16 16 3-8 3 8c-.87.65-1.92 1-3 1s-2.13-.35-3-1Z"/>
                            <path d="m2 16 3-8 3 8c-.87.65-1.92 1-3 1s-2.13-.35-3-1Z"/>
                            <path d="M7 21h10"/>
                            <path d="M12 3v18"/>
                            <path d="M3 7h18"/>
                        </svg>
                    </a>
                </nav>
            </div>

            <!-- Profile / Logout Actions -->
            <div class="p-3 flex flex-col items-center border-t border-[#1E293B] gap-3">
                <a href="{{ route('user.profile.index') }}" class="relative w-10 h-10 rounded-xl flex items-center justify-center {{ request()->routeIs('user.profile.*') ? 'bg-[#1E293B] text-[#818CF8] ring-1 ring-[#818CF8]/40' : 'text-slate-400 hover:bg-[#1E293B] hover:text-white' }} transition-colors" title="Profil Saya">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-10 h-10 rounded-xl flex items-center justify-center text-slate-400 hover:text-rose-400 hover:bg-rose-950/40 transition-colors" title="Keluar">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    </button>
                </form>
            </div>
        </aside>

        <!-- MAIN CONTAINER -->
        <div class="flex-1 md:ml-[76px] flex flex-col min-w-0 pb-24 md:pb-8">
            
            <!-- TOP HEADER WITH GLOBAL MONTH & YEAR SELECTOR (68px) -->
            <header class="h-[68px] bg-white border-b border-[#E2E8F0] px-4 md:px-8 flex items-center justify-between sticky top-0 z-20 shadow-xs">
                <!-- Global Month & Year Context Selector -->
                <form method="GET" action="{{ url()->current() }}" class="flex items-center gap-2">
                    <!-- Preserve existing tab / query params -->
                    @if(request('tab')) <input type="hidden" name="tab" value="{{ request('tab') }}"> @endif
                    @if(request('account_id')) <input type="hidden" name="account_id" value="{{ request('account_id') }}"> @endif

                    <div class="flex items-center gap-2 bg-[#F1F5F9] p-1.5 rounded-2xl border border-[#E2E8F0]">
                        <div class="flex items-center gap-1.5 pl-2 text-[#475467]">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                                <line x1="16" x2="16" y1="2" y2="6"/>
                                <line x1="8" x2="8" y1="2" y2="6"/>
                                <line x1="3" x2="21" y1="10" y2="10"/>
                            </svg>
                        </div>
                        
                        <select name="month" onchange="this.form.submit()" class="cm-select bg-white border border-[#CBD5E1] text-xs font-bold text-[#0F172A] rounded-xl pl-3 pr-8 py-2 cursor-pointer shadow-xs focus:ring-2 focus:ring-[#4F46E5]/20 min-w-[130px]">
                            @foreach(range(1, 12) as $m)
                                @php $date = \Carbon\Carbon::createFromDate(null, $m, 1); @endphp
                                <option value="{{ $m }}" {{ (request('month', $month ?? date('n')) == $m) ? 'selected' : '' }}>
                                    {{ $date->translatedFormat('F') }}
                                </option>
                            @endforeach
                        </select>

                        <select name="year" onchange="this.form.submit()" class="cm-select bg-white border border-[#CBD5E1] text-xs font-bold text-[#0F172A] rounded-xl pl-3 pr-8 py-2 cursor-pointer shadow-xs focus:ring-2 focus:ring-[#4F46E5]/20 min-w-[90px]">
                            @foreach(range(date('Y') - 3, date('Y') + 2) as $y)
                                <option value="{{ $y }}" {{ (request('year', $year ?? date('Y')) == $y) ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <span class="text-[11px] font-bold text-[#4F46E5] hidden lg:inline-flex items-center gap-1.5 bg-[#EEF2FF] px-3 py-1.5 rounded-full border border-[#C7D2FE]">
                        <span class="w-2 h-2 rounded-full bg-[#4F46E5] animate-pulse"></span>
                        <span>Periode Aktif</span>
                    </span>
                </form>

                <div class="flex items-center gap-3">
                    <!-- User Profile Quick Badge -->
                    <a href="{{ route('user.profile.index') }}" class="hidden sm:flex items-center gap-2.5 p-1.5 pr-3 rounded-2xl bg-[#F8FAFC] border border-[#E2E8F0] hover:bg-[#EEF2FF] hover:border-[#C7D2FE] transition group" title="Profil Saya">
                        <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-[#4F46E5] to-[#3730A3] text-white flex items-center justify-center text-xs font-extrabold shadow-sm">
                            {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                        </div>
                        <div class="text-left leading-tight">
                            <span class="text-xs font-bold text-[#0F172A] block truncate max-w-[120px] group-hover:text-[#4F46E5]">{{ Auth::user()->name }}</span>
                            <span class="text-[10px] text-[#64748B] font-semibold block">Personal OS</span>
                        </div>
                    </a>

                    <!-- Quick Add Transaction Button -->
                    <button @click="openSideSheet = true" class="btn-emerald">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="5" x2="12" y2="19"/>
                            <line x1="5" y1="12" x2="19" y2="12"/>
                        </svg>
                        <span class="hidden sm:inline">Catat Transaksi</span>
                        <span class="sm:hidden">Tambah</span>
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

            <!-- INLINE ERROR ALERT SUMMARY -->
            @if($errors->any())
                <div class="px-4 md:px-8 pt-6">
                    <div class="p-4 rounded-xl bg-[#FFF1F2] border border-[#FECDD3] text-[#E11D48] text-xs font-semibold space-y-1 shadow-sm">
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
        <div class="md:hidden fixed bottom-0 inset-x-0 bg-[#0F172A] text-slate-300 border-t border-[#1E293B] h-16 z-40 flex items-center justify-around px-2 pb-[env(safe-area-inset-bottom)] shadow-2xl">
            <a href="{{ route('user.dashboard') }}" class="flex flex-col items-center justify-center w-14 py-1 {{ request()->routeIs('user.dashboard') ? 'text-[#818CF8] font-bold' : 'text-slate-400' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                <span class="text-[10px] mt-1">Dashboard</span>
            </a>

            <a href="{{ route('user.transactions.index') }}" class="flex flex-col items-center justify-center w-14 py-1 {{ request()->routeIs('user.transactions.*') ? 'text-[#818CF8] font-bold' : 'text-slate-400' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><line x1="12" x2="12" y1="2" y2="22"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                <span class="text-[10px] mt-1">Income/Exp</span>
            </a>

            <!-- Mobile Center Floating Action Button -->
            <button @click="openSideSheet = true" class="w-13 h-13 rounded-full bg-gradient-to-br from-[#059669] to-[#047857] text-white flex items-center justify-center shadow-lg shadow-[#059669]/40 hover:scale-105 active:scale-95 -mt-5 border-4 border-[#0F172A]">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            </button>

            <a href="{{ route('user.master-data.index') }}" class="flex flex-col items-center justify-center w-14 py-1 {{ request()->routeIs('user.master-data.*') || request()->routeIs('user.categories.*') || request()->routeIs('user.accounts.*') ? 'text-[#818CF8] font-bold' : 'text-slate-400' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/><path d="M3 12c0 1.66 4 3 9 3s9-1.34 9-3"/></svg>
                <span class="text-[10px] mt-1">Master</span>
            </a>

            <button @click="openMobileMenu = true" class="flex flex-col items-center justify-center w-14 py-1 text-slate-400">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>
                <span class="text-[10px] mt-1">Lainnya</span>
            </button>
        </div>

        <!-- MOBILE MENU BOTTOM SHEET -->
        <div x-show="openMobileMenu" x-cloak class="fixed inset-0 z-50 flex items-end bg-[#0F172A]/60 backdrop-blur-xs md:hidden">
            <div @click.away="openMobileMenu = false" class="bg-white rounded-t-3xl w-full p-6 space-y-4">
                <div class="w-12 h-1.5 bg-[#E2E8F0] rounded-full mx-auto mb-2"></div>
                <h3 class="text-sm font-bold text-[#0F172A] font-display">Menu System CashMind</h3>

                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('user.reports.index') }}" class="p-4 rounded-2xl border border-[#E2E8F0] bg-[#F8FAFC] flex items-center gap-3">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#4F46E5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/></svg>
                        <span class="text-xs font-bold text-[#0F172A]">Usage Summary</span>
                    </a>
                    <a href="{{ route('user.reconciliation.index') }}" class="p-4 rounded-2xl border border-[#E2E8F0] bg-[#F8FAFC] flex items-center gap-3">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#4F46E5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m16 16 3-8 3 8c-.87.65-1.92 1-3 1s-2.13-.35-3-1Z"/><path d="m2 16 3-8 3 8c-.87.65-1.92 1-3 1s-2.13-.35-3-1Z"/><path d="M7 21h10"/><path d="M12 3v18"/><path d="M3 7h18"/></svg>
                        <span class="text-xs font-bold text-[#0F172A]">Missing Budget</span>
                    </a>
                    <a href="{{ route('user.profile.index') }}" class="p-4 rounded-2xl border border-[#C7D2FE] bg-[#EEF2FF] flex items-center gap-3">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#4F46E5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        <span class="text-xs font-bold text-[#0F172A]">Profil Saya</span>
                    </a>
                </div>

                <button @click="openMobileMenu = false" class="btn-secondary w-full justify-center">Tutup</button>
            </div>
        </div>

        <!-- FORM SIDE SHEET DESKTOP & FULL SCREEN SHEET MOBILE -->
        <div x-show="openSideSheet" x-cloak class="fixed inset-0 z-50 flex justify-end bg-[#0F172A]/60 backdrop-blur-xs">
            <div @click.away="openSideSheet = false" class="bg-white w-full md:w-[480px] h-full flex flex-col justify-between shadow-2xl overflow-y-auto">
                
                <!-- Side Sheet Header -->
                <div class="h-[72px] px-6 bg-[#0F172A] text-white flex items-center justify-between sticky top-0 z-10 shadow-md">
                    <div>
                        <h3 class="text-base font-bold font-display">Tambah Transaksi Baru</h3>
                        <p class="text-[11px] text-slate-300">Catat pemasukan, pengeluaran, atau transfer antar dana.</p>
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
                        <label class="block text-xs font-bold text-[#344054] mb-2 uppercase tracking-wider">Jenis Transaksi <span class="text-[#EF4444]">*</span></label>
                        <div class="grid grid-cols-3 gap-1 p-1 bg-[#F1F5F9] rounded-2xl border border-[#E2E8F0]">
                            <button type="button" @click="quickType = 'expense'" :class="quickType === 'expense' ? 'bg-[#EF4444] text-white font-bold shadow-md' : 'text-[#64748B] hover:text-[#0F172A]'" class="py-2.5 px-3 rounded-xl text-xs transition-all">
                                Pengeluaran
                            </button>
                            <button type="button" @click="quickType = 'income'" :class="quickType === 'income' ? 'bg-[#10B981] text-white font-bold shadow-md' : 'text-[#64748B] hover:text-[#0F172A]'" class="py-2.5 px-3 rounded-xl text-xs transition-all">
                                Pemasukan
                            </button>
                            <button type="button" @click="quickType = 'transfer'" :class="quickType === 'transfer' ? 'bg-[#4F46E5] text-white font-bold shadow-md' : 'text-[#64748B] hover:text-[#0F172A]'" class="py-2.5 px-3 rounded-xl text-xs transition-all">
                                Transfer Dana
                            </button>
                        </div>
                        <input type="hidden" name="type" :value="quickType">
                    </div>

                    <!-- Nominal Amount -->
                    <div>
                        <label class="block text-xs font-bold text-[#344054] mb-2 uppercase tracking-wider">Nominal <span class="text-[#EF4444]">*</span></label>
                        <div class="relative">
                            <input type="text" 
                                   x-model="quickFormattedAmount" 
                                   @input="formatRupiah($event.target.value, 'amount')" 
                                   inputmode="numeric"
                                   placeholder="Rp 0" 
                                   required 
                                   class="cm-input text-2xl font-bold text-[#0F172A] financial-number h-14 border-[#CBD5E1]">
                            <input type="hidden" name="amount" x-model="quickRawAmount">
                        </div>
                    </div>

                    <!-- Admin Fee (For Transfer Dana) -->
                    <div x-show="quickType === 'transfer'" transition:enter="transition ease-out duration-150" transition:enter-start="opacity-0 translate-y-[-5px]" transition:enter-end="opacity-100 translate-y-0">
                        <label class="block text-xs font-bold text-[#344054] mb-1.5 uppercase tracking-wider">Biaya Admin Bank/E-Wallet (Opsional)</label>
                        <div class="relative">
                            <input type="text" 
                                   x-model="quickFormattedAdminFee" 
                                   @input="formatRupiah($event.target.value, 'admin_fee')" 
                                   inputmode="numeric"
                                   placeholder="Rp 0 (misal: Rp 6.500 / Rp 2.500)" 
                                   class="cm-input financial-number border-[#CBD5E1]">
                            <input type="hidden" name="admin_fee" x-model="quickRawAdminFee">
                        </div>
                        <p class="text-[11px] text-[#64748B] mt-1">Biaya admin akan otomatis dicatat sebagai pengeluaran terpisah agar tidak memotong transfer pokok.</p>
                    </div>

                    <!-- Source Account -->
                    <div>
                        <label class="block text-xs font-bold text-[#344054] mb-1.5 uppercase tracking-wider" x-text="quickType === 'transfer' ? 'Rekening Sumber *' : 'Rekening *'"></label>
                        <select name="account_id" required class="cm-input">
                            <option value="">Pilih rekening</option>
                            @foreach(Auth::user()->accounts()->where('is_active', true)->get() as $acc)
                                <option value="{{ $acc->id }}">{{ $acc->name }} (Rp {{ number_format($acc->balance, 0, ',', '.') }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Destination Account (For Transfer) -->
                    <div x-show="quickType === 'transfer'">
                        <label class="block text-xs font-bold text-[#344054] mb-1.5 uppercase tracking-wider">Rekening / Dompet Tujuan <span class="text-[#EF4444]">*</span></label>
                        <select name="destination_account_id" class="cm-input">
                            <option value="">Pilih rekening/dompet tujuan (atau Tabungan)</option>
                            @foreach(Auth::user()->accounts()->where('is_active', true)->get() as $acc)
                                <option value="{{ $acc->id }}">{{ $acc->name }} ({{ $acc->account_category === 'savings' ? 'Tabungan' : strtoupper($acc->type) }})</option>
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
                                $activeCats = Auth::user()->categories()->where('is_active', true)->get()->concat(\App\Models\Category::where('is_system', true)->where('is_active', true)->whereNotIn('id', $disabledCatIds)->get());
                            @endphp
                            @foreach($activeCats as $cat)
                                <option value="{{ $cat->id }}" x-show="quickType === '{{ $cat->type }}'">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Date -->
                    <div>
                        <label class="block text-xs font-bold text-[#344054] mb-1.5 uppercase tracking-wider">Tanggal <span class="text-[#EF4444]">*</span></label>
                        <input type="date" name="transaction_date" value="{{ date('Y-m-d') }}" required class="cm-input">
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-xs font-bold text-[#344054] mb-1.5 uppercase tracking-wider">Uraian / Deskripsi <span class="text-[#EF4444]">*</span></label>
                        <input type="text" name="description" placeholder="Contoh: Belanja Bulanan / Transfer Tabungan Mandiri" required class="cm-input">
                    </div>

                    <!-- Detail Note -->
                    <div>
                        <label class="block text-xs font-bold text-[#344054] mb-1.5 uppercase tracking-wider">Catatan Opsional</label>
                        <input type="text" name="note" placeholder="Catatan opsional" class="cm-input">
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
