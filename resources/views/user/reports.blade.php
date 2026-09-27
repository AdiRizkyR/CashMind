@extends('layouts.user')

@section('content')
<div class="space-y-6">

    <!-- PAGE HEADER & EXPORT ACTIONS -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 print:hidden">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#ECFDF5] text-[#059669] border border-[#A7F3D0] text-xs font-bold mb-2">
                <span class="w-2 h-2 rounded-full bg-[#059669]"></span>
                <span>Usage Summary & Machine Learning Analysis</span>
            </div>
            <h1 class="text-2xl font-extrabold text-[#0F172A] tracking-tight font-display">Usage Summary (Laporan Analisis Bulanan)</h1>
            <p class="text-[#64748B] text-xs md:text-sm mt-1 font-medium">Analisis pola penggunaan dana, Poin Positif, Poin Perhatian, serta perbandingan Cash vs Transfer.</p>
        </div>

        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="btn-secondary text-xs">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9V2h12v7"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect width="12" height="8" x="6" y="14"/></svg>
                <span>Cetak / PDF</span>
            </button>
            <a href="{{ route('user.reports.csv', ['month' => $month, 'year' => $year]) }}" class="btn-primary text-xs">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                <span>Ekspor Excel / CSV</span>
            </a>
        </div>
    </div>

    <!-- FILTER & ANALYSIS CHECK STATUS BAR (Docx Section 4.4 Rule) -->
    <div class="cm-panel p-6 space-y-4 print:hidden">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-[#E2E8F0] pb-4">
            <div>
                <h3 class="text-base font-bold text-[#0F172A] font-display">Ketersediaan Analisis Bulanan</h3>
                <p class="text-xs text-[#64748B] font-medium">
                    @if($isPeriodCompleted)
                        <span class="text-[#059669] font-bold">Periode Ini Telah Berakhir</span> — Hasil analisis Usage Summary tersedia lengkap.
                    @else
                        <span class="text-[#F59E0B] font-bold">Periode Sedang Berjalan</span> — Hasil akhir otomatis siap setelah bulan berakhir.
                    @endif
                </p>
            </div>

            <!-- "Tampilkan Hasil Analisa" Button with Disabled Logic (Section 4.4 Rule) -->
            <div>
                @if($isPeriodCompleted)
                    <button type="button" class="btn-emerald text-xs" title="Analisis siap ditampilkan">
                        <span>✓ Analisa Periode Berhasil Dibuat</span>
                    </button>
                @else
                    <button type="button" disabled class="btn-secondary text-xs opacity-60 cursor-not-allowed" title="Bulan berjalan belum berakhir">
                        <span>🔒 Tampilkan Hasil Analisa (Belum Berakhir)</span>
                    </button>
                @endif
            </div>
        </div>

        <!-- Filter Form -->
        <form method="GET" action="{{ route('user.reports.index') }}" class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-4 gap-3">
            <div>
                <label class="block text-[10px] font-bold uppercase text-[#475467] mb-1">Bulan</label>
                <select name="month" class="cm-input text-xs">
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create(null, $m, 1)->translatedFormat('F') }}
                        </option>
                    @endfor
                </select>
            </div>

            <div>
                <label class="block text-[10px] font-bold uppercase text-[#475467] mb-1">Tahun</label>
                <select name="year" class="cm-input text-xs">
                    @for($y = 2024; $y <= 2028; $y++)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>

            <div>
                <label class="block text-[10px] font-bold uppercase text-[#475467] mb-1">Filter Akun</label>
                <select name="account_id" class="cm-input text-xs">
                    <option value="">Semua Rekening & Dompet</option>
                    @foreach($accounts as $acc)
                        <option value="{{ $acc->id }}" {{ $accountId == $acc->id ? 'selected' : '' }}>{{ $acc->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit" class="btn-primary w-full text-xs">Tampilkan Laporan</button>
            </div>
        </form>
    </div>

    <!-- 1. HIGH-CONTRAST ML ANALYSIS PANEL (POIN POSITIF & POIN PERHATIAN) -->
    <div class="cm-panel p-6 md:p-8 space-y-6 bg-gradient-to-br from-[#0F172A] via-[#1E293B] to-[#0F172A] text-white border-[#334155] shadow-xl relative overflow-hidden print:bg-none print:text-black print:p-0">
        <div class="absolute -top-16 -right-16 w-64 h-64 rounded-full bg-[#10B981]/20 blur-3xl pointer-events-none print:hidden"></div>

        <!-- Header Score Bar -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 border-b border-slate-800 pb-6 relative z-10">
            <div class="space-y-2">
                <div class="flex items-center gap-2">
                    <span class="px-3 py-1 rounded-full bg-[#10B981]/20 text-[#6EE7B7] border border-[#10B981]/40 text-xs font-bold uppercase tracking-wider">
                        Analisis Usage Summary
                    </span>
                    <span class="text-xs text-slate-300 font-medium">Periode: {{ \Carbon\Carbon::create(null, $month, 1)->translatedFormat('F') }} {{ $year }}</span>
                </div>
                <h2 class="text-xl md:text-2xl font-extrabold font-display text-white">Evaluasi Arus Kas & Budget Advisor</h2>
                <p class="text-xs text-slate-300 font-medium max-w-2xl">
                    Tingkat penggunaan budget periode ini mencapai <strong class="text-[#6EE7B7]">{{ $budgetUsageRate }}%</strong> dari total pemasukan Rp {{ number_format($totalIncome, 0, ',', '.') }}.
                </p>
            </div>

            <div class="flex items-center gap-4 bg-white/5 p-4 rounded-2xl border border-white/10 shrink-0">
                <div class="text-center">
                    <span class="text-[10px] font-bold uppercase text-slate-400 block">Financial Health Index</span>
                    <span class="text-3xl font-extrabold font-display {{ $mlAnalysis['health_score'] >= 70 ? 'text-[#6EE7B7]' : ($mlAnalysis['health_score'] >= 50 ? 'text-[#FBBF24]' : 'text-[#F87171]') }} financial-number">
                        {{ $mlAnalysis['health_score'] }}/100
                    </span>
                </div>
            </div>
        </div>

        <!-- POIN POSITIF & POIN PERHATIAN GRID (Docx Section 4.4 Requirement) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 relative z-10">
            
            <!-- POIN POSITIF -->
            <div class="p-5 rounded-2xl bg-[#090D16]/80 border border-[#10B981]/30 space-y-3">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-xl bg-[#10B981]/20 text-[#6EE7B7] flex items-center justify-center font-bold text-xs shrink-0">
                        ✓
                    </div>
                    <h3 class="text-sm font-bold text-[#6EE7B7] font-display">Poin Positif (Penghematan & Kategori Terkendali)</h3>
                </div>

                <div class="space-y-2.5 pt-1">
                    @foreach($mlAnalysis['poin_plus'] as $plus)
                        <div class="p-3 rounded-xl bg-slate-900/60 border border-slate-800 space-y-1">
                            <h4 class="text-xs font-bold text-white font-display">{{ $plus['title'] }}</h4>
                            <p class="text-[11px] text-slate-300 font-medium leading-relaxed">{{ $plus['description'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- POIN PERHATIAN -->
            <div class="p-5 rounded-2xl bg-[#090D16]/80 border border-[#EF4444]/30 space-y-3">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-xl bg-[#EF4444]/20 text-[#F87171] flex items-center justify-center font-bold text-xs shrink-0">
                        !
                    </div>
                    <h3 class="text-sm font-bold text-[#F87171] font-display">Poin Perhatian (Mendekati / Melebihi Budget)</h3>
                </div>

                <div class="space-y-2.5 pt-1">
                    @foreach($mlAnalysis['poin_minus'] as $minus)
                        <div class="p-3 rounded-xl bg-slate-900/60 border border-slate-800 space-y-1">
                            <h4 class="text-xs font-bold text-white font-display">{{ $minus['title'] }}</h4>
                            <p class="text-[11px] text-slate-300 font-medium leading-relaxed">{{ $minus['description'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

    </div>

    <!-- 2. TABEL PENGGUNAAN DANA: CASH VS TRANSFER (Docx Section 4.4 Requirement) -->
    <div class="cm-panel p-6 space-y-5">
        <div class="border-b border-[#E2E8F0] pb-4">
            <h2 class="text-base font-bold text-[#0F172A] font-display">Penggunaan Dana Berdasarkan Media: Cash vs Transfer (Bank / QRIS / E-Wallet)</h2>
            <p class="text-xs text-[#64748B] font-medium mt-0.5">Transfer antar akun internal ditampilkan sebagai aktivitas perpindahan saldo, bukan pengeluaran konsumtif. Biaya admin transfer tetap dicatat sebagai pengeluaran.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Table Cash -->
            <div class="space-y-3 p-4 rounded-2xl bg-[#F8FAFC] border border-[#E2E8F0]">
                <div class="flex items-center justify-between border-b border-[#CBD5E1] pb-2">
                    <span class="text-xs font-bold text-[#0F172A] uppercase tracking-wider font-display">💵 Transaksi Kas Tunai (Cash)</span>
                    <span class="text-xs font-bold text-[#10B981]">Aktif</span>
                </div>
                <div class="space-y-2 text-xs">
                    <div class="flex justify-between py-1 border-b border-[#E2E8F0]">
                        <span class="text-[#64748B]">Total Pemasukan Cash:</span>
                        <span class="font-bold text-[#10B981] financial-number">+ Rp {{ number_format($cashIncome, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-[#E2E8F0]">
                        <span class="text-[#64748B]">Total Pengeluaran Cash:</span>
                        <span class="font-bold text-[#EF4444] financial-number">- Rp {{ number_format($cashExpense, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between py-1">
                        <span class="text-[#0F172A] font-bold">Net Arus Kas Tunai:</span>
                        <span class="font-bold financial-number {{ ($cashIncome - $cashExpense) >= 0 ? 'text-[#10B981]' : 'text-[#EF4444]' }}">
                            Rp {{ number_format($cashIncome - $cashExpense, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Table Transfer (Bank / QRIS / E-Wallet) -->
            <div class="space-y-3 p-4 rounded-2xl bg-[#F8FAFC] border border-[#E2E8F0]">
                <div class="flex items-center justify-between border-b border-[#CBD5E1] pb-2">
                    <span class="text-xs font-bold text-[#0F172A] uppercase tracking-wider font-display">💳 Transaksi Transfer (Bank / E-Wallet)</span>
                    <span class="text-xs font-bold text-[#4F46E5]">Non-Konsumtif</span>
                </div>
                <div class="space-y-2 text-xs">
                    <div class="flex justify-between py-1 border-b border-[#E2E8F0]">
                        <span class="text-[#64748B]">Pemasukan Non-Cash:</span>
                        <span class="font-bold text-[#10B981] financial-number">+ Rp {{ number_format($transferIncome, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-[#E2E8F0]">
                        <span class="text-[#64748B]">Pengeluaran Non-Cash:</span>
                        <span class="font-bold text-[#EF4444] financial-number">- Rp {{ number_format($transferExpense, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between py-1">
                        <span class="text-[#0F172A] font-bold">Total Pemindahan Saldo Internal:</span>
                        <span class="font-bold text-[#4F46E5] financial-number">Rp {{ number_format($transferMovement, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. DETAILED SUMMARY METRICS & TRANSACTIONS LIST -->
    <div class="cm-panel p-6 space-y-6">
        <div class="flex items-center justify-between border-b border-[#E2E8F0] pb-4">
            <div>
                <h2 class="text-base font-bold text-[#0F172A] font-display">Histori Rincian Transaksi Periode {{ \Carbon\Carbon::create(null, $month, 1)->translatedFormat('F') }} {{ $year }}</h2>
                <p class="text-xs text-[#64748B] font-medium">Total {{ $transactions->count() }} catatan transaksi terverifikasi</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="border-b border-[#E2E8F0] bg-[#F8FAFC] text-[11px] font-bold uppercase tracking-wider text-[#475467]">
                        <th class="py-3 px-3">Tanggal</th>
                        <th class="py-3 px-3">Jenis</th>
                        <th class="py-3 px-3">Rekening</th>
                        <th class="py-3 px-3">Kategori</th>
                        <th class="py-3 px-3">Uraian / Deskripsi</th>
                        <th class="py-3 px-3 text-right">Nominal (Rp)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E2E8F0]">
                    @forelse($transactions as $t)
                        <tr class="hover:bg-[#F8FAFC]">
                            <td class="py-3 px-3 whitespace-nowrap text-[#475467] font-medium">{{ $t->transaction_date->format('d/m/Y') }}</td>
                            <td class="py-3 px-3 uppercase text-[10px] font-bold text-[#64748B]">{{ $t->type }}</td>
                            <td class="py-3 px-3 font-semibold text-[#0F172A]">{{ $t->account?->name }}</td>
                            <td class="py-3 px-3 text-[#475467]">{{ $t->category?->name ?? '-' }}</td>
                            <td class="py-3 px-3 text-[#334155] font-medium">{{ $t->description ?? '-' }}</td>
                            <td class="py-3 px-3 text-right financial-number font-bold {{ $t->type === 'income' ? 'text-[#10B981]' : ($t->type === 'expense' ? 'text-[#EF4444]' : 'text-[#4F46E5]') }}">
                                {{ $t->type === 'income' ? '+' : ($t->type === 'expense' ? '-' : '') }} Rp {{ number_format($t->amount, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-[#64748B] font-medium">
                                Belum ada catatan transaksi pada periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
