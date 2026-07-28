@extends('layouts.user')

@section('user-content')
<!-- Komentar Bahasa Indonesia: Dashboard Keuangan Utama Pengguna (Horizon Slate Edition) -->
<div x-data="{
    selectedMonth: 'Juli',
    selectedYear: '2026',
    
    // Data Arus Kas per Bulan (Ringkasan Keuangan)
    monthlyData: {
        'Juli': { income: 10959540, expenses: 10722830, expected: 236710, missing: 236710, burnRate: '97.8%' },
        'Juni': { income: 2309776, expenses: 2179900, expected: 129876, missing: 13101, burnRate: '94.3%' },
        'Mei': { income: 2451319, expenses: 2398163, expected: 53156, missing: 43380, burnRate: '97.8%' }
    },

    // Kategori Pengeluaran & Progress Realisasi Budget
    categories: [
        { name: 'Makanan', pct: 40, alokasi: 4383816, realisasi: 1129645, icon: 'fa-utensils' },
        { name: 'Belanja', pct: 10, alokasi: 1095954, realisasi: 147300, icon: 'fa-bag-shopping' },
        { name: 'Tabungan', pct: 0, alokasi: 0, realisasi: 4099765, icon: 'fa-piggy-bank' },
        { name: 'Hiburan', pct: 8, alokasi: 876763, realisasi: 52500, icon: 'fa-gamepad' },
        { name: 'Kendaraan', pct: 10, alokasi: 1095954, realisasi: 5000, icon: 'fa-motorcycle' },
        { name: 'Admin', pct: 2, alokasi: 219191, realisasi: 19000, icon: 'fa-receipt' },
        { name: 'Dana HP', pct: 15, alokasi: 1643931, realisasi: 5269620, icon: 'fa-mobile-screen' }
    ],

    // Helper Format Angka Mata Uang Rupiah (Rp)
    formatRp(val) {
        return 'Rp ' + Number(val).toLocaleString('id-ID');
    },

    // Inisialisasi Grafik Chart.js Visual Diagram Horizon
    initCharts() {
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
                            backgroundColor: '#059669',
                            borderRadius: 8
                        },
                        {
                            label: 'Pengeluaran (Expense)',
                            data: [3563655, 2173300, 5891300, 2124727, 2398163, 2179900, 10722830],
                            backgroundColor: '#e11d48',
                            borderRadius: 8
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { labels: { color: '#475569', font: { family: 'Plus Jakarta Sans', size: 11, weight: '700' } } }
                    },
                    scales: {
                        x: { ticks: { color: '#64748b' }, grid: { color: '#f1f5f9' } },
                        y: { ticks: { color: '#64748b' }, grid: { color: '#f1f5f9' } }
                    }
                }
            });
        }

        const ctxPie = document.getElementById('chartCategoryPie');
        if (ctxPie) {
            new Chart(ctxPie, {
                type: 'doughnut',
                data: {
                    labels: ['Makanan (40%)', 'Belanja (10%)', 'Dana HP (15%)', 'Kendaraan (10%)', 'Hiburan (8%)', 'Admin (2%)'],
                    datasets: [{
                        data: [4383816, 1095954, 1643931, 1095954, 876763, 219191],
                        backgroundColor: [
                            '#059669', '#0284c7', '#e11d48', '#0d9488', '#7c3aed', '#64748b'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom', labels: { color: '#475569', font: { family: 'Plus Jakarta Sans', size: 10 } } }
                    }
                }
            });
        }
    }
}" x-init="$nextTick(() => initCharts())" class="space-y-6">

    <!-- Header Halaman & Controls -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 rounded-full bg-emerald-100 border border-emerald-200 text-emerald-800 text-[11px] font-extrabold uppercase font-mono">Horizon System</span>
                <span class="text-slate-400">•</span>
                <span class="text-xs text-slate-500 font-bold">Ringkasan Finansial</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mt-1">Dashboard Rekap Keuangan</h1>
        </div>

        <div class="flex items-center gap-3">
            <select x-model="selectedMonth" class="horizon-input cursor-pointer font-bold">
                <option value="Juli">Juli 2026</option>
                <option value="Juni">Juni 2026</option>
                <option value="Mei">Mei 2026</option>
            </select>

            <a href="{{ route('user.expenses') }}" class="horizon-btn-primary">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>Catat Transaksi</span>
            </a>
        </div>
    </div>

    <!-- 4 KARTU METRIK KEUANGAN UTAMA -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Total Pemasukan -->
        <div class="horizon-card p-6 space-y-3 border-l-4 border-l-emerald-600">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500">Total Pemasukan</span>
                <span class="w-9 h-9 rounded-2xl bg-emerald-50 text-emerald-700 font-bold text-xs flex items-center justify-center shadow-xs">
                    <i class="fa-solid fa-arrow-down-left"></i>
                </span>
            </div>
            <div class="text-2xl font-extrabold text-slate-900 font-mono" x-text="formatRp(monthlyData[selectedMonth] ? monthlyData[selectedMonth].income : 0)"></div>
            <div class="flex items-center justify-between text-xs text-slate-500 pt-1 border-t border-slate-100 font-medium">
                <span>Pemasukan Terdaftar</span>
                <a href="{{ route('user.income') }}" class="text-emerald-700 font-extrabold hover:underline">Kelola →</a>
            </div>
        </div>

        <!-- Total Pengeluaran -->
        <div class="horizon-card p-6 space-y-3 border-l-4 border-l-rose-600">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500">Total Pengeluaran</span>
                <span class="w-9 h-9 rounded-2xl bg-rose-50 text-rose-700 font-bold text-xs flex items-center justify-center shadow-xs">
                    <i class="fa-solid fa-arrow-up-right"></i>
                </span>
            </div>
            <div class="text-2xl font-extrabold text-slate-900 font-mono" x-text="formatRp(monthlyData[selectedMonth] ? monthlyData[selectedMonth].expenses : 0)"></div>
            <div class="flex items-center justify-between text-xs text-slate-500 pt-1 border-t border-slate-100 font-medium">
                <span>Realisasi Kas</span>
                <a href="{{ route('user.expenses') }}" class="text-rose-700 font-extrabold hover:underline">Rincian →</a>
            </div>
        </div>

        <!-- Saldo Seharusnya -->
        <div class="horizon-card p-6 space-y-3 border-l-4 border-l-sky-600">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500">Saldo Seharusnya</span>
                <span class="w-9 h-9 rounded-2xl bg-sky-50 text-sky-700 font-bold text-xs flex items-center justify-center shadow-xs">
                    <i class="fa-solid fa-wallet"></i>
                </span>
            </div>
            <div class="text-2xl font-extrabold text-slate-900 font-mono" x-text="formatRp(monthlyData[selectedMonth] ? monthlyData[selectedMonth].expected : 0)"></div>
            <div class="text-xs text-slate-500 pt-1 border-t border-slate-100 font-medium">
                Kas Bersih (Income - Expense)
            </div>
        </div>

        <!-- Missing Cash Selisih -->
        <div class="horizon-card p-6 space-y-3 border-l-4 border-l-amber-500 bg-amber-50/40">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-amber-900">Missing Cash Selisih</span>
                <span class="w-9 h-9 rounded-2xl bg-amber-100 text-amber-800 font-bold text-xs flex items-center justify-center shadow-xs">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </span>
            </div>
            <div class="text-2xl font-extrabold text-amber-900 font-mono" x-text="formatRp(monthlyData[selectedMonth] ? monthlyData[selectedMonth].missing : 0)"></div>
            <div class="text-xs text-amber-800 font-bold pt-1 border-t border-amber-200">
                Perlu Audit Rekonsiliasi Kas
            </div>
        </div>
    </div>

    <!-- AREA DIAGRAM CHART.JS VISUAL -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Diagram Batang: Tren Arus Kas -->
        <div class="lg:col-span-2 horizon-card p-6 space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                <div>
                    <h2 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-chart-column text-emerald-600 text-sm"></i>
                        <span>Grafik Arus Kas Bulanan (2026)</span>
                    </h2>
                    <p class="text-xs text-slate-500 mt-0.5">Perbandingan arus masuk dan arus keluar per bulan.</p>
                </div>
                <span class="px-3 py-1 rounded-full bg-slate-100 border border-slate-200 text-slate-700 text-xs font-mono font-bold">Chart.js Engine</span>
            </div>

            <div class="h-64 relative">
                <canvas id="chartIncomeExpense"></canvas>
            </div>
        </div>

        <!-- Diagram Donut: Distribusi Budget -->
        <div class="horizon-card p-6 space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                <div>
                    <h2 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-chart-pie text-sky-600 text-sm"></i>
                        <span>Distribusi Alokasi Kategori</span>
                    </h2>
                    <p class="text-xs text-slate-500 mt-0.5">Persentase anggaran per kategori.</p>
                </div>
                <a href="{{ route('user.categories') }}" class="text-xs text-sky-700 font-extrabold hover:underline">Kelola % →</a>
            </div>

            <div class="h-64 relative">
                <canvas id="chartCategoryPie"></canvas>
            </div>
        </div>
    </div>

    <!-- PROGRES REALISASI BUDGET KATEGORI -->
    <div class="horizon-card p-6 space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-200">
            <div>
                <h2 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-sliders text-emerald-600 text-sm"></i>
                    <span>Progres Target Alokasi Budget Kategori (Juli 2026)</span>
                </h2>
                <p class="text-xs text-slate-500 mt-0.5">Pemantauan konsumsi budget per kategori pengeluaran.</p>
            </div>
            <a href="{{ route('user.categories') }}" class="horizon-btn-secondary">
                <span>Atur Kategori & Budget</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <template x-for="c in categories" :key="c.name">
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-xl bg-white border border-slate-200 text-emerald-600 flex items-center justify-center text-xs shadow-xs font-bold">
                                <i :class="'fa-solid ' + c.icon"></i>
                            </div>
                            <span class="text-xs font-bold text-slate-900" x-text="c.name"></span>
                        </div>
                        <span class="text-xs font-mono font-bold text-slate-500" x-text="'Target: ' + c.pct + '%'"></span>
                    </div>

                    <div class="space-y-1.5">
                        <div class="flex justify-between text-xs font-semibold">
                            <span class="text-slate-500">Realisasi: <strong class="text-slate-900" x-text="formatRp(c.realisasi)"></strong></span>
                            <span class="text-slate-500">Target: <strong class="text-slate-700" x-text="formatRp(c.alokasi)"></strong></span>
                        </div>
                        
                        <div class="w-full h-2 rounded-full bg-slate-200 overflow-hidden relative">
                            <div class="h-full rounded-full transition-all duration-300"
                                 :class="c.realisasi > c.alokasi && c.alokasi > 0 ? 'bg-rose-500' : 'bg-emerald-600'"
                                 :style="'width: ' + Math.min((c.realisasi / (c.alokasi || 1)) * 100, 100) + '%'">
                            </div>
                        </div>

                        <div class="flex justify-between text-[11px] pt-0.5">
                            <span x-text="c.alokasi > 0 ? ((c.realisasi / c.alokasi) * 100).toFixed(1) + '% Terpakai' : 'Pengeluaran Langsung'" class="text-slate-500 font-medium"></span>
                            <span x-text="c.alokasi - c.realisasi >= 0 ? 'Sisa ' + formatRp(c.alokasi - c.realisasi) : 'Defisit ' + formatRp(c.realisasi - c.alokasi)"
                                  :class="c.alokasi - c.realisasi < 0 ? 'text-rose-600 font-extrabold' : 'text-emerald-700 font-extrabold'"></span>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>
@endsection
