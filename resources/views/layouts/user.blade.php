<!DOCTYPE html>
<html lang="id" class="h-full bg-[#F4F6F8] text-[#101828] antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'CashMind — Personal Finance System' }}</title>

    <!-- Google Fonts: Manrope (Guideline v4 Section 3) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Tailwind CSS & Alpine.js -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Manrope', 'Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        cm: {
                            bg: '#F4F6F8',
                            bgSoft: '#F8FAFB',
                            surface: '#FFFFFF',
                            text: '#101828',
                            textSecondary: '#475467',
                            textMuted: '#667085',
                            border: '#E4E7EC',
                            borderSoft: '#EAECF0',
                            primary: '#0F172A',
                            primaryHover: '#1E293B',
                            accent: '#0F766E',
                            accentSoft: '#F0FDFA',
                            accentBorder: '#99F6E4',
                            income: '#15803D',
                            incomeSoft: '#F0FDF4',
                            expense: '#B42318',
                            expenseSoft: '#FEF3F2',
                            warning: '#B54708',
                            warningSoft: '#FFFAEB',
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
        ::-webkit-scrollbar-track { background: #F4F6F8; }
        ::-webkit-scrollbar-thumb { background: #D0D5DD; border-radius: 9999px; }
        ::-webkit-scrollbar-thumb:hover { background: #98A2B3; }
        
        .financial-number {
            font-variant-numeric: tabular-nums;
            letter-spacing: -0.01em;
        }

        .cm-panel {
            background-color: #FFFFFF;
            border: 1px solid #E4E7EC;
            border-radius: 16px;
        }
        
        .cm-input {
            background-color: #FFFFFF;
            border: 1px solid #D0D5DD;
            color: #101828;
            border-radius: 10px;
            padding: 0 14px;
            height: 44px;
            font-size: 0.875rem;
            width: 100%;
            transition: all 0.15s ease;
        }
        @media (max-width: 768px) {
            .cm-input {
                height: 48px;
            }
        }
        .cm-input:focus {
            outline: none;
            border-color: #0F766E;
            box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.10);
        }

        .btn-primary {
            background-color: #0F172A;
            color: #FFFFFF;
            font-weight: 600;
            border-radius: 10px;
            height: 42px;
            padding: 0 18px;
            font-size: 0.875rem;
            transition: all 0.15s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-primary:hover {
            background-color: #1E293B;
        }

        .btn-secondary {
            background-color: #FFFFFF;
            border: 1px solid #D0D5DD;
            color: #344054;
            font-weight: 600;
            border-radius: 10px;
            height: 42px;
            padding: 0 18px;
            font-size: 0.875rem;
            transition: all 0.15s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-secondary:hover {
            background-color: #F9FAFB;
            color: #101828;
        }
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
}" class="h-full bg-[#F4F6F8] text-[#101828] font-sans antialiased">
    <div class="min-h-screen flex flex-col md:flex-row">

        <!-- DESKTOP COMPACT NAVIGATION RAIL (72px - Guideline v4 Section 7 & 8) -->
        <aside class="w-[72px] bg-white border-r border-[#E4E7EC] flex-col justify-between hidden md:flex fixed inset-y-0 z-30">
            <div class="flex flex-col items-center">
                <!-- Brand Logo -->
                <div class="h-16 w-full flex items-center justify-center border-b border-[#EAECF0]">
                    <a href="{{ route('user.dashboard') }}" class="w-10 h-10 rounded-xl bg-[#0F172A] text-white flex items-center justify-center font-bold" title="CashMind Ledger">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 12V7H5a2 2 0 0 1 0-4h14v4"/>
                            <path d="M3 5v14a2 2 0 0 0 2 2h16v-5"/>
                            <path d="M18 12a2 2 0 0 0 0 4h4v-4Z"/>
                        </svg>
                    </a>
                </div>

                <!-- Rail Icons (Guideline v4 Section 8: SVG icons, compact tooltips, vertical teal active line) -->
                <nav class="py-6 space-y-4 w-full flex flex-col items-center">
                    <!-- Dashboard -->
                    <a href="{{ route('user.dashboard') }}" class="relative w-12 h-12 rounded-xl flex items-center justify-center transition-colors group {{ request()->routeIs('user.dashboard') ? 'bg-[#F1F5F9] text-[#0F172A]' : 'text-[#667085] hover:bg-[#F8FAFB] hover:text-[#101828]' }}" title="Dashboard">
                        @if(request()->routeIs('user.dashboard'))
                            <div class="absolute left-0 top-2 bottom-2 w-1 bg-[#0F766E] rounded-r-full"></div>
                        @endif
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="7" height="9" x="3" y="3" rx="1"/>
                            <rect width="7" height="5" x="14" y="3" rx="1"/>
                            <rect width="7" height="9" x="14" y="12" rx="1"/>
                            <rect width="7" height="5" x="3" y="16" rx="1"/>
                        </svg>
                    </a>

                    <!-- Transactions -->
                    <a href="{{ route('user.transactions.index') }}" class="relative w-12 h-12 rounded-xl flex items-center justify-center transition-colors group {{ request()->routeIs('user.transactions.*') ? 'bg-[#F1F5F9] text-[#0F172A]' : 'text-[#667085] hover:bg-[#F8FAFB] hover:text-[#101828]' }}" title="Transaksi">
                        @if(request()->routeIs('user.transactions.*'))
                            <div class="absolute left-0 top-2 bottom-2 w-1 bg-[#0F766E] rounded-r-full"></div>
                        @endif
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                            <line x1="16" y1="13" x2="8" y2="13"/>
                            <line x1="16" y1="17" x2="8" y2="17"/>
                        </svg>
                    </a>

                    <!-- Accounts -->
                    <a href="{{ route('user.accounts.index') }}" class="relative w-12 h-12 rounded-xl flex items-center justify-center transition-colors group {{ request()->routeIs('user.accounts.*') ? 'bg-[#F1F5F9] text-[#0F172A]' : 'text-[#667085] hover:bg-[#F8FAFB] hover:text-[#101828]' }}" title="Rekening">
                        @if(request()->routeIs('user.accounts.*'))
                            <div class="absolute left-0 top-2 bottom-2 w-1 bg-[#0F766E] rounded-r-full"></div>
                        @endif
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="20" height="12" x="2" y="6" rx="2"/>
                            <circle cx="12" cy="12" r="2"/>
                        </svg>
                    </a>

                    <!-- Budget -->
                    <a href="{{ route('user.budget.index') }}" class="relative w-12 h-12 rounded-xl flex items-center justify-center transition-colors group {{ request()->routeIs('user.budget.*') ? 'bg-[#F1F5F9] text-[#0F172A]' : 'text-[#667085] hover:bg-[#F8FAFB] hover:text-[#101828]' }}" title="Anggaran">
                        @if(request()->routeIs('user.budget.*'))
                            <div class="absolute left-0 top-2 bottom-2 w-1 bg-[#0F766E] rounded-r-full"></div>
                        @endif
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="4" x2="20" y1="12" y2="12"/>
                            <line x1="4" x2="20" y1="6" y2="6"/>
                            <line x1="4" x2="20" y1="18" y2="18"/>
                            <circle cx="8" cy="12" r="2"/>
                            <circle cx="16" cy="6" r="2"/>
                            <circle cx="12" cy="18" r="2"/>
                        </svg>
                    </a>

                    <!-- Goals -->
                    <a href="{{ route('user.goals.index') }}" class="relative w-12 h-12 rounded-xl flex items-center justify-center transition-colors group {{ request()->routeIs('user.goals.*') ? 'bg-[#F1F5F9] text-[#0F172A]' : 'text-[#667085] hover:bg-[#F8FAFB] hover:text-[#101828]' }}" title="Target Keuangan">
                        @if(request()->routeIs('user.goals.*'))
                            <div class="absolute left-0 top-2 bottom-2 w-1 bg-[#0F766E] rounded-r-full"></div>
                        @endif
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <circle cx="12" cy="12" r="6"/>
                            <circle cx="12" cy="12" r="2"/>
                        </svg>
                    </a>

                    <!-- Reports -->
                    <a href="{{ route('user.reports.index') }}" class="relative w-12 h-12 rounded-xl flex items-center justify-center transition-colors group {{ request()->routeIs('user.reports.*') ? 'bg-[#F1F5F9] text-[#0F172A]' : 'text-[#667085] hover:bg-[#F8FAFB] hover:text-[#101828]' }}" title="Laporan">
                        @if(request()->routeIs('user.reports.*'))
                            <div class="absolute left-0 top-2 bottom-2 w-1 bg-[#0F766E] rounded-r-full"></div>
                        @endif
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 3v18h18"/>
                            <path d="m19 9-5 5-4-4-3 3"/>
                        </svg>
                    </a>
                </nav>
            </div>

            <!-- Profile / Logout Action -->
            <div class="p-3 flex flex-col items-center border-t border-[#EAECF0] gap-3">
                <a href="{{ route('user.categories.index') }}" class="w-10 h-10 rounded-xl flex items-center justify-center text-[#667085] hover:bg-[#F8FAFB] hover:text-[#101828] transition-colors" title="Kategori">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="m15 5 4 4"/><path d="M13 2 3 12v7a2 2 0 0 0 2 2h7l10-10V4a2 2 0 0 0-2-2z"/><circle cx="7.5" cy="7.5" r=".5" fill="currentColor"/></svg>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-10 h-10 rounded-xl flex items-center justify-center text-[#667085] hover:text-[#B42318] hover:bg-[#FEF3F2] transition-colors" title="Keluar">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    </button>
                </form>
            </div>
        </aside>

        <!-- MAIN CONTAINER -->
        <div class="flex-1 md:ml-[72px] flex flex-col min-w-0 pb-24 md:pb-8">
            
            <!-- TOP HEADER (68px - Guideline v4 Section 11) -->
            <header class="h-[68px] bg-white border-b border-[#EAECF0] px-4 md:px-8 flex items-center justify-between sticky top-0 z-20">
                <div class="flex items-center gap-3">
                    <span class="text-xs font-semibold text-[#667085]">
                        {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                    </span>
                    <span class="hidden sm:inline-block w-1 h-1 rounded-full bg-[#D0D5DD]"></span>
                    <span class="text-xs font-semibold text-[#0F766E] hidden sm:inline-block bg-[#F0FDFA] px-2.5 py-1 rounded-md border border-[#99F6E4]">
                        Private Finance
                    </span>
                </div>

                <div class="flex items-center gap-3">
                    <button @click="openSideSheet = true" class="btn-primary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="5" x2="12" y2="19"/>
                            <line x1="5" y1="12" x2="19" y2="12"/>
                        </svg>
                        <span>Tambah Transaksi</span>
                    </button>
                </div>
            </header>

            <!-- TOAST NOTIFICATION CONTAINER (Guideline v4 Section 49 & 50) -->
            <div x-show="showToast" x-cloak transition:enter="transition ease-out duration-200" transition:enter-start="opacity-0 translate-y-[-10px]" transition:enter-end="opacity-100 translate-y-0" transition:leave="transition ease-in duration-150" transition:leave-start="opacity-100 translate-y-0" transition:leave-end="opacity-0 translate-y-[-10px]" class="fixed bottom-5 right-5 md:top-auto z-50 w-full max-w-[360px] bg-white border border-[#EAECF0] rounded-xl p-4 shadow-xl flex items-center gap-3">
                <div class="w-7 h-7 rounded-lg bg-[#ECFDF3] text-[#15803D] flex items-center justify-center flex-shrink-0">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <span class="text-xs font-semibold text-[#101828] block" x-text="toastMessage"></span>
                </div>
                <button @click="showToast = false" class="text-[#98A2B3] hover:text-[#475467]">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>

            <!-- INLINE ERROR ALERT -->
            @if($errors->any())
                <div class="px-4 md:px-8 pt-6">
                    <div class="p-4 rounded-xl bg-[#FEF3F2] border border-[#FECDCA] text-[#B42318] text-xs font-semibold space-y-1">
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

            <!-- MAIN CONTENT AREA (Guideline v4 Section 12: max-width 1360px desktop, padding 32px) -->
            <main class="w-full max-w-[1360px] mx-auto p-4 md:p-8 flex-1">
                @yield('content')
            </main>
        </div>

        <!-- MOBILE FIXED BOTTOM NAVIGATION BAR (Height 64-72px - Guideline v4 Section 9 & 10) -->
        <div class="md:hidden fixed bottom-0 inset-x-0 bg-white border-t border-[#EAECF0] h-16 z-40 flex items-center justify-around px-2 pb-[env(safe-area-inset-bottom)]">
            <a href="{{ route('user.dashboard') }}" class="flex flex-col items-center justify-center w-14 py-1 {{ request()->routeIs('user.dashboard') ? 'text-[#0F766E] font-bold' : 'text-[#667085]' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                <span class="text-[10px] mt-1">Dashboard</span>
            </a>

            <a href="{{ route('user.transactions.index') }}" class="flex flex-col items-center justify-center w-14 py-1 {{ request()->routeIs('user.transactions.*') ? 'text-[#0F766E] font-bold' : 'text-[#667085]' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                <span class="text-[10px] mt-1">Transaksi</span>
            </a>

            <!-- Mobile Primary Action Center Button (Guideline v4 Section 10) -->
            <button @click="openSideSheet = true" class="w-12 h-12 rounded-full bg-[#0F172A] text-white flex items-center justify-center shadow-lg hover:bg-[#1E293B] transition-transform active:scale-95 -mt-4 border-2 border-white">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            </button>

            <a href="{{ route('user.budget.index') }}" class="flex flex-col items-center justify-center w-14 py-1 {{ request()->routeIs('user.budget.*') ? 'text-[#0F766E] font-bold' : 'text-[#667085]' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/><circle cx="8" cy="12" r="2"/><circle cx="16" cy="6" r="2"/><circle cx="12" cy="18" r="2"/></svg>
                <span class="text-[10px] mt-1">Anggaran</span>
            </a>

            <button @click="openMobileMenu = true" class="flex flex-col items-center justify-center w-14 py-1 text-[#667085]">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>
                <span class="text-[10px] mt-1">Lainnya</span>
            </button>
        </div>

        <!-- MOBILE LAINNYA BOTTOM SHEET -->
        <div x-show="openMobileMenu" x-cloak class="fixed inset-0 z-50 flex items-end bg-[#0F172A]/40 backdrop-blur-xs md:hidden">
            <div @click.away="openMobileMenu = false" class="bg-white rounded-t-2xl w-full p-6 space-y-4">
                <div class="w-12 h-1.5 bg-[#EAECF0] rounded-full mx-auto mb-2"></div>
                <h3 class="text-sm font-bold text-[#101828]">Menu Keuangan Lainnya</h3>

                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('user.accounts.index') }}" class="p-3.5 rounded-xl border border-[#EAECF0] bg-[#F8FAFB] flex items-center gap-3">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#0F766E" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="12" x="2" y="6" rx="2"/><circle cx="12" cy="12" r="2"/></svg>
                        <span class="text-xs font-semibold text-[#101828]">Rekening</span>
                    </a>
                    <a href="{{ route('user.goals.index') }}" class="p-3.5 rounded-xl border border-[#EAECF0] bg-[#F8FAFB] flex items-center gap-3">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#0F766E" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
                        <span class="text-xs font-semibold text-[#101828]">Target</span>
                    </a>
                    <a href="{{ route('user.reconciliation.index') }}" class="p-3.5 rounded-xl border border-[#EAECF0] bg-[#F8FAFB] flex items-center gap-3">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#0F766E" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="m16 16 3-8 3 8c-.87.65-1.92 1-3 1s-2.13-.35-3-1Z"/><path d="m2 16 3-8 3 8c-.87.65-1.92 1-3 1s-2.13-.35-3-1Z"/><path d="M7 21h10"/><path d="M12 3v18"/><path d="M3 7h18"/></svg>
                        <span class="text-xs font-semibold text-[#101828]">Rekonsiliasi</span>
                    </a>
                    <a href="{{ route('user.reports.index') }}" class="p-3.5 rounded-xl border border-[#EAECF0] bg-[#F8FAFB] flex items-center gap-3">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#0F766E" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/></svg>
                        <span class="text-xs font-semibold text-[#101828]">Laporan</span>
                    </a>
                    <a href="{{ route('user.categories.index') }}" class="p-3.5 rounded-xl border border-[#EAECF0] bg-[#F8FAFB] flex items-center gap-3 col-span-2">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#0F766E" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="m15 5 4 4"/><path d="M13 2 3 12v7a2 2 0 0 0 2 2h7l10-10V4a2 2 0 0 0-2-2z"/><circle cx="7.5" cy="7.5" r=".5" fill="currentColor"/></svg>
                        <span class="text-xs font-semibold text-[#101828]">Kategori Keuangan</span>
                    </a>
                </div>

                <button @click="openMobileMenu = false" class="btn-secondary w-full justify-center">Tutup</button>
            </div>
        </div>

        <!-- FORM SIDE SHEET DESKTOP (440-480px) & FULL SCREEN SHEET MOBILE (Guideline v4 Section 29, 30, 31) -->
        <div x-show="openSideSheet" x-cloak class="fixed inset-0 z-50 flex justify-end bg-[#0F172A]/40 backdrop-blur-xs">
            <div @click.away="openSideSheet = false" class="bg-white w-full md:w-[460px] h-full flex flex-col justify-between shadow-2xl overflow-y-auto">
                
                <!-- Side Sheet Header -->
                <div class="h-[68px] px-6 border-b border-[#EAECF0] flex items-center justify-between sticky top-0 bg-white z-10">
                    <h3 class="text-base font-bold text-[#101828]">Tambah Transaksi</h3>
                    <button @click="openSideSheet = false" class="text-[#98A2B3] hover:text-[#101828]">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </button>
                </div>

                <!-- Form Content -->
                <form method="POST" action="{{ route('user.transactions.store') }}" class="p-6 space-y-5 flex-1">
                    @csrf
                    
                    <!-- 1. Segmented Transaction Type (Guideline v4 Section 37) -->
                    <div>
                        <label class="block text-sm font-semibold text-[#344054] mb-2">Jenis Transaksi <span class="text-[#B42318]">*</span></label>
                        <div class="grid grid-cols-3 gap-1 p-1 bg-[#F2F4F7] rounded-xl">
                            <button type="button" @click="quickType = 'expense'" :class="quickType === 'expense' ? 'bg-white text-[#101828] font-bold shadow-xs' : 'text-[#667085] hover:text-[#101828]'" class="py-2 px-3 rounded-lg text-xs transition-all">
                                Pengeluaran
                            </button>
                            <button type="button" @click="quickType = 'income'" :class="quickType === 'income' ? 'bg-white text-[#101828] font-bold shadow-xs' : 'text-[#667085] hover:text-[#101828]'" class="py-2 px-3 rounded-lg text-xs transition-all">
                                Pemasukan
                            </button>
                            <button type="button" @click="quickType = 'transfer'" :class="quickType === 'transfer' ? 'bg-white text-[#101828] font-bold shadow-xs' : 'text-[#667085] hover:text-[#101828]'" class="py-2 px-3 rounded-lg text-xs transition-all">
                                Transfer
                            </button>
                        </div>
                        <input type="hidden" name="type" :value="quickType">
                    </div>

                    <!-- 2. Nominal Amount (Guideline v4 Section 36: Large 26px font desktop / 30px mobile) -->
                    <div>
                        <label class="block text-sm font-semibold text-[#344054] mb-2">Nominal <span class="text-[#B42318]">*</span></label>
                        <div class="relative">
                            <input type="text" 
                                   x-model="quickFormattedAmount" 
                                   @input="formatRupiah($event.target.value)" 
                                   inputmode="numeric"
                                   placeholder="Rp 0" 
                                   required 
                                   class="cm-input text-2xl font-bold text-[#101828] financial-number h-14">
                            <input type="hidden" name="amount" x-model="quickRawAmount">
                        </div>
                    </div>

                    <!-- 3. Source Account -->
                    <div>
                        <label class="block text-sm font-semibold text-[#344054] mb-1.5" x-text="quickType === 'transfer' ? 'Rekening Asal *' : 'Rekening *'"></label>
                        <select name="account_id" required class="cm-input">
                            <option value="">Pilih rekening</option>
                            @foreach(Auth::user()->accounts()->where('is_active', true)->get() as $acc)
                                <option value="{{ $acc->id }}">{{ $acc->name }} (Rp {{ number_format($acc->balance, 0, ',', '.') }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Destination Account (For Transfer) -->
                    <div x-show="quickType === 'transfer'">
                        <label class="block text-sm font-semibold text-[#344054] mb-1.5">Rekening Tujuan <span class="text-[#B42318]">*</span></label>
                        <select name="destination_account_id" class="cm-input">
                            <option value="">Pilih rekening tujuan</option>
                            @foreach(Auth::user()->accounts()->where('is_active', true)->get() as $acc)
                                <option value="{{ $acc->id }}">{{ $acc->name }} (Rp {{ number_format($acc->balance, 0, ',', '.') }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- 4. Category -->
                    <div x-show="quickType !== 'transfer'">
                        <label class="block text-sm font-semibold text-[#344054] mb-1.5">Kategori</label>
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

                    <!-- 5. Date -->
                    <div>
                        <label class="block text-sm font-semibold text-[#344054] mb-1.5">Tanggal <span class="text-[#B42318]">*</span></label>
                        <input type="date" name="transaction_date" value="{{ date('Y-m-d') }}" required class="cm-input">
                    </div>

                    <!-- 6. Uraian -->
                    <div>
                        <label class="block text-sm font-semibold text-[#344054] mb-1.5">Uraian Transaksi <span class="text-[#B42318]">*</span></label>
                        <input type="text" name="description" placeholder="Contoh: Makan siang meeting" required class="cm-input">
                    </div>

                    <!-- 7. Catatan Detail -->
                    <div>
                        <label class="block text-sm font-semibold text-[#344054] mb-1.5">Catatan Detail (Opsional)</label>
                        <input type="text" name="note" placeholder="Contoh: Pembayaran via QRIS BCA" class="cm-input">
                    </div>

                    <!-- Sticky Bottom Action Footer (Guideline v4 Section 31) -->
                    <div class="pt-4 border-t border-[#EAECF0] flex justify-end gap-3 sticky bottom-0 bg-white pb-2">
                        <button type="button" @click="openSideSheet = false" class="btn-secondary">Batal</button>
                        <button type="submit" class="btn-primary">Simpan Transaksi</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</body>
</html>
