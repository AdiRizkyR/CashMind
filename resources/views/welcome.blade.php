@extends('layouts.app')

@section('content')
<!-- Komentar Bahasa Indonesia: Halaman Landing Utama CashMind Enterprise SaaS (Horizon 10/10 Edition) -->
<div x-data="{
    // Interactive ROI & Budget Calculator State
    monthlyIncome: 10000000,
    
    // Tab Preview Mockup State
    previewTab: 'dashboard',

    // FAQ Accordion State
    openFaq: null,

    // Helper Format Angka Rupiah
    formatRp(val) {
        return 'Rp ' + Number(val).toLocaleString('id-ID');
    }
}" class="min-h-screen flex flex-col justify-between relative overflow-hidden bg-slate-50 selection:bg-emerald-500 selection:text-white">
    
    <!-- Ambient Gradient Backdrops -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[1000px] h-[500px] bg-gradient-to-tr from-emerald-500/10 via-teal-500/10 to-indigo-500/10 blur-3xl pointer-events-none -z-0"></div>

    <!-- 1. STICKY NAVIGATION HEADER -->
    <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200/80 px-6 lg:px-12 flex items-center justify-between sticky top-0 z-50 shadow-xs">
        <a href="{{ url('/') }}" class="flex items-center gap-3 group">
            <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center font-bold text-lg shadow-md group-hover:scale-105 transition-transform">
                <i class="fa-solid fa-wallet"></i>
            </div>
            <div>
                <span class="text-xl font-extrabold tracking-tight text-slate-900 block leading-none">CashMind</span>
                <span class="text-[10px] text-emerald-600 font-bold uppercase tracking-wider mt-0.5 block">Enterprise OS</span>
            </div>
        </a>

        <!-- Desktop Navigation Links -->
        <nav class="hidden md:flex items-center gap-8 text-xs font-bold text-slate-600">
            <a href="#fitur" class="hover:text-emerald-600 transition">Fitur Utama</a>
            <a href="#kalkulator" class="hover:text-emerald-600 transition">Kalkulator Budget</a>
            <a href="#preview" class="hover:text-emerald-600 transition">Demo App</a>
            <a href="#faq" class="hover:text-emerald-600 transition">FAQ</a>
        </nav>

        <!-- Action Buttons -->
        <div class="flex items-center gap-3">
            @guest
                <a href="{{ route('login') }}" class="horizon-btn-secondary py-2.5 px-4 text-xs">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="horizon-btn-primary py-2.5 px-5 text-xs">
                    Daftar Akun
                </a>
            @else
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="horizon-btn-primary bg-amber-600 hover:bg-amber-700 py-2.5 px-5 text-xs">
                        Dashboard Admin
                    </a>
                @else
                    <a href="{{ route('user.dashboard') }}" class="horizon-btn-primary py-2.5 px-5 text-xs">
                        Buka Workspace Saya
                    </a>
                @endif
            @endguest
        </div>
    </header>

    <!-- 2. HERO BANNER SECTION -->
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 sm:pt-24 pb-12 text-center relative z-10 space-y-8">
        
        <!-- Live Status Pill -->
        <div class="flex justify-center">
            <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-white border border-slate-200/90 text-xs font-bold text-slate-800 shadow-xs">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>Financial Operating System #1 Indonesia</span>
                <span class="text-slate-300">|</span>
                <span class="text-emerald-700 font-mono">Horizon 2026 Edition</span>
            </div>
        </div>

        <!-- Headline & Subtitle -->
        <div class="max-w-4xl mx-auto space-y-6">
            <h1 class="text-4xl sm:text-6xl font-extrabold text-slate-900 tracking-tight leading-tight">
                Pencatatan Keuangan Presisi. <br class="hidden sm:inline">
                <span class="bg-gradient-to-r from-emerald-600 via-teal-600 to-indigo-600 bg-clip-text text-transparent">Alokasi Budget Auto & Rekonsiliasi Kas.</span>
            </h1>
            <p class="text-slate-600 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed font-medium">
                Sistem pengelolaan kas perorangan & enterprise. Atur persentase target pengeluaran, lacak selisih missing cash, dan cetak laporan resmi dalam hitungan detik.
            </p>

            <!-- Call To Action Buttons -->
            <div class="flex flex-wrap items-center justify-center gap-4 pt-2">
                @guest
                    <a href="{{ route('login') }}" class="horizon-btn-primary py-3.5 px-7 text-xs shadow-lg">
                        <i class="fa-solid fa-right-to-bracket text-xs"></i>
                        <span>Coba Demo Workspace Now</span>
                    </a>
                    <a href="{{ route('register') }}" class="horizon-btn-secondary py-3.5 px-7 text-xs">
                        Daftar Akun Baru
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="horizon-btn-primary py-3.5 px-7 text-xs shadow-lg">
                        <span>Buka Workspace Saya</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                @endguest
            </div>
        </div>

        <!-- Security Trust Ribbon -->
        <div class="pt-4 flex flex-wrap items-center justify-center gap-6 text-xs text-slate-500 font-semibold">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-shield-halved text-emerald-600"></i>
                <span>Enkripsi Ujung-ke-Ujung</span>
            </div>
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-lock text-emerald-600"></i>
                <span>100% Privacy Data Terjaga</span>
            </div>
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-print text-emerald-600"></i>
                <span>Cetak PDF Laporan Resmi</span>
            </div>
        </div>
    </section>

    <!-- 3. INTERACTIVE BUDGET ALLOCATOR ROI CALCULATOR WIDGET -->
    <section id="kalkulator" class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12 relative z-10 w-full">
        <div class="horizon-card p-6 sm:p-10 space-y-6 border-l-4 border-l-emerald-600 shadow-xl">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-4 border-b border-slate-200">
                <div>
                    <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-extrabold uppercase tracking-wider font-mono">Simulasi Interaktif</span>
                    <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight mt-1">Kalkulator Alokasi Otomatis CashMind</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Geser nominal pendapatan Anda untuk melihat simulasi alokasi anggaran ideal.</p>
                </div>

                <div class="text-left md:text-right">
                    <span class="text-xs text-slate-500 font-bold block">Pendapatan Bulanan:</span>
                    <span class="text-2xl font-extrabold text-emerald-600 font-mono" x-text="formatRp(monthlyIncome)"></span>
                </div>
            </div>

            <!-- Income Slider Input -->
            <div class="space-y-2">
                <div class="flex justify-between text-xs text-slate-500 font-semibold">
                    <span>Rp 2.000.000</span>
                    <span>Rp 50.000.000</span>
                </div>
                <input type="range" min="2000000" max="50000000" step="500000" x-model="monthlyIncome" class="w-full h-3 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-emerald-600">
            </div>

            <!-- Dynamic Allocation Cards Breakdown Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 pt-2">
                <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 space-y-1">
                    <span class="text-[11px] text-emerald-800 font-bold block">Kebutuhan & Makanan (40%)</span>
                    <strong class="text-lg font-extrabold text-emerald-950 font-mono block" x-text="formatRp(monthlyIncome * 0.40)"></strong>
                    <span class="text-[10px] text-emerald-700 block">Bahan Pokok & Makan</span>
                </div>

                <div class="p-4 rounded-2xl bg-purple-50 border border-purple-200 space-y-1">
                    <span class="text-[11px] text-purple-800 font-bold block">Tabungan & Goals (20%)</span>
                    <strong class="text-lg font-extrabold text-purple-950 font-mono block" x-text="formatRp(monthlyIncome * 0.20)"></strong>
                    <span class="text-[10px] text-purple-700 block">Investasi & Emergency</span>
                </div>

                <div class="p-4 rounded-2xl bg-sky-50 border border-sky-200 space-y-1">
                    <span class="text-[11px] text-sky-800 font-bold block">Dana HP & Tagihan (15%)</span>
                    <strong class="text-lg font-extrabold text-sky-950 font-mono block" x-text="formatRp(monthlyIncome * 0.15)"></strong>
                    <span class="text-[10px] text-sky-700 block">Internet, Listrik, HP</span>
                </div>

                <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 space-y-1">
                    <span class="text-[11px] text-amber-800 font-bold block">Kendaraan & Hiburan (15%)</span>
                    <strong class="text-lg font-extrabold text-amber-950 font-mono block" x-text="formatRp(monthlyIncome * 0.15)"></strong>
                    <span class="text-[10px] text-amber-700 block">Bensin, Service, Game</span>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. TABBED PRODUCT SHOWCASE MOCKUP -->
    <section id="preview" class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12 relative z-10 w-full space-y-6">
        <div class="text-center space-y-2">
            <span class="px-3 py-1 rounded-full bg-slate-200 text-slate-700 text-xs font-mono font-bold">Interactive Product Demo</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Antarmuka Modern yang Berfokus pada Data</h2>
            <p class="text-xs text-slate-500 font-medium max-w-xl mx-auto">Pilih tab di bawah untuk menginspeksi tampilan langsung modul CashMind.</p>
        </div>

        <div class="horizon-card p-6 sm:p-8 space-y-6 shadow-2xl">
            <!-- Tab Controls Header -->
            <div class="flex items-center gap-2 overflow-x-auto pb-2 border-b border-slate-200 text-xs font-bold">
                <button @click="previewTab = 'dashboard'" :class="previewTab === 'dashboard' ? 'bg-emerald-600 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100'" class="px-4 py-2 rounded-xl transition shrink-0 flex items-center gap-2">
                    <i class="fa-solid fa-chart-pie"></i>
                    <span>Dashboard Rekap</span>
                </button>
                <button @click="previewTab = 'income'" :class="previewTab === 'income' ? 'bg-emerald-600 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100'" class="px-4 py-2 rounded-xl transition shrink-0 flex items-center gap-2">
                    <i class="fa-solid fa-hand-holding-dollar"></i>
                    <span>Catat Income</span>
                </button>
                <button @click="previewTab = 'goals'" :class="previewTab === 'goals' ? 'bg-emerald-600 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100'" class="px-4 py-2 rounded-xl transition shrink-0 flex items-center gap-2">
                    <i class="fa-solid fa-bullseye"></i>
                    <span>Target Goals</span>
                </button>
                <button @click="previewTab = 'reconciliation'" :class="previewTab === 'reconciliation' ? 'bg-emerald-600 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100'" class="px-4 py-2 rounded-xl transition shrink-0 flex items-center gap-2">
                    <i class="fa-solid fa-scale-balanced"></i>
                    <span>Rekonsiliasi Kas</span>
                </button>
            </div>

            <!-- Tab Content View Container -->
            <div class="space-y-4">
                <!-- TAB 1: DASHBOARD PREVIEW -->
                <div x-show="previewTab === 'dashboard'" class="space-y-4" x-transition>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-xs">
                        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200">
                            <span class="text-slate-500 font-bold text-[10px]">Total Income</span>
                            <div class="text-base font-extrabold text-slate-900 font-mono mt-0.5">Rp 10.959.540</div>
                        </div>
                        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200">
                            <span class="text-slate-500 font-bold text-[10px]">Total Expense</span>
                            <div class="text-base font-extrabold text-slate-900 font-mono mt-0.5">Rp 10.722.830</div>
                        </div>
                        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200">
                            <span class="text-slate-500 font-bold text-[10px]">Saldo Seharusnya</span>
                            <div class="text-base font-extrabold text-slate-900 font-mono mt-0.5">Rp 236.710</div>
                        </div>
                        <div class="p-3.5 rounded-xl bg-amber-50 border border-amber-200">
                            <span class="text-amber-800 font-bold text-[10px]">Missing Cash</span>
                            <div class="text-base font-extrabold text-amber-900 font-mono mt-0.5">Rp 236.710</div>
                        </div>
                    </div>
                </div>

                <!-- TAB 2: INCOME PREVIEW -->
                <div x-show="previewTab === 'income'" class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-xs space-y-2" x-transition>
                    <div class="flex justify-between font-bold text-slate-800 border-b border-slate-200 pb-2">
                        <span>Sumber Pemasukan</span>
                        <span>Nominal Rp</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Gaji Bulanan Utama</span>
                        <span class="font-mono text-emerald-700 font-bold">Rp 2.300.000</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Ambil Tabungan Emas</span>
                        <span class="font-mono text-emerald-700 font-bold">Rp 5.069.765</span>
                    </div>
                </div>

                <!-- TAB 3: GOALS PREVIEW -->
                <div x-show="previewTab === 'goals'" class="p-4 rounded-2xl bg-purple-50 border border-purple-200 text-xs space-y-2" x-transition>
                    <div class="flex justify-between font-bold text-purple-950">
                        <span>Dana Darurat (6 Bulan)</span>
                        <span class="font-mono">72.5% Terkumpul</span>
                    </div>
                    <div class="w-full h-2 rounded-full bg-purple-200 overflow-hidden">
                        <div class="h-full bg-purple-600 w-3/4 rounded-full"></div>
                    </div>
                </div>

                <!-- TAB 4: RECONCILIATION PREVIEW -->
                <div x-show="previewTab === 'reconciliation'" class="p-4 rounded-2xl bg-indigo-50 border border-indigo-200 text-xs space-y-2" x-transition>
                    <div class="flex justify-between font-bold text-indigo-950">
                        <span>Audit Uang Tunai + Wallet vs System</span>
                        <span class="font-mono text-emerald-700">Balanced (Rp 0)</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. 6 KEY VALUE PROPOSITION CARDS GRID -->
    <section id="fitur" class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 relative z-10 w-full space-y-8">
        <div class="text-center space-y-2">
            <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-mono font-bold">Comprehensive Capabilities</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">6 Fitur Unggulan Sistem CashMind</h2>
            <p class="text-xs text-slate-500 font-medium max-w-lg mx-auto">Semua yang Anda butuhkan untuk mengelola keuangan pribadi maupun bisnis.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="horizon-card p-6 space-y-3">
                <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-base shadow-xs">
                    <i class="fa-solid fa-sliders"></i>
                </div>
                <h3 class="font-extrabold text-slate-900 text-base">Alokasi Budget Mandiri</h3>
                <p class="text-xs text-slate-600 leading-relaxed font-medium">Tentukan kategori pemasukan & pengeluaran kustom serta persentase target spending Anda secara mandiri.</p>
            </div>

            <div class="horizon-card p-6 space-y-3">
                <div class="w-10 h-10 rounded-2xl bg-purple-100 text-purple-700 flex items-center justify-center font-bold text-base shadow-xs">
                    <i class="fa-solid fa-bullseye"></i>
                </div>
                <h3 class="font-extrabold text-slate-900 text-base">Target Tabungan & Goals</h3>
                <p class="text-xs text-slate-600 leading-relaxed font-medium">Lacak progres pencapaian target tabungan impian seperti DP rumah, dana darurat, dan investasi.</p>
            </div>

            <div class="horizon-card p-6 space-y-3">
                <div class="w-10 h-10 rounded-2xl bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-base shadow-xs">
                    <i class="fa-solid fa-scale-balanced"></i>
                </div>
                <h3 class="font-extrabold text-slate-900 text-base">Audit Rekonsiliasi Selisih</h3>
                <p class="text-xs text-slate-600 leading-relaxed font-medium">Audit selisih uang tunai fisik dengan saldo aplikasi untuk menemukan missing cash secara presisi.</p>
            </div>

            <div class="horizon-card p-6 space-y-3">
                <div class="w-10 h-10 rounded-2xl bg-sky-100 text-sky-700 flex items-center justify-center font-bold text-base shadow-xs">
                    <i class="fa-solid fa-chart-column"></i>
                </div>
                <h3 class="font-extrabold text-slate-900 text-base">Diagram & Visual Analytics</h3>
                <p class="text-xs text-slate-600 leading-relaxed font-medium">Grafik perbandingan arus kas bulanan dan distribusi pengeluaran berbasis Chart.js visual.</p>
            </div>

            <div class="horizon-card p-6 space-y-3">
                <div class="w-10 h-10 rounded-2xl bg-amber-100 text-amber-800 flex items-center justify-center font-bold text-base shadow-xs">
                    <i class="fa-solid fa-file-invoice-dollar"></i>
                </div>
                <h3 class="font-extrabold text-slate-900 text-base">Cetak Laporan PDF Siap</h3>
                <p class="text-xs text-slate-600 leading-relaxed font-medium">Ekspor laporan pendapatan & pengeluaran bulanan/tahunan dengan tata letak bersih siap cetak resmi.</p>
            </div>

            <div class="horizon-card p-6 space-y-3">
                <div class="w-10 h-10 rounded-2xl bg-teal-100 text-teal-700 flex items-center justify-center font-bold text-base shadow-xs">
                    <i class="fa-solid fa-building"></i>
                </div>
                <h3 class="font-extrabold text-slate-900 text-base">Personal & Enterprise OS</h3>
                <p class="text-xs text-slate-600 leading-relaxed font-medium">Sistem siap digunakan untuk skala perorangan maupun enterprise dengan kontrol hak akses role.</p>
            </div>
        </div>
    </section>

    <!-- 6. INTERACTIVE FAQ ACCORDION SECTION -->
    <section id="faq" class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 relative z-10 w-full space-y-6">
        <div class="text-center space-y-2">
            <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Pertanyaan Sering Diajukan (FAQ)</h2>
            <p class="text-xs text-slate-500 font-medium">Jawaban atas pertanyaan umum seputar penggunaan platform CashMind.</p>
        </div>

        <div class="space-y-3 text-xs">
            <div class="horizon-card p-4 space-y-2 cursor-pointer" @click="openFaq = openFaq === 1 ? null : 1">
                <div class="flex items-center justify-between font-extrabold text-slate-900">
                    <span>Bagaimana cara kerja penentuan persentase budget?</span>
                    <i class="fa-solid" :class="openFaq === 1 ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                </div>
                <p x-show="openFaq === 1" class="text-slate-600 pt-2 border-t border-slate-200 font-medium leading-relaxed" x-transition>
                    Pengguna dapat menentukan target persentase (misal Makanan 40%, Belanja 10%) di menu Kategori & Budget. Sistem akan secara otomatis mengalikan persentase ini dengan total pemasukan bulan berjalan.
                </p>
            </div>

            <div class="horizon-card p-4 space-y-2 cursor-pointer" @click="openFaq = openFaq === 2 ? null : 2">
                <div class="flex items-center justify-between font-extrabold text-slate-900">
                    <span>Apakah data transaksi keuangan saya aman?</span>
                    <i class="fa-solid" :class="openFaq === 2 ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                </div>
                <p x-show="openFaq === 2" class="text-slate-600 pt-2 border-t border-slate-200 font-medium leading-relaxed" x-transition>
                    Ya, data Anda tersimpan secara terenkripsi dan hanya dapat diakses oleh akun Anda sendiri. Administrator hanya melihat agregat statistik tanpa mengakses rincian pribadi.
                </p>
            </div>
        </div>
    </section>

    <!-- 7. FOOTER BAR -->
    <footer class="border-t border-slate-200 py-6 text-center text-xs text-slate-500 z-10 bg-white">
        <div class="max-w-6xl mx-auto px-4 flex flex-col sm:flex-row items-center justify-between gap-4">
            <span class="font-semibold">CashMind System &copy; 2026 — Personal & Enterprise Financial Operating System</span>
            <div class="flex items-center gap-4 text-slate-700 font-bold">
                <a href="{{ route('login') }}" class="hover:text-emerald-600 transition">Login</a>
                <a href="{{ route('register') }}" class="hover:text-emerald-600 transition">Register</a>
            </div>
        </div>
    </footer>
</div>
@endsection
