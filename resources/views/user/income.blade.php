@extends('layouts.user')

@section('user-content')
<div x-data="{
    showAddIncomeModal: false,
    showEditIncomeModal: false,
    selectedMonth: 'Juli',

    // User's custom income categories
    incomeCategories: [
        'Primary Income (Gaji Pokok)',
        'Secondary Income (Side Job)',
        'Savings Release (Ambil Tabungan)',
        'Bonus & Insentif',
        'Rollover (Sisa Kas Lalu)',
        'Hasil Investasi & Deviden'
    ],

    editingIncome: { id: null, date: '', source: '', amount: 0, category: '', notes: '' },

    incomeSources: [
        { id: 1, date: '2026-07-01', displayDate: '01 Juli 2026', source: 'Gaji Bulanan', amount: 2300000, category: 'Primary Income (Gaji Pokok)', notes: 'Gaji Pokok Kantor' },
        { id: 2, date: '2026-07-05', displayDate: '05 Juli 2026', source: 'Ambil Tabungan', amount: 5069765, category: 'Savings Release (Ambil Tabungan)', notes: 'Penarikan Tabungan Emas' },
        { id: 3, date: '2026-07-10', displayDate: '10 Juli 2026', source: 'Side Job (Freelance)', amount: 3333000, category: 'Secondary Income (Side Job)', notes: 'Proyek Web Dev' },
        { id: 4, date: '2026-07-01', displayDate: '01 Juli 2026', source: 'Dana Sebelumnya', amount: 116775, category: 'Rollover (Sisa Kas Lalu)', notes: 'Sisa Kas Juni' },
        { id: 5, date: '2026-07-15', displayDate: '15 Juli 2026', source: 'THR / Bonus / Insentif', amount: 140000, category: 'Bonus & Insentif', notes: 'Insentif Performance' }
    ],

    get totalIncome() {
        return this.incomeSources.reduce((sum, item) => sum + Number(item.amount), 0);
    },

    formatRp(val) {
        return 'Rp ' + Number(val).toLocaleString('id-ID');
    },

    openEditIncome(item) {
        this.editingIncome = JSON.parse(JSON.stringify(item));
        this.showEditIncomeModal = true;
    },

    saveEditedIncome() {
        const index = this.incomeSources.findIndex(i => i.id === this.editingIncome.id);
        if (index !== -1) {
            const dateObj = new Date(this.editingIncome.date);
            const options = { day: '2-digit', month: 'long', year: 'numeric' };
            this.editingIncome.displayDate = dateObj.toLocaleDateString('id-ID', options);
            this.incomeSources[index] = { ...this.editingIncome };
        }
        this.showEditIncomeModal = false;
    }
}" class="space-y-6">

    <!-- Page Title & Header -->
    <div class="bg-slate-900/90 p-6 rounded-3xl border border-slate-800 shadow-xl flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-400 text-[11px] font-bold uppercase tracking-wider">Modul Pemasukan</span>
                <span class="text-slate-500">•</span>
                <span class="text-xs text-slate-400 font-medium">Income Tracker</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white mt-1">Pencatatan Pemasukan Mandiri</h1>
            <p class="text-xs text-slate-400 mt-1">Catat dan atur sumber pemasukan berdasarkan kategori yang Anda tentukan sendiri.</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('user.categories') }}" class="px-3.5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-750 text-slate-200 font-bold text-xs border border-slate-700 transition flex items-center gap-1.5">
                <i class="fa-solid fa-gear text-emerald-400"></i>
                <span>Kelola Kategori Income</span>
            </a>
            <button @click="showAddIncomeModal = true" class="px-4 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs shadow-lg shadow-emerald-500/20 transition flex items-center gap-2">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>Catat Pemasukan Baru</span>
            </button>
        </div>
    </div>

    <!-- Income Summary Banner -->
    <div class="p-6 rounded-3xl bg-slate-900/90 border border-slate-800 shadow-xl flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center font-bold text-2xl">
                <i class="fa-solid fa-hand-holding-dollar"></i>
            </div>
            <div>
                <span class="text-xs text-slate-400 block">Total Pemasukan Bulan Juli 2026:</span>
                <strong class="text-2xl font-extrabold text-emerald-400" x-text="formatRp(totalIncome)"></strong>
            </div>
        </div>

        <div class="text-xs font-semibold text-slate-400 bg-slate-950/70 px-4 py-2 rounded-xl border border-slate-800">
            Total Sumber Income: <strong class="text-white" x-text="incomeSources.length + ' Sumber'"></strong>
        </div>
    </div>

    <!-- Income Sources Data Table -->
    <div class="bg-slate-900/90 p-6 rounded-3xl border border-slate-800 shadow-xl space-y-4">
        <div class="overflow-x-auto rounded-2xl border border-slate-800">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-950/80 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-800">
                        <th class="py-3.5 px-4">Tanggal Pemasukan</th>
                        <th class="py-3.5 px-4">Sumber Pemasukan</th>
                        <th class="py-3.5 px-4">Kategori Income</th>
                        <th class="py-3.5 px-4">Catatan / Keterangan</th>
                        <th class="py-3.5 px-4 text-right">Jumlah Pemasukan (Rp)</th>
                        <th class="py-3.5 px-4 text-center">Aksi / Edit</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    <template x-for="item in incomeSources" :key="item.id">
                        <tr class="hover:bg-slate-800/40 transition">
                            <td class="py-3.5 px-4">
                                <div class="font-semibold text-white flex items-center gap-1.5">
                                    <i class="fa-regular fa-calendar text-emerald-400 text-xs"></i>
                                    <span x-text="item.displayDate || item.date"></span>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 font-bold text-white text-sm" x-text="item.source"></td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-1 rounded-lg bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 font-semibold text-[11px]" x-text="item.category"></span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-300 font-medium" x-text="item.notes"></td>
                            <td class="py-3.5 px-4 text-right font-extrabold text-emerald-400 text-sm" x-text="formatRp(item.amount)"></td>
                            <td class="py-3.5 px-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button @click="openEditIncome(item)" class="px-3 py-1.5 rounded-xl bg-amber-500/10 hover:bg-amber-500/20 border border-amber-500/30 text-amber-300 font-bold text-xs transition flex items-center gap-1">
                                        <i class="fa-solid fa-pen text-[10px]"></i>
                                        <span>Edit</span>
                                    </button>
                                    <button @click="incomeSources = incomeSources.filter(i => i.id !== item.id)" class="px-2.5 py-1.5 rounded-xl bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 font-bold text-xs transition">Hapus</button>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL 1: Tambah Pemasukan Baru -->
    <div x-show="showAddIncomeModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm" x-transition>
        <div @click.outside="showAddIncomeModal = false" class="bg-slate-900 border border-slate-800 rounded-3xl p-6 max-w-md w-full shadow-2xl space-y-6">
            <div class="flex items-center justify-between pb-4 border-b border-slate-800">
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <i class="fa-solid fa-plus-circle text-emerald-400"></i>
                    <span>Catat Pemasukan Baru</span>
                </h3>
                <button @click="showAddIncomeModal = false" class="text-slate-400 hover:text-white"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>

            <form @submit.prevent="showAddIncomeModal = false" class="space-y-4 text-xs">
                <div>
                    <label class="block font-semibold text-slate-300 mb-1">Tanggal Pemasukan</label>
                    <input type="date" value="2026-07-01" required class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-white focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block font-semibold text-slate-300 mb-1">Nama Sumber Pemasukan</label>
                    <input type="text" placeholder="Contoh: Gaji Bulanan / Side Job" required class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-white focus:ring-2 focus:ring-emerald-500">
                </div>

                <!-- Custom Income Category Dropdown -->
                <div>
                    <label class="block font-semibold text-slate-300 mb-1">Kategori Income (Dapat Diatur Mandiri)</label>
                    <select class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-white focus:ring-2 focus:ring-emerald-500">
                        <template x-for="cat in incomeCategories" :key="cat">
                            <option :value="cat" x-text="cat"></option>
                        </template>
                    </select>
                </div>

                <div>
                    <label class="block font-semibold text-slate-300 mb-1">Nominal Pemasukan (Rp)</label>
                    <input type="number" placeholder="2500000" required class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-white font-bold text-sm focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block font-semibold text-slate-300 mb-1">Keterangan / Catatan</label>
                    <input type="text" placeholder="Catatan tambahan..." class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-white focus:ring-2 focus:ring-emerald-500">
                </div>

                <div class="pt-4 flex justify-end gap-3">
                    <button type="button" @click="showAddIncomeModal = false" class="px-4 py-2 rounded-xl bg-slate-800 text-slate-300 font-bold hover:bg-slate-700">Batal</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-500 text-slate-950 font-bold hover:bg-emerald-400">Simpan Income</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 2: EDIT PEMASUKAN -->
    <div x-show="showEditIncomeModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm" x-transition>
        <div @click.outside="showEditIncomeModal = false" class="bg-slate-900 border border-slate-800 rounded-3xl p-6 max-w-md w-full shadow-2xl space-y-6">
            <div class="flex items-center justify-between pb-4 border-b border-slate-800">
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <i class="fa-solid fa-pen-to-square text-amber-400"></i>
                    <span>Edit Data Pemasukan</span>
                </h3>
                <button @click="showEditIncomeModal = false" class="text-slate-400 hover:text-white"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>

            <form @submit.prevent="saveEditedIncome()" class="space-y-4 text-xs">
                <div>
                    <label class="block font-semibold text-slate-300 mb-1">Tanggal Pemasukan</label>
                    <input type="date" x-model="editingIncome.date" required class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-white focus:ring-2 focus:ring-amber-500">
                </div>

                <div>
                    <label class="block font-semibold text-slate-300 mb-1">Nama Sumber Pemasukan</label>
                    <input type="text" x-model="editingIncome.source" required class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-white focus:ring-2 focus:ring-amber-500">
                </div>

                <div>
                    <label class="block font-semibold text-slate-300 mb-1">Kategori Income</label>
                    <select x-model="editingIncome.category" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-white focus:ring-2 focus:ring-amber-500">
                        <template x-for="cat in incomeCategories" :key="cat">
                            <option :value="cat" x-text="cat"></option>
                        </template>
                    </select>
                </div>

                <div>
                    <label class="block font-semibold text-slate-300 mb-1">Nominal Pemasukan (Rp)</label>
                    <input type="number" x-model="editingIncome.amount" required class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-white font-bold text-sm focus:ring-2 focus:ring-amber-500">
                </div>

                <div>
                    <label class="block font-semibold text-slate-300 mb-1">Keterangan / Catatan</label>
                    <input type="text" x-model="editingIncome.notes" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-white focus:ring-2 focus:ring-amber-500">
                </div>

                <div class="pt-4 flex justify-end gap-3">
                    <button type="button" @click="showEditIncomeModal = false" class="px-4 py-2 rounded-xl bg-slate-800 text-slate-300 font-bold hover:bg-slate-700">Batal</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-amber-500 text-slate-950 font-bold hover:bg-amber-400">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
