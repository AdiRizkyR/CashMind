@extends('layouts.admin')

@section('admin-content')
<!-- Komentar Bahasa Indonesia: Dashboard Analytics Admin Tema Terang -->
<div class="space-y-6">
    
    <!-- Page Title & Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Trafik & System Analytics</h1>
            <p class="text-xs text-slate-500 mt-1">Monitoring aktivitas pengguna harian, volume transaksi, dan kesehatan platform.</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.users') }}" class="light-btn-primary bg-amber-600 hover:bg-amber-700 text-white">
                <i class="fa-solid fa-users-gear text-xs"></i>
                <span>Direktori User</span>
            </a>
        </div>
    </div>

    <!-- 4 Key Admin Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="light-card p-5 space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500">Total User Terdaftar</span>
                <span class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 border border-amber-200 text-xs flex items-center justify-center font-bold shadow-sm">
                    <i class="fa-solid fa-users"></i>
                </span>
            </div>
            <div class="text-2xl font-bold text-slate-900 font-mono">1.482</div>
            <div class="text-xs text-emerald-600 font-bold flex items-center gap-1">
                <i class="fa-solid fa-arrow-trend-up text-[10px]"></i> +12 User Baru Minggu Ini
            </div>
        </div>

        <div class="light-card p-5 space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500">User Aktif Harian</span>
                <span class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-200 text-xs flex items-center justify-center font-bold shadow-sm">
                    <i class="fa-solid fa-chart-line"></i>
                </span>
            </div>
            <div class="text-2xl font-bold text-emerald-700 font-mono">842 Active</div>
            <div class="text-xs text-slate-500">Puncak Trafik: 20:00 - 22:00</div>
        </div>

        <div class="light-card p-5 space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500">Total Transaksi System</span>
                <span class="w-8 h-8 rounded-xl bg-sky-50 text-sky-600 border border-sky-200 text-xs flex items-center justify-center font-bold shadow-sm">
                    <i class="fa-solid fa-list-check"></i>
                </span>
            </div>
            <div class="text-2xl font-bold text-slate-900 font-mono">48.290</div>
            <div class="text-xs text-sky-600 font-bold">Tercatat di Database</div>
        </div>

        <div class="light-card p-5 space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500">Volume Arus Kas</span>
                <span class="w-8 h-8 rounded-xl bg-purple-50 text-purple-600 border border-purple-200 text-xs flex items-center justify-center font-bold shadow-sm">
                    <i class="fa-solid fa-money-bill-transfer"></i>
                </span>
            </div>
            <div class="text-2xl font-bold text-slate-900 font-mono">Rp 4.28 M</div>
            <div class="text-xs text-slate-500">Volume Terproses 2026</div>
        </div>
    </div>

    <!-- Traffic & Quick Access Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Live Traffic Activity Bar Graph Visual -->
        <div class="lg:col-span-2 light-card p-6 space-y-5">
            <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                <div>
                    <h2 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-chart-simple text-amber-600 text-xs"></i>
                        <span>Aktivitas Pengguna Harian (7 Hari Terakhir)</span>
                    </h2>
                    <p class="text-xs text-slate-500 mt-0.5">Jumlah sesi transaksi & pengaksesan platform per hari.</p>
                </div>
                <span class="px-2.5 py-1 rounded-lg bg-amber-50 border border-amber-200 text-amber-700 text-[10px] font-mono font-bold">Live Analytics</span>
            </div>

            <!-- Visual Bar Chart -->
            <div class="h-44 flex items-end justify-between gap-3 pt-4 px-2">
                <div class="flex-1 flex flex-col items-center gap-2">
                    <span class="text-[10px] text-slate-500 font-mono font-bold">420</span>
                    <div class="w-full bg-amber-200 hover:bg-amber-300 rounded-t-md transition-all" style="height: 60%"></div>
                    <span class="text-[10px] text-slate-500 font-mono">Sen</span>
                </div>
                <div class="flex-1 flex flex-col items-center gap-2">
                    <span class="text-[10px] text-slate-500 font-mono font-bold">580</span>
                    <div class="w-full bg-amber-300 hover:bg-amber-400 rounded-t-md transition-all" style="height: 75%"></div>
                    <span class="text-[10px] text-slate-500 font-mono">Sel</span>
                </div>
                <div class="flex-1 flex flex-col items-center gap-2">
                    <span class="text-[10px] text-slate-500 font-mono font-bold">710</span>
                    <div class="w-full bg-amber-400 hover:bg-amber-500 rounded-t-md transition-all" style="height: 85%"></div>
                    <span class="text-[10px] text-slate-500 font-mono">Rab</span>
                </div>
                <div class="flex-1 flex flex-col items-center gap-2">
                    <span class="text-[10px] text-slate-500 font-mono font-bold">640</span>
                    <div class="w-full bg-amber-300 hover:bg-amber-400 rounded-t-md transition-all" style="height: 78%"></div>
                    <span class="text-[10px] text-slate-500 font-mono">Kam</span>
                </div>
                <div class="flex-1 flex flex-col items-center gap-2">
                    <span class="text-[10px] text-slate-500 font-mono font-bold">890</span>
                    <div class="w-full bg-amber-500 hover:bg-amber-600 rounded-t-md transition-all" style="height: 95%"></div>
                    <span class="text-[10px] text-slate-500 font-mono">Jum</span>
                </div>
                <div class="flex-1 flex flex-col items-center gap-2">
                    <span class="text-[10px] text-amber-700 font-mono font-extrabold">950</span>
                    <div class="w-full bg-amber-600 rounded-t-md" style="height: 100%"></div>
                    <span class="text-[10px] text-amber-700 font-mono font-bold">Sab</span>
                </div>
                <div class="flex-1 flex flex-col items-center gap-2">
                    <span class="text-[10px] text-slate-500 font-mono font-bold">842</span>
                    <div class="w-full bg-amber-400 hover:bg-amber-500 rounded-t-md transition-all" style="height: 90%"></div>
                    <span class="text-[10px] text-slate-500 font-mono">Min</span>
                </div>
            </div>
        </div>

        <!-- Quick Access Card -->
        <div class="light-card p-6 space-y-4">
            <h2 class="text-sm font-bold text-slate-900 pb-3 border-b border-slate-200">Menu Pengawasan Admin</h2>

            <div class="space-y-3 text-xs">
                <a href="{{ route('admin.users') }}" class="p-3.5 rounded-xl bg-slate-50 hover:bg-amber-50 border border-slate-200 hover:border-amber-200 flex items-center justify-between text-slate-700 hover:text-amber-800 transition">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center font-bold">
                            <i class="fa-solid fa-users-gear text-xs"></i>
                        </div>
                        <div>
                            <span class="font-bold block text-slate-900">Direktori User</span>
                            <span class="text-[10px] text-slate-500">Tinjau profil & statistik kas user</span>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-right text-xs text-slate-400"></i>
                </a>

                <a href="{{ route('admin.logs') }}" class="p-3.5 rounded-xl bg-slate-50 hover:bg-emerald-50 border border-slate-200 hover:border-emerald-200 flex items-center justify-between text-slate-700 hover:text-emerald-800 transition">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold">
                            <i class="fa-solid fa-clock-rotate-left text-xs"></i>
                        </div>
                        <div>
                            <span class="font-bold block text-slate-900">Audit Trail System</span>
                            <span class="text-[10px] text-slate-500">Log aktivitas realtime seluruh user</span>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-right text-xs text-slate-400"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
