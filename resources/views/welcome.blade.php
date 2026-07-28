@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col justify-between relative overflow-hidden bg-[#09090b]">
    
    <!-- Top Navigation Header -->
    <header class="h-16 border-b border-zinc-800/60 px-6 lg:px-12 flex items-center justify-between z-20">
        <a href="{{ url('/') }}" class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-lg bg-emerald-500/10 border border-emerald-500/30 flex items-center justify-center text-emerald-400 font-bold text-sm">
                <i class="fa-solid fa-wallet"></i>
            </div>
            <span class="text-base font-extrabold tracking-tight text-zinc-100">CashMind</span>
        </a>

        <div class="flex items-center gap-3">
            @guest
                <a href="{{ route('login') }}" class="px-4 py-2 rounded-lg bg-zinc-900 hover:bg-zinc-800 border border-zinc-800 text-xs font-semibold text-zinc-200 transition">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="px-4 py-2 rounded-lg bg-emerald-500 hover:bg-emerald-400 text-zinc-950 font-bold text-xs transition shadow-lg shadow-emerald-500/10">
                    Daftar Baru
                </a>
            @else
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-lg bg-amber-500 hover:bg-amber-400 text-zinc-950 font-bold text-xs transition">
                        Dashboard Admin
                    </a>
                @else
                    <a href="{{ route('user.dashboard') }}" class="px-4 py-2 rounded-lg bg-emerald-500 hover:bg-emerald-400 text-zinc-950 font-bold text-xs transition">
                        Dashboard Workspace
                    </a>
                @endif
            @endguest
        </div>
    </header>

    <!-- Hero Content Container -->
    <main class="flex-1 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24 text-center z-10 space-y-12">
        
        <!-- Top Pill Badge -->
        <div class="flex justify-center">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-zinc-900/90 border border-zinc-800 text-xs font-medium text-zinc-300 backdrop-blur-md">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>Personal Financial Operating System</span>
                <span class="text-zinc-600">|</span>
                <span class="text-emerald-400 font-mono text-[11px]">2026 Edition</span>
            </div>
        </div>

        <!-- Headline & Subtitle -->
        <div class="max-w-4xl mx-auto space-y-6">
            <h1 class="text-4xl sm:text-6xl font-extrabold text-zinc-100 tracking-tight leading-tight">
                Pencatatan Keuangan Presisi. <br class="hidden sm:inline">
                <span class="bg-gradient-to-r from-emerald-400 via-teal-300 to-zinc-200 bg-clip-text text-transparent">Alokasi Budget & Auditing Selisih Kas.</span>
            </h1>
            <p class="text-zinc-400 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed">
                Kelola pemasukan gajihan, side job, dan alokasi persentase pengeluaran harian dengan antarmuka modern yang cepat, bersih, dan fokus pada data.
            </p>

            <!-- Hero Action Buttons -->
            <div class="flex flex-wrap items-center justify-center gap-4 pt-2">
                @guest
                    <a href="{{ route('login') }}" class="px-6 py-3 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-zinc-950 font-bold text-xs shadow-xl shadow-emerald-500/10 transition flex items-center gap-2">
                        <i class="fa-solid fa-right-to-bracket text-xs"></i>
                        <span>Masuk ke Workspace</span>
                    </a>
                    <a href="{{ route('register') }}" class="px-6 py-3 rounded-xl bg-zinc-900 hover:bg-zinc-800 border border-zinc-800 text-zinc-200 font-semibold text-xs transition">
                        Daftar Akun Baru
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="px-6 py-3 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-zinc-950 font-bold text-xs shadow-xl shadow-emerald-500/10 transition flex items-center gap-2">
                        <span>Buka Workspace Saya</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                @endguest
            </div>
        </div>

        <!-- Product Preview Box -->
        <div class="max-w-5xl mx-auto pt-4">
            <div class="bg-[#12131c] border border-zinc-800/80 rounded-2xl p-4 sm:p-6 shadow-2xl backdrop-blur-xl text-left space-y-6">
                
                <!-- Mockup Top Bar -->
                <div class="flex items-center justify-between pb-4 border-b border-zinc-800/80">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-zinc-800"></span>
                        <span class="w-3 h-3 rounded-full bg-zinc-800"></span>
                        <span class="w-3 h-3 rounded-full bg-zinc-800"></span>
                        <span class="ml-2 text-xs font-mono text-zinc-500">cashmind.app/workspace/overview</span>
                    </div>
                    <span class="text-[11px] font-mono text-emerald-400 bg-emerald-500/10 px-2.5 py-0.5 rounded border border-emerald-500/20">Live System Sync</span>
                </div>

                <!-- Preview Metric Cards Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="p-4 rounded-xl bg-zinc-950/60 border border-zinc-800/80">
                        <span class="text-[11px] text-zinc-500 font-mono block">Total Pemasukan</span>
                        <div class="text-xl font-bold text-zinc-100 font-mono mt-1">Rp 10.959.540</div>
                        <span class="text-[10px] text-emerald-400 mt-1 block">Gaji + Side Job</span>
                    </div>

                    <div class="p-4 rounded-xl bg-zinc-950/60 border border-zinc-800/80">
                        <span class="text-[11px] text-zinc-500 font-mono block">Total Pengeluaran</span>
                        <div class="text-xl font-bold text-zinc-100 font-mono mt-1">Rp 10.722.830</div>
                        <span class="text-[10px] text-rose-400 mt-1 block">97.8% Realisasi</span>
                    </div>

                    <div class="p-4 rounded-xl bg-zinc-950/60 border border-zinc-800/80">
                        <span class="text-[11px] text-zinc-500 font-mono block">Saldo Seharusnya</span>
                        <div class="text-xl font-bold text-zinc-100 font-mono mt-1">Rp 236.710</div>
                        <span class="text-[10px] text-zinc-400 mt-1 block">Kas Bersih Sisa</span>
                    </div>

                    <div class="p-4 rounded-xl bg-amber-500/5 border border-amber-500/20">
                        <span class="text-[11px] text-amber-400 font-mono block">Missing Cash Selisih</span>
                        <div class="text-xl font-bold text-amber-300 font-mono mt-1">Rp 236.710</div>
                        <span class="text-[10px] text-amber-400/80 mt-1 block">Status: Perlu Audit</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3 Key Value Propositions -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-left max-w-5xl mx-auto pt-8">
            <div class="p-6 rounded-2xl bg-[#12131c] border border-zinc-800/80 space-y-2">
                <div class="w-8 h-8 rounded-lg bg-emerald-500/10 text-emerald-400 flex items-center justify-center font-bold text-xs">
                    <i class="fa-solid fa-sliders"></i>
                </div>
                <h3 class="font-bold text-zinc-200 text-sm">Alokasi Budget Mandiri</h3>
                <p class="text-xs text-zinc-400 leading-relaxed">Tentukan kategori pemasukan & pengeluaran kustom serta persentase target spending Anda secara fleksibel.</p>
            </div>

            <div class="p-6 rounded-2xl bg-[#12131c] border border-zinc-800/80 space-y-2">
                <div class="w-8 h-8 rounded-lg bg-sky-500/10 text-sky-400 flex items-center justify-center font-bold text-xs">
                    <i class="fa-solid fa-chart-column"></i>
                </div>
                <h3 class="font-bold text-zinc-200 text-sm">Diagram & Visual Analytics</h3>
                <p class="text-xs text-zinc-400 leading-relaxed">Pantau grafik perbandingan arus kas bulanan dan distribusi pengeluaran dengan Chart.js yang presisi.</p>
            </div>

            <div class="p-6 rounded-2xl bg-[#12131c] border border-zinc-800/80 space-y-2">
                <div class="w-8 h-8 rounded-lg bg-amber-500/10 text-amber-400 flex items-center justify-center font-bold text-xs">
                    <i class="fa-solid fa-file-invoice-dollar"></i>
                </div>
                <h3 class="font-bold text-zinc-200 text-sm">Cetak Laporan PDF</h3>
                <p class="text-xs text-zinc-400 leading-relaxed">Ekspor laporan pendapatan & pengeluaran bulanan/tahunan dengan layout bersih siap cetak resmi.</p>
            </div>
        </div>
    </main>

    <!-- Footer Bar -->
    <footer class="border-t border-zinc-800/60 py-6 text-center text-xs text-zinc-500 z-10">
        <div class="max-w-6xl mx-auto px-4 flex flex-col sm:flex-row items-center justify-between gap-4">
            <span>CashMind System &copy; 2026 — Financial Management Operating System</span>
            <div class="flex items-center gap-4 text-zinc-400">
                <a href="{{ route('login') }}" class="hover:text-emerald-400 transition">Login</a>
                <a href="{{ route('register') }}" class="hover:text-emerald-400 transition">Register</a>
            </div>
        </div>
    </footer>
</div>
@endsection
