@extends('layouts.user')

@section('content')
<div class="space-y-8">

    <!-- PAGE HEADER -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-[#0F172A] font-display tracking-tight">Studio Dashboard</h1>
            <p class="text-[#64748B] text-xs md:text-sm mt-1 font-medium">Ringkasan kesehatan arus kas dan posisi keuangan personal Anda.</p>
        </div>

        <!-- Month & Year Selector -->
        <form method="GET" action="{{ route('user.dashboard') }}" class="flex items-center gap-2">
            <select name="month" onchange="this.form.submit()" class="cm-input h-10 text-xs font-bold w-auto border-[#CBD5E1]">
                @for($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create(null, $m, 1)->translatedFormat('F') }}
                    </option>
                @endfor
            </select>
            <select name="year" onchange="this.form.submit()" class="cm-input h-10 text-xs font-bold w-auto border-[#CBD5E1]">
                @for($y = 2024; $y <= 2028; $y++)
                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
        </form>
    </div>

    <!-- 1. HIGH-CONTRAST HERO BALANCE BANNER (Studio Finansial Modern) -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#0B132B] via-[#0F172A] to-[#1C2541] p-6 md:p-8 text-white shadow-cm-dark-glow border border-[#1C2541]">
        <!-- Glowing Emerald Ambient Blur -->
        <div class="absolute -top-24 -right-24 w-72 h-72 rounded-full bg-[#059669]/20 blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-72 h-72 rounded-full bg-[#3B82F6]/10 blur-3xl pointer-events-none"></div>

        <div class="relative z-10 space-y-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="space-y-2">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-[#A7F3D0]">Total Saldo Terkumpul</span>
                        <span class="px-2.5 py-0.5 rounded-full bg-[#059669]/20 text-[#A7F3D0] border border-[#059669]/40 text-[10px] font-bold">Terverifikasi</span>
                    </div>
                    <div class="text-3xl md:text-5xl font-extrabold font-display tracking-tight text-white financial-number">
                        Rp {{ number_format($totalBalance, 0, ',', '.') }}
                    </div>
                    <p class="text-xs text-slate-300 font-medium">Akumulasi seluruh rekening bank, e-wallet, dan kas fisik aktif Anda.</p>
                </div>

                <div class="flex items-center gap-3">
                    <button @click="openSideSheet = true" class="btn-emerald text-xs shadow-lg shadow-[#059669]/30">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        <span>Catat Transaksi</span>
                    </button>
                    <a href="{{ route('user.reports.index') }}" class="px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 border border-white/10 text-xs font-semibold text-white transition backdrop-blur-xs flex items-center gap-2">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/></svg>
                        <span>Laporan</span>
                    </a>
                </div>
            </div>

            <div class="h-px bg-slate-800/80"></div>

            <!-- Summary Metric Grid (Asymmetric & Color-Coded Accent Borders) -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-1">
                <!-- Pemasukan Card -->
                <div class="p-4 rounded-2xl bg-[#059669]/10 border border-[#059669]/30 space-y-1">
                    <span class="text-[11px] font-bold text-[#A7F3D0] uppercase tracking-wider block">Pemasukan Bulan Ini</span>
                    <div class="text-xl font-bold text-[#34D399] financial-number font-display">
                        + Rp {{ number_format($monthIncome, 0, ',', '.') }}
                    </div>
                </div>

                <!-- Pengeluaran Card -->
                <div class="p-4 rounded-2xl bg-[#E11D48]/10 border border-[#E11D48]/30 space-y-1">
                    <span class="text-[11px] font-bold text-[#FECDD3] uppercase tracking-wider block">Pengeluaran Bulan Ini</span>
                    <div class="text-xl font-bold text-[#FB7185] financial-number font-display">
                        - Rp {{ number_format($monthExpense, 0, ',', '.') }}
                    </div>
                </div>

                <!-- Net Cash Flow Card -->
                <div class="p-4 rounded-2xl bg-white/10 border border-white/20 space-y-1">
                    <span class="text-[11px] font-bold text-slate-300 uppercase tracking-wider block">Net Cash Flow</span>
                    <div class="text-xl font-bold financial-number font-display {{ $netCashFlow >= 0 ? 'text-[#34D399]' : 'text-[#FB7185]' }}">
                        {{ $netCashFlow >= 0 ? '+' : '' }} Rp {{ number_format($netCashFlow, 0, ',', '.') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. CASH FLOW CHART PANEL -->
    <div class="cm-panel p-6 space-y-4">
        <div class="flex items-center justify-between border-b border-[#E2E8F0] pb-4">
            <div>
                <h2 class="text-base font-bold text-[#0F172A] font-display">Grafik Cash Flow {{ $year }}</h2>
                <p class="text-[#64748B] text-xs mt-0.5 font-medium">Tren visual arus kas masuk vs keluar per bulan</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-[11px] font-bold text-[#059669] bg-[#ECFDF5] px-2.5 py-1 rounded-full border border-[#A7F3D0]">● Pemasukan</span>
                <span class="text-[11px] font-bold text-[#E11D48] bg-[#FFF1F2] px-2.5 py-1 rounded-full border border-[#FECDD3]">● Pengeluaran</span>
            </div>
        </div>
        <div class="h-[290px]">
            <canvas id="cashFlowLineChart"></canvas>
        </div>
    </div>

    <!-- 3. RECENT ACTIVITY & ACCOUNTS ASYMMETRIC GRID (7 Cols / 5 Cols - RHYTHM 3) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Recent Activity (7 Cols) -->
        <div class="cm-panel p-6 lg:col-span-7 space-y-4">
            <div class="flex items-center justify-between border-b border-[#E2E8F0] pb-4">
                <div>
                    <h2 class="text-base font-bold text-[#0F172A] font-display">Aktivitas Transaksi Terbaru</h2>
                    <p class="text-[#64748B] text-xs font-medium">5 pencatatan keuangan terakhir Anda</p>
                </div>
                <a href="{{ route('user.transactions.index') }}" class="text-xs font-bold text-[#059669] hover:text-[#047857] transition flex items-center gap-1 bg-[#ECFDF5] px-3 py-1.5 rounded-xl border border-[#A7F3D0]">
                    <span>Lihat Semua</span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                </a>
            </div>

            @if($recentTransactions->count() > 0)
                <div class="divide-y divide-[#E2E8F0]">
                    @foreach($recentTransactions as $t)
                        <div class="py-3.5 flex items-center justify-between first:pt-0 last:pb-0 hover:bg-[#F8FAFC] px-2 rounded-xl transition-colors">
                            <div class="flex items-center gap-3.5 min-w-0">
                                <div class="w-10 h-10 rounded-2xl flex items-center justify-center text-xs flex-shrink-0 font-bold {{ $t->type === 'income' ? 'bg-[#ECFDF5] text-[#059669] border border-[#A7F3D0]' : ($t->type === 'expense' ? 'bg-[#FFF1F2] text-[#E11D48] border border-[#FECDD3]' : 'bg-[#F1F5F9] text-[#0F172A] border border-[#E2E8F0]') }}">
                                    @if($t->type === 'income')
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 19 5 12"/></svg>
                                    @elseif($t->type === 'expense')
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="19" x2="12" y2="5"/><polyline points="5 12 12 5 19 12"/></svg>
                                    @else
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 1l4 4-4 4"/><path d="M3 11V9a4 4 0 0 1 4-4h14"/><path d="M7 23l-4-4 4-4"/><path d="M21 13v2a4 4 0 0 1-4 4H3"/></svg>
                                    @endif
                                </div>
                                <div class="truncate">
                                    <span class="text-xs font-bold text-[#0F172A] block truncate leading-tight">{{ $t->description ?: ($t->category?->name ?? strtoupper($t->type)) }}</span>
                                    <span class="text-[11px] text-[#64748B] block mt-0.5 truncate font-medium">
                                        {{ $t->category?->name ?? 'Transfer' }} • {{ $t->account?->name }}
                                    </span>
                                </div>
                            </div>
                            <div class="text-right flex-shrink-0 ml-3">
                                <span class="text-xs font-bold financial-number {{ $t->type === 'income' ? 'text-[#059669]' : ($t->type === 'expense' ? 'text-[#E11D48]' : 'text-[#0F172A]') }}">
                                    {{ $t->type === 'income' ? '+' : ($t->type === 'expense' ? '-' : '') }} Rp {{ number_format($t->amount, 0, ',', '.') }}
                                </span>
                                <span class="text-[10px] text-[#94A3B8] block mt-0.5 font-medium">{{ $t->transaction_date->format('d M Y') }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="py-12 text-center space-y-2">
                    <div class="w-12 h-12 rounded-2xl bg-[#F1F5F9] text-[#64748B] flex items-center justify-center mx-auto">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    </div>
                    <h3 class="text-xs font-bold text-[#0F172A]">Belum Ada Transaksi</h3>
                    <p class="text-[11px] text-[#64748B] font-medium max-w-xs mx-auto">Mulai catat transaksi pertama Anda untuk melihat histori arus kas.</p>
                </div>
            @endif
        </div>

        <!-- Accounts Overview (5 Cols) -->
        <div class="cm-panel p-6 lg:col-span-5 space-y-4">
            <div class="flex items-center justify-between border-b border-[#E2E8F0] pb-4">
                <div>
                    <h2 class="text-base font-bold text-[#0F172A] font-display">Rekening & Dompet</h2>
                    <p class="text-[#64748B] text-xs font-medium">Alokasi saldo per akun</p>
                </div>
                <a href="{{ route('user.accounts.index') }}" class="text-xs font-bold text-[#059669] hover:underline">Kelola</a>
            </div>

            <div class="space-y-3">
                @foreach($accounts as $acc)
                    <div class="p-3.5 rounded-2xl border border-[#E2E8F0] bg-[#F8FAFC] flex items-center justify-between hover:border-[#059669]/40 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-white border border-[#CBD5E1] text-[#0F172A] flex items-center justify-center text-xs shadow-xs">
                                @if($acc->type === 'cash')
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="12" x="2" y="6" rx="2"/><circle cx="12" cy="12" r="2"/></svg>
                                @elseif($acc->type === 'bank')
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" x2="21" y1="22" y2="22"/><line x1="6" x2="6" y1="18" y2="11"/><line x1="10" x2="10" y1="18" y2="11"/><line x1="14" x2="14" y1="18" y2="11"/><line x1="18" x2="18" y1="18" y2="11"/><polygon points="12 2 20 7 4 7 12 2"/></svg>
                                @else
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="14" height="20" x="5" y="2" rx="2" ry="2"/><path d="M12 18h.01"/></svg>
                                @endif
                            </div>
                            <div>
                                <span class="text-xs font-bold text-[#0F172A] block leading-tight">{{ $acc->name }}</span>
                                <span class="text-[10px] text-[#64748B] uppercase font-bold block mt-0.5">{{ $acc->type }}</span>
                            </div>
                        </div>
                        <span class="text-xs font-bold text-[#0F172A] financial-number">
                            Rp {{ number_format($acc->balance, 0, ',', '.') }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

</div>

<!-- Line Chart Scripts (Emerald & Rose Dual Gradient) -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctxLine = document.getElementById('cashFlowLineChart').getContext('2d');
        
        let gradientIncome = ctxLine.createLinearGradient(0, 0, 0, 270);
        gradientIncome.addColorStop(0, 'rgba(5, 150, 105, 0.18)');
        gradientIncome.addColorStop(1, 'rgba(5, 150, 105, 0.0)');

        let gradientExpense = ctxLine.createLinearGradient(0, 0, 0, 270);
        gradientExpense.addColorStop(0, 'rgba(225, 29, 72, 0.18)');
        gradientExpense.addColorStop(1, 'rgba(225, 29, 72, 0.0)');

        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartMonths) !!},
                datasets: [
                    {
                        label: 'Pemasukan',
                        data: {!! json_encode($incomeSeries) !!},
                        borderColor: '#059669',
                        backgroundColor: gradientIncome,
                        borderWidth: 3,
                        fill: true,
                        tension: 0.35,
                        pointRadius: 4,
                        pointBackgroundColor: '#059669',
                        pointHoverRadius: 7,
                    },
                    {
                        label: 'Pengeluaran',
                        data: {!! json_encode($expenseSeries) !!},
                        borderColor: '#E11D48',
                        backgroundColor: gradientExpense,
                        borderWidth: 3,
                        fill: true,
                        tension: 0.35,
                        pointRadius: 4,
                        pointBackgroundColor: '#E11D48',
                        pointHoverRadius: 7,
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
                        ticks: { font: { family: 'Manrope', size: 11, weight: '600' }, color: '#64748B' }
                    },
                    y: { 
                        grid: { color: '#F1F5F9' },
                        ticks: { 
                            font: { family: 'Manrope', size: 11, weight: '600' }, 
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
