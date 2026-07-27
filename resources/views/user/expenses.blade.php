@extends('layouts.user')

@section('user-content')
<div x-data="{
    showAddExpenseModal: false,
    showEditExpenseModal: false,
    searchQuery: '',
    filterCategory: 'All',
    filterBank: 'All',

    editingExpense: { id: null, date: '', type: 'Cash', uraian: '', rincian: '', kategori: 'Makanan', bank: 'Cash', amount: 0 },

    categories: ['Makanan', 'Belanja', 'Tabungan', 'Hiburan', 'Kendaraan', 'Admin', 'Dana HP', 'Sosial', 'Dilla (transfer)'],

    transactions: [
        { id: 1, date: '2026-07-15', displayDate: '15 Juli 2026', type: 'Transfer', uraian: 'Pembelian Gadget / HP Baru', rincian: 'Dp Unit HP', kategori: 'Dana HP', bank: 'BNI', amount: 5269620 },
        { id: 2, date: '2026-07-14', displayDate: '14 Juli 2026', type: 'Transfer', uraian: 'Setor Emas Digital & Tabungan', rincian: 'DANA Emas', kategori: 'Tabungan', bank: 'DANA', amount: 4099765 },
        { id: 3, date: '2026-07-12', displayDate: '12 Juli 2026', type: 'Cash', uraian: 'Belanja Bahan Makanan & Resto', rincian: 'Makan Mingguan', kategori: 'Makanan', bank: 'Cash', amount: 1129645 },
        { id: 4, date: '2026-07-10', displayDate: '10 Juli 2026', type: 'Cash', uraian: 'Vape Cartridge & Sabun', rincian: 'Kebutuhan Harian', kategori: 'Belanja', bank: 'Cash', amount: 147300 },
        { id: 5, date: '2026-07-08', displayDate: '08 Juli 2026', type: 'Transfer', uraian: 'Paket Data Internet & Game', rincian: 'WiFi & Game', kategori: 'Hiburan', bank: 'BNI', amount: 52500 },
        { id: 6, date: '2026-07-05', displayDate: '05 Juli 2026', type: 'Transfer', uraian: 'Biaya Admin Bulanan Bank', rincian: 'Admin BNI', kategori: 'Admin', bank: 'BNI', amount: 19000 },
        { id: 7, date: '2026-07-02', displayDate: '02 Juli 2026', type: 'Cash', uraian: 'Bensin Motor', rincian: 'Pertalite', kategori: 'Kendaraan', bank: 'Cash', amount: 5000 }
    ],

    get filteredTransactions() {
        return this.transactions.filter(t => {
            const matchesSearch = t.uraian.toLowerCase().includes(this.searchQuery.toLowerCase()) || 
                                  t.kategori.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                                  t.bank.toLowerCase().includes(this.searchQuery.toLowerCase());
            const matchesCategory = this.filterCategory === 'All' || t.kategori === this.filterCategory;
            const matchesBank = this.filterBank === 'All' || t.bank === this.filterBank;
            return matchesSearch && matchesCategory && matchesBank;
        });
    },

    formatRp(val) {
        return 'Rp ' + Number(val).toLocaleString('id-ID');
    },

    openEditExpense(item) {
        this.editingExpense = JSON.parse(JSON.stringify(item));
        this.showEditExpenseModal = true;
    },

    saveEditedExpense() {
        const index = this.transactions.findIndex(t => t.id === this.editingExpense.id);
        if (index !== -1) {
            const dateObj = new Date(this.editingExpense.date);
            const options = { day: '2-digit', month: 'long', year: 'numeric' };
            this.editingExpense.displayDate = dateObj.toLocaleDateString('id-ID', options);
            this.transactions[index] = { ...this.editingExpense };
        }
        this.showEditExpenseModal = false;
    }
}" class="space-y-6">

    <!-- Page Title & Header -->
    <div class="bg-slate-900/90 p-6 rounded-3xl border border-slate-800 shadow-xl flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-1 rounded-full bg-rose-500/10 text-rose-400 text-[11px] font-bold uppercase tracking-wider">Modul Pengeluaran</span>
                <span class="text-slate-500">•</span>
                <span class="text-xs text-slate-400 font-medium">Daily Expense Tracker</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white mt-1">Pencatatan & Edit Pengeluaran Harian</h1>
            <p class="text-xs text-slate-400 mt-1">Catat dan ubah transaksi pengeluaran tunai (Cash) dan transfer bank/e-wallet secara fleksibel.</p>
        </div>

        <button @click="showAddExpenseModal = true" class="px-4 py-2.5 rounded-xl bg-rose-500 hover:bg-rose-400 text-white font-bold text-xs shadow-lg shadow-rose-500/20 transition flex items-center gap-2">
            <i class="fa-solid fa-plus text-xs"></i>
            <span>Catat Pengeluaran Baru</span>
        </button>
    </div>

    <!-- Data Table & Search Bar Container -->
    <div class="bg-slate-900/90 p-6 rounded-3xl border border-slate-800 shadow-xl space-y-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-4 border-b border-slate-800">
            <div class="flex items-center gap-2 text-xs font-bold text-slate-300">
                <i class="fa-solid fa-filter text-rose-400"></i>
                <span>Filter & Search Pengeluaran</span>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <div class="relative">
                    <i class="fa-solid fa-magnifying-glass text-xs text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                    <input type="text" x-model="searchQuery" placeholder="Cari uraian, bank, kategori..." class="bg-slate-800 text-white text-xs pl-9 pr-4 py-2 rounded-xl border border-slate-700 focus:outline-none focus:ring-2 focus:ring-rose-500 w-52 sm:w-64">
                </div>

                <select x-model="filterCategory" class="bg-slate-800 text-slate-300 text-xs px-3 py-2 rounded-xl border border-slate-700 focus:outline-none focus:ring-2 focus:ring-rose-500">
                    <option value="All">Semua Kategori</option>
                    <template x-for="c in categories" :key="c">
                        <option :value="c" x-text="c"></option>
                    </template>
                </select>
            </div>
        </div>

        <!-- Data Table (With Edit Buttons) -->
        <div class="overflow-x-auto rounded-2xl border border-slate-800">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-950/80 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-800">
                        <th class="py-3.5 px-4">Tanggal & Tipe</th>
                        <th class="py-3.5 px-4">Uraian & Rincian</th>
                        <th class="py-3.5 px-4">Kategori</th>
                        <th class="py-3.5 px-4">Bank / Akun</th>
                        <th class="py-3.5 px-4 text-right">Nilai Pengeluaran (Rp)</th>
                        <th class="py-3.5 px-4 text-center">Aksi / Edit</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    <template x-for="t in filteredTransactions" :key="t.id">
                        <tr class="hover:bg-slate-800/40 transition">
                            <td class="py-3.5 px-4">
                                <div class="font-semibold text-white" x-text="t.displayDate || t.date"></div>
                                <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase mt-0.5"
                                      :class="t.type === 'Cash' ? 'bg-amber-500/10 text-amber-400' : 'bg-sky-500/10 text-sky-400'"
                                      x-text="t.type"></span>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-slate-100" x-text="t.uraian"></div>
                                <div class="text-[11px] text-slate-400" x-text="t.rincian"></div>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-1 rounded-lg bg-slate-800 border border-slate-700 text-rose-300 font-semibold text-[11px]" x-text="t.kategori"></span>
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
                                    <button @click="openEditExpense(t)" class="px-3 py-1.5 rounded-xl bg-amber-500/10 hover:bg-amber-500/20 border border-amber-500/30 text-amber-300 font-bold text-xs transition flex items-center gap-1">
                                        <i class="fa-solid fa-pen text-[10px]"></i>
                                        <span>Edit</span>
                                    </button>
                                    <button @click="transactions = transactions.filter(item => item.id !== t.id)" class="px-2.5 py-1.5 rounded-xl bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 font-bold text-xs transition">Hapus</button>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL 1: Tambah Pengeluaran Baru -->
    <div x-show="showAddExpenseModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm" x-transition>
        <div @click.outside="showAddExpenseModal = false" class="bg-slate-900 border border-slate-800 rounded-3xl p-6 max-w-lg w-full shadow-2xl space-y-6">
            <div class="flex items-center justify-between pb-4 border-b border-slate-800">
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <i class="fa-solid fa-plus-circle text-rose-400"></i>
                    <span>Catat Pengeluaran Baru</span>
                </h3>
                <button @click="showAddExpenseModal = false" class="text-slate-400 hover:text-white"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>

            <form @submit.prevent="showAddExpenseModal = false" class="space-y-4 text-xs">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold text-slate-300 mb-1">Tanggal</label>
                        <input type="date" value="2026-07-27" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-white focus:ring-2 focus:ring-rose-500">
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-300 mb-1">Tipe Pembayaran</label>
                        <select class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-white focus:ring-2 focus:ring-rose-500">
                            <option value="Cash">Cash (Tunai)</option>
                            <option value="Transfer">Transfer Bank / E-Wallet</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block font-semibold text-slate-300 mb-1">Uraian Transaksi</label>
                    <input type="text" placeholder="Contoh: Belanja bahan makanan" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-white focus:ring-2 focus:ring-rose-500">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold text-slate-300 mb-1">Kategori</label>
                        <select class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-white focus:ring-2 focus:ring-rose-500">
                            <template x-for="c in categories" :key="c">
                                <option :value="c" x-text="c"></option>
                            </template>
                        </select>
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-300 mb-1">Bank / E-Wallet</label>
                        <select class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-white focus:ring-2 focus:ring-rose-500">
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
                    <input type="number" placeholder="50000" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-white focus:ring-2 focus:ring-rose-500 font-bold text-sm">
                </div>

                <div class="pt-4 flex justify-end gap-3">
                    <button type="button" @click="showAddExpenseModal = false" class="px-4 py-2 rounded-xl bg-slate-800 text-slate-300 font-bold hover:bg-slate-700">Batal</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-rose-500 text-white font-bold hover:bg-rose-400 shadow-lg shadow-rose-500/20">Simpan Pengeluaran</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 2: EDIT PENGELUARAN -->
    <div x-show="showEditExpenseModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm" x-transition>
        <div @click.outside="showEditExpenseModal = false" class="bg-slate-900 border border-slate-800 rounded-3xl p-6 max-w-lg w-full shadow-2xl space-y-6">
            <div class="flex items-center justify-between pb-4 border-b border-slate-800">
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <i class="fa-solid fa-pen-to-square text-amber-400"></i>
                    <span>Edit Transaksi Pengeluaran</span>
                </h3>
                <button @click="showEditExpenseModal = false" class="text-slate-400 hover:text-white"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>

            <form @submit.prevent="saveEditedExpense()" class="space-y-4 text-xs">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold text-slate-300 mb-1">Tanggal</label>
                        <input type="date" x-model="editingExpense.date" required class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-white focus:ring-2 focus:ring-amber-500">
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-300 mb-1">Tipe Pembayaran</label>
                        <select x-model="editingExpense.type" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-white focus:ring-2 focus:ring-amber-500">
                            <option value="Cash">Cash (Tunai)</option>
                            <option value="Transfer">Transfer Bank / E-Wallet</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block font-semibold text-slate-300 mb-1">Uraian Transaksi</label>
                    <input type="text" x-model="editingExpense.uraian" required class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-white focus:ring-2 focus:ring-amber-500">
                </div>

                <div>
                    <label class="block font-semibold text-slate-300 mb-1">Rincian Transaksi</label>
                    <input type="text" x-model="editingExpense.rincian" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-white focus:ring-2 focus:ring-amber-500">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold text-slate-300 mb-1">Kategori</label>
                        <select x-model="editingExpense.kategori" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-white focus:ring-2 focus:ring-amber-500">
                            <template x-for="c in categories" :key="c">
                                <option :value="c" x-text="c"></option>
                            </template>
                        </select>
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-300 mb-1">Bank / E-Wallet</label>
                        <select x-model="editingExpense.bank" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-white focus:ring-2 focus:ring-amber-500">
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
                    <input type="number" x-model="editingExpense.amount" required class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-white focus:ring-2 focus:ring-amber-500 font-bold text-sm">
                </div>

                <div class="pt-4 flex justify-end gap-3">
                    <button type="button" @click="showEditExpenseModal = false" class="px-4 py-2 rounded-xl bg-slate-800 text-slate-300 font-bold hover:bg-slate-700">Batal</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-amber-500 text-slate-950 font-bold hover:bg-amber-400">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
