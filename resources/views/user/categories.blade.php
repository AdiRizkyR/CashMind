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
        { id: 8, name: 'Sosial', pct: 5, alokasi: 547977, realisasi: 0, icon: 'fa-hand-holding-heart' },
        { id: 9, name: 'Dilla (transfer)', pct: 10, alokasi: 1095954, realisasi: 0, icon: 'fa-paper-plane' }
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
    <div class="bg-slate-900/90 p-6 rounded-3xl border border-slate-800 shadow-xl flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-400 text-[11px] font-bold uppercase tracking-wider">Modul Pengaturan Kategori</span>
                <span class="text-slate-500">•</span>
                <span class="text-xs text-slate-400 font-medium">Pemasukan & Pengeluaran Mandiri</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white mt-1">Pengaturan Kategori Transaksi</h1>
            <p class="text-xs text-slate-400 mt-1">Kelola sendiri kategori pemasukan dan kategori pengeluaran beserta target persentase alokasi budget Anda.</p>
        </div>

        <!-- Sub-Tab Switcher (Pemasukan vs Pengeluaran) -->
        <div class="flex items-center bg-slate-950/80 p-1.5 rounded-2xl border border-slate-800 text-xs font-bold">
            <button @click="categoryTab = 'income'" :class="categoryTab === 'income' ? 'bg-emerald-500 text-slate-950 shadow-md' : 'text-slate-400 hover:text-white'" class="px-4 py-2 rounded-xl transition flex items-center gap-1.5">
                <i class="fa-solid fa-hand-holding-dollar"></i>
                <span>Kategori Pemasukan</span>
            </button>
            <button @click="categoryTab = 'expense'" :class="categoryTab === 'expense' ? 'bg-emerald-500 text-slate-950 shadow-md' : 'text-slate-400 hover:text-white'" class="px-4 py-2 rounded-xl transition flex items-center gap-1.5">
                <i class="fa-solid fa-sliders"></i>
                <span>Kategori Pengeluaran & % Budget</span>
            </button>
        </div>
    </div>

    <!-- ========================================================= -->
    <!-- SECTION 1: KELOLA KATEGORI PEMASUKAN MANDIRI               -->
    <!-- ========================================================= -->
    <div x-show="categoryTab === 'income'" class="space-y-6">
        <div class="bg-slate-900/90 p-6 rounded-3xl border border-slate-800 shadow-xl space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-800">
                <div>
                    <h2 class="text-base font-bold text-white flex items-center gap-2">
                        <i class="fa-solid fa-hand-holding-dollar text-emerald-400"></i>
                        <span>Daftar Kategori Pemasukan Saya</span>
                    </h2>
                    <p class="text-xs text-slate-400 mt-0.5">Tambah dan ubah kategori sumber pendapatan yang Anda miliki.</p>
                </div>

                <button @click="showAddIncomeCatModal = true" class="px-4 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs shadow-lg shadow-emerald-500/20 transition flex items-center gap-2">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span>Tambah Kategori Pemasukan</span>
                </button>
            </div>

            <!-- Income Categories Table -->
            <div class="overflow-x-auto rounded-2xl border border-slate-800">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-950/80 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-800">
                            <th class="py-3.5 px-4">Nama Kategori Pemasukan</th>
                            <th class="py-3.5 px-4">Catatan Keterangan</th>
                            <th class="py-3.5 px-4">Penggunaan Transaksi</th>
                            <th class="py-3.5 px-4 text-center">Aksi / Edit / Hapus</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/60">
                        <template x-for="item in incomeCategories" :key="item.id">
                            <tr class="hover:bg-slate-800/40 transition">
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center font-bold text-xs">
                                            <i class="fa-solid fa-wallet"></i>
                                        </div>
                                        <span class="font-bold text-white text-sm" x-text="item.name"></span>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 text-slate-300 font-medium" x-text="item.notes"></td>
                                <td class="py-3.5 px-4">
                                    <span class="px-2.5 py-1 rounded-full bg-slate-800 border border-slate-700 text-slate-300 font-bold text-[10px]" x-text="item.count + ' Digunakan'"></span>
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button @click="openEditIncomeCategory(item)" class="px-3 py-1.5 rounded-xl bg-amber-500/10 hover:bg-amber-500/20 border border-amber-500/30 text-amber-300 font-bold text-xs transition flex items-center gap-1">
                                            <i class="fa-solid fa-pen text-[10px]"></i>
                                            <span>Edit</span>
                                        </button>
                                        <button @click="incomeCategories = incomeCategories.filter(i => i.id !== item.id)" class="px-2.5 py-1.5 rounded-xl bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 font-bold text-xs transition">Hapus</button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- ========================================================= -->
    <!-- SECTION 2: KELOLA KATEGORI PENGELUARAN & % BUDGET          -->
    <!-- ========================================================= -->
    <div x-show="categoryTab === 'expense'" class="space-y-6">
        <!-- Live Total Percentage Calculator Banner -->
        <div class="p-5 rounded-3xl bg-slate-900/90 border border-slate-800 shadow-xl flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center font-bold text-xl">
                    <i class="fa-solid fa-calculator"></i>
                </div>
                <div>
                    <span class="text-xs text-slate-400 block">Total Persentase Teralokasi Saat Ini:</span>
                    <strong class="text-white text-xl font-extrabold" x-text="totalPct + '%'"></strong>
                </div>
            </div>

            <div class="text-left sm:text-right">
                <span class="text-xs block text-slate-400">Estimasi Target Alokasi (dari Rp 10.95M Income):</span>
                <span class="text-emerald-400 font-extrabold text-base" x-text="formatRp(Math.round(10959540 * (totalPct/100)))"></span>
            </div>
        </div>

        <!-- Editable Categories Table -->
        <div class="bg-slate-900/90 p-6 rounded-3xl border border-slate-800 shadow-xl space-y-4">
            <div class="flex items-center justify-between pb-4 border-b border-slate-800">
                <h2 class="text-base font-bold text-white flex items-center gap-2">
                    <i class="fa-solid fa-sliders text-emerald-400"></i>
                    <span>Daftar Kategori Pengeluaran Saya</span>
                </h2>
                <button @click="showAddExpenseCatModal = true" class="px-4 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs shadow-lg shadow-emerald-500/20 transition flex items-center gap-2">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span>Tambah Kategori Pengeluaran</span>
                </button>
            </div>

            <div class="overflow-x-auto rounded-2xl border border-slate-800">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-950/80 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-800">
                            <th class="py-3.5 px-4">Kategori & Ikon</th>
                            <th class="py-3.5 px-4">Persentase Target (%)</th>
                            <th class="py-3.5 px-4">Nominal Target Alokasi (Rp)</th>
                            <th class="py-3.5 px-4">Realisasi Pengeluaran (Rp)</th>
                            <th class="py-3.5 px-4 text-center">Aksi / Edit / Hapus</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/60">
                        <template x-for="c in categories" :key="c.id">
                            <tr class="hover:bg-slate-800/40 transition">
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-xl bg-slate-800 text-emerald-400 flex items-center justify-center text-xs font-bold">
                                            <i :class="'fa-solid ' + c.icon"></i>
                                        </div>
                                        <span class="font-bold text-white text-sm" x-text="c.name"></span>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center gap-2">
                                        <input type="number" x-model="c.pct" @input="c.alokasi = Math.round(10959540 * (c.pct/100))" class="w-20 bg-slate-800 border border-slate-700 rounded-xl px-3 py-1.5 text-white font-bold text-xs focus:ring-2 focus:ring-emerald-500">
                                        <span class="text-slate-400 font-semibold">%</span>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 font-bold text-emerald-400 text-sm" x-text="formatRp(c.alokasi)"></td>
                                <td class="py-3.5 px-4 font-bold text-slate-200" x-text="formatRp(c.realisasi)"></td>
                                <td class="py-3.5 px-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button @click="openEditCategory(c)" class="px-3 py-1.5 rounded-xl bg-amber-500/10 hover:bg-amber-500/20 border border-amber-500/30 text-amber-300 font-bold text-xs transition flex items-center gap-1">
                                            <i class="fa-solid fa-pen text-[10px]"></i>
                                            <span>Edit</span>
                                        </button>
                                        <button @click="categories = categories.filter(item => item.id !== c.id)" class="px-2.5 py-1.5 rounded-xl bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 font-bold text-xs transition">Hapus</button>
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
    <div x-show="showAddIncomeCatModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm" x-transition>
        <div @click.outside="showAddIncomeCatModal = false" class="bg-slate-900 border border-slate-800 rounded-3xl p-6 max-w-md w-full shadow-2xl space-y-6">
            <div class="flex items-center justify-between pb-4 border-b border-slate-800">
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <i class="fa-solid fa-plus-circle text-emerald-400"></i>
                    <span>Tambah Kategori Pemasukan</span>
                </h3>
                <button @click="showAddIncomeCatModal = false" class="text-slate-400 hover:text-white"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>

            <form @submit.prevent="addIncomeCategory()" class="space-y-4 text-xs">
                <div>
                    <label class="block font-semibold text-slate-300 mb-1">Nama Kategori Pemasukan</label>
                    <input type="text" x-model="newIncomeCatName" placeholder="Contoh: Hasil Usaha / Deviden Saham" required class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-white focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block font-semibold text-slate-300 mb-1">Catatan Keterangan</label>
                    <input type="text" x-model="newIncomeCatNotes" placeholder="Contoh: Pendapatan pasif tahunan" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-white focus:ring-2 focus:ring-emerald-500">
                </div>

                <div class="pt-4 flex justify-end gap-3">
                    <button type="button" @click="showAddIncomeCatModal = false" class="px-4 py-2 rounded-xl bg-slate-800 text-slate-300 font-bold hover:bg-slate-700">Batal</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-500 text-slate-950 font-bold hover:bg-emerald-400">Simpan Kategori</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 2: EDIT KATEGORI PEMASUKAN -->
    <div x-show="showEditIncomeCatModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm" x-transition>
        <div @click.outside="showEditIncomeCatModal = false" class="bg-slate-900 border border-slate-800 rounded-3xl p-6 max-w-md w-full shadow-2xl space-y-6">
            <div class="flex items-center justify-between pb-4 border-b border-slate-800">
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <i class="fa-solid fa-pen-to-square text-amber-400"></i>
                    <span>Edit Kategori Pemasukan</span>
                </h3>
                <button @click="showEditIncomeCatModal = false" class="text-slate-400 hover:text-white"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>

            <form @submit.prevent="saveEditedIncomeCategory()" class="space-y-4 text-xs">
                <div>
                    <label class="block font-semibold text-slate-300 mb-1">Nama Kategori Pemasukan</label>
                    <input type="text" x-model="editingIncomeCat.name" required class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-white focus:ring-2 focus:ring-amber-500">
                </div>

                <div>
                    <label class="block font-semibold text-slate-300 mb-1">Catatan Keterangan</label>
                    <input type="text" x-model="editingIncomeCat.notes" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-white focus:ring-2 focus:ring-amber-500">
                </div>

                <div class="pt-4 flex justify-end gap-3">
                    <button type="button" @click="showEditIncomeCatModal = false" class="px-4 py-2 rounded-xl bg-slate-800 text-slate-300 font-bold hover:bg-slate-700">Batal</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-amber-500 text-slate-950 font-bold hover:bg-amber-400">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 3: TAMBAH KATEGORI PENGELUARAN -->
    <div x-show="showAddExpenseCatModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm" x-transition>
        <div @click.outside="showAddExpenseCatModal = false" class="bg-slate-900 border border-slate-800 rounded-3xl p-6 max-w-md w-full shadow-2xl space-y-6">
            <div class="flex items-center justify-between pb-4 border-b border-slate-800">
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <i class="fa-solid fa-plus-circle text-emerald-400"></i>
                    <span>Buat Kategori Pengeluaran Baru</span>
                </h3>
                <button @click="showAddExpenseCatModal = false" class="text-slate-400 hover:text-white"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>

            <form @submit.prevent="addCategory()" class="space-y-4 text-xs">
                <div>
                    <label class="block font-semibold text-slate-300 mb-1">Nama Kategori</label>
                    <input type="text" x-model="newCatName" placeholder="Contoh: Tagihan Listrik / Edukasi" required class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-white focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block font-semibold text-slate-300 mb-1">Target Persentase Budget (%)</label>
                    <input type="number" x-model="newCatPct" min="1" max="100" required class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-white focus:ring-2 focus:ring-emerald-500 font-bold">
                </div>

                <div class="pt-4 flex justify-end gap-3">
                    <button type="button" @click="showAddExpenseCatModal = false" class="px-4 py-2 rounded-xl bg-slate-800 text-slate-300 font-bold hover:bg-slate-700">Batal</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-500 text-slate-950 font-bold hover:bg-emerald-400">Simpan Kategori</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 4: EDIT KATEGORI PENGELUARAN -->
    <div x-show="showEditExpenseCatModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm" x-transition>
        <div @click.outside="showEditExpenseCatModal = false" class="bg-slate-900 border border-slate-800 rounded-3xl p-6 max-w-md w-full shadow-2xl space-y-6">
            <div class="flex items-center justify-between pb-4 border-b border-slate-800">
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <i class="fa-solid fa-pen-to-square text-amber-400"></i>
                    <span>Edit Kategori Pengeluaran & % Budget</span>
                </h3>
                <button @click="showEditExpenseCatModal = false" class="text-slate-400 hover:text-white"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>

            <form @submit.prevent="saveEditedCategory()" class="space-y-4 text-xs">
                <div>
                    <label class="block font-semibold text-slate-300 mb-1">Nama Kategori</label>
                    <input type="text" x-model="editingCat.name" required class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-white focus:ring-2 focus:ring-amber-500">
                </div>

                <div>
                    <label class="block font-semibold text-slate-300 mb-1">Target Persentase Budget (%)</label>
                    <input type="number" x-model="editingCat.pct" min="0" max="100" required class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-white font-bold text-sm focus:ring-2 focus:ring-amber-500">
                </div>

                <div class="pt-4 flex justify-end gap-3">
                    <button type="button" @click="showEditExpenseCatModal = false" class="px-4 py-2 rounded-xl bg-slate-800 text-slate-300 font-bold hover:bg-slate-700">Batal</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-amber-500 text-slate-950 font-bold hover:bg-amber-400">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
