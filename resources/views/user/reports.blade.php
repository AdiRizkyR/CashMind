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
        { name: 'Sosial', pct: 5, alokasi: 547977, realisasi: 0 },
        { name: 'Dilla (transfer)', pct: 10, alokasi: 1095954, realisasi: 0 }
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
        { month: 'Juli', income: 10959540, expenses: 10722830, expected: 236710, actual: 0, missing: 236710 },
        { month: 'Agustus', income: 0, expenses: 0, expected: 0, actual: 0, missing: 0 },
        { month: 'September', income: 0, expenses: 0, expected: 0, actual: 0, missing: 0 },
        { month: 'Oktober', income: 0, expenses: 0, expected: 0, actual: 0, missing: 0 },
        { month: 'November', income: 0, expenses: 0, expected: 0, actual: 0, missing: 0 },
        { month: 'Desember', income: 0, expenses: 0, expected: 0, actual: 0, missing: 0 }
    ],

    formatRp(val) {
        return 'Rp ' + Number(val).toLocaleString('id-ID');
    },

    printReport() {
        window.print();
    }
}" class="space-y-6">

    <!-- Controls Bar -->
    <div class="bg-slate-900/90 p-6 rounded-3xl border border-slate-800 shadow-xl flex flex-col sm:flex-row sm:items-center justify-between gap-4 backdrop-blur-md print:hidden">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-400 text-[11px] font-bold uppercase tracking-wider">Modul Laporan</span>
                <span class="text-slate-500">•</span>
                <span class="text-xs text-slate-400 font-medium">Cetak PDF / Print</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white mt-1">Cetak Laporan Pendapatan & Pengeluaran</h1>
            <p class="text-xs text-slate-400 mt-1">Pilih jenis laporan bulanan atau rekapitulasi 12 bulan (Tahun 2026) untuk dicetak.</p>
        </div>

        <div class="flex items-center gap-3">
            <div class="flex items-center bg-slate-950/80 p-1 rounded-xl border border-slate-800 text-xs font-bold">
                <button @click="reportType = 'monthly'" :class="reportType === 'monthly' ? 'bg-emerald-500 text-slate-950' : 'text-slate-400'" class="px-3 py-1.5 rounded-lg transition">
                    Per Bulan (Juli)
                </button>
                <button @click="reportType = 'annual'" :class="reportType === 'annual' ? 'bg-emerald-500 text-slate-950' : 'text-slate-400'" class="px-3 py-1.5 rounded-lg transition">
                    Per Tahun (2026)
                </button>
            </div>

            <button @click="printReport()" class="px-5 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs shadow-lg shadow-emerald-500/20 transition flex items-center gap-2">
                <i class="fa-solid fa-print"></i>
                <span>Cetak Laporan (Print / PDF)</span>
            </button>
        </div>
    </div>

    <!-- PRINTABLE REPORT CONTAINER -->
    <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 sm:p-8 space-y-8 shadow-2xl print:bg-white print:text-black print:border-none print:shadow-none print:p-0">
        
        <!-- Formal Report Header -->
        <div class="border-b border-slate-800 pb-6 print:border-black flex justify-between items-start">
            <div>
                <div class="text-xs font-mono font-bold text-emerald-400 print:text-black uppercase">CASHMIND FINANCIAL REPORT</div>
                <h1 class="text-2xl font-extrabold text-white print:text-black mt-1" x-text="reportType === 'monthly' ? 'LAPORAN PENDAPATAN & PENGELUARAN (JULI 2026)' : 'LAPORAN REKAPITULASI KEUANGAN TAHUNAN (2026)'"></h1>
                <p class="text-xs text-slate-400 print:text-slate-600 mt-1">Dicetak pada: 27 Juli 2026 | Pemilik Akun: Aditya Personal</p>
            </div>

            <div class="text-right">
                <span class="inline-block px-3 py-1 rounded-lg bg-emerald-500/10 text-emerald-400 print:bg-gray-100 print:text-black font-bold text-xs uppercase" x-text="reportType === 'monthly' ? 'Periode: Juli 2026' : 'Periode: Tahun 2026'"></span>
            </div>
        </div>

        <!-- REPORT MODE 1: MONTHLY REPORT -->
        <div x-show="reportType === 'monthly'" class="space-y-6">
            <div class="grid grid-cols-4 gap-4 text-xs">
                <div class="p-4 rounded-xl bg-slate-950/60 border border-slate-800 print:border-black print:bg-gray-50">
                    <span class="text-slate-400 print:text-slate-600 block">Total Pendapatan (Income)</span>
                    <strong class="text-white print:text-black text-sm font-extrabold">Rp 10.959.540</strong>
                </div>
                <div class="p-4 rounded-xl bg-slate-950/60 border border-slate-800 print:border-black print:bg-gray-50">
                    <span class="text-slate-400 print:text-slate-600 block">Total Pengeluaran</span>
                    <strong class="text-white print:text-black text-sm font-extrabold">Rp 10.722.830</strong>
                </div>
                <div class="p-4 rounded-xl bg-slate-950/60 border border-slate-800 print:border-black print:bg-gray-50">
                    <span class="text-slate-400 print:text-slate-600 block">Total Alokasi Budget</span>
                    <strong class="text-white print:text-black text-sm font-extrabold">Rp 10.959.540</strong>
                </div>
                <div class="p-4 rounded-xl bg-amber-500/10 border border-amber-500/30 print:border-black print:bg-gray-50">
                    <span class="text-amber-400 print:text-slate-600 block font-bold">Selisih Kas (Missing)</span>
                    <strong class="text-amber-300 print:text-black text-sm font-extrabold">Rp 236.710</strong>
                </div>
            </div>

            <div>
                <h3 class="text-sm font-bold text-white print:text-black mb-3">1. Rekapitulasi Alokasi per Kategori Pengeluaran</h3>
                <table class="w-full text-left border-collapse text-xs print:border print:border-black">
                    <thead>
                        <tr class="bg-slate-950/80 print:bg-gray-100 text-slate-400 print:text-black font-bold uppercase text-[10px] border-b border-slate-800 print:border-black">
                            <th class="py-2.5 px-3">Kategori</th>
                            <th class="py-2.5 px-3">Target (%)</th>
                            <th class="py-2.5 px-3">Target Alokasi (Rp)</th>
                            <th class="py-2.5 px-3">Realisasi (Rp)</th>
                            <th class="py-2.5 px-3 text-right">Status Selisih Budget</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/60 print:divide-black">
                        <template x-for="c in categories" :key="c.name">
                            <tr class="print:border-b print:border-black">
                                <td class="py-2 px-3 font-bold text-white print:text-black" x-text="c.name"></td>
                                <td class="py-2 px-3 font-semibold text-slate-300 print:text-black" x-text="c.pct + '%'"></td>
                                <td class="py-2 px-3 font-semibold text-slate-300 print:text-black" x-text="formatRp(c.alokasi)"></td>
                                <td class="py-2 px-3 font-bold text-emerald-400 print:text-black" x-text="formatRp(c.realisasi)"></td>
                                <td class="py-2 px-3 text-right font-bold" :class="c.alokasi - c.realisasi < 0 ? 'text-rose-400 print:text-black' : 'text-slate-300 print:text-black'" x-text="c.alokasi - c.realisasi >= 0 ? 'Sisa ' + formatRp(c.alokasi - c.realisasi) : 'Defisit ' + formatRp(c.realisasi - c.alokasi)"></td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <div>
                <h3 class="text-sm font-bold text-white print:text-black mb-3">2. Rincian Transaksi Pengeluaran Harian</h3>
                <table class="w-full text-left border-collapse text-xs print:border print:border-black">
                    <thead>
                        <tr class="bg-slate-950/80 print:bg-gray-100 text-slate-400 print:text-black font-bold uppercase text-[10px] border-b border-slate-800 print:border-black">
                            <th class="py-2.5 px-3">Tanggal</th>
                            <th class="py-2.5 px-3">Tipe</th>
                            <th class="py-2.5 px-3">Uraian & Rincian</th>
                            <th class="py-2.5 px-3">Kategori</th>
                            <th class="py-2.5 px-3">Bank/Akun</th>
                            <th class="py-2.5 px-3 text-right">Nilai (Rp)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/60 print:divide-black">
                        <template x-for="t in transactions" :key="t.id">
                            <tr class="print:border-b print:border-black">
                                <td class="py-2 px-3 font-semibold text-white print:text-black" x-text="t.date"></td>
                                <td class="py-2 px-3 text-slate-300 print:text-black" x-text="t.type"></td>
                                <td class="py-2 px-3">
                                    <div class="font-bold text-slate-100 print:text-black" x-text="t.uraian"></div>
                                    <div class="text-[10px] text-slate-400 print:text-slate-600" x-text="t.rincian"></div>
                                </td>
                                <td class="py-2 px-3 text-slate-300 print:text-black" x-text="t.kategori"></td>
                                <td class="py-2 px-3 text-slate-300 print:text-black" x-text="t.bank"></td>
                                <td class="py-2 px-3 text-right font-bold text-rose-400 print:text-black" x-text="formatRp(t.amount)"></td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- REPORT MODE 2: ANNUAL 2026 SUMMARY REPORT -->
        <div x-show="reportType === 'annual'" class="space-y-6">
            <div>
                <h3 class="text-sm font-bold text-white print:text-black mb-3">Rekapitulasi Arus Kas Pendapatan & Pengeluaran 12 Bulan (Tahun 2026)</h3>
                <table class="w-full text-left border-collapse text-xs print:border print:border-black">
                    <thead>
                        <tr class="bg-slate-950/80 print:bg-gray-100 text-slate-400 print:text-black font-bold uppercase text-[10px] border-b border-slate-800 print:border-black">
                            <th class="py-2.5 px-3">Bulan</th>
                            <th class="py-2.5 px-3 text-right">Total Pemasukan</th>
                            <th class="py-2.5 px-3 text-right">Total Pengeluaran</th>
                            <th class="py-2.5 px-3 text-right">Saldo Seharusnya</th>
                            <th class="py-2.5 px-3 text-right">Saldo Real Nyata</th>
                            <th class="py-2.5 px-3 text-right">Selisih/Missing (Rp)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/60 print:divide-black">
                        <template x-for="a in annualSummary" :key="a.month">
                            <tr class="print:border-b print:border-black">
                                <td class="py-2.5 px-3 font-bold text-white print:text-black" x-text="a.month"></td>
                                <td class="py-2.5 px-3 text-right text-emerald-400 print:text-black font-bold" x-text="a.income > 0 ? formatRp(a.income) : '-'"></td>
                                <td class="py-2.5 px-3 text-right text-rose-400 print:text-black font-bold" x-text="a.expenses > 0 ? formatRp(a.expenses) : '-'"></td>
                                <td class="py-2.5 px-3 text-right text-slate-300 print:text-black font-semibold" x-text="a.expected > 0 ? formatRp(a.expected) : '-'"></td>
                                <td class="py-2.5 px-3 text-right text-slate-300 print:text-black font-semibold" x-text="a.actual > 0 ? formatRp(a.actual) : '-'"></td>
                                <td class="py-2.5 px-3 text-right text-amber-400 print:text-black font-bold" x-text="a.missing > 0 ? formatRp(a.missing) : '-'"></td>
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
                <div class="mt-12 font-bold underline">Aditya Personal</div>
                <div>Pemilik Akun CashMind</div>
            </div>
            <div class="text-right">
                <div>Tanggal Cetak: 27 Juli 2026</div>
                <div class="mt-12 font-bold underline">CashMind System 2026</div>
                <div>Sistem Rekonsiliasi Otomatis</div>
            </div>
        </div>
    </div>
</div>
@endsection
