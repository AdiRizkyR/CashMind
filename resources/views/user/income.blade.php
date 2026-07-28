@extends('layouts.user')

@section('user-content')
<!-- Komentar Bahasa Indonesia: Command Center Pencatatan Pemasukan (Split View Architecture) -->
<div x-data="{
    showAddIncomeModal: false,
    showEditIncomeModal: false,
    selectedMonth: 'Juli',

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

    <!-- Page Title Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Pencatatan Pemasukan</h1>
            <p class="text-xs text-slate-500 mt-1">Kelola dan analisis sumber pendapatan per bulan secara presisi.</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('user.categories') }}" class="exec-btn-secondary">
                <i class="fa-solid fa-sliders text-xs text-emerald-600"></i> Kategori Income
            </a>
            <button @click="showAddIncomeModal = true" class="exec-btn-primary">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>Catat Pemasukan</span>
            </button>
        </div>
    </div>

    <!-- SPLIT VIEW ARCHITECTURE (7 COLS TABLE / 5 COLS SIDE PANEL) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- LEFT 7 COLUMNS: INCOME DATA TABLE -->
        <div class="lg:col-span-7 space-y-4">
            <div class="exec-panel p-6 space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                    <h2 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-hand-holding-dollar text-emerald-600 text-sm"></i>
                        <span>Daftar Pemasukan Terdaftar</span>
                    </h2>
                    <span class="text-xs font-mono font-bold text-slate-500" x-text="incomeSources.length + ' Item'"></span>
                </div>

                <div class="overflow-x-auto rounded-xl border border-slate-200">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-slate-100/80 text-[11px] font-bold text-slate-500 uppercase tracking-wider border-b border-slate-200">
                                <th class="py-3 px-3.5">Tanggal & Sumber</th>
                                <th class="py-3 px-3.5">Kategori</th>
                                <th class="py-3 px-3.5 text-right">Jumlah (Rp)</th>
                                <th class="py-3 px-3.5 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            <template x-for="item in incomeSources" :key="item.id">
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="py-3 px-3.5">
                                        <div class="font-bold text-slate-900 text-xs" x-text="item.source"></div>
                                        <div class="text-[10px] text-slate-500 font-medium" x-text="item.displayDate || item.date"></div>
                                    </td>
                                    <td class="py-3 px-3.5">
                                        <span class="px-2 py-0.5 rounded bg-emerald-50 border border-emerald-200 text-emerald-800 font-bold text-[10px]" x-text="item.category"></span>
                                    </td>
                                    <td class="py-3 px-3.5 text-right font-extrabold text-emerald-600 font-mono text-xs" x-text="formatRp(item.amount)"></td>
                                    <td class="py-3 px-3.5 text-center">
                                        <div class="flex items-center justify-center gap-1">
                                            <button @click="openEditIncome(item)" class="p-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-[10px] transition">
                                                <i class="fa-solid fa-pen"></i>
                                            </button>
                                            <button @click="incomeSources = incomeSources.filter(i => i.id !== item.id)" class="p-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold text-[10px] transition">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- RIGHT 5 COLUMNS: LIVE ANALYTICS & QUICK ENTRY CARD -->
        <div class="lg:col-span-5 space-y-6">
            
            <!-- Income Total Metric Card -->
            <div class="exec-panel p-6 space-y-4 border-l-4 border-l-emerald-600">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 border border-emerald-200 text-emerald-700 flex items-center justify-center font-bold text-base shadow-xs">
                        <i class="fa-solid fa-hand-holding-dollar"></i>
                    </div>
                    <div>
                        <span class="text-xs font-bold text-slate-500 block">Total Pemasukan Bulan Juli 2026</span>
                        <strong class="text-2xl font-extrabold text-emerald-600 font-mono" x-text="formatRp(totalIncome)"></strong>
                    </div>
                </div>

                <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-600 space-y-1">
                    <div class="flex justify-between">
                        <span>Sumber Terbesar:</span>
                        <strong class="text-slate-900 font-bold">Penarikan Tabungan</strong>
                    </div>
                    <div class="flex justify-between">
                        <span>Kontribusi Side Job:</span>
                        <strong class="text-emerald-700 font-bold">Rp 3.333.000</strong>
                    </div>
                </div>
            </div>

            <!-- Income Stream Breakdown List -->
            <div class="exec-panel p-6 space-y-4">
                <h3 class="text-sm font-extrabold text-slate-900 pb-2 border-b border-slate-200">Breakdown Kategori Income</h3>

                <div class="space-y-2.5 text-xs">
                    <template x-for="cat in incomeCategories" :key="cat">
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-between">
                            <span class="font-bold text-slate-800" x-text="cat"></span>
                            <span class="px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 font-mono font-bold text-[10px]">Aktif</span>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL 1: Tambah Pemasukan -->
    <div x-show="showAddIncomeModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm" x-transition>
        <div @click.outside="showAddIncomeModal = false" class="bg-white border border-slate-200 rounded-2xl p-6 max-w-md w-full shadow-2xl space-y-5">
            <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-plus-circle text-emerald-600"></i>
                    <span>Catat Pemasukan Baru</span>
                </h3>
                <button @click="showAddIncomeModal = false" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark text-sm"></i></button>
            </div>

            <form @submit.prevent="showAddIncomeModal = false" class="space-y-4 text-xs">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Tanggal Pemasukan</label>
                    <input type="date" value="2026-07-01" required class="exec-input w-full">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nama Sumber Pemasukan</label>
                    <input type="text" placeholder="Contoh: Gaji Bulanan / Side Job" required class="exec-input w-full">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Kategori Income</label>
                    <select class="exec-input w-full cursor-pointer font-bold">
                        <template x-for="cat in incomeCategories" :key="cat">
                            <option :value="cat" x-text="cat"></option>
                        </template>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nominal Pemasukan (Rp)</label>
                    <input type="number" placeholder="2500000" required class="exec-input w-full font-mono font-bold">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Keterangan / Catatan</label>
                    <input type="text" placeholder="Catatan tambahan..." class="exec-input w-full">
                </div>

                <div class="pt-3 border-t border-slate-200 flex justify-end gap-2.5">
                    <button type="button" @click="showAddIncomeModal = false" class="exec-btn-secondary">Batal</button>
                    <button type="submit" class="exec-btn-primary">Simpan Income</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 2: EDIT PEMASUKAN -->
    <div x-show="showEditIncomeModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm" x-transition>
        <div @click.outside="showEditIncomeModal = false" class="bg-white border border-slate-200 rounded-2xl p-6 max-w-md w-full shadow-2xl space-y-5">
            <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-pen-to-square text-emerald-600"></i>
                    <span>Edit Data Pemasukan</span>
                </h3>
                <button @click="showEditIncomeModal = false" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark text-sm"></i></button>
            </div>

            <form @submit.prevent="saveEditedIncome()" class="space-y-4 text-xs">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Tanggal Pemasukan</label>
                    <input type="date" x-model="editingIncome.date" required class="exec-input w-full">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nama Sumber Pemasukan</label>
                    <input type="text" x-model="editingIncome.source" required class="exec-input w-full">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Kategori Income</label>
                    <select x-model="editingIncome.category" class="exec-input w-full cursor-pointer font-bold">
                        <template x-for="cat in incomeCategories" :key="cat">
                            <option :value="cat" x-text="cat"></option>
                        </template>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nominal Pemasukan (Rp)</label>
                    <input type="number" x-model="editingIncome.amount" required class="exec-input w-full font-mono font-bold">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Keterangan / Catatan</label>
                    <input type="text" x-model="editingIncome.notes" class="exec-input w-full">
                </div>

                <div class="pt-3 border-t border-slate-200 flex justify-end gap-2.5">
                    <button type="button" @click="showEditIncomeModal = false" class="exec-btn-secondary">Batal</button>
                    <button type="submit" class="exec-btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
