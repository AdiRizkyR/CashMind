@extends('layouts.app')

@section('content')
<div x-data="{
    showAddTransactionModal: false,
    searchQuery: '',
    filterCategory: 'All',
    filterBank: 'All',
    filterType: 'All',

    categories: ['Makanan', 'Belanja', 'Tabungan', 'Hiburan', 'Kendaraan', 'Admin', 'Dana HP', 'Sosial', 'Dilla (transfer)'],

    transactions: [
        { id: 1, date: '15 Juli 2026', month: 'Juli', type: 'Transfer', uraian: 'Pembelian Gadget / HP Baru', rincian: 'Dp Unit HP', kategori: 'Dana HP', bank: 'BNI', amount: 5269620 },
        { id: 2, date: '14 Juli 2026', month: 'Juli', type: 'Transfer', uraian: 'Setor Emas Digital & Tabungan', rincian: 'DANA Emas', kategori: 'Tabungan', bank: 'DANA', amount: 4099765 },
        { id: 3, date: '12 Juli 2026', month: 'Juli', type: 'Cash', uraian: 'Belanja Bahan Makanan & Resto', rincian: 'Makan Mingguan', kategori: 'Makanan', bank: 'Cash', amount: 1129645 },
        { id: 4, date: '10 Juli 2026', month: 'Juli', type: 'Cash', uraian: 'Vape Cartridge & Sabun', rincian: 'Kebutuhan Harian', kategori: 'Belanja', bank: 'Cash', amount: 147300 },
        { id: 5, date: '08 Juli 2026', month: 'Juli', type: 'Transfer', uraian: 'Paket Data Internet & Game', rincian: 'WiFi & Game', kategori: 'Hiburan', bank: 'BNI', amount: 52500 },
        { id: 6, date: '05 Juli 2026', month: 'Juli', type: 'Transfer', uraian: 'Biaya Admin Bulanan Bank', rincian: 'Admin BNI', kategori: 'Admin', bank: 'BNI', amount: 19000 },
        { id: 7, date: '02 Juli 2026', month: 'Juli', type: 'Cash', uraian: 'Bensin Motor', rincian: 'Pertalite', kategori: 'Kendaraan', bank: 'Cash', amount: 5000 }
    ],

    get filteredTransactions() {
        return this.transactions.filter(t => {
            const matchesSearch = t.uraian.toLowerCase().includes(this.searchQuery.toLowerCase()) || 
                                  t.kategori.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                                  t.bank.toLowerCase().includes(this.searchQuery.toLowerCase());
            const matchesCategory = this.filterCategory === 'All' || t.kategori === this.filterCategory;
            const matchesBank = this.filterBank === 'All' || t.bank === this.filterBank;
            const matchesType = this.filterType === 'All' || t.type === this.filterType;
            return matchesSearch && matchesCategory && matchesBank && matchesType;
        });
    },

    formatRp(val) {
        return 'Rp ' + Number(val).toLocaleString('id-ID');
    }
}" class="space-y-6">

    <!-- Page Title & Header -->
    <div class="bg-slate-900/90 p-6 rounded-3xl border border-slate-800 shadow-xl flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-400 text-[11px] font-bold uppercase tracking-wider">Modul Transaksi</span>
                <span class="text-slate-500">•</span>
                <span class="text-xs text-slate-400 font-medium">Buku Kas Harian</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white mt-1">Kelola Transaksi Pengeluaran</h1>
            <p class="text-xs text-slate-400 mt-1">Pencatatan riwayat pengeluaran tunai (Cash) dan transfer bank/e-wallet.</p>
        </div>

        <button @click="showAddTransactionModal = true" class="px-4 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs shadow-lg shadow-emerald-500/20 transition flex items-center gap-2">
            <i class="fa-solid fa-plus text-xs"></i>
            <span>Tambah Transaksi Baru</span>
        </button>
    </div>

    <!-- Data Table & Search Bar Container -->
    <div class="bg-slate-900/90 p-6 rounded-3xl border border-slate-800 shadow-xl space-y-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-4 border-b border-slate-800">
            <div class="flex items-center gap-2 text-xs font-bold text-slate-300">
                <i class="fa-solid fa-filter text-emerald-400"></i>
                <span>Filter & Search Data</span>
            </div>

            <!-- Filters & Search -->
            <div class="flex flex-wrap items-center gap-3">
                <div class="relative">
                    <i class="fa-solid fa-magnifying-glass text-xs text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                    <input type="text" x-model="searchQuery" placeholder="Cari uraian, bank, kategori..." class="bg-slate-800 text-white text-xs pl-9 pr-4 py-2 rounded-xl border border-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 w-52 sm:w-64">
                </div>

                <select x-model="filterCategory" class="bg-slate-800 text-slate-300 text-xs px-3 py-2 rounded-xl border border-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <option value="All">Semua Kategori</option>
                    <template x-for="c in categories" :key="c">
                        <option :value="c" x-text="c"></option>
                    </template>
                </select>

                <select x-model="filterBank" class="bg-slate-800 text-slate-300 text-xs px-3 py-2 rounded-xl border border-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <option value="All">Semua Bank/E-Wallet</option>
                    <option value="Cash">Cash (Tunai)</option>
                    <option value="BNI">BNI</option>
                    <option value="DANA">DANA</option>
                    <option value="BRI">BRI</option>
                    <option value="GoPay">GoPay</option>
                </select>

                <select x-model="filterType" class="bg-slate-800 text-slate-300 text-xs px-3 py-2 rounded-xl border border-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <option value="All">Semua Tipe</option>
                    <option value="Cash">Cash</option>
                    <option value="Transfer">Transfer</option>
                </select>
            </div>
        </div>

        <!-- Data Table -->
        <div class="overflow-x-auto rounded-2xl border border-slate-800">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-950/80 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-800">
                        <th class="py-3.5 px-4">Tanggal & Tipe</th>
                        <th class="py-3.5 px-4">Uraian & Rincian</th>
                        <th class="py-3.5 px-4">Kategori</th>
                        <th class="py-3.5 px-4">Bank / Akun</th>
                        <th class="py-3.5 px-4 text-right">Nilai (Rp)</th>
                        <th class="py-3.5 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    <template x-for="t in filteredTransactions" :key="t.id">
                        <tr class="hover:bg-slate-800/40 transition">
                            <td class="py-3.5 px-4">
                                <div class="font-semibold text-white" x-text="t.date"></div>
                                <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase mt-0.5"
                                      :class="t.type === 'Cash' ? 'bg-amber-500/10 text-amber-400' : 'bg-sky-500/10 text-sky-400'"
                                      x-text="t.type"></span>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-slate-100" x-text="t.uraian"></div>
                                <div class="text-[11px] text-slate-400" x-text="t.rincian"></div>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-1 rounded-lg bg-slate-800 border border-slate-700 text-emerald-400 font-semibold text-[11px]" x-text="t.kategori"></span>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-1.5 text-slate-300">
                                    <i :class="t.bank === 'Cash' ? 'fa-solid fa-money-bill-wave text-amber-400' : 'fa-solid fa-building-columns text-sky-400'"></i>
                                    <span class="font-medium" x-text="t.bank"></span>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 text-right font-extrabold text-rose-400 text-sm" x-text="formatRp(t.amount)"></td>
                            <td class="py-3.5 px-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button class="w-7 h-7 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 flex items-center justify-center transition">
                                        <i class="fa-solid fa-pen text-[10px]"></i>
                                    </button>
                                    <button class="w-7 h-7 rounded-lg bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 flex items-center justify-center transition">
                                        <i class="fa-solid fa-trash text-[10px]"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL: Tambah Transaksi Baru -->
    <div x-show="showAddTransactionModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm" x-transition>
        <div @click.outside="showAddTransactionModal = false" class="bg-slate-900 border border-slate-800 rounded-3xl p-6 max-w-lg w-full shadow-2xl space-y-6">
            <div class="flex items-center justify-between pb-4 border-b border-slate-800">
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <i class="fa-solid fa-plus-circle text-emerald-400"></i>
                    <span>Tambah Transaksi Baru</span>
                </h3>
                <button @click="showAddTransactionModal = false" class="text-slate-400 hover:text-white"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>

            <form @submit.prevent="showAddTransactionModal = false" class="space-y-4 text-xs">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold text-slate-300 mb-1">Tanggal</label>
                        <input type="date" value="2026-07-27" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-white focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-300 mb-1">Tipe Pembayaran</label>
                        <select class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-white focus:ring-2 focus:ring-emerald-500">
                            <option value="Cash">Cash (Tunai)</option>
                            <option value="Transfer">Transfer Bank / E-Wallet</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block font-semibold text-slate-300 mb-1">Uraian Transaksi</label>
                    <input type="text" placeholder="Contoh: Makan Siang Resto" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-white focus:ring-2 focus:ring-emerald-500">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold text-slate-300 mb-1">Kategori</label>
                        <select class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-white focus:ring-2 focus:ring-emerald-500">
                            <template x-for="c in categories" :key="c">
                                <option :value="c" x-text="c"></option>
                            </template>
                        </select>
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-300 mb-1">Bank / E-Wallet</label>
                        <select class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-white focus:ring-2 focus:ring-emerald-500">
                            <option value="Cash">Cash</option>
                            <option value="BNI">BNI</option>
                            <option value="DANA">DANA</option>
                            <option value="BRI">BRI</option>
                            <option value="GoPay">GoPay</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block font-semibold text-slate-300 mb-1">Nilai Pengeluaran (Rp)</label>
                    <input type="number" placeholder="50000" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-white focus:ring-2 focus:ring-emerald-500 font-bold text-sm">
                </div>

                <div class="pt-4 flex justify-end gap-3">
                    <button type="button" @click="showAddTransactionModal = false" class="px-4 py-2 rounded-xl bg-slate-800 text-slate-300 font-bold hover:bg-slate-700">Batal</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-500 text-slate-950 font-bold hover:bg-emerald-400 shadow-lg shadow-emerald-500/20">Simpan Transaksi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
