@extends('layouts.app')

@section('content')
<div x-data="{ openFaq: null }" class="min-h-screen flex flex-col justify-between bg-[#F8FAFC] text-[#0F172A] selection:bg-[#4F46E5] selection:text-white font-sans">
    
    <!-- 1. EDITORIAL DARK HEADER NAVBAR -->
    <header class="h-20 bg-[#0F172A]/95 backdrop-blur-md border-b border-[#1E293B] px-6 lg:px-12 flex items-center justify-between sticky top-0 z-50 text-white shadow-xl">
        <a href="{{ url('/') }}" class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-[#4F46E5] to-[#3730A3] text-white flex items-center justify-center font-bold text-lg shadow-lg shadow-[#4F46E5]/30">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="20" height="14" x="2" y="5" rx="2"/>
                    <line x1="2" x2="22" y1="10" y2="10"/>
                </svg>
            </div>
            <div>
                <span class="text-xl font-extrabold font-display tracking-tight text-white block leading-none">CashMind</span>
                <span class="text-[10px] text-[#A5B4FC] font-bold uppercase tracking-wider mt-0.5 block">Financial OS v2.0</span>
            </div>
        </a>

        <!-- Desktop Navigation Links -->
        <nav class="hidden md:flex items-center gap-8 text-xs font-bold text-slate-300">
            <a href="#beranda" class="hover:text-[#A5B4FC] transition">Beranda</a>
            <a href="#fitur" class="hover:text-[#A5B4FC] transition">5 Core Menus</a>
            <a href="#keamanan" class="hover:text-[#A5B4FC] transition">Keamanan & Privasi</a>
            <a href="#faq" class="hover:text-[#A5B4FC] transition">FAQ</a>
        </nav>

        <!-- Auth Actions -->
        <div class="flex items-center gap-3">
            @guest
                <a href="{{ route('login') }}" class="px-4 py-2.5 text-xs font-bold text-slate-200 bg-white/10 hover:bg-white/20 border border-white/10 rounded-xl transition">Masuk</a>
                <a href="{{ route('register') }}" class="btn-primary text-xs shadow-lg shadow-[#4F46E5]/30">Mulai Gratis</a>
            @else
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="px-5 py-2.5 text-xs font-bold text-white bg-[#D97706] hover:bg-[#B45309] rounded-xl transition">Console Admin</a>
                @else
                    <a href="{{ route('user.dashboard') }}" class="btn-emerald text-xs shadow-lg shadow-[#10B981]/30">Buka Workspace Saya</a>
                @endif
            @endguest
        </div>
    </header>

    <!-- 2. HIGH-IMPACT HERO SECTION -->
    <section id="beranda" class="relative bg-gradient-to-b from-[#0F172A] via-[#1E293B] to-[#0F172A] text-white pt-20 pb-24 overflow-hidden border-b border-[#334155]">
        <!-- Glowing Ambient Orbs -->
        <div class="absolute top-1/4 left-1/2 -translate-x-1/2 w-[600px] h-[600px] rounded-full bg-[#4F46E5]/15 blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-10 right-10 w-[400px] h-[400px] rounded-full bg-[#10B981]/15 blur-3xl pointer-events-none"></div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10 space-y-8">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#4F46E5]/20 border border-[#4F46E5]/40 text-xs font-bold text-[#A5B4FC] shadow-md">
                <span class="w-2 h-2 rounded-full bg-[#818CF8]"></span>
                <span>Financial Management System v2.0</span>
            </div>

            <div class="max-w-3xl mx-auto space-y-6">
                <h1 class="text-4xl sm:text-6xl font-extrabold font-display tracking-tight leading-[1.1] text-white">
                    Pencatatan Keuangan,<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#818CF8] via-[#6EE7B7] to-[#10B981]">Presisi & Terkontrol.</span>
                </h1>
                <p class="text-slate-300 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed font-medium">
                    Kelola arus kas bulanan, alokasi budget per kategori, transfer antar rekening dengan biaya admin terpisah, serta deteksi selisih saldo dalam satu platform finansial pribadi.
                </p>

                <!-- CTA Buttons -->
                <div class="flex flex-wrap items-center justify-center gap-4 pt-2">
                    @guest
                        <a href="{{ route('register') }}" class="btn-emerald text-sm px-8 py-3.5 shadow-xl hover:scale-105">
                            <span>Mulai Gratis Sekarang</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                        <a href="{{ route('login') }}" class="btn-secondary text-sm px-8 py-3.5 bg-white/10 hover:bg-white/20 border-white/20 text-white">
                            <span>Akses Demo Login</span>
                        </a>
                    @else
                        <a href="{{ route('user.dashboard') }}" class="btn-emerald text-sm px-8 py-3.5 shadow-xl hover:scale-105">
                            <span>Buka Workspace Saya</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    @endif
                </div>

                <div class="pt-2 text-xs font-semibold text-slate-400 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4 text-[#10B981]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 0 0-8 0v4h8z"/>
                    </svg>
                    <span>Data finansial Anda terisolasi mutlak. 100% Private by Design.</span>
                </div>
            </div>

            <!-- DASHBOARD MOCKUP PREVIEW CARD -->
            <div class="pt-8 max-w-5xl mx-auto">
                <div class="p-4 sm:p-6 bg-white/5 rounded-3xl border border-white/10 shadow-2xl backdrop-blur-md text-left">
                    <div class="flex items-center justify-between border-b border-white/10 pb-3 mb-4">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-[#EF4444]"></span>
                            <span class="w-3 h-3 rounded-full bg-[#F59E0B]"></span>
                            <span class="w-3 h-3 rounded-full bg-[#10B981]"></span>
                            <span class="text-xs font-mono text-slate-400 ml-2">app.cashmind.id/dashboard</span>
                        </div>
                        <span class="text-[11px] font-bold text-[#A5B4FC] bg-[#4F46E5]/20 px-3 py-1 rounded-full border border-[#4F46E5]/40">CashMind System v2</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="p-5 rounded-2xl bg-[#0F172A] border border-[#334155] space-y-1">
                            <span class="text-xs font-bold text-slate-400 block uppercase tracking-wider">Saldo Total Terkumpul</span>
                            <span class="text-3xl font-bold font-display text-white financial-number">Rp 11.770.000</span>
                            <span class="text-[10px] text-[#A5B4FC] block mt-1">Cash, E-Wallet & Rekening Bank</span>
                        </div>
                        <div class="p-5 rounded-2xl bg-[#10B981]/15 border border-[#10B981]/30 space-y-1">
                            <span class="text-xs font-bold text-[#6EE7B7] block uppercase tracking-wider">Pemasukan Bulan Ini</span>
                            <span class="text-3xl font-bold font-display text-[#10B981] financial-number">+ Rp 8.500.000</span>
                            <span class="text-[10px] text-[#6EE7B7] block mt-1">Gaji & Hasil Freelance</span>
                        </div>
                        <div class="p-5 rounded-2xl bg-[#EF4444]/15 border border-[#EF4444]/30 space-y-1">
                            <span class="text-xs font-bold text-[#F87171] block uppercase tracking-wider">Pengeluaran Bulan Ini</span>
                            <span class="text-3xl font-bold font-display text-[#EF4444] financial-number">- Rp 3.250.000</span>
                            <span class="text-[10px] text-[#F87171] block mt-1">Realisasi Konsumsi Terkendali</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. 5 CORE MENUS SHOWCASE SECTION -->
    <section id="fitur" class="py-24 bg-white border-b border-[#E2E8F0]">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16 space-y-3">
                <h2 class="text-3xl sm:text-4xl font-extrabold text-[#0F172A] font-display tracking-tight">5 Core Menu Spesifikasi CashMind v2</h2>
                <p class="text-[#64748B] text-sm font-medium">Struktur navigasi bisnis terintegrasi untuk pencatatan dan evaluasi arus kas.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- 1. Dashboard -->
                <div class="p-8 rounded-3xl bg-[#F8FAFC] border border-[#E2E8F0] space-y-4 hover:border-[#4F46E5]/40 transition shadow-xs">
                    <div class="w-12 h-12 rounded-2xl bg-[#EEF2FF] text-[#4F46E5] flex items-center justify-center font-bold">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-[#0F172A] font-display">1. Dashboard Overview</h3>
                    <p class="text-[#64748B] text-xs leading-relaxed font-medium">Monitoring saldo Cash, E-Wallet, Bank, status budget (Aman, Waspada, Melebihi Budget), dan ringkasan Transfer Dana terpisah.</p>
                </div>

                <!-- 2. Income & Expenses -->
                <div class="p-8 rounded-3xl bg-[#F8FAFC] border border-[#E2E8F0] space-y-4 hover:border-[#4F46E5]/40 transition shadow-xs">
                    <div class="w-12 h-12 rounded-2xl bg-[#ECFDF5] text-[#10B981] flex items-center justify-center font-bold">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" x2="12" y1="2" y2="22"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-[#0F172A] font-display">2. Income & Expenses</h3>
                    <p class="text-[#64748B] text-xs leading-relaxed font-medium">3 Tab utama (Income, Expenses, Transfer). Mode alokasi Persentase/Nominal dan pencatatan biaya admin transfer otomatis.</p>
                </div>

                <!-- 3. Master Data -->
                <div class="p-8 rounded-3xl bg-[#F8FAFC] border border-[#E2E8F0] space-y-4 hover:border-[#4F46E5]/40 transition shadow-xs">
                    <div class="w-12 h-12 rounded-2xl bg-[#EEF2FF] text-[#4F46E5] flex items-center justify-center font-bold">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/><path d="M3 12c0 1.66 4 3 9 3s9-1.34 9-3"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-[#0F172A] font-display">3. Master Data</h3>
                    <p class="text-[#64748B] text-xs leading-relaxed font-medium">Pengelolaan Kategori Income, Expenses, E-Wallet, dan Rekening Bank dengan status toggle Aktif/Nonaktif.</p>
                </div>

                <!-- 4. Usage Summary -->
                <div class="p-8 rounded-3xl bg-[#F8FAFC] border border-[#E2E8F0] space-y-4 hover:border-[#4F46E5]/40 transition shadow-xs">
                    <div class="w-12 h-12 rounded-2xl bg-[#ECFDF5] text-[#10B981] flex items-center justify-center font-bold">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-[#0F172A] font-display">4. Usage Summary</h3>
                    <p class="text-[#64748B] text-xs leading-relaxed font-medium">Analisis bulanan, Poin Positif, Poin Perhatian, perbandingan Cash vs Transfer, serta ekspor Excel/CSV & PDF.</p>
                </div>

                <!-- 5. Missing Budget -->
                <div class="p-8 rounded-3xl bg-[#F8FAFC] border border-[#E2E8F0] space-y-4 hover:border-[#4F46E5]/40 transition shadow-xs md:col-span-2">
                    <div class="w-12 h-12 rounded-2xl bg-[#FEF3C7] text-[#D97706] flex items-center justify-center font-bold">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m16 16 3-8 3 8c-.87.65-1.92 1-3 1s-2.13-.35-3-1Z"/><path d="m2 16 3-8 3 8c-.87.65-1.92 1-3 1s-2.13-.35-3-1Z"/><path d="M7 21h10"/><path d="M12 3v18"/><path d="M3 7h18"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-[#0F172A] font-display">5. Missing Budget & Deteksi Selisih</h3>
                    <p class="text-[#64748B] text-xs leading-relaxed font-medium">Kalkulasi selisih matematis antara Saldo Seharusnya (Income - Expense) dengan Saldo Aktual Pembanding secara transparan.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. PRIVACY HIGHLIGHT SECTION -->
    <section id="keamanan" class="py-24 bg-[#0F172A] text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-8">
            <div class="space-y-3">
                <span class="px-4 py-1.5 rounded-full bg-[#10B981]/20 text-[#6EE7B7] border border-[#10B981]/40 text-xs font-bold uppercase tracking-wider">Private by Design Architecture</span>
                <h2 class="text-3xl sm:text-5xl font-extrabold font-display">Data Finansial Anda Terisolasi Mutlak</h2>
                <p class="text-slate-300 text-sm max-w-xl mx-auto font-medium">Admin platform hanya mengelola operasional akun dan master template data. Catatan transaksi Anda 100% rahasia.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-left pt-4">
                <div class="p-5 rounded-2xl bg-[#1E293B] border border-[#334155] flex items-center gap-3">
                    <svg class="w-5 h-5 text-[#6EE7B7] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span class="text-xs font-bold text-slate-100">Admin tidak dapat melihat transaksi Anda</span>
                </div>
                <div class="p-5 rounded-2xl bg-[#1E293B] border border-[#334155] flex items-center gap-3">
                    <svg class="w-5 h-5 text-[#6EE7B7] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span class="text-xs font-bold text-slate-100">Admin tidak dapat melihat saldo akun Anda</span>
                </div>
                <div class="p-5 rounded-2xl bg-[#1E293B] border border-[#334155] flex items-center gap-3">
                    <svg class="w-5 h-5 text-[#6EE7B7] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span class="text-xs font-bold text-slate-100">Admin tidak dapat melihat laporan bulanan Anda</span>
                </div>
                <div class="p-5 rounded-2xl bg-[#1E293B] border border-[#334155] flex items-center gap-3">
                    <svg class="w-5 h-5 text-[#6EE7B7] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span class="text-xs font-bold text-slate-100">Isolasi data antar pengguna terjamin 100%</span>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. FAQ ACCORDION -->
    <section id="faq" class="py-24 bg-white border-t border-[#E2E8F0]">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div class="text-center space-y-3">
                <h2 class="text-3xl font-extrabold text-[#0F172A] font-display">Pertanyaan Umum (FAQ)</h2>
                <p class="text-[#64748B] text-xs font-medium">Informasi seputar privasi dan penggunaan CashMind.</p>
            </div>

            <div class="space-y-4">
                <div class="p-5 rounded-2xl bg-[#F8FAFC] border border-[#E2E8F0]">
                    <button @click="openFaq = openFaq === 1 ? null : 1" class="w-full flex items-center justify-between font-bold text-sm text-[#0F172A] text-left font-display">
                        <span>Apakah admin platform dapat melihat catatan transaksi saya?</span>
                        <svg class="w-5 h-5 text-[#64748B] transition-transform" :class="openFaq === 1 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <p x-show="openFaq === 1" class="mt-3 text-xs text-[#64748B] leading-relaxed font-medium">
                        Tidak. CashMind menggunakan arsitektur Private by Design. Seluruh catatan transaksi, rincian nominal, dan laporan saldo terisolasi sepenuhnya dan hanya dapat diakses dari sesi akun Anda.
                    </p>
                </div>

                <div class="p-5 rounded-2xl bg-[#F8FAFC] border border-[#E2E8F0]">
                    <button @click="openFaq = openFaq === 2 ? null : 2" class="w-full flex items-center justify-between font-bold text-sm text-[#0F172A] text-left font-display">
                        <span>Bagaimana cara pencatatan nominal dengan format Rupiah?</span>
                        <svg class="w-5 h-5 text-[#64748B] transition-transform" :class="openFaq === 2 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <p x-show="openFaq === 2" class="mt-3 text-xs text-[#64748B] leading-relaxed font-medium">
                        Form input nominal otomatis memformat angka dengan pemisah ribuan Rupiah (contoh: <code>Rp 1.000.000</code>) sehingga nyaman dibaca saat menginput.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. FOOTER -->
    <footer class="py-10 bg-[#0F172A] text-slate-400 text-xs border-t border-[#1E293B] text-center">
        <div class="max-w-6xl mx-auto px-4 space-y-2">
            <p>&copy; {{ date('Y') }} CashMind. Studio Finansial Personal Private by Design.</p>
        </div>
    </footer>

</div>
@endsection
