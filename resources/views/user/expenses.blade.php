@extends('layouts.user')

@section('user-content')
<!-- Komentar Bahasa Indonesia: Command Center Pencatatan Pengeluaran Harian & Transfer -->
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

    <!-- Page Title & Controls Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Pencatatan Pengeluaran</h1>
            <p class="text-xs text-slate-500 mt-1">Kelola transaksi pengeluaran kas harian dan transfer bank/e-wallet.</p>
        </div>

        <button @click="showAddExpenseModal = true" class="exec-btn-primary bg-rose-600 hover:bg-rose-700 text-white">
            <i class="fa-solid fa-plus text-xs"></i>
            <span>Catat Pengeluaran</span>
        </button>
    </div>

    <!-- Data Table & Search Bar Card -->
    <div class="exec-panel p-6 space-y-4">
        
        <!-- Controls Toolbar -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-4 border-b border-slate-200">
            <div class="relative w-full md:w-72">
                <i class="fa-solid fa-magnifying-glass text-xs text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                <input type="text" x-model="searchQuery" placeholder="Cari uraian, bank, atau rincian..." class="exec-input w-full pl-9">
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <select x-model="filterCategory" class="exec-input cursor-pointer font-bold">
                    <option value="All">Semua Kategori</option>
                    <template x-for="c in categories" :key="c">
                        <option :value="c" x-text="c"></option>
                    </template>
                </select>

                <select x-model="filterBank" class="exec-input cursor-pointer font-bold">
                    <option value="All">Semua Bank/E-Wallet</option>
                    <option value="Cash">Cash (Tunai)</option>
                    <option value="BNI">BNI</option>
                    <option value="DANA">DANA</option>
                    <option value="BRI">BRI</option>
                </select>
            </div>
        </div>

        <!-- Ledger Table -->
        <div class="overflow-x-auto rounded-xl border border-slate-200">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-100/80 text-[11px] font-bold text-slate-500 uppercase tracking-wider border-b border-slate-200">
                        <th class="py-3.5 px-4">Tanggal & Tipe</th>
                        <th class="py-3.5 px-4">Uraian & Rincian</th>
                        <th class="py-3.5 px-4">Kategori</th>
                        <th class="py-3.5 px-4">Bank / Akun</th>
                        <th class="py-3.5 px-4 text-right">Nilai (Rp)</th>
                        <th class="py-3.5 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    <template x-for="t in filteredTransactions" :key="t.id">
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-slate-800" x-text="t.displayDate || t.date"></div>
                                <span class="inline-block px-2 py-0.5 rounded text-[10px] font-mono font-bold mt-0.5"
                                      :class="t.type === 'Cash' ? 'bg-amber-50 text-amber-800 border border-amber-200' : 'bg-sky-50 text-sky-800 border border-sky-200'"
                                      x-text="t.type"></span>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-extrabold text-slate-900 text-sm" x-text="t.uraian"></div>
                                <div class="text-[11px] text-slate-500 font-medium" x-text="t.rincian"></div>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-1 rounded-md bg-slate-100 border border-slate-200 text-slate-800 font-bold text-[11px]" x-text="t.kategori"></span>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-1.5 text-slate-800 font-bold">
                                    <i :class="t.bank === 'Cash' ? 'fa-solid fa-money-bill-wave text-amber-600' : 'fa-solid fa-building-columns text-sky-600'"></i>
                                    <span x-text="t.bank"></span>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 text-right font-extrabold text-rose-600 font-mono text-sm" x-text="formatRp(t.amount)"></td>
                            <td class="py-3.5 px-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <button @click="openEditExpense(t)" class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 border border-slate-200 text-slate-700 font-bold text-[11px] transition">
                                        <i class="fa-solid fa-pen text-[10px] mr-1"></i> Edit
                                    </button>
                                    <button @click="transactions = transactions.filter(item => item.id !== t.id)" class="px-2.5 py-1 rounded-lg bg-rose-50 hover:bg-rose-100 border border-rose-200 text-rose-600 font-bold text-[11px] transition">Hapus</button>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL 1: Tambah Pengeluaran Baru -->
    <div x-show="showAddExpenseModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm" x-transition>
        <div @click.outside="showAddExpenseModal = false" class="bg-white border border-slate-200 rounded-2xl p-6 max-w-lg w-full shadow-2xl space-y-5">
            <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-plus-circle text-rose-600"></i>
                    <span>Catat Pengeluaran Baru</span>
                </h3>
                <button @click="showAddExpenseModal = false" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark text-sm"></i></button>
            </div>

            <form @submit.prevent="showAddExpenseModal = false" class="space-y-4 text-xs">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Tanggal</label>
                        <input type="date" value="2026-07-27" class="exec-input w-full">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Tipe Pembayaran</label>
                        <select class="exec-input w-full cursor-pointer font-bold">
                            <option value="Cash">Cash (Tunai)</option>
                            <option value="Transfer">Transfer Bank / E-Wallet</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Uraian Transaksi</label>
                    <input type="text" placeholder="Contoh: Belanja bahan makanan" class="exec-input w-full">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Kategori</label>
                        <select class="exec-input w-full cursor-pointer font-bold">
                            <template x-for="c in categories" :key="c">
                                <option :value="c" x-text="c"></option>
                            </template>
                        </select>
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Bank / E-Wallet</label>
                        <select class="exec-input w-full cursor-pointer font-bold">
                            <option value="Cash">Cash</option>
                            <option value="BNI">BNI</option>
                            <option value="DANA">DANA</option>
                            <option value="BRI">BRI</option>
                            <option value="GoPay">GoPay</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nilai Pengeluaran (Rp)</label>
                    <input type="number" placeholder="50000" class="exec-input w-full font-mono font-bold">
                </div>

                <div class="pt-3 border-t border-slate-200 flex justify-end gap-2.5">
                    <button type="button" @click="showAddExpenseModal = false" class="exec-btn-secondary">Batal</button>
                    <button type="submit" class="exec-btn-primary bg-rose-600 hover:bg-rose-700 text-white">Simpan Pengeluaran</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 2: EDIT PENGELUARAN -->
    <div x-show="showEditExpenseModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm" x-transition>
        <div @click.outside="showEditExpenseModal = false" class="bg-white border border-slate-200 rounded-2xl p-6 max-w-lg w-full shadow-2xl space-y-5">
            <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-pen-to-square text-emerald-600"></i>
                    <span>Edit Transaksi Pengeluaran</span>
                </h3>
                <button @click="showEditExpenseModal = false" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark text-sm"></i></button>
            </div>

            <form @submit.prevent="saveEditedExpense()" class="space-y-4 text-xs">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Tanggal</label>
                        <input type="date" x-model="editingExpense.date" required class="exec-input w-full">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Tipe Pembayaran</label>
                        <select x-model="editingExpense.type" class="exec-input w-full cursor-pointer font-bold">
                            <option value="Cash">Cash (Tunai)</option>
                            <option value="Transfer">Transfer Bank / E-Wallet</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Uraian Transaksi</label>
                    <input type="text" x-model="editingExpense.uraian" required class="exec-input w-full">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Rincian Transaksi</label>
                    <input type="text" x-model="editingExpense.rincian" class="exec-input w-full">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Kategori</label>
                        <select x-model="editingExpense.kategori" class="exec-input w-full cursor-pointer font-bold">
                            <template x-for="c in categories" :key="c">
                                <option :value="c" x-text="c"></option>
                            </template>
                        </select>
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Bank / E-Wallet</label>
                        <select x-model="editingExpense.bank" class="exec-input w-full cursor-pointer font-bold">
                            <option value="Cash">Cash</option>
                            <option value="BNI">BNI</option>
                            <option value="DANA">DANA</option>
                            <option value="BRI">BRI</option>
                            <option value="GoPay">GoPay</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nilai Pengeluaran (Rp)</label>
                    <input type="number" x-model="editingExpense.amount" required class="exec-input w-full font-mono font-bold">
                </div>

                <div class="pt-3 border-t border-slate-200 flex justify-end gap-2.5">
                    <button type="button" @click="showEditExpenseModal = false" class="exec-btn-secondary">Batal</button>
                    <button type="submit" class="exec-btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
