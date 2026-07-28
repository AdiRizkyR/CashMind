@extends('layouts.user')

@section('user-content')
<div x-data="{
    categoryTab: 'income',
    showAddIncomeCatModal: false,
    showEditIncomeCatModal: false,
    showAddExpenseCatModal: false,
    showEditExpenseCatModal: false,

    newIncomeCatName: '',
    newIncomeCatNotes: '',

    editingIncomeCat: { id: null, name: '', notes: '' },

    // Custom Income Categories (User Managed)
    incomeCategories: [
        { id: 1, name: 'Primary Income (Gaji Pokok)', notes: 'Pendapatan rutin bulanan utama', count: 1 },
        { id: 2, name: 'Secondary Income (Side Job)', notes: 'Hasil proyek freelance / usaha sampingan', count: 1 },
        { id: 3, name: 'Savings Release (Ambil Tabungan)', notes: 'Pencairan dana simpanan / emas', count: 1 },
        { id: 4, name: 'Bonus & Insentif', notes: 'THR, bonus kinerja, komisi', count: 1 },
        { id: 5, name: 'Rollover (Sisa Kas Lalu)', notes: 'Sisa saldo dari bulan sebelumnya', count: 1 },
        { id: 6, name: 'Hasil Investasi & Deviden', notes: 'Pasif income reksa dana / saham', count: 0 }
    ],

    newCatName: '',
    newCatPct: 5,
    newCatIcon: 'fa-tags',

    editingCat: { id: null, name: '', pct: 0, icon: 'fa-tags' },

    // Custom Expense Categories (User Managed)
    categories: [
        { id: 1, name: 'Makanan', pct: 40, alokasi: 4383816, realisasi: 1129645, icon: 'fa-utensils' },
        { id: 2, name: 'Belanja', pct: 10, alokasi: 1095954, realisasi: 147300, icon: 'fa-bag-shopping' },
        { id: 3, name: 'Tabungan', pct: 0, alokasi: 0, realisasi: 4099765, icon: 'fa-piggy-bank' },
        { id: 4, name: 'Hiburan', pct: 8, alokasi: 876763, realisasi: 52500, icon: 'fa-gamepad' },
        { id: 5, name: 'Kendaraan', pct: 10, alokasi: 1095954, realisasi: 5000, icon: 'fa-motorcycle' },
        { id: 6, name: 'Admin', pct: 2, alokasi: 219191, realisasi: 19000, icon: 'fa-receipt' },
        { id: 7, name: 'Dana HP', pct: 15, alokasi: 1643931, realisasi: 5269620, icon: 'fa-mobile-screen' },
        { id: 8, name: 'Sosial', pct: 5, alokasi: 547977, realisasi: 0, icon: 'fa-hand-holding-heart' }
    ],

    get totalPct() {
        return this.categories.reduce((sum, c) => sum + Number(c.pct), 0);
    },

    addIncomeCategory() {
        if (!this.newIncomeCatName) return;
        this.incomeCategories.push({
            id: Date.now(),
            name: this.newIncomeCatName,
            notes: this.newIncomeCatNotes || 'Kategori Pemasukan Kustom',
            count: 0
        });
        this.newIncomeCatName = '';
        this.newIncomeCatNotes = '';
        this.showAddIncomeCatModal = false;
    },

    openEditIncomeCategory(item) {
        this.editingIncomeCat = JSON.parse(JSON.stringify(item));
        this.showEditIncomeCatModal = true;
    },

    saveEditedIncomeCategory() {
        const index = this.incomeCategories.findIndex(i => i.id === this.editingIncomeCat.id);
        if (index !== -1) {
            this.incomeCategories[index] = { ...this.editingIncomeCat };
        }
        this.showEditIncomeCatModal = false;
    },

    addCategory() {
        if (!this.newCatName) return;
        this.categories.push({
            id: Date.now(),
            name: this.newCatName,
            pct: Number(this.newCatPct),
            alokasi: Math.round(10959540 * (Number(this.newCatPct)/100)),
            realisasi: 0,
            icon: this.newCatIcon || 'fa-tags'
        });
        this.newCatName = '';
        this.newCatPct = 5;
        this.showAddExpenseCatModal = false;
    },

    openEditCategory(c) {
        this.editingCat = JSON.parse(JSON.stringify(c));
        this.showEditExpenseCatModal = true;
    },

    saveEditedCategory() {
        const index = this.categories.findIndex(c => c.id === this.editingCat.id);
        if (index !== -1) {
            this.editingCat.alokasi = Math.round(10959540 * (Number(this.editingCat.pct)/100));
            this.categories[index] = { ...this.editingCat };
        }
        this.showEditExpenseCatModal = false;
    },

    formatRp(val) {
        return 'Rp ' + Number(val).toLocaleString('id-ID');
    }
}" class="space-y-6">

    <!-- Page Title & Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-zinc-100 tracking-tight">Kategori & Budgeting</h1>
            <p class="text-xs text-zinc-400 mt-0.5">Pengaturan kategori pemasukan & pengeluaran serta alokasi target persentase.</p>
        </div>

        <!-- Sub-Tab Switcher -->
        <div class="flex items-center bg-zinc-950 p-1 rounded-lg border border-zinc-800 text-xs font-medium">
            <button @click="categoryTab = 'income'" :class="categoryTab === 'income' ? 'bg-zinc-800 text-zinc-100 font-semibold' : 'text-zinc-400 hover:text-zinc-200'" class="px-3.5 py-1.5 rounded-md transition flex items-center gap-1.5">
                <i class="fa-solid fa-arrow-down-left text-emerald-400 text-xs"></i>
                <span>Kategori Pemasukan</span>
            </button>
            <button @click="categoryTab = 'expense'" :class="categoryTab === 'expense' ? 'bg-zinc-800 text-zinc-100 font-semibold' : 'text-zinc-400 hover:text-zinc-200'" class="px-3.5 py-1.5 rounded-md transition flex items-center gap-1.5">
                <i class="fa-solid fa-sliders text-xs"></i>
                <span>Kategori Pengeluaran & % Budget</span>
            </button>
        </div>
    </div>

    <!-- SECTION 1: KATEGORI PEMASUKAN -->
    <div x-show="categoryTab === 'income'" class="space-y-6">
        <div class="saas-card p-6 space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-zinc-800/80">
                <h2 class="text-sm font-semibold text-zinc-200 flex items-center gap-2">
                    <i class="fa-solid fa-hand-holding-dollar text-emerald-400 text-xs"></i>
                    <span>Daftar Kategori Pemasukan Saya</span>
                </h2>
                <button @click="showAddIncomeCatModal = true" class="saas-btn-primary flex items-center gap-1.5">
                    <i class="fa-solid fa-plus text-[10px]"></i>
                    <span>Tambah Kategori Pemasukan</span>
                </button>
            </div>

            <div class="overflow-x-auto rounded-xl border border-zinc-800/80">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-zinc-950/80 text-[11px] font-semibold text-zinc-400 uppercase tracking-wider border-b border-zinc-800">
                            <th class="py-3 px-4">Nama Kategori</th>
                            <th class="py-3 px-4">Catatan Keterangan</th>
                            <th class="py-3 px-4">Penggunaan Transaksi</th>
                            <th class="py-3 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-800/60">
                        <template x-for="item in incomeCategories" :key="item.id">
                            <tr class="hover:bg-zinc-900/40 transition">
                                <td class="py-3 px-4 font-semibold text-zinc-100 text-sm" x-text="item.name"></td>
                                <td class="py-3 px-4 text-zinc-400" x-text="item.notes"></td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-0.5 rounded bg-zinc-900 border border-zinc-800 text-zinc-400 font-mono text-[10px]" x-text="item.count + ' Digunakan'"></span>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <button @click="openEditIncomeCategory(item)" class="px-2.5 py-1 rounded-md bg-zinc-900 hover:bg-zinc-800 border border-zinc-700/80 text-zinc-300 font-medium text-[11px] transition">
                                            <i class="fa-solid fa-pen text-[10px] mr-1"></i> Edit
                                        </button>
                                        <button @click="incomeCategories = incomeCategories.filter(i => i.id !== item.id)" class="px-2.5 py-1 rounded-md bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 font-medium text-[11px] transition">Hapus</button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- SECTION 2: KATEGORI PENGELUARAN & % BUDGET -->
    <div x-show="categoryTab === 'expense'" class="space-y-6">
        <!-- Live Total Percentage Calculator Card -->
        <div class="saas-card p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center font-bold text-base">
                    <i class="fa-solid fa-calculator"></i>
                </div>
                <div>
                    <span class="text-xs text-zinc-400 block">Total Persentase Teralokasi</span>
                    <strong class="text-xl font-bold text-zinc-100 font-mono" x-text="totalPct + '%'"></strong>
                </div>
            </div>

            <div class="text-left sm:text-right">
                <span class="text-xs text-zinc-400 block">Estimasi Target Alokasi (dari Rp 10.95M Income)</span>
                <span class="text-emerald-400 font-bold font-mono text-sm" x-text="formatRp(Math.round(10959540 * (totalPct/100)))"></span>
            </div>
        </div>

        <div class="saas-card p-6 space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-zinc-800/80">
                <h2 class="text-sm font-semibold text-zinc-200 flex items-center gap-2">
                    <i class="fa-solid fa-sliders text-emerald-400 text-xs"></i>
                    <span>Daftar Kategori Pengeluaran & Target %</span>
                </h2>
                <button @click="showAddExpenseCatModal = true" class="saas-btn-primary flex items-center gap-1.5">
                    <i class="fa-solid fa-plus text-[10px]"></i>
                    <span>Tambah Kategori</span>
                </button>
            </div>

            <div class="overflow-x-auto rounded-xl border border-zinc-800/80">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-zinc-950/80 text-[11px] font-semibold text-zinc-400 uppercase tracking-wider border-b border-zinc-800">
                            <th class="py-3 px-4">Kategori & Ikon</th>
                            <th class="py-3 px-4">Persentase Target (%)</th>
                            <th class="py-3 px-4">Target Alokasi (Rp)</th>
                            <th class="py-3 px-4">Realisasi (Rp)</th>
                            <th class="py-3 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-800/60">
                        <template x-for="c in categories" :key="c.id">
                            <tr class="hover:bg-zinc-900/40 transition">
                                <td class="py-3 px-4">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-7 h-7 rounded-lg bg-zinc-900 border border-zinc-800 text-emerald-400 flex items-center justify-center text-xs">
                                            <i :class="'fa-solid ' + c.icon"></i>
                                        </div>
                                        <span class="font-semibold text-zinc-100 text-sm" x-text="c.name"></span>
                                    </div>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="flex items-center gap-1.5">
                                        <input type="number" x-model="c.pct" @input="c.alokasi = Math.round(10959540 * (c.pct/100))" class="saas-input w-16 text-center font-mono font-bold py-1">
                                        <span class="text-zinc-500 font-semibold">%</span>
                                    </div>
                                </td>
                                <td class="py-3 px-4 font-bold text-emerald-400 font-mono text-sm" x-text="formatRp(c.alokasi)"></td>
                                <td class="py-3 px-4 font-semibold text-zinc-300 font-mono text-xs" x-text="formatRp(c.realisasi)"></td>
                                <td class="py-3 px-4 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <button @click="openEditCategory(c)" class="px-2.5 py-1 rounded-md bg-zinc-900 hover:bg-zinc-800 border border-zinc-700/80 text-zinc-300 font-medium text-[11px] transition">
                                            <i class="fa-solid fa-pen text-[10px] mr-1"></i> Edit
                                        </button>
                                        <button @click="categories = categories.filter(item => item.id !== c.id)" class="px-2.5 py-1 rounded-md bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 font-medium text-[11px] transition">Hapus</button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- MODAL 1: TAMBAH KATEGORI PEMASUKAN -->
    <div x-show="showAddIncomeCatModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm" x-transition>
        <div @click.outside="showAddIncomeCatModal = false" class="bg-[#12131c] border border-zinc-800 rounded-2xl p-6 max-w-md w-full shadow-2xl space-y-5">
            <div class="flex items-center justify-between pb-3 border-b border-zinc-800">
                <h3 class="text-base font-bold text-zinc-100 flex items-center gap-2">
                    <i class="fa-solid fa-plus-circle text-emerald-400"></i>
                    <span>Tambah Kategori Pemasukan</span>
                </h3>
                <button @click="showAddIncomeCatModal = false" class="text-zinc-500 hover:text-zinc-200"><i class="fa-solid fa-xmark text-sm"></i></button>
            </div>

            <form @submit.prevent="addIncomeCategory()" class="space-y-4 text-xs">
                <div>
                    <label class="block font-medium text-zinc-300 mb-1">Nama Kategori Pemasukan</label>
                    <input type="text" x-model="newIncomeCatName" placeholder="Contoh: Hasil Usaha / Deviden" required class="saas-input w-full">
                </div>

                <div>
                    <label class="block font-medium text-zinc-300 mb-1">Catatan Keterangan</label>
                    <input type="text" x-model="newIncomeCatNotes" placeholder="Contoh: Pendapatan pasif tahunan" class="saas-input w-full">
                </div>

                <div class="pt-3 border-t border-zinc-800 flex justify-end gap-2.5">
                    <button type="button" @click="showAddIncomeCatModal = false" class="saas-btn-secondary">Batal</button>
                    <button type="submit" class="saas-btn-primary">Simpan Kategori</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 2: EDIT KATEGORI PEMASUKAN -->
    <div x-show="showEditIncomeCatModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm" x-transition>
        <div @click.outside="showEditIncomeCatModal = false" class="bg-[#12131c] border border-zinc-800 rounded-2xl p-6 max-w-md w-full shadow-2xl space-y-5">
            <div class="flex items-center justify-between pb-3 border-b border-zinc-800">
                <h3 class="text-base font-bold text-zinc-100 flex items-center gap-2">
                    <i class="fa-solid fa-pen-to-square text-emerald-400"></i>
                    <span>Edit Kategori Pemasukan</span>
                </h3>
                <button @click="showEditIncomeCatModal = false" class="text-zinc-500 hover:text-zinc-200"><i class="fa-solid fa-xmark text-sm"></i></button>
            </div>

            <form @submit.prevent="saveEditedIncomeCategory()" class="space-y-4 text-xs">
                <div>
                    <label class="block font-medium text-zinc-300 mb-1">Nama Kategori Pemasukan</label>
                    <input type="text" x-model="editingIncomeCat.name" required class="saas-input w-full">
                </div>

                <div>
                    <label class="block font-medium text-zinc-300 mb-1">Catatan Keterangan</label>
                    <input type="text" x-model="editingIncomeCat.notes" class="saas-input w-full">
                </div>

                <div class="pt-3 border-t border-zinc-800 flex justify-end gap-2.5">
                    <button type="button" @click="showEditIncomeCatModal = false" class="saas-btn-secondary">Batal</button>
                    <button type="submit" class="saas-btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 3: TAMBAH KATEGORI PENGELUARAN -->
    <div x-show="showAddExpenseCatModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm" x-transition>
        <div @click.outside="showAddExpenseCatModal = false" class="bg-[#12131c] border border-zinc-800 rounded-2xl p-6 max-w-md w-full shadow-2xl space-y-5">
            <div class="flex items-center justify-between pb-3 border-b border-zinc-800">
                <h3 class="text-base font-bold text-zinc-100 flex items-center gap-2">
                    <i class="fa-solid fa-plus-circle text-emerald-400"></i>
                    <span>Buat Kategori Pengeluaran Baru</span>
                </h3>
                <button @click="showAddExpenseCatModal = false" class="text-zinc-500 hover:text-zinc-200"><i class="fa-solid fa-xmark text-sm"></i></button>
            </div>

            <form @submit.prevent="addCategory()" class="space-y-4 text-xs">
                <div>
                    <label class="block font-medium text-zinc-300 mb-1">Nama Kategori</label>
                    <input type="text" x-model="newCatName" placeholder="Contoh: Tagihan Listrik / Edukasi" required class="saas-input w-full">
                </div>

                <div>
                    <label class="block font-medium text-zinc-300 mb-1">Target Persentase Budget (%)</label>
                    <input type="number" x-model="newCatPct" min="1" max="100" required class="saas-input w-full font-mono font-bold">
                </div>

                <div class="pt-3 border-t border-zinc-800 flex justify-end gap-2.5">
                    <button type="button" @click="showAddExpenseCatModal = false" class="saas-btn-secondary">Batal</button>
                    <button type="submit" class="saas-btn-primary">Simpan Kategori</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 4: EDIT KATEGORI PENGELUARAN -->
    <div x-show="showEditExpenseCatModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm" x-transition>
        <div @click.outside="showEditExpenseCatModal = false" class="bg-[#12131c] border border-zinc-800 rounded-2xl p-6 max-w-md w-full shadow-2xl space-y-5">
            <div class="flex items-center justify-between pb-3 border-b border-zinc-800">
                <h3 class="text-base font-bold text-zinc-100 flex items-center gap-2">
                    <i class="fa-solid fa-pen-to-square text-emerald-400"></i>
                    <span>Edit Kategori Pengeluaran & % Budget</span>
                </h3>
                <button @click="showEditExpenseCatModal = false" class="text-zinc-500 hover:text-zinc-200"><i class="fa-solid fa-xmark text-sm"></i></button>
            </div>

            <form @submit.prevent="saveEditedCategory()" class="space-y-4 text-xs">
                <div>
                    <label class="block font-medium text-zinc-300 mb-1">Nama Kategori</label>
                    <input type="text" x-model="editingCat.name" required class="saas-input w-full">
                </div>

                <div>
                    <label class="block font-medium text-zinc-300 mb-1">Target Persentase Budget (%)</label>
                    <input type="number" x-model="editingCat.pct" min="0" max="100" required class="saas-input w-full font-mono font-bold">
                </div>

                <div class="pt-3 border-t border-zinc-800 flex justify-end gap-2.5">
                    <button type="button" @click="showEditExpenseCatModal = false" class="saas-btn-secondary">Batal</button>
                    <button type="submit" class="saas-btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
