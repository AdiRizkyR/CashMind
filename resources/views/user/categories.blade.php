@extends('layouts.user')

@section('user-content')
<!-- Komentar Bahasa Indonesia: Smart Budget Allocator Hub (Dual-Pane Structure) -->
<div x-data="{
    categoryTab: 'income',
    showAddIncomeCatModal: false,
    showEditIncomeCatModal: false,
    showAddExpenseCatModal: false,
    showEditExpenseCatModal: false,

    newIncomeCatName: '',
    newIncomeCatNotes: '',

    editingIncomeCat: { id: null, name: '', notes: '' },

    // Kategori Pemasukan Mandiri Pengguna
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

    // Kategori Pengeluaran Mandiri Pengguna
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

    <!-- Header Command Title & Sub-Tab Controls -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Kategori & Budget Hub</h1>
            <p class="text-xs text-slate-500 mt-1">Pengaturan kategori pemasukan, kategori pengeluaran, dan persentase alokasi budget.</p>
        </div>

        <!-- Sub-Tab Segmented Controls -->
        <div class="flex items-center bg-slate-200/80 p-1.5 rounded-2xl text-xs font-bold shadow-xs">
            <button @click="categoryTab = 'income'" :class="categoryTab === 'income' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:text-slate-900'" class="px-4 py-2 rounded-xl transition flex items-center gap-2">
                <i class="fa-solid fa-arrow-down-left text-emerald-600 text-xs"></i>
                <span>Kategori Income</span>
            </button>
            <button @click="categoryTab = 'expense'" :class="categoryTab === 'expense' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:text-slate-900'" class="px-4 py-2 rounded-xl transition flex items-center gap-2">
                <i class="fa-solid fa-sliders text-xs text-amber-600"></i>
                <span>Kategori Expense & % Budget</span>
            </button>
        </div>
    </div>

    <!-- SECTION 1: KATEGORI PEMASUKAN MANDIRI -->
    <div x-show="categoryTab === 'income'" class="space-y-6">
        <div class="exec-panel p-6 space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                <h2 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-hand-holding-dollar text-emerald-600 text-sm"></i>
                    <span>Daftar Kategori Pemasukan Saya</span>
                </h2>
                <button @click="showAddIncomeCatModal = true" class="exec-btn-primary">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span>Tambah Kategori Pemasukan</span>
                </button>
            </div>

            <div class="overflow-x-auto rounded-xl border border-slate-200">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-100/80 text-[11px] font-bold text-slate-500 uppercase tracking-wider border-b border-slate-200">
                            <th class="py-3.5 px-4">Nama Kategori Pemasukan</th>
                            <th class="py-3.5 px-4">Catatan Keterangan</th>
                            <th class="py-3.5 px-4">Status Penggunaan</th>
                            <th class="py-3.5 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        <template x-for="item in incomeCategories" :key="item.id">
                            <tr class="hover:bg-slate-50 transition">
                                <td class="py-3.5 px-4 font-bold text-slate-900 text-sm" x-text="item.name"></td>
                                <td class="py-3.5 px-4 text-slate-600 font-medium" x-text="item.notes"></td>
                                <td class="py-3.5 px-4">
                                    <span class="px-2.5 py-1 rounded bg-slate-100 border border-slate-200 text-slate-700 font-mono text-[10px] font-bold" x-text="item.count + ' Digunakan'"></span>
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <button @click="openEditIncomeCategory(item)" class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 border border-slate-200 text-slate-700 font-bold text-[11px] transition">
                                            <i class="fa-solid fa-pen text-[10px] mr-1"></i> Edit
                                        </button>
                                        <button @click="incomeCategories = incomeCategories.filter(i => i.id !== item.id)" class="px-2.5 py-1 rounded-lg bg-rose-50 hover:bg-rose-100 border border-rose-200 text-rose-600 font-bold text-[11px] transition">Hapus</button>
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
        
        <!-- Live Total Percentage Calculator Banner -->
        <div class="exec-panel p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-l-4 border-l-emerald-600">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-2xl bg-emerald-100 border border-emerald-200 text-emerald-700 flex items-center justify-center font-bold text-lg shadow-xs">
                    <i class="fa-solid fa-calculator"></i>
                </div>
                <div>
                    <span class="text-xs text-slate-500 font-semibold block">Total Persentase Teralokasi</span>
                    <strong class="text-2xl font-extrabold text-slate-900 font-mono" x-text="totalPct + '%'"></strong>
                </div>
            </div>

            <div class="text-left sm:text-right">
                <span class="text-xs text-slate-500 font-semibold block">Estimasi Target Alokasi (dari Rp 10.95M Income)</span>
                <span class="text-emerald-600 font-extrabold font-mono text-base" x-text="formatRp(Math.round(10959540 * (totalPct/100)))"></span>
            </div>
        </div>

        <div class="exec-panel p-6 space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                <h2 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-sliders text-amber-600 text-sm"></i>
                    <span>Daftar Kategori Pengeluaran & Target % Budget</span>
                </h2>
                <button @click="showAddExpenseCatModal = true" class="exec-btn-primary">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span>Tambah Kategori</span>
                </button>
            </div>

            <div class="overflow-x-auto rounded-xl border border-slate-200">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-100/80 text-[11px] font-bold text-slate-500 uppercase tracking-wider border-b border-slate-200">
                            <th class="py-3.5 px-4">Kategori & Ikon</th>
                            <th class="py-3.5 px-4">Persentase Target (%)</th>
                            <th class="py-3.5 px-4">Target Alokasi (Rp)</th>
                            <th class="py-3.5 px-4">Realisasi (Rp)</th>
                            <th class="py-3.5 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        <template x-for="c in categories" :key="c.id">
                            <tr class="hover:bg-slate-50 transition">
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-lg bg-slate-100 border border-slate-200 text-emerald-600 flex items-center justify-center text-xs shadow-xs">
                                            <i :class="'fa-solid ' + c.icon"></i>
                                        </div>
                                        <span class="font-extrabold text-slate-900 text-sm" x-text="c.name"></span>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center gap-1.5">
                                        <input type="number" x-model="c.pct" @input="c.alokasi = Math.round(10959540 * (c.pct/100))" class="exec-input w-20 text-center font-mono font-bold py-1">
                                        <span class="text-slate-500 font-bold">%</span>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 font-extrabold text-emerald-600 font-mono text-sm" x-text="formatRp(c.alokasi)"></td>
                                <td class="py-3.5 px-4 font-bold text-slate-800 font-mono text-xs" x-text="formatRp(c.realisasi)"></td>
                                <td class="py-3.5 px-4 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <button @click="openEditCategory(c)" class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 border border-slate-200 text-slate-700 font-bold text-[11px] transition">
                                            <i class="fa-solid fa-pen text-[10px] mr-1"></i> Edit
                                        </button>
                                        <button @click="categories = categories.filter(item => item.id !== c.id)" class="px-2.5 py-1 rounded-lg bg-rose-50 hover:bg-rose-100 border border-rose-200 text-rose-600 font-bold text-[11px] transition">Hapus</button>
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
    <div x-show="showAddIncomeCatModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm" x-transition>
        <div @click.outside="showAddIncomeCatModal = false" class="bg-white border border-slate-200 rounded-2xl p-6 max-w-md w-full shadow-2xl space-y-5">
            <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-plus-circle text-emerald-600"></i>
                    <span>Tambah Kategori Pemasukan</span>
                </h3>
                <button @click="showAddIncomeCatModal = false" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark text-sm"></i></button>
            </div>

            <form @submit.prevent="addIncomeCategory()" class="space-y-4 text-xs">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nama Kategori Pemasukan</label>
                    <input type="text" x-model="newIncomeCatName" placeholder="Contoh: Hasil Usaha / Deviden" required class="exec-input w-full">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Catatan Keterangan</label>
                    <input type="text" x-model="newIncomeCatNotes" placeholder="Contoh: Pendapatan pasif tahunan" class="exec-input w-full">
                </div>

                <div class="pt-3 border-t border-slate-200 flex justify-end gap-2.5">
                    <button type="button" @click="showAddIncomeCatModal = false" class="exec-btn-secondary">Batal</button>
                    <button type="submit" class="exec-btn-primary">Simpan Kategori</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 2: EDIT KATEGORI PEMASUKAN -->
    <div x-show="showEditIncomeCatModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm" x-transition>
        <div @click.outside="showEditIncomeCatModal = false" class="bg-white border border-slate-200 rounded-2xl p-6 max-w-md w-full shadow-2xl space-y-5">
            <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-pen-to-square text-emerald-600"></i>
                    <span>Edit Kategori Pemasukan</span>
                </h3>
                <button @click="showEditIncomeCatModal = false" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark text-sm"></i></button>
            </div>

            <form @submit.prevent="saveEditedIncomeCategory()" class="space-y-4 text-xs">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nama Kategori Pemasukan</label>
                    <input type="text" x-model="editingIncomeCat.name" required class="exec-input w-full">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Catatan Keterangan</label>
                    <input type="text" x-model="editingIncomeCat.notes" class="exec-input w-full">
                </div>

                <div class="pt-3 border-t border-slate-200 flex justify-end gap-2.5">
                    <button type="button" @click="showEditIncomeCatModal = false" class="exec-btn-secondary">Batal</button>
                    <button type="submit" class="exec-btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 3: TAMBAH KATEGORI PENGELUARAN -->
    <div x-show="showAddExpenseCatModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm" x-transition>
        <div @click.outside="showAddExpenseCatModal = false" class="bg-white border border-slate-200 rounded-2xl p-6 max-w-md w-full shadow-2xl space-y-5">
            <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-plus-circle text-emerald-600"></i>
                    <span>Buat Kategori Pengeluaran Baru</span>
                </h3>
                <button @click="showAddExpenseCatModal = false" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark text-sm"></i></button>
            </div>

            <form @submit.prevent="addCategory()" class="space-y-4 text-xs">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nama Kategori</label>
                    <input type="text" x-model="newCatName" placeholder="Contoh: Tagihan Listrik / Edukasi" required class="exec-input w-full">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Target Persentase Budget (%)</label>
                    <input type="number" x-model="newCatPct" min="1" max="100" required class="exec-input w-full font-mono font-bold">
                </div>

                <div class="pt-3 border-t border-slate-200 flex justify-end gap-2.5">
                    <button type="button" @click="showAddExpenseCatModal = false" class="exec-btn-secondary">Batal</button>
                    <button type="submit" class="exec-btn-primary">Simpan Kategori</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 4: EDIT KATEGORI PENGELUARAN -->
    <div x-show="showEditExpenseCatModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm" x-transition>
        <div @click.outside="showEditExpenseCatModal = false" class="bg-white border border-slate-200 rounded-2xl p-6 max-w-md w-full shadow-2xl space-y-5">
            <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-pen-to-square text-emerald-600"></i>
                    <span>Edit Kategori Pengeluaran & % Budget</span>
                </h3>
                <button @click="showEditExpenseCatModal = false" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark text-sm"></i></button>
            </div>

            <form @submit.prevent="saveEditedCategory()" class="space-y-4 text-xs">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nama Kategori</label>
                    <input type="text" x-model="editingCat.name" required class="exec-input w-full">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Target Persentase Budget (%)</label>
                    <input type="number" x-model="editingCat.pct" min="0" max="100" required class="exec-input w-full font-mono font-bold">
                </div>

                <div class="pt-3 border-t border-slate-200 flex justify-end gap-2.5">
                    <button type="button" @click="showEditExpenseCatModal = false" class="exec-btn-secondary">Batal</button>
                    <button type="submit" class="exec-btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
