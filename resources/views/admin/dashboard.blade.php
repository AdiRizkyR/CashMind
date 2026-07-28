@extends('layouts.admin')

@section('admin-content')
<div class="space-y-6">
    
    <!-- Page Title & Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-zinc-100 tracking-tight">Trafik & System Analytics</h1>
            <p class="text-xs text-zinc-400 mt-0.5">Monitoring aktivitas pengguna harian, volume transaksi, dan kesehatan platform.</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.users') }}" class="saas-btn-primary bg-amber-500 hover:bg-amber-400 text-zinc-950 flex items-center gap-1.5">
                <i class="fa-solid fa-users-gear text-[10px]"></i>
                <span>Direktori User</span>
            </a>
        </div>
    </div>

    <!-- 4 Key Admin Metric Cards (Vercel Analytics Style) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="saas-card p-5 space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-medium text-zinc-400">Total User Terdaftar</span>
                <span class="p-1.5 rounded-md bg-amber-500/10 text-amber-400 text-xs">
                    <i class="fa-solid fa-users"></i>
                </span>
            </div>
            <div class="text-2xl font-bold text-zinc-100 font-mono">1.482</div>
            <div class="text-[11px] text-emerald-400 font-medium flex items-center gap-1">
                <i class="fa-solid fa-arrow-trend-up text-[10px]"></i> +12 User Baru Minggu Ini
            </div>
        </div>

        <div class="saas-card p-5 space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-medium text-zinc-400">User Aktif Harian</span>
                <span class="p-1.5 rounded-md bg-emerald-500/10 text-emerald-400 text-xs">
                    <i class="fa-solid fa-chart-line"></i>
                </span>
            </div>
            <div class="text-2xl font-bold text-emerald-400 font-mono">842 Active</div>
            <div class="text-[11px] text-zinc-500">Puncak Trafik: 20:00 - 22:00</div>
        </div>

        <div class="saas-card p-5 space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-medium text-zinc-400">Total Transaksi System</span>
                <span class="p-1.5 rounded-md bg-sky-500/10 text-sky-400 text-xs">
                    <i class="fa-solid fa-list-check"></i>
                </span>
            </div>
            <div class="text-2xl font-bold text-zinc-100 font-mono">48.290</div>
            <div class="text-[11px] text-sky-400 font-medium">Tercatat di Database</div>
        </div>

        <div class="saas-card p-5 space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-medium text-zinc-400">Volume Arus Kas</span>
                <span class="p-1.5 rounded-md bg-purple-500/10 text-purple-400 text-xs">
                    <i class="fa-solid fa-money-bill-transfer"></i>
                </span>
            </div>
            <div class="text-2xl font-bold text-zinc-100 font-mono">Rp 4.28 M</div>
            <div class="text-[11px] text-zinc-500">Volume Terproses 2026</div>
        </div>
    </div>

    <!-- Traffic & Quick Access Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Live Traffic Activity Bar Graph Visual -->
        <div class="lg:col-span-2 saas-card p-6 space-y-5">
            <div class="flex items-center justify-between pb-3 border-b border-zinc-800/80">
                <div>
                    <h2 class="text-sm font-semibold text-zinc-200 flex items-center gap-2">
                        <i class="fa-solid fa-chart-simple text-amber-400 text-xs"></i>
                        <span>Aktivitas Pengguna Harian (7 Hari Terakhir)</span>
                    </h2>
                    <p class="text-[11px] text-zinc-400 mt-0.5">Jumlah sesi transaksi & pengaksesan platform per hari.</p>
                </div>
                <span class="px-2 py-0.5 rounded bg-zinc-800 text-amber-400 text-[10px] font-mono">Live Analytics</span>
            </div>

            <!-- Visual Bar Chart -->
            <div class="h-44 flex items-end justify-between gap-3 pt-4 px-2">
                <div class="flex-1 flex flex-col items-center gap-2">
                    <span class="text-[10px] text-zinc-500 font-mono">420</span>
                    <div class="w-full bg-amber-500/20 hover:bg-amber-500/40 rounded-t-md transition-all" style="height: 60%"></div>
                    <span class="text-[10px] text-zinc-500 font-mono">Sen</span>
                </div>
                <div class="flex-1 flex flex-col items-center gap-2">
                    <span class="text-[10px] text-zinc-500 font-mono">580</span>
                    <div class="w-full bg-amber-500/30 hover:bg-amber-500/50 rounded-t-md transition-all" style="height: 75%"></div>
                    <span class="text-[10px] text-zinc-500 font-mono">Sel</span>
                </div>
                <div class="flex-1 flex flex-col items-center gap-2">
                    <span class="text-[10px] text-zinc-500 font-mono">710</span>
                    <div class="w-full bg-amber-500/50 hover:bg-amber-500/70 rounded-t-md transition-all" style="height: 85%"></div>
                    <span class="text-[10px] text-zinc-500 font-mono">Rab</span>
                </div>
                <div class="flex-1 flex flex-col items-center gap-2">
                    <span class="text-[10px] text-zinc-500 font-mono">640</span>
                    <div class="w-full bg-amber-500/40 hover:bg-amber-500/60 rounded-t-md transition-all" style="height: 78%"></div>
                    <span class="text-[10px] text-zinc-500 font-mono">Kam</span>
                </div>
                <div class="flex-1 flex flex-col items-center gap-2">
                    <span class="text-[10px] text-zinc-500 font-mono">890</span>
                    <div class="w-full bg-amber-500/70 hover:bg-amber-500/90 rounded-t-md transition-all" style="height: 95%"></div>
                    <span class="text-[10px] text-zinc-500 font-mono">Jum</span>
                </div>
                <div class="flex-1 flex flex-col items-center gap-2">
                    <span class="text-[10px] text-amber-400 font-mono font-bold">950</span>
                    <div class="w-full bg-amber-400 rounded-t-md" style="height: 100%"></div>
                    <span class="text-[10px] text-amber-400 font-mono font-bold">Sab</span>
                </div>
                <div class="flex-1 flex flex-col items-center gap-2">
                    <span class="text-[10px] text-zinc-500 font-mono">842</span>
                    <div class="w-full bg-amber-500/60 hover:bg-amber-500/80 rounded-t-md transition-all" style="height: 90%"></div>
                    <span class="text-[10px] text-zinc-500 font-mono">Min</span>
                </div>
            </div>
        </div>

        <!-- Quick Access Card -->
        <div class="saas-card p-6 space-y-4">
            <h2 class="text-sm font-semibold text-zinc-200 pb-3 border-b border-zinc-800/80">Menu Pengawasan Admin</h2>

            <div class="space-y-3 text-xs">
                <a href="{{ route('admin.users') }}" class="p-3.5 rounded-xl bg-zinc-950/60 hover:bg-zinc-900 border border-zinc-800/80 flex items-center justify-between text-zinc-300 hover:text-amber-400 transition">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-amber-500/10 text-amber-400 flex items-center justify-center">
                            <i class="fa-solid fa-users-gear text-xs"></i>
                        </div>
                        <div>
                            <span class="font-semibold block text-zinc-200">Direktori User</span>
                            <span class="text-[10px] text-zinc-500">Tinjau profil & statistik kas user</span>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-right text-xs text-zinc-600"></i>
                </a>

                <a href="{{ route('admin.logs') }}" class="p-3.5 rounded-xl bg-zinc-950/60 hover:bg-zinc-900 border border-zinc-800/80 flex items-center justify-between text-zinc-300 hover:text-amber-400 transition">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-emerald-500/10 text-emerald-400 flex items-center justify-center">
                            <i class="fa-solid fa-clock-rotate-left text-xs"></i>
                        </div>
                        <div>
                            <span class="font-semibold block text-zinc-200">Audit Trail System</span>
                            <span class="text-[10px] text-zinc-500">Log aktivitas realtime seluruh user</span>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-right text-xs text-zinc-600"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
