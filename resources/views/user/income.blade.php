@extends('layouts.user')

@section('user-content')
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

    <!-- Page Title & Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-zinc-100 tracking-tight">Pencatatan Pemasukan</h1>
            <p class="text-xs text-zinc-400 mt-0.5">Kelola tanggal dan rincian sumber pendapatan per bulan.</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('user.categories') }}" class="saas-btn-secondary">
                <i class="fa-solid fa-sliders text-xs mr-1 text-emerald-400"></i> Kategori Income
            </a>
            <button @click="showAddIncomeModal = true" class="saas-btn-primary flex items-center gap-1.5">
                <i class="fa-solid fa-plus text-[10px]"></i>
                <span>Catat Pemasukan</span>
            </button>
        </div>
    </div>

    <!-- Income Summary Metric Banner -->
    <div class="saas-card p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center font-bold text-lg">
                <i class="fa-solid fa-arrow-down-left"></i>
            </div>
            <div>
                <span class="text-xs text-zinc-400 block">Total Pemasukan Bulan Juli 2026</span>
                <strong class="text-2xl font-bold text-emerald-400 font-mono" x-text="formatRp(totalIncome)"></strong>
            </div>
        </div>

        <div class="text-xs text-zinc-400 font-mono bg-zinc-950 px-3.5 py-2 rounded-lg border border-zinc-800">
            Total Sumber: <strong class="text-zinc-200" x-text="incomeSources.length + ' Item'"></strong>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="saas-card p-6 space-y-4">
        <div class="overflow-x-auto rounded-xl border border-zinc-800/80">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-zinc-950/80 text-[11px] font-semibold text-zinc-400 uppercase tracking-wider border-b border-zinc-800">
                        <th class="py-3 px-4">Tanggal</th>
                        <th class="py-3 px-4">Sumber Pemasukan</th>
                        <th class="py-3 px-4">Kategori</th>
                        <th class="py-3 px-4">Keterangan</th>
                        <th class="py-3 px-4 text-right">Jumlah (Rp)</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-800/60">
                    <template x-for="item in incomeSources" :key="item.id">
                        <tr class="hover:bg-zinc-900/40 transition">
                            <td class="py-3 px-4 font-medium text-zinc-300">
                                <div class="flex items-center gap-1.5">
                                    <i class="fa-regular fa-calendar text-emerald-400 text-xs"></i>
                                    <span x-text="item.displayDate || item.date"></span>
                                </div>
                            </td>
                            <td class="py-3 px-4 font-semibold text-zinc-100 text-sm" x-text="item.source"></td>
                            <td class="py-3 px-4">
                                <span class="px-2.5 py-1 rounded-md bg-emerald-500/10 border border-emerald-500/20 text-emerald-300 font-medium text-[11px]" x-text="item.category"></span>
                            </td>
                            <td class="py-3 px-4 text-zinc-400" x-text="item.notes"></td>
                            <td class="py-3 px-4 text-right font-bold text-emerald-400 font-mono text-sm" x-text="formatRp(item.amount)"></td>
                            <td class="py-3 px-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <button @click="openEditIncome(item)" class="px-2.5 py-1 rounded-md bg-zinc-900 hover:bg-zinc-800 border border-zinc-700/80 text-zinc-300 font-medium text-[11px] transition">
                                        <i class="fa-solid fa-pen text-[10px] mr-1"></i> Edit
                                    </button>
                                    <button @click="incomeSources = incomeSources.filter(i => i.id !== item.id)" class="px-2.5 py-1 rounded-md bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 font-medium text-[11px] transition">Hapus</button>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL 1: Tambah Pemasukan -->
    <div x-show="showAddIncomeModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm" x-transition>
        <div @click.outside="showAddIncomeModal = false" class="bg-[#12131c] border border-zinc-800 rounded-2xl p-6 max-w-md w-full shadow-2xl space-y-5">
            <div class="flex items-center justify-between pb-3 border-b border-zinc-800">
                <h3 class="text-base font-bold text-zinc-100 flex items-center gap-2">
                    <i class="fa-solid fa-plus-circle text-emerald-400"></i>
                    <span>Catat Pemasukan Baru</span>
                </h3>
                <button @click="showAddIncomeModal = false" class="text-zinc-500 hover:text-zinc-200"><i class="fa-solid fa-xmark text-sm"></i></button>
            </div>

            <form @submit.prevent="showAddIncomeModal = false" class="space-y-4 text-xs">
                <div>
                    <label class="block font-medium text-zinc-300 mb-1">Tanggal Pemasukan</label>
                    <input type="date" value="2026-07-01" required class="saas-input w-full">
                </div>

                <div>
                    <label class="block font-medium text-zinc-300 mb-1">Nama Sumber Pemasukan</label>
                    <input type="text" placeholder="Contoh: Gaji Bulanan / Side Job" required class="saas-input w-full">
                </div>

                <div>
                    <label class="block font-medium text-zinc-300 mb-1">Kategori Income</label>
                    <select class="saas-input w-full cursor-pointer">
                        <template x-for="cat in incomeCategories" :key="cat">
                            <option :value="cat" x-text="cat"></option>
                        </template>
                    </select>
                </div>

                <div>
                    <label class="block font-medium text-zinc-300 mb-1">Nominal Pemasukan (Rp)</label>
                    <input type="number" placeholder="2500000" required class="saas-input w-full font-mono font-bold">
                </div>

                <div>
                    <label class="block font-medium text-zinc-300 mb-1">Keterangan / Catatan</label>
                    <input type="text" placeholder="Catatan tambahan..." class="saas-input w-full">
                </div>

                <div class="pt-3 border-t border-zinc-800 flex justify-end gap-2.5">
                    <button type="button" @click="showAddIncomeModal = false" class="saas-btn-secondary">Batal</button>
                    <button type="submit" class="saas-btn-primary">Simpan Income</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 2: EDIT PEMASUKAN -->
    <div x-show="showEditIncomeModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm" x-transition>
        <div @click.outside="showEditIncomeModal = false" class="bg-[#12131c] border border-zinc-800 rounded-2xl p-6 max-w-md w-full shadow-2xl space-y-5">
            <div class="flex items-center justify-between pb-3 border-b border-zinc-800">
                <h3 class="text-base font-bold text-zinc-100 flex items-center gap-2">
                    <i class="fa-solid fa-pen-to-square text-emerald-400"></i>
                    <span>Edit Data Pemasukan</span>
                </h3>
                <button @click="showEditIncomeModal = false" class="text-zinc-500 hover:text-zinc-200"><i class="fa-solid fa-xmark text-sm"></i></button>
            </div>

            <form @submit.prevent="saveEditedIncome()" class="space-y-4 text-xs">
                <div>
                    <label class="block font-medium text-zinc-300 mb-1">Tanggal Pemasukan</label>
                    <input type="date" x-model="editingIncome.date" required class="saas-input w-full">
                </div>

                <div>
                    <label class="block font-medium text-zinc-300 mb-1">Nama Sumber Pemasukan</label>
                    <input type="text" x-model="editingIncome.source" required class="saas-input w-full">
                </div>

                <div>
                    <label class="block font-medium text-zinc-300 mb-1">Kategori Income</label>
                    <select x-model="editingIncome.category" class="saas-input w-full cursor-pointer">
                        <template x-for="cat in incomeCategories" :key="cat">
                            <option :value="cat" x-text="cat"></option>
                        </template>
                    </select>
                </div>

                <div>
                    <label class="block font-medium text-zinc-300 mb-1">Nominal Pemasukan (Rp)</label>
                    <input type="number" x-model="editingIncome.amount" required class="saas-input w-full font-mono font-bold">
                </div>

                <div>
                    <label class="block font-medium text-zinc-300 mb-1">Keterangan / Catatan</label>
                    <input type="text" x-model="editingIncome.notes" class="saas-input w-full">
                </div>

                <div class="pt-3 border-t border-zinc-800 flex justify-end gap-2.5">
                    <button type="button" @click="showEditIncomeModal = false" class="saas-btn-secondary">Batal</button>
                    <button type="submit" class="saas-btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
