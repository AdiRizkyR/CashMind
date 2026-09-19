@extends('layouts.user')

@section('content')
<div class="space-y-8">

    <!-- PAGE HEADER (Guideline v4 Section 14) -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-[24px] md:text-[30px] font-bold text-[#101828] tracking-tight">Dashboard</h1>
            <p class="text-[#667085] text-xs md:text-sm mt-1">Ringkasan kesehatan arus kas dan posisi keuangan Anda.</p>
        </div>

        <!-- Month & Year Selector -->
        <form method="GET" action="{{ route('user.dashboard') }}" class="flex items-center gap-2">
            <select name="month" onchange="this.form.submit()" class="cm-input h-10 text-xs font-semibold w-auto">
                @for($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create(null, $m, 1)->translatedFormat('F') }}
                    </option>
                @endfor
            </select>
            <select name="year" onchange="this.form.submit()" class="cm-input h-10 text-xs font-semibold w-auto">
                @for($y = 2024; $y <= 2028; $y++)
                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
        </form>
    </div>

    <!-- 1. FINANCIAL SNAPSHOT PANEL (Guideline v4 Section 16, 17, 18) -->
    <div class="cm-panel p-6 md:p-8 space-y-6">
        <!-- Main Anchor Balance -->
        <div>
            <span class="text-xs font-bold text-[#667085] uppercase tracking-wider block">Total Saldo Terkumpul</span>
            <div class="text-[28px] md:text-[34px] font-bold text-[#101828] financial-number mt-1">
                Rp {{ number_format($totalBalance, 0, ',', '.') }}
            </div>
            <span class="text-xs text-[#667085] mt-1 block">Akumulasi seluruh rekening & dompet digital aktif</span>
        </div>

        <div class="h-px bg-[#EAECF0]"></div>

        <!-- Summary Grid (Pemasukan, Pengeluaran, Net Cash Flow) -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <!-- Pemasukan -->
            <div class="space-y-1">
                <span class="text-xs font-semibold text-[#667085] flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-[#15803D]"></span>
                    Pemasukan Bulan Ini
                </span>
                <div class="text-lg md:text-xl font-bold text-[#15803D] financial-number">
                    + Rp {{ number_format($monthIncome, 0, ',', '.') }}
                </div>
            </div>

            <!-- Pengeluaran -->
            <div class="space-y-1">
                <span class="text-xs font-semibold text-[#667085] flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-[#B42318]"></span>
                    Pengeluaran Bulan Ini
                </span>
                <div class="text-lg md:text-xl font-bold text-[#B42318] financial-number">
                    - Rp {{ number_format($monthExpense, 0, ',', '.') }}
                </div>
            </div>

            <!-- Net Cash Flow -->
            <div class="space-y-1">
                <span class="text-xs font-semibold text-[#667085] flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-[#0F766E]"></span>
                    Net Cash Flow
                </span>
                <div class="text-lg md:text-xl font-bold financial-number {{ $netCashFlow >= 0 ? 'text-[#15803D]' : 'text-[#B42318]' }}">
                    {{ $netCashFlow >= 0 ? '+' : '' }} Rp {{ number_format($netCashFlow, 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>

    <!-- 2. CASH FLOW CHART (Guideline v4 Section 19: Thin Area/Line Chart) -->
    <div class="cm-panel p-6 space-y-4">
        <div class="flex items-center justify-between border-b border-[#EAECF0] pb-4">
            <div>
                <h2 class="text-base font-bold text-[#101828]">Cash Flow {{ $year }}</h2>
                <p class="text-[#667085] text-xs mt-0.5">Tren arus kas masuk dan keluar per bulan</p>
            </div>
        </div>
        <div class="h-[280px]">
            <canvas id="cashFlowLineChart"></canvas>
        </div>
    </div>

    <!-- 3. RECENT ACTIVITY & BUDGET HEALTH -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Recent Activity (2 Cols - Guideline v4 Section 20) -->
        <div class="cm-panel p-6 lg:col-span-2 space-y-4">
            <div class="flex items-center justify-between border-b border-[#EAECF0] pb-4">
                <h2 class="text-base font-bold text-[#101828]">Aktivitas Terbaru</h2>
                <a href="{{ route('user.transactions.index') }}" class="text-xs font-semibold text-[#0F766E] hover:text-[#115E59] transition flex items-center gap-1">
                    <span>Lihat Semua</span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                </a>
            </div>

            @if($recentTransactions->count() > 0)
                <div class="divide-y divide-[#EAECF0]">
                    @foreach($recentTransactions as $t)
                        <div class="py-3.5 flex items-center justify-between first:pt-0 last:pb-0">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-9 h-9 rounded-xl flex items-center justify-center text-xs flex-shrink-0 {{ $t->type === 'income' ? 'bg-[#F0FDF4] text-[#15803D]' : ($t->type === 'expense' ? 'bg-[#FEF3F2] text-[#B42318]' : 'bg-[#F1F5F9] text-[#0F172A]') }}">
                                    @if($t->type === 'income')
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 19 5 12"/></svg>
                                    @elseif($t->type === 'expense')
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="19" x2="12" y2="5"/><polyline points="5 12 12 5 19 12"/></svg>
                                    @else
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 1l4 4-4 4"/><path d="M3 11V9a4 4 0 0 1 4-4h14"/><path d="M7 23l-4-4 4-4"/><path d="M21 13v2a4 4 0 0 1-4 4H3"/></svg>
                                    @endif
                                </div>
                                <div class="truncate">
                                    <span class="text-xs font-semibold text-[#101828] block truncate leading-tight">{{ $t->description ?: ($t->category?->name ?? strtoupper($t->type)) }}</span>
                                    <span class="text-[11px] text-[#667085] block mt-0.5 truncate">
                                        {{ $t->category?->name ?? '-' }} • {{ $t->account?->name }}
                                    </span>
                                </div>
                            </div>
                            <div class="text-right flex-shrink-0 ml-3">
                                <span class="text-xs font-bold financial-number {{ $t->type === 'income' ? 'text-[#15803D]' : ($t->type === 'expense' ? 'text-[#B42318]' : 'text-[#0F172A]') }}">
                                    {{ $t->type === 'income' ? '+' : ($t->type === 'expense' ? '-' : '') }} Rp {{ number_format($t->amount, 0, ',', '.') }}
                                </span>
                                <span class="text-[10px] text-[#98A2B3] block mt-0.5">{{ $t->transaction_date->format('d M') }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="py-10 text-center space-y-2">
                    <div class="w-10 h-10 rounded-full bg-[#F4F6F8] text-[#667085] flex items-center justify-center mx-auto">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    </div>
                    <h3 class="text-xs font-semibold text-[#101828]">Belum ada aktivitas</h3>
                    <p class="text-[11px] text-[#667085]">Catatan transaksi terbaru Anda akan muncul di sini.</p>
                </div>
            @endif
        </div>

        <!-- Accounts Quick Overview (1 Col) -->
        <div class="cm-panel p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-[#EAECF0] pb-4">
                <h2 class="text-base font-bold text-[#101828]">Rekening</h2>
                <a href="{{ route('user.accounts.index') }}" class="text-xs font-semibold text-[#0F766E] hover:text-[#115E59] transition flex items-center gap-1">
                    <span>Kelola</span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                </a>
            </div>

            <div class="space-y-3">
                @foreach($accounts as $acc)
                    <div class="p-3.5 rounded-xl border border-[#EAECF0] bg-[#F8FAFB] flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-white border border-[#E4E7EC] text-[#344054] flex items-center justify-center text-xs">
                                @if($acc->type === 'cash')
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="12" x="2" y="6" rx="2"/><circle cx="12" cy="12" r="2"/></svg>
                                @elseif($acc->type === 'bank')
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><line x1="3" x2="21" y1="22" y2="22"/><line x1="6" x2="6" y1="18" y2="11"/><line x1="10" x2="10" y1="18" y2="11"/><line x1="14" x2="14" y1="18" y2="11"/><line x1="18" x2="18" y1="18" y2="11"/><polygon points="12 2 20 7 4 7 12 2"/></svg>
                                @else
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect width="14" height="20" x="5" y="2" rx="2" ry="2"/><path d="M12 18h.01"/></svg>
                                @endif
                            </div>
                            <div>
                                <span class="text-xs font-semibold text-[#101828] block leading-tight">{{ $acc->name }}</span>
                                <span class="text-[10px] text-[#667085] uppercase font-semibold block mt-0.5">{{ $acc->type }}</span>
                            </div>
                        </div>
                        <span class="text-xs font-bold text-[#101828] financial-number">
                            Rp {{ number_format($acc->balance, 0, ',', '.') }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

</div>

<!-- Line Chart Scripts (Guideline v4 Section 19: Thin Area/Line Chart) -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctxLine = document.getElementById('cashFlowLineChart').getContext('2d');
        
        let gradientIncome = ctxLine.createLinearGradient(0, 0, 0, 260);
        gradientIncome.addColorStop(0, 'rgba(15, 118, 110, 0.12)');
        gradientIncome.addColorStop(1, 'rgba(15, 118, 110, 0.0)');

        let gradientExpense = ctxLine.createLinearGradient(0, 0, 0, 260);
        gradientExpense.addColorStop(0, 'rgba(180, 35, 24, 0.12)');
        gradientExpense.addColorStop(1, 'rgba(180, 35, 24, 0.0)');

        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartMonths) !!},
                datasets: [
                    {
                        label: 'Pemasukan',
                        data: {!! json_encode($incomeSeries) !!},
                        borderColor: '#0F766E',
                        backgroundColor: gradientIncome,
                        borderWidth: 2.5,
                        fill: true,
                        tension: 0.35,
                        pointRadius: 3,
                        pointHoverRadius: 6,
                    },
                    {
                        label: 'Pengeluaran',
                        data: {!! json_encode($expenseSeries) !!},
                        borderColor: '#B42318',
                        backgroundColor: gradientExpense,
                        borderWidth: 2.5,
                        fill: true,
                        tension: 0.35,
                        pointRadius: 3,
                        pointHoverRadius: 6,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top', labels: { font: { family: 'Manrope', size: 12 } } }
                },
                scales: {
                    x: { grid: { display: false } },
                    y: { 
                        grid: { color: '#F2F4F7' },
                        ticks: { callback: function(val) { return 'Rp ' + (val/1000) + 'k'; } } 
                    }
                }
            }
        });
    });
</script>
@endsection
