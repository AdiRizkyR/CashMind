@extends('layouts.user')

@section('content')
<div class="space-y-8">

    <!-- PAGE HEADER & PERIOD CONTEXT -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-[#0F172A] font-display tracking-tight">Dashboard Ringkasan Keuangan</h1>
            <p class="text-[#64748B] text-xs md:text-sm mt-1 font-medium">Monitoring kondisi keuangan, realisasi budget, dan alokasi saldo periode aktif.</p>
        </div>

        <div class="flex items-center gap-2 bg-white px-4 py-2 rounded-2xl border border-[#E2E8F0] shadow-xs">
            <span class="w-2.5 h-2.5 rounded-full bg-[#10B981]"></span>
            <span class="text-xs font-bold text-[#0F172A]">Periode: {{ \Carbon\Carbon::createFromDate($year, $month, 1)->translatedFormat('F Y') }}</span>
        </div>
    </div>

    <!-- 1. HIGH-CONTRAST HERO BANNER: TOTAL SALDO & BREAKDOWN CASH, E-WALLET, BANK -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#0F172A] via-[#1E293B] to-[#0F172A] p-6 md:p-8 text-white shadow-xl border border-[#334155]">
        <!-- Ambient Blur Effects -->
        <div class="absolute -top-24 -right-24 w-72 h-72 rounded-full bg-[#4F46E5]/20 blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-72 h-72 rounded-full bg-[#10B981]/20 blur-3xl pointer-events-none"></div>

        <div class="relative z-10 space-y-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="space-y-2">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-[#A5B4FC]">Saldo Total Saat Ini</span>
                        <span class="px-2.5 py-0.5 rounded-full bg-[#10B981]/20 text-[#6EE7B7] border border-[#10B981]/40 text-[10px] font-bold">Arus Kas Terkelola</span>
                    </div>
                    <div class="text-3xl md:text-5xl font-extrabold font-display tracking-tight text-white financial-number">
                        Rp {{ number_format($totalBalance, 0, ',', '.') }}
                    </div>
                    <p class="text-xs text-slate-300 font-medium">Akumulasi net dana tersisa dari seluruh media penyimpanan aktif Anda.</p>
                </div>

                <div class="flex items-center gap-3">
                    <button @click="openSideSheet = true" class="btn-emerald text-xs shadow-lg">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        <span>Catat Transaksi</span>
                    </button>
                    <a href="{{ route('user.reports.index') }}" class="px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 border border-white/10 text-xs font-semibold text-white transition backdrop-blur-xs flex items-center gap-2">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/></svg>
                        <span>Usage Summary</span>
                    </a>
                </div>
            </div>

            <div class="h-px bg-slate-800"></div>

            <!-- Breakdown per Account Storage Media (Cash, E-Wallet, Bank) -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <!-- Cash -->
                <div class="p-4 rounded-2xl bg-white/5 border border-white/10 space-y-1">
                    <div class="flex items-center gap-2">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#6EE7B7" stroke-width="2"><rect width="20" height="12" x="2" y="6" rx="2"/><circle cx="12" cy="12" r="2"/></svg>
                        <span class="text-[11px] font-bold text-slate-300 uppercase tracking-wider block">Saldo Cash / Tunai</span>
                    </div>
                    <div class="text-lg font-bold text-white financial-number font-display">
                        Rp {{ number_format($cashBalance, 0, ',', '.') }}
                    </div>
                </div>

                <!-- Dompet Digital (E-Wallet) -->
                <div class="p-4 rounded-2xl bg-white/5 border border-white/10 space-y-1">
                    <div class="flex items-center gap-2">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#93C5FD" stroke-width="2"><rect width="14" height="20" x="5" y="2" rx="2" ry="2"/><path d="M12 18h.01"/></svg>
                        <span class="text-[11px] font-bold text-slate-300 uppercase tracking-wider block">Dompet Digital (E-Wallet)</span>
                    </div>
                    <div class="text-lg font-bold text-white financial-number font-display">
                        Rp {{ number_format($ewalletBalance, 0, ',', '.') }}
                    </div>
                </div>

                <!-- Rekening Bank -->
                <div class="p-4 rounded-2xl bg-white/5 border border-white/10 space-y-1">
                    <div class="flex items-center gap-2">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#A5B4FC" stroke-width="2"><line x1="3" x2="21" y1="22" y2="22"/><line x1="6" x2="6" y1="18" y2="11"/><polygon points="12 2 20 7 4 7 12 2"/></svg>
                        <span class="text-[11px] font-bold text-slate-300 uppercase tracking-wider block">Rekening Bank</span>
                    </div>
                    <div class="text-lg font-bold text-white financial-number font-display">
                        Rp {{ number_format($bankBalance, 0, ',', '.') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. KPI METRICS BAR BULAN AKTIF (Pemasukan, Pengeluaran, Net Cash Flow, % Usage) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Pemasukan Bulan Ini -->
        <div class="cm-panel p-5 space-y-2 border-l-4 border-l-[#10B981]">
            <span class="text-xs font-bold text-[#64748B] uppercase tracking-wider block">Pemasukan Bulan Ini</span>
            <div class="text-2xl font-extrabold text-[#10B981] financial-number font-display">
                + Rp {{ number_format($monthIncome, 0, ',', '.') }}
            </div>
            <p class="text-[11px] text-[#64748B] font-medium">Dari transaksi pemasukan terdaftar</p>
        </div>

        <!-- Pengeluaran Bulan Ini -->
        <div class="cm-panel p-5 space-y-2 border-l-4 border-l-[#EF4444]">
            <span class="text-xs font-bold text-[#64748B] uppercase tracking-wider block">Pengeluaran Bulan Ini</span>
            <div class="text-2xl font-extrabold text-[#EF4444] financial-number font-display">
                - Rp {{ number_format($monthExpense, 0, ',', '.') }}
            </div>
            <p class="text-[11px] text-[#64748B] font-medium">Realisasi konsumsi dana</p>
        </div>

        <!-- Net Cash Flow -->
        <div class="cm-panel p-5 space-y-2 border-l-4 border-l-[#4F46E5]">
            <span class="text-xs font-bold text-[#64748B] uppercase tracking-wider block">Sisa Dana Arus Kas</span>
            <div class="text-2xl font-extrabold financial-number font-display {{ $netCashFlow >= 0 ? 'text-[#10B981]' : 'text-[#EF4444]' }}">
                {{ $netCashFlow >= 0 ? '+' : '' }} Rp {{ number_format($netCashFlow, 0, ',', '.') }}
            </div>
            <p class="text-[11px] text-[#64748B] font-medium">Selisih pemasukan - pengeluaran</p>
        </div>

        <!-- Persentase Penggunaan Budget -->
        <div class="cm-panel p-5 space-y-2 border-l-4 border-l-[#F59E0B]">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-[#64748B] uppercase tracking-wider block">Penggunaan Budget</span>
                <span class="text-xs font-bold font-display {{ $budgetUsagePercentage >= 100 ? 'text-[#EF4444]' : ($budgetUsagePercentage >= 80 ? 'text-[#F59E0B]' : 'text-[#10B981]') }}">
                    {{ $budgetUsagePercentage }}%
                </span>
            </div>
            <div class="w-full bg-[#E2E8F0] h-2.5 rounded-full overflow-hidden">
                <div class="h-full transition-all duration-500 {{ $budgetUsagePercentage >= 100 ? 'bg-[#EF4444]' : ($budgetUsagePercentage >= 80 ? 'bg-[#F59E0B]' : 'bg-[#10B981]') }}" style="width: {{ min(100, $budgetUsagePercentage) }}%"></div>
            </div>
            <p class="text-[11px] text-[#64748B] font-medium">Rasio pengeluaran vs pemasukan</p>
        </div>
    </div>

    <!-- 3. TABEL PENGELUARAN PER KATEGORI (Alokasi, Realisasi, Sisa Budget, Status Badge) -->
    <div class="cm-panel p-6 space-y-5">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-[#E2E8F0] pb-4">
            <div>
                <h2 class="text-base font-bold text-[#0F172A] font-display">Status Budget & Realisasi Pengeluaran per Kategori</h2>
                <p class="text-[#64748B] text-xs font-medium">Indikator status: <span class="text-[#10B981] font-bold">Aman (&lt;80%)</span>, <span class="text-[#F59E0B] font-bold">Waspada (80–99%)</span>, dan <span class="text-[#EF4444] font-bold">Melebihi Budget (≥100%)</span>.</p>
            </div>
            <a href="{{ route('user.transactions.index', ['tab' => 'expenses']) }}" class="btn-secondary text-xs">
                <span>Atur Budget Kategori</span>
            </a>
        </div>

        @if($budgets->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="border-b border-[#E2E8F0] bg-[#F8FAFC] text-[#475467] font-bold uppercase tracking-wider">
                            <th class="py-3 px-4 rounded-l-xl">Kategori Pengeluaran</th>
                            <th class="py-3 px-4">Alokasi Budget</th>
                            <th class="py-3 px-4">Realisasi Terpakai</th>
                            <th class="py-3 px-4">Sisa Alokasi</th>
                            <th class="py-3 px-4">Progress Pemakaian</th>
                            <th class="py-3 px-4 text-right rounded-r-xl">Status Badge</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E2E8F0]">
                        @foreach($budgets as $b)
                            @php
                                $spent = $b->spent;
                                $allocated = $b->amount;
                                $remaining = $allocated - $spent;
                                $usagePct = $allocated > 0 ? round(($spent / $allocated) * 100, 1) : 0;
                                $status = $b->status; // Aman, Waspada, Melebihi Budget
                            @endphp
                            <tr class="hover:bg-[#F8FAFC] transition-colors">
                                <td class="py-3.5 px-4 font-bold text-[#0F172A] flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full {{ $status === 'Aman' ? 'bg-[#10B981]' : ($status === 'Waspada' ? 'bg-[#F59E0B]' : 'bg-[#EF4444]') }}"></span>
                                    <span>{{ $b->category?->name ?? 'Kategori' }}</span>
                                </td>
                                <td class="py-3.5 px-4 font-semibold text-[#0F172A] financial-number">
                                    Rp {{ number_format($allocated, 0, ',', '.') }}
                                </td>
                                <td class="py-3.5 px-4 font-semibold text-[#EF4444] financial-number">
                                    Rp {{ number_format($spent, 0, ',', '.') }}
                                </td>
                                <td class="py-3.5 px-4 font-semibold {{ $remaining >= 0 ? 'text-[#10B981]' : 'text-[#EF4444]' }} financial-number">
                                    {{ $remaining >= 0 ? 'Rp ' . number_format($remaining, 0, ',', '.') : '- Rp ' . number_format(abs($remaining), 0, ',', '.') }}
                                </td>
                                <td class="py-3.5 px-4 w-48">
                                    <div class="space-y-1">
                                        <div class="flex justify-between text-[11px] font-bold financial-number text-[#334155]">
                                            <span>{{ $usagePct }}%</span>
                                        </div>
                                        <div class="w-full bg-[#E2E8F0] h-2 rounded-full overflow-hidden">
                                            <div class="h-full transition-all duration-300 {{ $status === 'Aman' ? 'bg-[#10B981]' : ($status === 'Waspada' ? 'bg-[#F59E0B]' : 'bg-[#EF4444]') }}" style="width: {{ min(100, $usagePct) }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 text-right">
                                    @if($status === 'Aman')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#ECFDF5] text-[#059669] border border-[#A7F3D0] text-[11px] font-bold">
                                            <span>Aman (&lt;80%)</span>
                                        </span>
                                    @elseif($status === 'Waspada')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#FEF3C7] text-[#D97706] border border-[#FDE68A] text-[11px] font-bold">
                                            <span>Waspada (80–99%)</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#FFF1F2] text-[#E11D48] border border-[#FECDD3] text-[11px] font-bold">
                                            <span>Melebihi Budget (≥100%)</span>
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <!-- EMPTY STATE UI REQUIREMENT (Docx Section 6.5 & antislop rules) -->
            <div class="p-8 text-center bg-[#F8FAFC] rounded-2xl border border-dashed border-[#CBD5E1] space-y-3">
                <div class="w-12 h-12 rounded-2xl bg-[#EEF2FF] text-[#4F46E5] flex items-center justify-center mx-auto">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/><circle cx="8" cy="12" r="2"/></svg>
                </div>
                <h3 class="text-sm font-bold text-[#0F172A] font-display">Belum Ada Alokasi Budget pada Periode Ini</h3>
                <p class="text-xs text-[#64748B] max-w-md mx-auto">Tetapkan batas anggaran pengeluaran per kategori untuk memantau status keamanan budget secara otomatis.</p>
                <a href="{{ route('user.transactions.index', ['tab' => 'expenses']) }}" class="btn-primary text-xs">Tetapkan Budget Kategori</a>
            </div>
        @endif
    </div>

    <!-- 4. CHARTS & RINGKASAN TRANSFER DANA (Terpisah agar tidak ganda) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Cash Flow Line Chart (7 Cols) -->
        <div class="cm-panel p-6 lg:col-span-7 space-y-4">
            <div class="flex items-center justify-between border-b border-[#E2E8F0] pb-4">
                <div>
                    <h2 class="text-base font-bold text-[#0F172A] font-display">Grafik Tren Pemasukan vs Pengeluaran {{ $year }}</h2>
                    <p class="text-[#64748B] text-xs font-medium">Perbandingan arus kas bulanan sepanjang tahun {{ $year }}</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-[11px] font-bold text-[#10B981] bg-[#ECFDF5] px-2.5 py-1 rounded-full border border-[#A7F3D0]">● Pemasukan</span>
                    <span class="text-[11px] font-bold text-[#EF4444] bg-[#FFF1F2] px-2.5 py-1 rounded-full border border-[#FECDD3]">● Pengeluaran</span>
                </div>
            </div>
            <div class="h-[280px]">
                <canvas id="cashFlowLineChart"></canvas>
            </div>
        </div>

        <!-- Ringkasan Transfer Dana Terpisah (5 Cols - Section 4.1 Requirement) -->
        <div class="cm-panel p-6 lg:col-span-5 space-y-4">
            <div class="flex items-center justify-between border-b border-[#E2E8F0] pb-4">
                <div>
                    <h2 class="text-base font-bold text-[#0F172A] font-display">Ringkasan Transfer Dana Internal</h2>
                    <p class="text-[#64748B] text-xs font-medium">Pemindahan saldo antar rekening (tidak dihitung ganda sebagai income/expense)</p>
                </div>
                <span class="text-xs font-bold text-[#4F46E5] bg-[#EEF2FF] px-2.5 py-1 rounded-full border border-[#C7D2FE]">
                    {{ $monthTransfers->count() }} Transaksi
                </span>
            </div>

            @if($monthTransfers->count() > 0)
                <div class="space-y-3 max-h-[260px] overflow-y-auto pr-1 divide-y divide-[#E2E8F0]">
                    @foreach($monthTransfers as $t)
                        <div class="pt-3 first:pt-0 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-[#EEF2FF] text-[#4F46E5] flex items-center justify-center text-xs font-bold border border-[#C7D2FE]">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M17 1l4 4-4 4"/><path d="M3 11V9a4 4 0 0 1 4-4h14"/><path d="M7 23l-4-4 4-4"/><path d="M21 13v2a4 4 0 0 1-4 4H3"/></svg>
                                </div>
                                <div>
                                    <span class="text-xs font-bold text-[#0F172A] block leading-tight">
                                        {{ $t->account?->name }} → {{ $t->destinationAccount?->name }}
                                    </span>
                                    <span class="text-[11px] text-[#64748B] block mt-0.5 font-medium">
                                        {{ $t->transaction_date->format('d M Y') }} {{ $t->admin_fee > 0 ? '(Fee: Rp '.number_format($t->admin_fee, 0, ',', '.').')' : '' }}
                                    </span>
                                </div>
                            </div>
                            <span class="text-xs font-bold text-[#4F46E5] financial-number">
                                Rp {{ number_format($t->amount, 0, ',', '.') }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="py-10 text-center space-y-2">
                    <div class="w-10 h-10 rounded-2xl bg-[#F1F5F9] text-[#64748B] flex items-center justify-center mx-auto">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M17 1l4 4-4 4"/><path d="M3 11V9a4 4 0 0 1 4-4h14"/></svg>
                    </div>
                    <p class="text-xs font-bold text-[#0F172A]">Tidak Ada Pemindahan Saldo</p>
                    <p class="text-[11px] text-[#64748B] font-medium">Belum ada aktivitas transfer internal antar rekening bulan ini.</p>
                </div>
            @endif
        </div>

    </div>

</div>

<!-- Chart.js Setup -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctxLine = document.getElementById('cashFlowLineChart').getContext('2d');
        
        let gradientIncome = ctxLine.createLinearGradient(0, 0, 0, 260);
        gradientIncome.addColorStop(0, 'rgba(16, 185, 129, 0.2)');
        gradientIncome.addColorStop(1, 'rgba(16, 185, 129, 0.0)');

        let gradientExpense = ctxLine.createLinearGradient(0, 0, 0, 260);
        gradientExpense.addColorStop(0, 'rgba(239, 68, 68, 0.2)');
        gradientExpense.addColorStop(1, 'rgba(239, 68, 68, 0.0)');

        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartMonths) !!},
                datasets: [
                    {
                        label: 'Pemasukan',
                        data: {!! json_encode($incomeSeries) !!},
                        borderColor: '#10B981',
                        backgroundColor: gradientIncome,
                        borderWidth: 3,
                        fill: true,
                        tension: 0.35,
                        pointRadius: 4,
                        pointBackgroundColor: '#10B981',
                    },
                    {
                        label: 'Pengeluaran',
                        data: {!! json_encode($expenseSeries) !!},
                        borderColor: '#EF4444',
                        backgroundColor: gradientExpense,
                        borderWidth: 3,
                        fill: true,
                        tension: 0.35,
                        pointRadius: 4,
                        pointBackgroundColor: '#EF4444',
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: { 
                        grid: { display: false },
                        ticks: { font: { family: 'Inter', size: 11, weight: '600' }, color: '#64748B' }
                    },
                    y: { 
                        grid: { color: '#F1F5F9' },
                        ticks: { 
                            font: { family: 'Inter', size: 11, weight: '600' }, 
                            color: '#64748B',
                            callback: function(val) { return 'Rp ' + (val/1000) + 'k'; } 
                        } 
                    }
                }
            }
        });
    });
</script>
@endsection
