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

    categories: [
        { name: 'Makanan', pct: 40, alokasi: 4383816, realisasi: 1129645, icon: 'fa-utensils' },
        { name: 'Belanja', pct: 10, alokasi: 1095954, realisasi: 147300, icon: 'fa-bag-shopping' },
        { name: 'Tabungan', pct: 0, alokasi: 0, realisasi: 4099765, icon: 'fa-piggy-bank' },
        { name: 'Hiburan', pct: 8, alokasi: 876763, realisasi: 52500, icon: 'fa-gamepad' },
        { name: 'Kendaraan', pct: 10, alokasi: 1095954, realisasi: 5000, icon: 'fa-motorcycle' },
        { name: 'Admin', pct: 2, alokasi: 219191, realisasi: 19000, icon: 'fa-receipt' },
        { name: 'Dana HP', pct: 15, alokasi: 1643931, realisasi: 5269620, icon: 'fa-mobile-screen' }
    ],

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
                            label: 'Pemasukan',
                            data: [4035594, 2386962, 6210023, 2299497, 2451319, 2309776, 10959540],
                            backgroundColor: '#10b981',
                            borderRadius: 4
                        },
                        {
                            label: 'Pengeluaran',
                            data: [3563655, 2173300, 5891300, 2124727, 2398163, 2179900, 10722830],
                            backgroundColor: '#f43f5e',
                            borderRadius: 4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { labels: { color: '#a1a1aa', font: { family: 'Plus Jakarta Sans', size: 11 } } }
                    },
                    scales: {
                        x: { ticks: { color: '#71717a' }, grid: { color: '#181926' } },
                        y: { ticks: { color: '#71717a' }, grid: { color: '#181926' } }
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
                    labels: ['Makanan (40%)', 'Belanja (10%)', 'Dana HP (15%)', 'Kendaraan (10%)', 'Hiburan (8%)', 'Admin (2%)'],
                    datasets: [{
                        data: [4383816, 1095954, 1643931, 1095954, 876763, 219191],
                        backgroundColor: [
                            '#10b981', '#0284c7', '#f43f5e', '#14b8a6', '#8b5cf6', '#64748b'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom', labels: { color: '#a1a1aa', font: { family: 'Plus Jakarta Sans', size: 10 } } }
                    }
                }
            });
        }
    }
}" x-init="$nextTick(() => initCharts())" class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-zinc-100 tracking-tight">Overview Keuangan</h1>
            <p class="text-xs text-zinc-400 mt-0.5">Ringkasan arus kas, alokasi anggaran, dan status rekonsiliasi kas Anda.</p>
        </div>

        <div class="flex items-center gap-3">
            <select x-model="selectedMonth" class="saas-input cursor-pointer font-semibold">
                <option value="Juli">Juli 2026</option>
                <option value="Juni">Juni 2026</option>
                <option value="Mei">Mei 2026</option>
            </select>

            <a href="{{ route('user.expenses') }}" class="saas-btn-primary flex items-center gap-1.5">
                <i class="fa-solid fa-plus text-[10px]"></i>
                <span>Catat Transaksi</span>
            </a>
        </div>
    </div>

    <!-- 4 Key Metric Cards (Stripe Style) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Total Income -->
        <div class="saas-card p-5 space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-medium text-zinc-400">Total Pemasukan</span>
                <span class="p-1.5 rounded-md bg-emerald-500/10 text-emerald-400 text-xs">
                    <i class="fa-solid fa-arrow-down-left"></i>
                </span>
            </div>
            <div class="text-2xl font-bold text-zinc-100 font-mono" x-text="formatRp(monthlyData[selectedMonth] ? monthlyData[selectedMonth].income : 0)"></div>
            <div class="flex items-center justify-between text-[11px] text-zinc-500 pt-1">
                <span>Pemasukan Terverifikasi</span>
                <a href="{{ route('user.income') }}" class="text-emerald-400 font-medium hover:underline">Kelola →</a>
            </div>
        </div>

        <!-- Total Realisasi -->
        <div class="saas-card p-5 space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-medium text-zinc-400">Total Pengeluaran</span>
                <span class="p-1.5 rounded-md bg-rose-500/10 text-rose-400 text-xs">
                    <i class="fa-solid fa-arrow-up-right"></i>
                </span>
            </div>
            <div class="text-2xl font-bold text-zinc-100 font-mono" x-text="formatRp(monthlyData[selectedMonth] ? monthlyData[selectedMonth].expenses : 0)"></div>
            <div class="flex items-center justify-between text-[11px] text-zinc-500 pt-1">
                <span>Realisasi Pengeluaran</span>
                <a href="{{ route('user.expenses') }}" class="text-rose-400 font-medium hover:underline">Rincian →</a>
            </div>
        </div>

        <!-- Saldo Seharusnya -->
        <div class="saas-card p-5 space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-medium text-zinc-400">Saldo Seharusnya</span>
                <span class="p-1.5 rounded-md bg-sky-500/10 text-sky-400 text-xs">
                    <i class="fa-solid fa-wallet"></i>
                </span>
            </div>
            <div class="text-2xl font-bold text-zinc-100 font-mono" x-text="formatRp(monthlyData[selectedMonth] ? monthlyData[selectedMonth].expected : 0)"></div>
            <div class="text-[11px] text-zinc-500 pt-1">
                Kas Bersih Sisa (Income - Expense)
            </div>
        </div>

        <!-- Missing Cash Status -->
        <div class="saas-card p-5 space-y-3 border-amber-500/30 bg-amber-500/5">
            <div class="flex items-center justify-between">
                <span class="text-xs font-medium text-amber-400">Missing Cash Selisih</span>
                <span class="p-1.5 rounded-md bg-amber-500/20 text-amber-400 text-xs">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </span>
            </div>
            <div class="text-2xl font-bold text-amber-300 font-mono" x-text="formatRp(monthlyData[selectedMonth] ? monthlyData[selectedMonth].missing : 0)"></div>
            <div class="text-[11px] text-amber-400/80 pt-1">
                Perlu Audit Rekonsiliasi Kas
            </div>
        </div>
    </div>

    <!-- Visual Charts Grid (Stripe / Vercel Analytics Aesthetic) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Bar Chart: Trend Arus Kas -->
        <div class="lg:col-span-2 saas-card p-6 space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-zinc-800/80">
                <div>
                    <h2 class="text-sm font-semibold text-zinc-200 flex items-center gap-2">
                        <i class="fa-solid fa-chart-column text-emerald-400 text-xs"></i>
                        <span>Tren Arus Kas Bulanan (2026)</span>
                    </h2>
                    <p class="text-[11px] text-zinc-400 mt-0.5">Perbandingan pemasukan vs pengeluaran per bulan.</p>
                </div>
                <span class="px-2 py-0.5 rounded bg-zinc-800 text-zinc-400 text-[10px] font-mono">Chart.js</span>
            </div>

            <div class="h-60 relative">
                <canvas id="chartIncomeExpense"></canvas>
            </div>
        </div>

        <!-- Doughnut Chart: Kategori -->
        <div class="saas-card p-6 space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-zinc-800/80">
                <div>
                    <h2 class="text-sm font-semibold text-zinc-200 flex items-center gap-2">
                        <i class="fa-solid fa-chart-pie text-sky-400 text-xs"></i>
                        <span>Distribusi Budget Kategori</span>
                    </h2>
                    <p class="text-[11px] text-zinc-400 mt-0.5">Persentase alokasi per kategori.</p>
                </div>
                <a href="{{ route('user.categories') }}" class="text-[11px] text-sky-400 hover:underline">Kelola % →</a>
            </div>

            <div class="h-60 relative">
                <canvas id="chartCategoryPie"></canvas>
            </div>
        </div>
    </div>

    <!-- Category Budget Progress Section -->
    <div class="saas-card p-6 space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-zinc-800/80">
            <div>
                <h2 class="text-sm font-semibold text-zinc-200 flex items-center gap-2">
                    <i class="fa-solid fa-sliders text-emerald-400 text-xs"></i>
                    <span>Progres Realisasi vs Target Budget Kategori (Juli 2026)</span>
                </h2>
                <p class="text-[11px] text-zinc-400 mt-0.5">Pemantauan konsumsi budget per kategori.</p>
            </div>
            <a href="{{ route('user.categories') }}" class="saas-btn-secondary">Atur Kategori & Budget</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <template x-for="c in categories" :key="c.name">
                <div class="p-4 rounded-xl bg-zinc-950/60 border border-zinc-800/80 space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-lg bg-zinc-900 border border-zinc-800 text-emerald-400 flex items-center justify-center text-xs">
                                <i :class="'fa-solid ' + c.icon"></i>
                            </div>
                            <span class="text-xs font-semibold text-zinc-200" x-text="c.name"></span>
                        </div>
                        <span class="text-[11px] font-mono text-zinc-400" x-text="'Target: ' + c.pct + '%'"></span>
                    </div>

                    <div class="space-y-1">
                        <div class="flex justify-between text-[11px]">
                            <span class="text-zinc-400">Realisasi: <strong class="text-zinc-200" x-text="formatRp(c.realisasi)"></strong></span>
                            <span class="text-zinc-400">Target: <strong class="text-zinc-300" x-text="formatRp(c.alokasi)"></strong></span>
                        </div>
                        
                        <div class="w-full h-1.5 rounded-full bg-zinc-800 overflow-hidden relative">
                            <div class="h-full rounded-full transition-all duration-300"
                                 :class="c.realisasi > c.alokasi && c.alokasi > 0 ? 'bg-rose-500' : 'bg-emerald-500'"
                                 :style="'width: ' + Math.min((c.realisasi / (c.alokasi || 1)) * 100, 100) + '%'">
                            </div>
                        </div>

                        <div class="flex justify-between text-[10px] pt-0.5">
                            <span x-text="c.alokasi > 0 ? ((c.realisasi / c.alokasi) * 100).toFixed(1) + '% Terpakai' : 'Pengeluaran Langsung'" class="text-zinc-500"></span>
                            <span x-text="c.alokasi - c.realisasi >= 0 ? 'Sisa ' + formatRp(c.alokasi - c.realisasi) : 'Defisit ' + formatRp(c.realisasi - c.alokasi)"
                                  :class="c.alokasi - c.realisasi < 0 ? 'text-rose-400 font-semibold' : 'text-emerald-400'"></span>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>
@endsection
