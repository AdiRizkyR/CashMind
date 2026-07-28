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
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-zinc-100 tracking-tight">Pencatatan Pengeluaran</h1>
            <p class="text-xs text-zinc-400 mt-0.5">Kelola riwayat pengeluaran tunai (Cash) dan transfer bank/e-wallet.</p>
        </div>

        <button @click="showAddExpenseModal = true" class="saas-btn-primary flex items-center gap-1.5">
            <i class="fa-solid fa-plus text-[10px]"></i>
            <span>Catat Pengeluaran</span>
        </button>
    </div>

    <!-- Data Table & Search Bar Card -->
    <div class="saas-card p-6 space-y-4">
        
        <!-- Controls Bar -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-4 border-b border-zinc-800/80">
            <div class="relative w-full md:w-64">
                <i class="fa-solid fa-magnifying-glass text-xs text-zinc-500 absolute left-3 top-1/2 -translate-y-1/2"></i>
                <input type="text" x-model="searchQuery" placeholder="Cari uraian, bank..." class="saas-input w-full pl-9">
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <select x-model="filterCategory" class="saas-input cursor-pointer">
                    <option value="All">Semua Kategori</option>
                    <template x-for="c in categories" :key="c">
                        <option :value="c" x-text="c"></option>
                    </template>
                </select>

                <select x-model="filterBank" class="saas-input cursor-pointer">
                    <option value="All">Semua Bank/E-Wallet</option>
                    <option value="Cash">Cash (Tunai)</option>
                    <option value="BNI">BNI</option>
                    <option value="DANA">DANA</option>
                    <option value="BRI">BRI</option>
                </select>
            </div>
        </div>

        <!-- Data Table -->
        <div class="overflow-x-auto rounded-xl border border-zinc-800/80">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-zinc-950/80 text-[11px] font-semibold text-zinc-400 uppercase tracking-wider border-b border-zinc-800">
                        <th class="py-3 px-4">Tanggal & Tipe</th>
                        <th class="py-3 px-4">Uraian & Rincian</th>
                        <th class="py-3 px-4">Kategori</th>
                        <th class="py-3 px-4">Bank / Akun</th>
                        <th class="py-3 px-4 text-right">Nilai (Rp)</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-800/60">
                    <template x-for="t in filteredTransactions" :key="t.id">
                        <tr class="hover:bg-zinc-900/40 transition">
                            <td class="py-3 px-4">
                                <div class="font-medium text-zinc-200" x-text="t.displayDate || t.date"></div>
                                <span class="inline-block px-2 py-0.5 rounded text-[10px] font-mono mt-0.5"
                                      :class="t.type === 'Cash' ? 'bg-amber-500/10 text-amber-400 border border-amber-500/20' : 'bg-sky-500/10 text-sky-400 border border-sky-500/20'"
                                      x-text="t.type"></span>
                            </td>
                            <td class="py-3 px-4">
                                <div class="font-semibold text-zinc-100 text-sm" x-text="t.uraian"></div>
                                <div class="text-[11px] text-zinc-400" x-text="t.rincian"></div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2.5 py-1 rounded-md bg-zinc-900 border border-zinc-800 text-zinc-300 font-medium text-[11px]" x-text="t.kategori"></span>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-1.5 text-zinc-300 font-medium">
                                    <i :class="t.bank === 'Cash' ? 'fa-solid fa-money-bill-wave text-amber-400' : 'fa-solid fa-building-columns text-sky-400'"></i>
                                    <span x-text="t.bank"></span>
                                </div>
                            </td>
                            <td class="py-3 px-4 text-right font-bold text-rose-400 font-mono text-sm" x-text="formatRp(t.amount)"></td>
                            <td class="py-3 px-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <button @click="openEditExpense(t)" class="px-2.5 py-1 rounded-md bg-zinc-900 hover:bg-zinc-800 border border-zinc-700/80 text-zinc-300 font-medium text-[11px] transition">
                                        <i class="fa-solid fa-pen text-[10px] mr-1"></i> Edit
                                    </button>
                                    <button @click="transactions = transactions.filter(item => item.id !== t.id)" class="px-2.5 py-1 rounded-md bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 font-medium text-[11px] transition">Hapus</button>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL 1: Tambah Pengeluaran Baru -->
    <div x-show="showAddExpenseModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm" x-transition>
        <div @click.outside="showAddExpenseModal = false" class="bg-[#12131c] border border-zinc-800 rounded-2xl p-6 max-w-lg w-full shadow-2xl space-y-5">
            <div class="flex items-center justify-between pb-3 border-b border-zinc-800">
                <h3 class="text-base font-bold text-zinc-100 flex items-center gap-2">
                    <i class="fa-solid fa-plus-circle text-rose-400"></i>
                    <span>Catat Pengeluaran Baru</span>
                </h3>
                <button @click="showAddExpenseModal = false" class="text-zinc-500 hover:text-zinc-200"><i class="fa-solid fa-xmark text-sm"></i></button>
            </div>

            <form @submit.prevent="showAddExpenseModal = false" class="space-y-4 text-xs">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-medium text-zinc-300 mb-1">Tanggal</label>
                        <input type="date" value="2026-07-27" class="saas-input w-full">
                    </div>
                    <div>
                        <label class="block font-medium text-zinc-300 mb-1">Tipe Pembayaran</label>
                        <select class="saas-input w-full cursor-pointer">
                            <option value="Cash">Cash (Tunai)</option>
                            <option value="Transfer">Transfer Bank / E-Wallet</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block font-medium text-zinc-300 mb-1">Uraian Transaksi</label>
                    <input type="text" placeholder="Contoh: Belanja bahan makanan" class="saas-input w-full">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-medium text-zinc-300 mb-1">Kategori</label>
                        <select class="saas-input w-full cursor-pointer">
                            <template x-for="c in categories" :key="c">
                                <option :value="c" x-text="c"></option>
                            </template>
                        </select>
                    </div>
                    <div>
                        <label class="block font-medium text-zinc-300 mb-1">Bank / E-Wallet</label>
                        <select class="saas-input w-full cursor-pointer">
                            <option value="Cash">Cash</option>
                            <option value="BNI">BNI</option>
                            <option value="DANA">DANA</option>
                            <option value="BRI">BRI</option>
                            <option value="GoPay">GoPay</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block font-medium text-zinc-300 mb-1">Nilai Pengeluaran (Rp)</label>
                    <input type="number" placeholder="50000" class="saas-input w-full font-mono font-bold">
                </div>

                <div class="pt-3 border-t border-zinc-800 flex justify-end gap-2.5">
                    <button type="button" @click="showAddExpenseModal = false" class="saas-btn-secondary">Batal</button>
                    <button type="submit" class="saas-btn-primary bg-rose-500 hover:bg-rose-400 text-white">Simpan Pengeluaran</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 2: EDIT PENGELUARAN -->
    <div x-show="showEditExpenseModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm" x-transition>
        <div @click.outside="showEditExpenseModal = false" class="bg-[#12131c] border border-zinc-800 rounded-2xl p-6 max-w-lg w-full shadow-2xl space-y-5">
            <div class="flex items-center justify-between pb-3 border-b border-zinc-800">
                <h3 class="text-base font-bold text-zinc-100 flex items-center gap-2">
                    <i class="fa-solid fa-pen-to-square text-emerald-400"></i>
                    <span>Edit Transaksi Pengeluaran</span>
                </h3>
                <button @click="showEditExpenseModal = false" class="text-zinc-500 hover:text-zinc-200"><i class="fa-solid fa-xmark text-sm"></i></button>
            </div>

            <form @submit.prevent="saveEditedExpense()" class="space-y-4 text-xs">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-medium text-zinc-300 mb-1">Tanggal</label>
                        <input type="date" x-model="editingExpense.date" required class="saas-input w-full">
                    </div>
                    <div>
                        <label class="block font-medium text-zinc-300 mb-1">Tipe Pembayaran</label>
                        <select x-model="editingExpense.type" class="saas-input w-full cursor-pointer">
                            <option value="Cash">Cash (Tunai)</option>
                            <option value="Transfer">Transfer Bank / E-Wallet</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block font-medium text-zinc-300 mb-1">Uraian Transaksi</label>
                    <input type="text" x-model="editingExpense.uraian" required class="saas-input w-full">
                </div>

                <div>
                    <label class="block font-medium text-zinc-300 mb-1">Rincian Transaksi</label>
                    <input type="text" x-model="editingExpense.rincian" class="saas-input w-full">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-medium text-zinc-300 mb-1">Kategori</label>
                        <select x-model="editingExpense.kategori" class="saas-input w-full cursor-pointer">
                            <template x-for="c in categories" :key="c">
                                <option :value="c" x-text="c"></option>
                            </template>
                        </select>
                    </div>
                    <div>
                        <label class="block font-medium text-zinc-300 mb-1">Bank / E-Wallet</label>
                        <select x-model="editingExpense.bank" class="saas-input w-full cursor-pointer">
                            <option value="Cash">Cash</option>
                            <option value="BNI">BNI</option>
                            <option value="DANA">DANA</option>
                            <option value="BRI">BRI</option>
                            <option value="GoPay">GoPay</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block font-medium text-zinc-300 mb-1">Nilai Pengeluaran (Rp)</label>
                    <input type="number" x-model="editingExpense.amount" required class="saas-input w-full font-mono font-bold">
                </div>

                <div class="pt-3 border-t border-zinc-800 flex justify-end gap-2.5">
                    <button type="button" @click="showEditExpenseModal = false" class="saas-btn-secondary">Batal</button>
                    <button type="submit" class="saas-btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
