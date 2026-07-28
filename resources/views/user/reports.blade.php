@extends('layouts.user')

@section('user-content')
<div x-data="{
    reportType: 'monthly',

    categories: [
        { name: 'Makanan', pct: 40, alokasi: 4383816, realisasi: 1129645 },
        { name: 'Belanja', pct: 10, alokasi: 1095954, realisasi: 147300 },
        { name: 'Tabungan', pct: 0, alokasi: 0, realisasi: 4099765 },
        { name: 'Hiburan', pct: 8, alokasi: 876763, realisasi: 52500 },
        { name: 'Kendaraan', pct: 10, alokasi: 1095954, realisasi: 5000 },
        { name: 'Admin', pct: 2, alokasi: 219191, realisasi: 19000 },
        { name: 'Dana HP', pct: 15, alokasi: 1643931, realisasi: 5269620 },
        { name: 'Sosial', pct: 5, alokasi: 547977, realisasi: 0 }
    ],

    transactions: [
        { id: 1, date: '15 Juli 2026', type: 'Transfer', uraian: 'Pembelian Gadget / HP Baru', rincian: 'Dp Unit HP', kategori: 'Dana HP', bank: 'BNI', amount: 5269620 },
        { id: 2, date: '14 Juli 2026', type: 'Transfer', uraian: 'Setor Emas Digital & Tabungan', rincian: 'DANA Emas', kategori: 'Tabungan', bank: 'DANA', amount: 4099765 },
        { id: 3, date: '12 Juli 2026', type: 'Cash', uraian: 'Belanja Bahan Makanan & Resto', rincian: 'Makan Mingguan', kategori: 'Makanan', bank: 'Cash', amount: 1129645 },
        { id: 4, date: '10 Juli 2026', type: 'Cash', uraian: 'Vape Cartridge & Sabun', rincian: 'Kebutuhan Harian', kategori: 'Belanja', bank: 'Cash', amount: 147300 },
        { id: 5, date: '08 Juli 2026', type: 'Transfer', uraian: 'Paket Data Internet & Game', rincian: 'WiFi & Game', kategori: 'Hiburan', bank: 'BNI', amount: 52500 },
        { id: 6, date: '05 Juli 2026', type: 'Transfer', uraian: 'Biaya Admin Bulanan Bank', rincian: 'Admin BNI', kategori: 'Admin', bank: 'BNI', amount: 19000 },
        { id: 7, date: '02 Juli 2026', type: 'Cash', uraian: 'Bensin Motor', rincian: 'Pertalite', kategori: 'Kendaraan', bank: 'Cash', amount: 5000 }
    ],

    annualSummary: [
        { month: 'Januari', income: 4035594, expenses: 3563655, expected: 471939, actual: 386962, missing: 84977 },
        { month: 'Februari', income: 2386962, expenses: 2173300, expected: 213662, actual: 155528, missing: 58134 },
        { month: 'Maret', income: 6210023, expenses: 5891300, expected: 318723, actual: 299497, missing: 19226 },
        { month: 'April', income: 2299497, expenses: 2124727, expected: 174770, actual: 151319, missing: 23451 },
        { month: 'Mei', income: 2451319, expenses: 2398163, expected: 53156, actual: 9776, missing: 43380 },
        { month: 'Juni', income: 2309776, expenses: 2179900, expected: 129876, actual: 116775, missing: 13101 },
        { month: 'Juli', income: 10959540, expenses: 10722830, expected: 236710, actual: 0, missing: 236710 }
    ],

    formatRp(val) {
        return 'Rp ' + Number(val).toLocaleString('id-ID');
    },

    printReport() {
        window.print();
    }
}" class="space-y-6">

    <!-- Controls Bar (Hidden on Print) -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 print:hidden">
        <div>
            <h1 class="text-xl font-bold text-zinc-100 tracking-tight">Laporan Keuangan</h1>
            <p class="text-xs text-zinc-400 mt-0.5">Cetak statement pendapatan, pengeluaran, dan audit selisih kas resmi.</p>
        </div>

        <div class="flex items-center gap-3">
            <div class="flex items-center bg-zinc-950 p-1 rounded-lg border border-zinc-800 text-xs font-medium">
                <button @click="reportType = 'monthly'" :class="reportType === 'monthly' ? 'bg-zinc-800 text-zinc-100 font-semibold' : 'text-zinc-400 hover:text-zinc-200'" class="px-3 py-1 rounded-md transition">
                    Per Bulan (Juli)
                </button>
                <button @click="reportType = 'annual'" :class="reportType === 'annual' ? 'bg-zinc-800 text-zinc-100 font-semibold' : 'text-zinc-400 hover:text-zinc-200'" class="px-3 py-1 rounded-md transition">
                    Per Tahun (2026)
                </button>
            </div>

            <button @click="printReport()" class="saas-btn-primary flex items-center gap-1.5">
                <i class="fa-solid fa-print text-xs"></i>
                <span>Cetak Laporan PDF</span>
            </button>
        </div>
    </div>

    <!-- PRINTABLE STATEMENT CONTAINER -->
    <div class="saas-card p-6 sm:p-8 space-y-8 print:bg-white print:text-black print:border-none print:shadow-none print:p-0">
        
        <!-- Formal Report Header -->
        <div class="border-b border-zinc-800 pb-6 print:border-black flex justify-between items-start">
            <div>
                <div class="text-[11px] font-mono font-bold text-emerald-400 print:text-black uppercase">CASHMIND FINANCIAL STATEMENT</div>
                <h1 class="text-xl font-bold text-zinc-100 print:text-black mt-1" x-text="reportType === 'monthly' ? 'LAPORAN PENDAPATAN & PENGELUARAN (JULI 2026)' : 'LAPORAN REKAPITULASI KEUANGAN TAHUNAN (2026)'"></h1>
                <p class="text-xs text-zinc-400 print:text-zinc-600 mt-1">Dicetak pada: 28 Juli 2026 | Pemilik Akun: {{ Auth::user()->name ?? 'Aditya Personal' }}</p>
            </div>

            <div class="text-right">
                <span class="inline-block px-3 py-1 rounded-md bg-zinc-900 border border-zinc-800 text-zinc-300 print:bg-gray-100 print:text-black print:border-black font-mono text-xs" x-text="reportType === 'monthly' ? 'Periode: Juli 2026' : 'Periode: Tahun 2026'"></span>
            </div>
        </div>

        <!-- REPORT MODE 1: MONTHLY REPORT -->
        <div x-show="reportType === 'monthly'" class="space-y-6">
            <div class="grid grid-cols-4 gap-4 text-xs">
                <div class="p-4 rounded-xl bg-zinc-950/60 border border-zinc-800/80 print:border-black print:bg-gray-50">
                    <span class="text-zinc-500 print:text-zinc-600 block text-[11px]">Total Pendapatan</span>
                    <strong class="text-zinc-100 print:text-black text-sm font-bold font-mono">Rp 10.959.540</strong>
                </div>
                <div class="p-4 rounded-xl bg-zinc-950/60 border border-zinc-800/80 print:border-black print:bg-gray-50">
                    <span class="text-zinc-500 print:text-zinc-600 block text-[11px]">Total Pengeluaran</span>
                    <strong class="text-zinc-100 print:text-black text-sm font-bold font-mono">Rp 10.722.830</strong>
                </div>
                <div class="p-4 rounded-xl bg-zinc-950/60 border border-zinc-800/80 print:border-black print:bg-gray-50">
                    <span class="text-zinc-500 print:text-zinc-600 block text-[11px]">Saldo Seharusnya</span>
                    <strong class="text-zinc-100 print:text-black text-sm font-bold font-mono">Rp 236.710</strong>
                </div>
                <div class="p-4 rounded-xl bg-amber-500/5 border border-amber-500/20 print:border-black print:bg-gray-50">
                    <span class="text-amber-400 print:text-zinc-600 block text-[11px]">Missing Cash Selisih</span>
                    <strong class="text-amber-300 print:text-black text-sm font-bold font-mono">Rp 236.710</strong>
                </div>
            </div>

            <div>
                <h3 class="text-xs font-semibold text-zinc-200 print:text-black uppercase font-mono mb-3">1. Rekapitulasi Alokasi per Kategori</h3>
                <table class="w-full text-left border-collapse text-xs print:border print:border-black">
                    <thead>
                        <tr class="bg-zinc-950/80 print:bg-gray-100 text-zinc-400 print:text-black font-semibold text-[10px] uppercase border-b border-zinc-800 print:border-black">
                            <th class="py-2.5 px-3">Kategori</th>
                            <th class="py-2.5 px-3">Target (%)</th>
                            <th class="py-2.5 px-3">Target Alokasi (Rp)</th>
                            <th class="py-2.5 px-3">Realisasi (Rp)</th>
                            <th class="py-2.5 px-3 text-right">Status Selisih</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-800/60 print:divide-black">
                        <template x-for="c in categories" :key="c.name">
                            <tr class="print:border-b print:border-black">
                                <td class="py-2 px-3 font-semibold text-zinc-200 print:text-black" x-text="c.name"></td>
                                <td class="py-2 px-3 font-mono text-zinc-400 print:text-black" x-text="c.pct + '%'"></td>
                                <td class="py-2 px-3 font-mono text-zinc-300 print:text-black" x-text="formatRp(c.alokasi)"></td>
                                <td class="py-2 px-3 font-mono text-emerald-400 print:text-black font-bold" x-text="formatRp(c.realisasi)"></td>
                                <td class="py-2 px-3 text-right font-mono font-semibold" :class="c.alokasi - c.realisasi < 0 ? 'text-rose-400 print:text-black' : 'text-zinc-400 print:text-black'" x-text="c.alokasi - c.realisasi >= 0 ? 'Sisa ' + formatRp(c.alokasi - c.realisasi) : 'Defisit ' + formatRp(c.realisasi - c.alokasi)"></td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <div>
                <h3 class="text-xs font-semibold text-zinc-200 print:text-black uppercase font-mono mb-3">2. Rincian Transaksi Pengeluaran Harian</h3>
                <table class="w-full text-left border-collapse text-xs print:border print:border-black">
                    <thead>
                        <tr class="bg-zinc-950/80 print:bg-gray-100 text-zinc-400 print:text-black font-semibold text-[10px] uppercase border-b border-zinc-800 print:border-black">
                            <th class="py-2.5 px-3">Tanggal</th>
                            <th class="py-2.5 px-3">Tipe</th>
                            <th class="py-2.5 px-3">Uraian & Rincian</th>
                            <th class="py-2.5 px-3">Kategori</th>
                            <th class="py-2.5 px-3">Bank/Akun</th>
                            <th class="py-2.5 px-3 text-right">Nilai (Rp)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-800/60 print:divide-black">
                        <template x-for="t in transactions" :key="t.id">
                            <tr class="print:border-b print:border-black">
                                <td class="py-2 px-3 text-zinc-300 print:text-black" x-text="t.date"></td>
                                <td class="py-2 px-3 font-mono text-zinc-400 print:text-black text-[11px]" x-text="t.type"></td>
                                <td class="py-2 px-3">
                                    <div class="font-semibold text-zinc-200 print:text-black" x-text="t.uraian"></div>
                                    <div class="text-[10px] text-zinc-500 print:text-zinc-600" x-text="t.rincian"></div>
                                </td>
                                <td class="py-2 px-3 text-zinc-300 print:text-black" x-text="t.kategori"></td>
                                <td class="py-2 px-3 text-zinc-300 print:text-black" x-text="t.bank"></td>
                                <td class="py-2 px-3 text-right font-mono font-bold text-rose-400 print:text-black" x-text="formatRp(t.amount)"></td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- REPORT MODE 2: ANNUAL 2026 SUMMARY REPORT -->
        <div x-show="reportType === 'annual'" class="space-y-6">
            <div>
                <h3 class="text-xs font-semibold text-zinc-200 print:text-black uppercase font-mono mb-3">Rekapitulasi Arus Kas 12 Bulan (Tahun 2026)</h3>
                <table class="w-full text-left border-collapse text-xs print:border print:border-black">
                    <thead>
                        <tr class="bg-zinc-950/80 print:bg-gray-100 text-zinc-400 print:text-black font-semibold text-[10px] uppercase border-b border-zinc-800 print:border-black">
                            <th class="py-2.5 px-3">Bulan</th>
                            <th class="py-2.5 px-3 text-right">Total Pemasukan</th>
                            <th class="py-2.5 px-3 text-right">Total Pengeluaran</th>
                            <th class="py-2.5 px-3 text-right">Saldo Seharusnya</th>
                            <th class="py-2.5 px-3 text-right">Saldo Real Nyata</th>
                            <th class="py-2.5 px-3 text-right">Selisih/Missing (Rp)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-800/60 print:divide-black">
                        <template x-for="a in annualSummary" :key="a.month">
                            <tr class="print:border-b print:border-black">
                                <td class="py-2.5 px-3 font-semibold text-zinc-200 print:text-black" x-text="a.month"></td>
                                <td class="py-2.5 px-3 text-right font-mono text-emerald-400 print:text-black font-bold" x-text="a.income > 0 ? formatRp(a.income) : '-'"></td>
                                <td class="py-2.5 px-3 text-right font-mono text-rose-400 print:text-black font-bold" x-text="a.expenses > 0 ? formatRp(a.expenses) : '-'"></td>
                                <td class="py-2.5 px-3 text-right font-mono text-zinc-300 print:text-black font-semibold" x-text="a.expected > 0 ? formatRp(a.expected) : '-'"></td>
                                <td class="py-2.5 px-3 text-right font-mono text-zinc-300 print:text-black font-semibold" x-text="a.actual > 0 ? formatRp(a.actual) : '-'"></td>
                                <td class="py-2.5 px-3 text-right font-mono text-amber-400 print:text-black font-bold" x-text="a.missing > 0 ? formatRp(a.missing) : '-'"></td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Formal Signatures Footer on Print -->
        <div class="hidden print:flex justify-between items-end pt-12 text-xs text-black">
            <div>
                <div>Mengetahui,</div>
                <div class="mt-12 font-bold underline">{{ Auth::user()->name ?? 'Aditya Personal' }}</div>
                <div>Pemilik Akun CashMind</div>
            </div>
            <div class="text-right">
                <div>Tanggal Cetak: 28 Juli 2026</div>
                <div class="mt-12 font-bold underline">CashMind System 2026</div>
                <div>Sistem Rekonsiliasi Otomatis</div>
            </div>
        </div>
    </div>
</div>
@endsection
