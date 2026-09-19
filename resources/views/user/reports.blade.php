@extends('layouts.user')

@section('content')
<div class="space-y-6">

    <!-- PAGE HEADER & EXPORT ACTIONS (Guideline Section 70) -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 print:hidden">
        <div>
            <h1 class="text-2xl font-extrabold text-[#0F172A] tracking-tight">Laporan Keuangan Pribadi</h1>
            <p class="text-[#667085] text-xs font-medium mt-1">Ringkasan evaluasi arus kas dan rincian transaksi per periode.</p>
        </div>

        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-[#344054] bg-white border border-[#D0D5DD] hover:bg-[#F9FAFB] rounded-xl transition">
                <svg class="w-4 h-4 text-[#667085]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                <span>Cetak / PDF</span>
            </button>
            <a href="{{ route('user.reports.csv', ['month' => $month, 'year' => $year]) }}" class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-white bg-[#0F172A] hover:bg-[#1E293B] rounded-xl shadow-xs transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span>Ekspor CSV</span>
            </a>
        </div>
    </div>

    <!-- FILTER BAR (Print Hidden) -->
    <form method="GET" action="{{ route('user.reports.index') }}" class="cm-panel p-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 print:hidden">
        <div>
            <label class="block text-[10px] font-bold uppercase text-[#667085] mb-1">Bulan</label>
            <select name="month" class="w-full h-10 px-3 rounded-xl border border-[#D0D5DD] text-[#101828] text-xs font-semibold focus:border-[#0F766E] focus:ring-2 focus:ring-[#0F766E]/10 transition">
                @for($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create(null, $m, 1)->translatedFormat('F') }}
                    </option>
                @endfor
            </select>
        </div>

        <div>
            <label class="block text-[10px] font-bold uppercase text-[#667085] mb-1">Tahun</label>
            <select name="year" class="w-full h-10 px-3 rounded-xl border border-[#D0D5DD] text-[#101828] text-xs font-semibold focus:border-[#0F766E] focus:ring-2 focus:ring-[#0F766E]/10 transition">
                @for($y = 2024; $y <= 2028; $y++)
                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
        </div>

        <div>
            <label class="block text-[10px] font-bold uppercase text-[#667085] mb-1">Filter Akun</label>
            <select name="account_id" class="w-full h-10 px-3 rounded-xl border border-[#D0D5DD] text-[#101828] text-xs font-semibold focus:border-[#0F766E] focus:ring-2 focus:ring-[#0F766E]/10 transition">
                <option value="">Semua Akun</option>
                @foreach($accounts as $acc)
                    <option value="{{ $acc->id }}" {{ $accountId == $acc->id ? 'selected' : '' }}>{{ $acc->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex items-end">
            <button type="submit" class="inline-flex items-center justify-center gap-2 h-10 px-4 w-full text-xs font-semibold text-white bg-[#0F172A] hover:bg-[#1E293B] rounded-xl shadow-xs transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                <span>Tampilkan Laporan</span>
            </button>
        </div>
    </form>

    <!-- PRINTABLE REPORT DOCUMENT CONTAINER -->
    <div class="cm-panel p-6 md:p-8 space-y-8 bg-white print:border-none print:shadow-none print:p-0">
        
        <!-- REPORT HEADER BRANDING -->
        <div class="border-b border-[#EAECF0] pb-6 flex items-center justify-between">
            <div>
                <h2 class="text-xl font-extrabold text-[#0F172A]">Laporan Keuangan Personal</h2>
                <p class="text-xs text-[#667085] font-semibold mt-1">
                    Periode: {{ \Carbon\Carbon::create(null, $month, 1)->translatedFormat('F') }} {{ $year }}
                </p>
            </div>
            <div class="text-right">
                <span class="text-lg font-extrabold text-[#0F766E] block">CashMind</span>
                <span class="text-[10px] text-[#98A2B3] font-medium block">Dicetak: {{ \Carbon\Carbon::now()->translatedFormat('d M Y H:i') }}</span>
            </div>
        </div>

        <!-- 1. FINANCIAL SUMMARY METRICS (Guideline Section 70) -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="p-4 rounded-xl bg-[#F0FDF4] border border-[#DCFCE7]">
                <span class="text-[10px] font-bold uppercase text-[#15803D] block">Total Pemasukan</span>
                <div class="text-lg font-extrabold text-[#15803D] financial-number mt-1">
                    + Rp {{ number_format($totalIncome, 0, ',', '.') }}
                </div>
            </div>
            <div class="p-4 rounded-xl bg-[#FEF3F2] border border-[#FEE4E2]">
                <span class="text-[10px] font-bold uppercase text-[#B42318] block">Total Pengeluaran</span>
                <div class="text-lg font-extrabold text-[#B42318] financial-number mt-1">
                    - Rp {{ number_format($totalExpense, 0, ',', '.') }}
                </div>
            </div>
            <div class="p-4 rounded-xl bg-[#F8FAFB] border border-[#E4E7EC]">
                <span class="text-[10px] font-bold uppercase text-[#667085] block">Net Cash Flow</span>
                <div class="text-lg font-extrabold {{ $netCashFlow >= 0 ? 'text-[#15803D]' : 'text-[#B42318]' }} financial-number mt-1">
                    {{ $netCashFlow >= 0 ? '+' : '' }} Rp {{ number_format($netCashFlow, 0, ',', '.') }}
                </div>
            </div>
        </div>

        <!-- 2. BREAKDOWN TABLES (Income & Expense) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Income Breakdown -->
            <div class="space-y-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-[#667085] border-b border-[#EAECF0] pb-2">Rincian Pemasukan per Kategori</h3>
                <table class="w-full text-left text-xs border-collapse">
                    <tbody class="divide-y divide-[#EAECF0]">
                        @forelse($incomeBreakdown as $ib)
                            <tr>
                                <td class="py-2.5 text-[#344054] font-medium">{{ $ib['category'] }}</td>
                                <td class="py-2.5 text-right financial-number font-bold text-[#15803D]">Rp {{ number_format($ib['total'], 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="py-3 text-[#98A2B3] text-center">Tidak ada data pemasukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Expense Breakdown -->
            <div class="space-y-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-[#667085] border-b border-[#EAECF0] pb-2">Rincian Pengeluaran per Kategori</h3>
                <table class="w-full text-left text-xs border-collapse">
                    <tbody class="divide-y divide-[#EAECF0]">
                        @forelse($expenseBreakdown as $eb)
                            <tr>
                                <td class="py-2.5 text-[#344054] font-medium">{{ $eb['category'] }}</td>
                                <td class="py-2.5 text-right financial-number font-bold text-[#B42318]">Rp {{ number_format($eb['total'], 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="py-3 text-[#98A2B3] text-center">Tidak ada data pengeluaran</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 3. TRANSACTION DETAILS TABLE -->
        <div class="space-y-3 pt-4">
            <h3 class="text-xs font-bold uppercase tracking-wider text-[#667085] border-b border-[#EAECF0] pb-2">Rincian Transaksi</h3>

            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="border-b border-[#E4E7EC] bg-[#F8FAFB] text-[10px] font-bold uppercase tracking-wider text-[#475467]">
                        <th class="py-2.5 px-3">Tanggal</th>
                        <th class="py-2.5 px-3">Jenis</th>
                        <th class="py-2.5 px-3">Akun</th>
                        <th class="py-2.5 px-3">Kategori</th>
                        <th class="py-2.5 px-3">Uraian</th>
                        <th class="py-2.5 px-3 text-right">Nominal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#EAECF0]">
                    @forelse($transactions as $t)
                        <tr>
                            <td class="py-2.5 px-3 whitespace-nowrap text-[#475467] font-medium">{{ $t->transaction_date->format('d/m/Y') }}</td>
                            <td class="py-2.5 px-3 uppercase text-[10px] font-bold text-[#667085]">{{ $t->type }}</td>
                            <td class="py-2.5 px-3 font-semibold text-[#0F172A]">{{ $t->account?->name }}</td>
                            <td class="py-2.5 px-3 text-[#475467]">{{ $t->category?->name ?? '-' }}</td>
                            <td class="py-2.5 px-3 text-[#344054]">{{ $t->description ?? '-' }}</td>
                            <td class="py-2.5 px-3 text-right financial-number font-bold {{ $t->type === 'income' ? 'text-[#15803D]' : ($t->type === 'expense' ? 'text-[#B42318]' : 'text-[#344054]') }}">
                                {{ $t->type === 'income' ? '+' : ($t->type === 'expense' ? '-' : '') }} Rp {{ number_format($t->amount, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-[#98A2B3] font-medium">
                                Tidak ada transaksi di periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</div>
@endsection
