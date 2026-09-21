@extends('layouts.app')

@section('content')
<div x-data="{ openFaq: null }" class="min-h-screen flex flex-col justify-between bg-[#F1F5F9] text-[#0F172A] selection:bg-[#059669] selection:text-white font-sans">
    
    <!-- 1. EDITORIAL DARK HEADER NAVBAR -->
    <header class="h-20 bg-[#0B132B]/95 backdrop-blur-md border-b border-[#1C2541] px-6 lg:px-12 flex items-center justify-between sticky top-0 z-50 text-white shadow-xl">
        <a href="{{ url('/') }}" class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-[#059669] to-[#047857] text-white flex items-center justify-center font-bold text-lg shadow-lg shadow-[#059669]/30">
                <svg class="w-6 h-6 text-[#A7F3D0]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <span class="text-xl font-bold font-display tracking-tight text-white block leading-none">CashMind</span>
                <span class="text-[10px] text-[#34D399] font-bold uppercase tracking-wider mt-0.5 block">Ledger OS</span>
            </div>
        </a>

        <!-- Desktop Navigation Links -->
        <nav class="hidden md:flex items-center gap-8 text-xs font-bold text-slate-300">
            <a href="#beranda" class="hover:text-[#34D399] transition">Beranda</a>
            <a href="#fitur" class="hover:text-[#34D399] transition">Fitur Utama</a>
            <a href="#keamanan" class="hover:text-[#34D399] transition">Keamanan & Privasi</a>
            <a href="#carakerja" class="hover:text-[#34D399] transition">Cara Kerja</a>
            <a href="#faq" class="hover:text-[#34D399] transition">FAQ</a>
        </nav>

        <!-- Auth Actions -->
        <div class="flex items-center gap-3">
            @guest
                <a href="{{ route('login') }}" class="px-4 py-2.5 text-xs font-bold text-slate-200 bg-white/10 hover:bg-white/20 border border-white/10 rounded-xl transition">Masuk</a>
                <a href="{{ route('register') }}" class="px-5 py-2.5 text-xs font-bold text-white bg-[#059669] hover:bg-[#047857] rounded-xl shadow-lg shadow-[#059669]/30 transition">Mulai Gratis</a>
            @else
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="px-5 py-2.5 text-xs font-bold text-white bg-[#D97706] hover:bg-[#B45309] rounded-xl transition">Console Admin</a>
                @else
                    <a href="{{ route('user.dashboard') }}" class="px-5 py-2.5 text-xs font-bold text-white bg-[#059669] hover:bg-[#047857] rounded-xl shadow-lg shadow-[#059669]/30 transition">Buka Workspace Saya</a>
                @endif
            @endguest
        </div>
    </header>

    <!-- 2. HIGH-IMPACT HERO SECTION (EDITORIAL BOLD - DARK NAVY HERO) -->
    <section id="beranda" class="relative bg-gradient-to-b from-[#0B132B] via-[#0F172A] to-[#1C2541] text-white pt-20 pb-24 overflow-hidden border-b border-[#1C2541]">
        <!-- Glowing Emerald Ambient Orbs -->
        <div class="absolute top-1/4 left-1/2 -translate-x-1/2 w-[600px] h-[600px] rounded-full bg-[#059669]/15 blur-3xl pointer-events-none"></div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10 space-y-8">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#059669]/20 border border-[#059669]/40 text-xs font-bold text-[#A7F3D0] shadow-md">
                <span class="w-2 h-2 rounded-full bg-[#34D399]"></span>
                <span>Financial Management System v4.0</span>
            </div>

            <div class="max-w-3xl mx-auto space-y-6">
                <h1 class="text-4xl sm:text-6xl font-extrabold font-display tracking-tight leading-[1.1] text-white">
                    Keuangan Pribadi,<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#34D399] to-[#059669]">Tanpa Kerumitan.</span>
                </h1>
                <p class="text-slate-300 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed font-medium">
                    Catat arus kas harian, kelola rekening bank & e-wallet, susun anggaran, dan evaluasi laporan dalam studio finansial personal yang 100% aman.
                </p>

                <!-- CTA Buttons -->
                <div class="flex flex-wrap items-center justify-center gap-4 pt-2">
                    @guest
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-8 py-4 text-sm font-bold text-white bg-[#059669] hover:bg-[#047857] rounded-2xl shadow-lg shadow-[#059669]/40 transition hover:scale-105">
                            <span>Mulai Sekarang Gratis</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                        <a href="#fitur" class="inline-flex items-center gap-2 px-8 py-4 text-sm font-bold text-slate-200 bg-white/10 hover:bg-white/20 border border-white/10 rounded-2xl transition backdrop-blur-xs">
                            <span>Lihat Produk</span>
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-8 py-4 text-sm font-bold text-white bg-[#059669] hover:bg-[#047857] rounded-2xl shadow-lg shadow-[#059669]/40 transition hover:scale-105">
                            <span>Masuk ke Workspace Saya</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    @endif
                </div>

                <div class="pt-2 text-xs font-semibold text-slate-400 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4 text-[#34D399]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 0 0-8 0v4h8z"/>
                    </svg>
                    <span>Data finansial Anda terisolasi mutlak. Admin 0% akses saldo Anda.</span>
                </div>
            </div>

            <!-- DASHBOARD PREVIEW MOCKUP -->
            <div class="pt-8 max-w-5xl mx-auto">
                <div class="p-4 sm:p-6 bg-white/5 rounded-3xl border border-white/10 shadow-2xl backdrop-blur-md text-left">
                    <div class="flex items-center gap-2 mb-4 border-b border-white/10 pb-3">
                        <span class="w-3 h-3 rounded-full bg-[#E11D48]"></span>
                        <span class="w-3 h-3 rounded-full bg-[#D97706]"></span>
                        <span class="w-3 h-3 rounded-full bg-[#059669]"></span>
                        <span class="text-xs font-mono text-slate-400 ml-2">app.cashmind.id/studio</span>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="p-5 rounded-2xl bg-[#090D16] border border-[#1C2541]">
                            <span class="text-xs font-bold text-slate-400 block uppercase tracking-wider">Total Saldo</span>
                            <span class="text-3xl font-bold font-display text-white mt-1 block tracking-tight">Rp 8.750.000</span>
                        </div>
                        <div class="p-5 rounded-2xl bg-[#059669]/15 border border-[#059669]/30">
                            <span class="text-xs font-bold text-[#A7F3D0] block uppercase tracking-wider">Pemasukan Bulan Ini</span>
                            <span class="text-3xl font-bold font-display text-[#34D399] mt-1 block tracking-tight">+ Rp 7.000.000</span>
                        </div>
                        <div class="p-5 rounded-2xl bg-[#E11D48]/15 border border-[#E11D48]/30">
                            <span class="text-xs font-bold text-[#FECDD3] block uppercase tracking-wider">Pengeluaran Bulan Ini</span>
                            <span class="text-3xl font-bold font-display text-[#FB7185] mt-1 block tracking-tight">- Rp 4.250.000</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. FEATURE SHOWCASE SECTION -->
    <section id="fitur" class="py-24 bg-white border-b border-[#E2E8F0]">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16 space-y-3">
                <h2 class="text-3xl sm:text-4xl font-extrabold text-[#0F172A] font-display">Fitur Utama CashMind</h2>
                <p class="text-[#64748B] text-sm font-medium">Pengalaman mencatat keuangan personal yang tenang, cepat, dan presisi.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="p-8 rounded-3xl bg-[#F8FAFC] border border-[#E2E8F0] space-y-4 hover:border-[#059669]/40 transition">
                    <div class="w-12 h-12 rounded-2xl bg-[#ECFDF5] text-[#059669] flex items-center justify-center font-bold">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-[#0F172A] font-display">Pencatatan Presisi</h3>
                    <p class="text-[#64748B] text-xs leading-relaxed font-medium">Catat pemasukan, pengeluaran, serta pemindahan dana (transfer) antar akun dengan deskripsi dan rincian yang jelas.</p>
                </div>

                <!-- Feature 2 -->
                <div class="p-8 rounded-3xl bg-[#F8FAFC] border border-[#E2E8F0] space-y-4 hover:border-[#059669]/40 transition">
                    <div class="w-12 h-12 rounded-2xl bg-[#ECFDF5] text-[#059669] flex items-center justify-center font-bold">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-[#0F172A] font-display">Banyak Akun & Dompet</h3>
                    <p class="text-[#64748B] text-xs leading-relaxed font-medium">Pisahkan saldo Tunai, Bank, dan E-Wallet. Anda dapat menambahkan rekening custom sesuai kebutuhan Anda.</p>
                </div>

                <!-- Feature 3 -->
                <div class="p-8 rounded-3xl bg-[#F8FAFC] border border-[#E2E8F0] space-y-4 hover:border-[#059669]/40 transition">
                    <div class="w-12 h-12 rounded-2xl bg-[#ECFDF5] text-[#059669] flex items-center justify-center font-bold">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-[#0F172A] font-display">Laporan & Grafik Cash Flow</h3>
                    <p class="text-[#64748B] text-xs leading-relaxed font-medium">Pantau tren arus kas bulanan serta evaluasi pengeluaran per kategori secara visual dan dapat diekspor ke CSV.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. PRIVACY HIGHLIGHT SECTION (DARK BREAK) -->
    <section id="keamanan" class="py-24 bg-[#090D16] text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-8">
            <div class="space-y-3">
                <span class="px-4 py-1.5 rounded-full bg-[#059669]/20 text-[#A7F3D0] border border-[#059669]/40 text-xs font-bold uppercase tracking-wider">Private by Design Architecture</span>
                <h2 class="text-3xl sm:text-5xl font-extrabold font-display">Data Finansial Anda Terisolasi Mutlak</h2>
                <p class="text-slate-300 text-sm max-w-xl mx-auto font-medium">Admin platform hanya mengelola operasional akun dan master template data. Catatan transaksi Anda 100% rahasia.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-left pt-4">
                <div class="p-5 rounded-2xl bg-[#0B132B] border border-[#1C2541] flex items-center gap-3">
                    <svg class="w-5 h-5 text-[#34D399] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span class="text-xs font-bold text-slate-100">Admin tidak dapat melihat transaksi Anda</span>
                </div>
                <div class="p-5 rounded-2xl bg-[#0B132B] border border-[#1C2541] flex items-center gap-3">
                    <svg class="w-5 h-5 text-[#34D399] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span class="text-xs font-bold text-slate-100">Admin tidak dapat melihat saldo akun Anda</span>
                </div>
                <div class="p-5 rounded-2xl bg-[#0B132B] border border-[#1C2541] flex items-center gap-3">
                    <svg class="w-5 h-5 text-[#34D399] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span class="text-xs font-bold text-slate-100">Admin tidak dapat melihat laporan bulanan Anda</span>
                </div>
                <div class="p-5 rounded-2xl bg-[#0B132B] border border-[#1C2541] flex items-center gap-3">
                    <svg class="w-5 h-5 text-[#34D399] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
    <footer class="py-10 bg-[#0B132B] text-slate-400 text-xs border-t border-[#1C2541] text-center">
        <div class="max-w-6xl mx-auto px-4 space-y-2">
            <p>© 2026 CashMind. Studio Finansial Personal Private by Design.</p>
        </div>
    </footer>

</div>
@endsection
