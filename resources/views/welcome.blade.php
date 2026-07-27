@extends('layouts.app')

@section('content')
<div class="relative overflow-hidden pt-8 pb-20">
    <!-- Glow Decorative Background Elements -->
    <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-gradient-to-tr from-emerald-500/10 via-teal-500/10 to-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute top-1/3 -right-20 w-80 h-80 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <!-- Hero Container -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <!-- Top Pill Badge -->
        <div class="flex justify-center mb-6">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-slate-800/80 border border-slate-700/80 text-xs font-semibold text-emerald-400 backdrop-blur-md shadow-lg shadow-emerald-500/5">
                <span class="flex h-2 w-2 rounded-full bg-emerald-400 animate-ping"></span>
                <span>Financial Management System 2026</span>
                <span class="text-slate-500">|</span>
                <span class="text-slate-300">Inspired by Catatan Keuangan</span>
            </div>
        </div>

        <!-- Headline & Subtitle -->
        <div class="text-center max-w-4xl mx-auto space-y-6">
            <h1 class="text-4xl sm:text-6xl font-extrabold text-white tracking-tight leading-tight">
                Pencatatan Keuangan Presisi, <br class="hidden sm:inline">
                <span class="bg-gradient-to-r from-emerald-400 via-teal-300 to-amber-300 bg-clip-text text-transparent">Alokasi Budget & Deteksi Selisih Kas</span>
            </h1>
            <p class="text-slate-400 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed">
                Kelola pemasukan gajihan, side job, dan alokasi persentase pengeluaran harian. Dilengkapi sistem <strong class="text-emerald-300 font-medium">Reconciliation Track</strong> untuk menemukan dana tidak diketahui (Missing Cash).
            </p>

            <!-- Hero Action Buttons -->
            <div class="flex flex-wrap items-center justify-center gap-4 pt-4">
                @guest
                    <a href="{{ route('login') }}" class="group relative inline-flex items-center gap-3 px-8 py-4 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-600 font-bold text-slate-950 text-sm shadow-xl shadow-emerald-500/25 hover:shadow-emerald-500/40 hover:scale-[1.02] transition-all duration-200">
                        <i class="fa-solid fa-right-to-bracket text-base group-hover:rotate-12 transition-transform"></i>
                        <span>Masuk Akun (Login)</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                    <a href="{{ route('register') }}" class="inline-flex items-center gap-3 px-8 py-4 rounded-2xl bg-slate-800/90 hover:bg-slate-800 border border-slate-700/80 font-bold text-white text-sm shadow-lg hover:border-emerald-500/50 hover:text-emerald-400 transition-all duration-200">
                        <i class="fa-solid fa-user-plus text-emerald-400"></i>
                        <span>Daftar Akun Baru</span>
                    </a>
                @else
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="group relative inline-flex items-center gap-3 px-8 py-4 rounded-2xl bg-gradient-to-r from-amber-500 to-orange-500 font-bold text-slate-950 text-sm shadow-xl shadow-amber-500/25 hover:scale-[1.02] transition-all">
                            <i class="fa-solid fa-user-shield text-base"></i>
                            <span>Buka Dashboard Admin</span>
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                    @else
                        <a href="{{ route('user.dashboard') }}" class="group relative inline-flex items-center gap-3 px-8 py-4 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-600 font-bold text-slate-950 text-sm shadow-xl shadow-emerald-500/25 hover:scale-[1.02] transition-all">
                            <i class="fa-solid fa-chart-pie text-base"></i>
                            <span>Buka Dashboard User</span>
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                    @endif
                @endguest
            </div>
        </div>

        <!-- Live Interactive Preview Mockup Box -->
        <div class="mt-16 max-w-5xl mx-auto">
            <div class="relative rounded-3xl bg-slate-900/90 border border-slate-800/90 shadow-2xl p-4 sm:p-6 backdrop-blur-xl">
                <!-- Mockup Header Bar -->
                <div class="flex items-center justify-between border-b border-slate-800 pb-4 mb-6">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-rose-500"></span>
                        <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                        <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                        <span class="ml-2 text-xs font-mono text-slate-400">CashMind System 2026 Overview</span>
                    </div>
                    <div class="flex items-center gap-2 text-xs text-slate-400 bg-slate-800/60 px-3 py-1 rounded-lg">
                        <i class="fa-solid fa-circle-check text-emerald-400"></i>
                        <span>System Sync Active</span>
                    </div>
                </div>

                <!-- Preview KPI Cards Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <div class="p-4 rounded-2xl bg-slate-800/50 border border-slate-700/50">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Total Income</span>
                            <div class="w-8 h-8 rounded-xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center">
                                <i class="fa-solid fa-arrow-down text-xs"></i>
                            </div>
                        </div>
                        <div class="text-xl font-bold text-white">Rp 10.959.540</div>
                        <div class="text-[11px] text-emerald-400 mt-1 flex items-center gap-1">
                            <i class="fa-solid fa-circle-plus"></i> Gaji + Side Job + Tabungan
                        </div>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-800/50 border border-slate-700/50">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Total Realisasi</span>
                            <div class="w-8 h-8 rounded-xl bg-rose-500/10 text-rose-400 flex items-center justify-center">
                                <i class="fa-solid fa-arrow-up text-xs"></i>
                            </div>
                        </div>
                        <div class="text-xl font-bold text-white">Rp 10.722.830</div>
                        <div class="text-[11px] text-slate-400 mt-1">Realisasi Pengeluaran 97.8%</div>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-800/50 border border-slate-700/50">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Total Alokasi</span>
                            <div class="w-8 h-8 rounded-xl bg-sky-500/10 text-sky-400 flex items-center justify-center">
                                <i class="fa-solid fa-sliders text-xs"></i>
                            </div>
                        </div>
                        <div class="text-xl font-bold text-white">Rp 10.959.540</div>
                        <div class="text-[11px] text-sky-400 mt-1">100% Ter alokasi per Kategori</div>
                    </div>

                    <div class="p-4 rounded-2xl bg-amber-500/10 border border-amber-500/30">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs text-amber-400 font-semibold uppercase tracking-wider">Status Selisih</span>
                            <div class="w-8 h-8 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center">
                                <i class="fa-solid fa-triangle-exclamation text-xs"></i>
                            </div>
                        </div>
                        <div class="text-xl font-bold text-amber-300">Rp 236.710</div>
                        <div class="text-[11px] text-amber-400/90 mt-1">Perlu Rekonsiliasi Kas</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Flow Steps Section -->
        <div class="mt-24 text-center max-w-4xl mx-auto">
            <h2 class="text-3xl font-extrabold text-white mb-4">Alur Kerja Aplikasi CashMind</h2>
            <p class="text-slate-400 text-sm mb-12">Sistem pencatatan terstruktur yang mudah dipahami bagi Pengguna dan Pengelola.</p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-slate-900/80 border border-slate-800 p-6 rounded-3xl space-y-3 relative">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center font-bold text-lg mx-auto">1</div>
                    <h3 class="text-lg font-bold text-white">Masuk / Login Akun</h3>
                    <p class="text-xs text-slate-400">Masuk sebagai User Personal untuk mencatatkan kas atau sebagai Admin untuk mengelola data master.</p>
                </div>

                <div class="bg-slate-900/80 border border-slate-800 p-6 rounded-3xl space-y-3 relative">
                    <div class="w-10 h-10 rounded-2xl bg-sky-500/10 text-sky-400 flex items-center justify-center font-bold text-lg mx-auto">2</div>
                    <h3 class="text-lg font-bold text-white">Input Kas & Alokasi</h3>
                    <p class="text-xs text-slate-400">Catat pemasukan bulanan dan atur persentase alokasi Makanan, Belanja, Kendaraan, & Tabungan.</p>
                </div>

                <div class="bg-slate-900/80 border border-slate-800 p-6 rounded-3xl space-y-3 relative">
                    <div class="w-10 h-10 rounded-2xl bg-amber-500/10 text-amber-400 flex items-center justify-center font-bold text-lg mx-auto">3</div>
                    <h3 class="text-lg font-bold text-white">Audit & Rekonsiliasi</h3>
                    <p class="text-xs text-slate-400">Pantau realisasi pengeluaran dan temukan otomatis selisih dana yang hilang (Missing Cash).</p>
                </div>
            </div>
        </div>

        <!-- Quick Login Callout Banner -->
        <div class="mt-20 p-8 rounded-3xl bg-gradient-to-r from-emerald-950/60 via-slate-900 to-amber-950/60 border border-slate-800 text-center relative overflow-hidden">
            <div class="relative z-10 max-w-2xl mx-auto space-y-4">
                <h3 class="text-2xl font-extrabold text-white">Uji Coba Login Akun Seeder</h3>
                <p class="text-xs text-slate-400">Gunakan akun demo yang telah disiapkan untuk menguji peran Admin & User.</p>
                
                <div class="flex flex-wrap justify-center gap-4 text-xs font-mono text-slate-300">
                    <div class="px-4 py-2 rounded-xl bg-slate-800/80 border border-amber-500/30 text-amber-300">
                        <strong>Admin:</strong> admin@cashmind.id / password
                    </div>
                    <div class="px-4 py-2 rounded-xl bg-slate-800/80 border border-emerald-500/30 text-emerald-300">
                        <strong>User:</strong> user@cashmind.id / password
                    </div>
                </div>

                <div class="pt-2">
                    <a href="{{ route('login') }}" class="px-8 py-3.5 rounded-2xl bg-emerald-500 text-slate-950 font-bold text-sm hover:bg-emerald-400 transition shadow-lg shadow-emerald-500/20 inline-flex items-center gap-2">
                        <i class="fa-solid fa-right-to-bracket"></i>
                        <span>Ke Halaman Login</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
