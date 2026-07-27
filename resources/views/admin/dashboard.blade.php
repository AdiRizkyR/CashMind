@extends('layouts.admin')

@section('admin-content')
<div class="space-y-8">
    
    <!-- Top Admin Header -->
    <div class="bg-slate-900/90 p-6 sm:p-8 rounded-3xl border border-slate-800 shadow-xl flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-1 rounded-full bg-amber-500/10 text-amber-400 text-[11px] font-bold uppercase tracking-wider">Trafik System</span>
                <span class="text-slate-500">•</span>
                <span class="text-xs text-slate-400 font-medium">Monitoring Platform</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white mt-1">Trafik & Analytics Aktivitas Pengguna</h1>
            <p class="text-xs text-slate-400 mt-1">Pengawasan lalu lintas platform, penggunaan fitur oleh pengguna, dan statistik transaksi keseluruhan.</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.users') }}" class="px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs shadow-lg shadow-amber-500/20 transition flex items-center gap-2">
                <i class="fa-solid fa-users-gear text-xs"></i>
                <span>Lihat Detail Users</span>
            </a>
        </div>
    </div>

    <!-- 4 Key System Traffic Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="p-6 rounded-3xl bg-slate-900/90 border border-slate-800 shadow-xl">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total User Terdaftar</span>
                <div class="w-10 h-10 rounded-2xl bg-amber-500/10 text-amber-400 flex items-center justify-center font-bold">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
            <div class="text-2xl font-extrabold text-white">1.482 User</div>
            <div class="text-[11px] text-emerald-400 mt-2 flex items-center gap-1">
                <i class="fa-solid fa-arrow-trend-up"></i> +12 User Baru Minggu Ini
            </div>
        </div>

        <div class="p-6 rounded-3xl bg-slate-900/90 border border-slate-800 shadow-xl">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Trafik User Aktif Harian</span>
                <div class="w-10 h-10 rounded-2xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center font-bold">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
            </div>
            <div class="text-2xl font-extrabold text-emerald-400">842 Active Today</div>
            <div class="text-[11px] text-slate-400 mt-2">Puncak trafik: 20:00 - 22:00</div>
        </div>

        <div class="p-6 rounded-3xl bg-slate-900/90 border border-slate-800 shadow-xl">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Transaksi System</span>
                <div class="w-10 h-10 rounded-2xl bg-sky-500/10 text-sky-400 flex items-center justify-center font-bold">
                    <i class="fa-solid fa-list-check"></i>
                </div>
            </div>
            <div class="text-2xl font-extrabold text-white">48.290 Transaksi</div>
            <div class="text-[11px] text-sky-400 mt-2">Di seluruh akun user</div>
        </div>

        <div class="p-6 rounded-3xl bg-slate-900/90 border border-slate-800 shadow-xl">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Volume Arus Kas Terproses</span>
                <div class="w-10 h-10 rounded-2xl bg-purple-500/10 text-purple-400 flex items-center justify-center font-bold">
                    <i class="fa-solid fa-money-bill-transfer"></i>
                </div>
            </div>
            <div class="text-2xl font-extrabold text-purple-300">Rp 4.28 Milyar</div>
            <div class="text-[11px] text-slate-400 mt-2">Total Volume Kas 2026</div>
        </div>
    </div>

    <!-- Traffic & User Activity Visual Cards Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- System Traffic Activity Bar Graph Visual -->
        <div class="lg:col-span-2 bg-slate-900/90 p-6 rounded-3xl border border-slate-800 shadow-xl space-y-6">
            <div class="flex items-center justify-between pb-4 border-b border-slate-800">
                <div>
                    <h2 class="text-base font-bold text-white flex items-center gap-2">
                        <i class="fa-solid fa-chart-simple text-amber-400"></i>
                        <span>Grafik Trafik Aktivitas Pengguna (7 Hari Terakhir)</span>
                    </h2>
                    <p class="text-xs text-slate-400 mt-0.5">Jumlah aksi transaksi & login per hari.</p>
                </div>
                <span class="px-3 py-1 rounded-xl bg-slate-800 text-amber-400 text-xs font-bold">Live Stats</span>
            </div>

            <!-- Visual Bar Chart -->
            <div class="h-48 flex items-end justify-between gap-3 pt-6 px-4">
                <div class="flex-1 flex flex-col items-center gap-2">
                    <span class="text-[10px] text-slate-400 font-bold">420</span>
                    <div class="w-full bg-amber-500/30 hover:bg-amber-500 rounded-t-xl transition-all" style="height: 60%"></div>
                    <span class="text-[10px] text-slate-400">Sen</span>
                </div>
                <div class="flex-1 flex flex-col items-center gap-2">
                    <span class="text-[10px] text-slate-400 font-bold">580</span>
                    <div class="w-full bg-amber-500/40 hover:bg-amber-500 rounded-t-xl transition-all" style="height: 75%"></div>
                    <span class="text-[10px] text-slate-400">Sel</span>
                </div>
                <div class="flex-1 flex flex-col items-center gap-2">
                    <span class="text-[10px] text-slate-400 font-bold">710</span>
                    <div class="w-full bg-amber-500/60 hover:bg-amber-500 rounded-t-xl transition-all" style="height: 85%"></div>
                    <span class="text-[10px] text-slate-400">Rab</span>
                </div>
                <div class="flex-1 flex flex-col items-center gap-2">
                    <span class="text-[10px] text-slate-400 font-bold">640</span>
                    <div class="w-full bg-amber-500/50 hover:bg-amber-500 rounded-t-xl transition-all" style="height: 78%"></div>
                    <span class="text-[10px] text-slate-400">Kam</span>
                </div>
                <div class="flex-1 flex flex-col items-center gap-2">
                    <span class="text-[10px] text-slate-400 font-bold">890</span>
                    <div class="w-full bg-amber-500/80 hover:bg-amber-500 rounded-t-xl transition-all" style="height: 95%"></div>
                    <span class="text-[10px] text-slate-400">Jum</span>
                </div>
                <div class="flex-1 flex flex-col items-center gap-2">
                    <span class="text-[10px] text-slate-400 font-bold">950</span>
                    <div class="w-full bg-amber-400 rounded-t-xl shadow-lg shadow-amber-500/20" style="height: 100%"></div>
                    <span class="text-[10px] text-amber-400 font-bold">Sab</span>
                </div>
                <div class="flex-1 flex flex-col items-center gap-2">
                    <span class="text-[10px] text-slate-400 font-bold">842</span>
                    <div class="w-full bg-amber-500/70 hover:bg-amber-500 rounded-t-xl transition-all" style="height: 90%"></div>
                    <span class="text-[10px] text-slate-400">Min</span>
                </div>
            </div>
        </div>

        <!-- Quick Admin Links Card -->
        <div class="bg-slate-900/90 p-6 rounded-3xl border border-slate-800 shadow-xl space-y-4">
            <h2 class="text-base font-bold text-white border-b border-slate-800 pb-3">Akses Cepat Monitoring Admin</h2>

            <div class="space-y-3">
                <a href="{{ route('admin.users') }}" class="p-4 rounded-2xl bg-slate-950/60 hover:bg-slate-800 border border-slate-800 flex items-center justify-between text-xs font-bold text-slate-200 hover:text-amber-400 transition">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-amber-500/10 text-amber-400 flex items-center justify-center">
                            <i class="fa-solid fa-users-gear"></i>
                        </div>
                        <div>
                            <span>Direktori & Detail User</span>
                            <span class="text-[10px] text-slate-400 block font-normal">Tinjau profil & statistik kas user</span>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-right text-xs text-slate-500"></i>
                </a>

                <a href="{{ route('admin.logs') }}" class="p-4 rounded-2xl bg-slate-950/60 hover:bg-slate-800 border border-slate-800 flex items-center justify-between text-xs font-bold text-slate-200 hover:text-amber-400 transition">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                        </div>
                        <div>
                            <span>Aktivitas & Audit Trail</span>
                            <span class="text-[10px] text-slate-400 block font-normal">Log aktivitas realtime seluruh user</span>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-right text-xs text-slate-500"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
