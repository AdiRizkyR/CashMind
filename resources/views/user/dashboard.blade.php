@extends('layouts.user')

@section('user-content')
<div x-data="{
    selectedMonth: 'Juli',
    selectedYear: '2026',
    
    monthlyData: {
        'Juli': { income: 10959540, expenses: 10722830, expected: 236710, missing: 236710 },
        'Juni': { income: 2309776, expenses: 2179900, expected: 129876, missing: 13101 },
        'Mei': { income: 2451319, expenses: 2398163, expected: 53156, missing: 43380 }
    },

    formatRp(val) {
        return 'Rp ' + Number(val).toLocaleString('id-ID');
    },

    initCharts() {
        // Chart 1: Bar Chart Trend Pemasukan vs Pengeluaran 2026
        const ctxBar = document.getElementById('chartIncomeExpense');
        if (ctxBar) {
            new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul'],
                    datasets: [
                        {
                            label: 'Pemasukan (Income)',
                            data: [4035594, 2386962, 6210023, 2299497, 2451319, 2309776, 10959540],
                            backgroundColor: 'rgba(16, 185, 129, 0.85)',
                            borderRadius: 8
                        },
                        {
                            label: 'Pengeluaran (Realisasi)',
                            data: [3563655, 2173300, 5891300, 2124727, 2398163, 2179900, 10722830],
                            backgroundColor: 'rgba(244, 63, 94, 0.85)',
                            borderRadius: 8
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { labels: { color: '#94a3b8', font: { family: 'Plus Jakarta Sans', size: 11 } } }
                    },
                    scales: {
                        x: { ticks: { color: '#94a3b8' }, grid: { color: '#1e293b' } },
                        y: { ticks: { color: '#94a3b8' }, grid: { color: '#1e293b' } }
                    }
                }
            });
        }

        // Chart 2: Doughnut Chart Distribusi Budget per Kategori
        const ctxPie = document.getElementById('chartCategoryPie');
        if (ctxPie) {
            new Chart(ctxPie, {
                type: 'doughnut',
                data: {
                    labels: ['Makanan (40%)', 'Belanja (10%)', 'Dana HP (15%)', 'Kendaraan (10%)', 'Dilla (10%)', 'Hiburan (8%)', 'Sosial (5%)', 'Admin (2%)'],
                    datasets: [{
                        data: [4383816, 1095954, 1643931, 1095954, 1095954, 876763, 547977, 219191],
                        backgroundColor: [
                            '#10b981', '#0284c7', '#f43f5e', '#14b8a6', '#6366f1', '#8b5cf6', '#f59e0b', '#64748b'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom', labels: { color: '#94a3b8', font: { family: 'Plus Jakarta Sans', size: 10 } } }
                    }
                }
            });
        }
    }
}" x-init="$nextTick(() => initCharts())" class="space-y-8">
    
    <!-- Top Banner -->
    <div class="bg-slate-900/90 p-6 sm:p-8 rounded-3xl border border-slate-800 shadow-xl flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-400 text-[11px] font-bold uppercase tracking-wider">Rekapitulasi Kas</span>
                <span class="text-slate-500">•</span>
                <span class="text-xs text-slate-400 font-medium">Bulan: Juli 2026</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white mt-1">Dashboard Rekap Pemasukan & Pengeluaran</h1>
            <p class="text-xs text-slate-400 mt-1">Ringkasan grafik diagram arus kas mandiri per bulan, alokasi budget, dan penyesuaian selisih saldo.</p>
        </div>

        <div class="flex items-center gap-3">
            <select x-model="selectedMonth" class="bg-slate-800 text-white text-xs font-bold px-4 py-2.5 rounded-xl border border-slate-700 focus:ring-2 focus:ring-emerald-500 cursor-pointer">
                <option value="Juli">Bulan: Juli 2026</option>
                <option value="Juni">Bulan: Juni 2026</option>
                <option value="Mei">Bulan: Mei 2026</option>
            </select>
        </div>
    </div>

    <!-- 4 Key Financial KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="p-6 rounded-3xl bg-slate-900/90 border border-slate-800 shadow-xl">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Pemasukan</span>
                <div class="w-10 h-10 rounded-2xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center font-bold">
                    <i class="fa-solid fa-arrow-down-left"></i>
                </div>
            </div>
            <div class="text-2xl font-extrabold text-white" x-text="formatRp(monthlyData[selectedMonth] ? monthlyData[selectedMonth].income : 0)"></div>
            <div class="mt-3 flex items-center justify-between text-[11px] text-slate-400 pt-3 border-t border-slate-800">
                <span>Pemasukan Bulan Ini</span>
                <a href="{{ route('user.income') }}" class="text-emerald-400 font-bold hover:underline">Kelola Income →</a>
            </div>
        </div>

        <div class="p-6 rounded-3xl bg-slate-900/90 border border-slate-800 shadow-xl">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Pengeluaran</span>
                <div class="w-10 h-10 rounded-2xl bg-rose-500/10 text-rose-400 flex items-center justify-center font-bold">
                    <i class="fa-solid fa-arrow-up-right"></i>
                </div>
            </div>
            <div class="text-2xl font-extrabold text-white" x-text="formatRp(monthlyData[selectedMonth] ? monthlyData[selectedMonth].expenses : 0)"></div>
            <div class="mt-3 flex items-center justify-between text-[11px] text-slate-400 pt-3 border-t border-slate-800">
                <span>Pengeluaran Harian</span>
                <a href="{{ route('user.expenses') }}" class="text-rose-400 font-bold hover:underline">Kelola Transaksi →</a>
            </div>
        </div>

        <div class="p-6 rounded-3xl bg-slate-900/90 border border-slate-800 shadow-xl">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Saldo Seharusnya</span>
                <div class="w-10 h-10 rounded-2xl bg-sky-500/10 text-sky-400 flex items-center justify-center font-bold">
                    <i class="fa-solid fa-wallet"></i>
                </div>
            </div>
            <div class="text-2xl font-extrabold text-white" x-text="formatRp(monthlyData[selectedMonth] ? monthlyData[selectedMonth].expected : 0)"></div>
            <div class="mt-3 text-[11px] text-sky-400 pt-3 border-t border-slate-800 font-semibold">
                Sisa Kas Pemasukan - Pengeluaran
            </div>
        </div>

        <div class="p-6 rounded-3xl bg-amber-500/10 border border-amber-500/30 shadow-xl">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-amber-400 uppercase tracking-wider">Status Missing Cash</span>
                <div class="w-10 h-10 rounded-2xl bg-amber-500/20 text-amber-400 flex items-center justify-center font-bold">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
            </div>
            <div class="text-2xl font-extrabold text-amber-300" x-text="formatRp(monthlyData[selectedMonth] ? monthlyData[selectedMonth].missing : 0)"></div>
            <div class="mt-3 text-[11px] text-amber-400/90 pt-3 border-t border-amber-500/20 font-semibold">
                Selisih Belum Ter-audit
            </div>
        </div>
    </div>

    <!-- INTERACTIVE DIAGRAMS SECTION -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- DIAGRAM 1: Bar Chart Trend Pemasukan vs Pengeluaran -->
        <div class="lg:col-span-2 bg-slate-900/90 p-6 rounded-3xl border border-slate-800 shadow-xl space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-800">
                <div>
                    <h2 class="text-base font-bold text-white flex items-center gap-2">
                        <i class="fa-solid fa-chart-column text-emerald-400"></i>
                        <span>Diagram Trend Pemasukan vs Pengeluaran (2026)</span>
                    </h2>
                    <p class="text-xs text-slate-400 mt-0.5">Perbandingan total pemasukan dan pengeluaran per bulan.</p>
                </div>
                <span class="px-3 py-1 rounded-xl bg-slate-800 text-emerald-400 text-xs font-bold">Chart.js</span>
            </div>

            <!-- Canvas Chart Bar Container -->
            <div class="h-64 relative">
                <canvas id="chartIncomeExpense"></canvas>
            </div>
        </div>

        <!-- DIAGRAM 2: Doughnut Chart Distribusi Budget per Kategori -->
        <div class="bg-slate-900/90 p-6 rounded-3xl border border-slate-800 shadow-xl space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-800">
                <div>
                    <h2 class="text-base font-bold text-white flex items-center gap-2">
                        <i class="fa-solid fa-chart-pie text-sky-400"></i>
                        <span>Diagram Distribusi Budget Kategori</span>
                    </h2>
                    <p class="text-xs text-slate-400 mt-0.5">Persentase alokasi per kategori.</p>
                </div>
                <a href="{{ route('user.categories') }}" class="text-xs text-sky-400 font-bold hover:underline">Edit % →</a>
            </div>

            <!-- Canvas Chart Pie Container -->
            <div class="h-64 relative">
                <canvas id="chartCategoryPie"></canvas>
            </div>
        </div>
    </div>

    <!-- Quick Navigation Banner for User Actions -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <a href="{{ route('user.income') }}" class="p-5 rounded-3xl bg-slate-900/90 hover:bg-slate-850 border border-slate-800 transition space-y-2 group">
            <div class="w-10 h-10 rounded-2xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center font-bold text-base group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-hand-holding-dollar"></i>
            </div>
            <h3 class="font-bold text-white text-sm">Catat Pemasukan</h3>
            <p class="text-[11px] text-slate-400">Gaji, Side Job, & Tabungan</p>
        </a>

        <a href="{{ route('user.expenses') }}" class="p-5 rounded-3xl bg-slate-900/90 hover:bg-slate-850 border border-slate-800 transition space-y-2 group">
            <div class="w-10 h-10 rounded-2xl bg-rose-500/10 text-rose-400 flex items-center justify-center font-bold text-base group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-receipt"></i>
            </div>
            <h3 class="font-bold text-white text-sm">Catat Pengeluaran</h3>
            <p class="text-[11px] text-slate-400">Pengeluaran Cash & Bank</p>
        </a>

        <a href="{{ route('user.categories') }}" class="p-5 rounded-3xl bg-slate-900/90 hover:bg-slate-850 border border-slate-800 transition space-y-2 group">
            <div class="w-10 h-10 rounded-2xl bg-sky-500/10 text-sky-400 flex items-center justify-center font-bold text-base group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-sliders"></i>
            </div>
            <h3 class="font-bold text-white text-sm">Atur Kategori & %</h3>
            <p class="text-[11px] text-slate-400">Persentase Target Budget</p>
        </a>

        <a href="{{ route('user.reports') }}" class="p-5 rounded-3xl bg-slate-900/90 hover:bg-slate-850 border border-slate-800 transition space-y-2 group">
            <div class="w-10 h-10 rounded-2xl bg-amber-500/10 text-amber-400 flex items-center justify-center font-bold text-base group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-file-invoice-dollar"></i>
            </div>
            <h3 class="font-bold text-white text-sm">Cetak Laporan PDF</h3>
            <p class="text-[11px] text-slate-400">Laporan Per Bulan/Tahun</p>
        </a>
    </div>
</div>
@endsection
