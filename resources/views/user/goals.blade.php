@extends('layouts.user')

@section('user-content')
<!-- Komentar Bahasa Indonesia: Modul Perencanaan Target Tabungan & Financial Goals -->
<div x-data="{
    showAddGoalModal: false,
    showDepositModal: false,
    selectedGoal: null,

    depositAmount: 500000,

    goals: [
        { id: 1, name: 'Dana Darurat (6 Bulan)', target: 20000000, current: 14500000, deadline: 'Desember 2026', icon: 'fa-shield-heart', color: 'emerald' },
        { id: 2, name: 'DP Rumah Impian', target: 50000000, current: 12500000, deadline: 'Maret 2027', icon: 'fa-house-lock', color: 'purple' },
        { id: 3, name: 'Investasi Emas Digital', target: 10000000, current: 4099765, deadline: 'Agustus 2026', icon: 'fa-coins', color: 'amber' },
        { id: 4, name: 'Upgrade Laptop Kerja', target: 15000000, current: 8200000, deadline: 'November 2026', icon: 'fa-laptop-code', color: 'sky' }
    ],

    newGoal: { name: '', target: 5000000, deadline: '', icon: 'fa-bullseye' },

    formatRp(val) {
        return 'Rp ' + Number(val).toLocaleString('id-ID');
    },

    openDepositModal(g) {
        this.selectedGoal = g;
        this.showDepositModal = true;
    },

    processDeposit() {
        if (!this.selectedGoal || !this.depositAmount) return;
        this.selectedGoal.current += Number(this.depositAmount);
        this.showDepositModal = false;
    },

    addNewGoal() {
        if (!this.newGoal.name) return;
        this.goals.push({
            id: Date.now(),
            name: this.newGoal.name,
            target: Number(this.newGoal.target),
            current: 0,
            deadline: this.newGoal.deadline || '2026',
            icon: this.newGoal.icon || 'fa-bullseye',
            color: 'teal'
        });
        this.newGoal = { name: '', target: 5000000, deadline: '', icon: 'fa-bullseye' };
        this.showAddGoalModal = false;
    }
}" class="space-y-6">

    <!-- Page Title & Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Target Tabungan & Financial Goals</h1>
            <p class="text-xs text-slate-500 mt-1">Rencanakan dan pantau progres pencapaian target tabungan impian Anda.</p>
        </div>

        <button @click="showAddGoalModal = true" class="horizon-btn-primary bg-purple-600 hover:bg-purple-700 text-white">
            <i class="fa-solid fa-plus text-xs"></i>
            <span>Tambah Target Goals</span>
        </button>
    </div>

    <!-- Goals Grid Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <template x-for="g in goals" :key="g.id">
            <div class="horizon-card p-6 space-y-4 border-l-4 border-l-purple-600">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-purple-100 border border-purple-200 text-purple-800 flex items-center justify-center font-bold text-base shadow-xs">
                            <i :class="'fa-solid ' + g.icon"></i>
                        </div>
                        <div>
                            <h3 class="font-extrabold text-slate-900 text-base" x-text="g.name"></h3>
                            <span class="text-[11px] text-slate-500 font-medium" x-text="'Target Deadline: ' + g.deadline"></span>
                        </div>
                    </div>

                    <span class="px-3 py-1 rounded-full bg-purple-50 border border-purple-200 text-purple-800 font-mono font-extrabold text-xs"
                          x-text="((g.current / g.target) * 100).toFixed(1) + '%'"></span>
                </div>

                <!-- Progress Meter Bar -->
                <div class="space-y-1.5">
                    <div class="flex justify-between text-xs font-semibold">
                        <span class="text-slate-500">Terkumpul: <strong class="text-emerald-700 font-mono font-extrabold" x-text="formatRp(g.current)"></strong></span>
                        <span class="text-slate-500">Target: <strong class="text-slate-800 font-mono font-bold" x-text="formatRp(g.target)"></strong></span>
                    </div>

                    <div class="w-full h-3 rounded-full bg-slate-100 overflow-hidden border border-slate-200">
                        <div class="h-full rounded-full bg-gradient-to-r from-purple-600 to-indigo-500 transition-all duration-500"
                             :style="'width: ' + Math.min((g.current / g.target) * 100, 100) + '%'"></div>
                    </div>

                    <div class="flex justify-between text-[11px] font-medium pt-0.5">
                        <span class="text-slate-500">Kekurangan: <strong class="text-slate-700 font-mono" x-text="formatRp(Math.max(g.target - g.current, 0))"></strong></span>
                        <span x-text="g.current >= g.target ? 'Goal Tercapai!' : 'Dalam Progres'" :class="g.current >= g.target ? 'text-emerald-600 font-bold' : 'text-purple-700 font-bold'"></span>
                    </div>
                </div>

                <!-- Card Actions -->
                <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                    <button @click="openDepositModal(g)" class="horizon-btn-primary bg-purple-600 hover:bg-purple-700 text-white py-2 px-4 text-xs">
                        <i class="fa-solid fa-piggy-bank text-xs"></i>
                        <span>Setor Tabungan</span>
                    </button>
                    <button @click="goals = goals.filter(item => item.id !== g.id)" class="text-xs text-rose-600 hover:underline font-bold">Hapus Goal</button>
                </div>
            </div>
        </template>
    </div>

    <!-- MODAL 1: TAMBAH FINANCIAL GOAL BARU -->
    <div x-show="showAddGoalModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm" x-transition>
        <div @click.outside="showAddGoalModal = false" class="bg-white border border-slate-200 rounded-3xl p-6 max-w-md w-full shadow-2xl space-y-5">
            <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-bullseye text-purple-600"></i>
                    <span>Buat Target Goal Baru</span>
                </h3>
                <button @click="showAddGoalModal = false" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark text-sm"></i></button>
            </div>

            <form @submit.prevent="addNewGoal()" class="space-y-4 text-xs">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nama Target Goal</label>
                    <input type="text" x-model="newGoal.name" placeholder="Contoh: DP Mobil / Liburan Jepang" required class="horizon-input w-full">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Target Nominal Rp</label>
                    <input type="number" x-model="newGoal.target" required class="horizon-input w-full font-mono font-bold">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Target Deadline</label>
                    <input type="text" x-model="newGoal.deadline" placeholder="Contoh: Desember 2026" class="horizon-input w-full">
                </div>

                <div class="pt-3 border-t border-slate-200 flex justify-end gap-2.5">
                    <button type="button" @click="showAddGoalModal = false" class="horizon-btn-secondary">Batal</button>
                    <button type="submit" class="horizon-btn-primary bg-purple-600 hover:bg-purple-700 text-white">Simpan Goal</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 2: SETOR TABUNGAN KE GOAL -->
    <div x-show="showDepositModal && selectedGoal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm" x-transition>
        <div @click.outside="showDepositModal = false" class="bg-white border border-slate-200 rounded-3xl p-6 max-w-md w-full shadow-2xl space-y-5">
            <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-piggy-bank text-emerald-600"></i>
                    <span>Setor Alokasi Tabungan</span>
                </h3>
                <button @click="showDepositModal = false" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark text-sm"></i></button>
            </div>

            <form @submit.prevent="processDeposit()" class="space-y-4 text-xs">
                <div class="p-3.5 rounded-2xl bg-purple-50 border border-purple-200 text-purple-900 space-y-1">
                    <span class="text-[10px] font-bold uppercase tracking-wider block">Target Terpilih</span>
                    <strong class="text-base font-extrabold block" x-text="selectedGoal ? selectedGoal.name : ''"></strong>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nominal Setoran (Rp)</label>
                    <input type="number" x-model="depositAmount" required class="horizon-input w-full font-mono font-bold">
                </div>

                <div class="pt-3 border-t border-slate-200 flex justify-end gap-2.5">
                    <button type="button" @click="showDepositModal = false" class="horizon-btn-secondary">Batal</button>
                    <button type="submit" class="horizon-btn-primary">Konfirmasi Setoran</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
