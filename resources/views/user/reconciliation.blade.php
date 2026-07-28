@extends('layouts.user')

@section('user-content')
<!-- Komentar Bahasa Indonesia: Modul Rekonsiliasi Kas & Audit Selisih (Missing Cash Audit) -->
<div x-data="{
    systemExpectedBalance: 236710,
    physicalCashInput: 0,
    digitalWalletInput: 0,
    auditNotes: '',
    showSuccessAlert: false,

    auditLogs: [
        { id: 1, date: '28 Juli 2026', expected: 236710, actual: 236710, variance: 0, status: 'Balanced', notes: 'Pemeriksaan Dompet Tunai & BNI' },
        { id: 2, date: '30 Juni 2026', expected: 129876, actual: 116775, variance: 13101, status: 'Audit Selisih', notes: 'Selisih parkir & kembalian warung' },
        { id: 3, date: '31 Mei 2026', expected: 53156, actual: 9776, variance: 43380, status: 'Audit Selisih', notes: 'Lupa catat snack mini market' }
    ],

    get totalActualCash() {
        return Number(this.physicalCashInput) + Number(this.digitalWalletInput);
    },

    get cashVariance() {
        return this.systemExpectedBalance - this.totalActualCash;
    },

    formatRp(val) {
        return 'Rp ' + Number(val).toLocaleString('id-ID');
    },

    saveReconciliation() {
        this.auditLogs.unshift({
            id: Date.now(),
            date: new Date().toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' }),
            expected: this.systemExpectedBalance,
            actual: this.totalActualCash,
            variance: this.cashVariance,
            status: this.cashVariance === 0 ? 'Balanced' : 'Audit Selisih',
            notes: this.auditNotes || 'Penyesuaian Saldo Kas'
        });

        this.showSuccessAlert = true;
        setTimeout(() => this.showSuccessAlert = false, 4000);
    }
}" class="space-y-6">

    <!-- Page Title Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Rekonsiliasi Kas & Audit Selisih</h1>
            <p class="text-xs text-slate-500 mt-1">Audit kesesuaian antara saldo di aplikasi CashMind dengan saldo nyata di fisik & rekening.</p>
        </div>

        <div class="px-3.5 py-1.5 rounded-full bg-indigo-50 border border-indigo-200 text-indigo-900 text-xs font-mono font-bold flex items-center gap-2">
            <i class="fa-solid fa-scale-balanced text-indigo-600"></i>
            <span>Realtime Cash Audit Tool</span>
        </div>
    </div>

    <!-- Success Notification Alert Banner -->
    <div x-show="showSuccessAlert" x-cloak class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs flex items-center justify-between shadow-xs" x-transition>
        <div class="flex items-center gap-3 font-bold">
            <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
            <span>Rekonsiliasi Kas Berhasil Disimpan & Dicatat dalam Log Audit!</span>
        </div>
        <button @click="showSuccessAlert = false" class="text-emerald-700 hover:text-emerald-900"><i class="fa-solid fa-xmark"></i></button>
    </div>

    <!-- MAIN DUAL-PANEL RECONCILIATION CONTAINER -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- LEFT 7 COLUMNS: RECONCILIATION FORM & LIVE AUDIT CALCULATOR -->
        <div class="lg:col-span-7 space-y-6">
            <div class="horizon-card p-6 space-y-5">
                <div class="pb-3 border-b border-slate-200">
                    <h2 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-calculator text-indigo-600 text-sm"></i>
                        <span>Kalkulator Rekonsiliasi Saldo Kas</span>
                    </h2>
                    <p class="text-xs text-slate-500 mt-0.5">Input saldo uang tunai fisik & saldo bank/e-wallet Anda saat ini.</p>
                </div>

                <!-- Expected Balance Ribbon -->
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 flex items-center justify-between text-xs">
                    <div>
                        <span class="text-slate-500 font-bold block text-[11px]">Saldo Seharusnya di Aplikasi (System)</span>
                        <strong class="text-xl font-extrabold text-slate-900 font-mono" x-text="formatRp(systemExpectedBalance)"></strong>
                    </div>
                    <span class="px-2.5 py-1 rounded-full bg-slate-200 text-slate-700 font-mono font-bold text-[10px]">Pemasukan - Pengeluaran</span>
                </div>

                <!-- Form Inputs -->
                <form @submit.prevent="saveReconciliation()" class="space-y-4 text-xs">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1 flex items-center gap-1.5">
                                <i class="fa-solid fa-money-bill-wave text-amber-600"></i>
                                <span>Saldo Uang Tunai Fisik (Rp)</span>
                            </label>
                            <input type="number" x-model="physicalCashInput" placeholder="0" class="horizon-input w-full font-mono font-bold">
                        </div>

                        <div>
                            <label class="block font-bold text-slate-700 mb-1 flex items-center gap-1.5">
                                <i class="fa-solid fa-building-columns text-sky-600"></i>
                                <span>Saldo Bank / E-Wallet Nyata (Rp)</span>
                            </label>
                            <input type="number" x-model="digitalWalletInput" placeholder="0" class="horizon-input w-full font-mono font-bold">
                        </div>
                    </div>

                    <!-- Live Audit Result Summary Panel -->
                    <div class="p-4 rounded-2xl border transition-all space-y-2"
                         :class="cashVariance === 0 ? 'bg-emerald-50 border-emerald-200 text-emerald-950' : 'bg-amber-50 border-amber-200 text-amber-950'">
                        <div class="flex items-center justify-between text-xs">
                            <span class="font-bold">Total Saldo Real Terhitung:</span>
                            <strong class="text-base font-extrabold font-mono" x-text="formatRp(totalActualCash)"></strong>
                        </div>
                        <div class="flex items-center justify-between text-xs pt-1 border-t border-slate-200/60">
                            <span class="font-bold">Status Selisih (Missing Cash):</span>
                            <strong class="text-base font-extrabold font-mono"
                                    :class="cashVariance === 0 ? 'text-emerald-700' : 'text-amber-800'"
                                    x-text="cashVariance === 0 ? 'Balanced (Rp 0)' : formatRp(cashVariance) + ' Selisih'"></strong>
                        </div>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Catatan Hasil Audit Selisih</label>
                        <input type="text" x-model="auditNotes" placeholder="Contoh: Lupa catat uang parkir & kembalian warung" class="horizon-input w-full">
                    </div>

                    <div class="pt-2 flex justify-end">
                        <button type="submit" class="horizon-btn-primary bg-indigo-600 hover:bg-indigo-700 text-white">
                            <i class="fa-solid fa-scale-balanced text-xs"></i>
                            <span>Simpan Rekonsiliasi Kas</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- RIGHT 5 COLUMNS: AUDIT LOG HISTORY TABLE -->
        <div class="lg:col-span-5 space-y-6">
            <div class="horizon-card p-6 space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                    <h2 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-clock-rotate-left text-slate-600 text-sm"></i>
                        <span>Riwayat Audit Selisih Kas</span>
                    </h2>
                    <span class="text-xs font-mono font-bold text-slate-500" x-text="auditLogs.length + ' Item'"></span>
                </div>

                <div class="space-y-3 text-xs">
                    <template x-for="log in auditLogs" :key="log.id">
                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-slate-900" x-text="log.date"></span>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold font-mono"
                                      :class="log.status === 'Balanced' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800'"
                                      x-text="log.status"></span>
                            </div>

                            <div class="flex justify-between text-[11px] text-slate-600">
                                <span>Real vs System:</span>
                                <span class="font-mono font-bold text-slate-800" x-text="formatRp(log.actual) + ' / ' + formatRp(log.expected)"></span>
                            </div>

                            <div class="text-[11px] text-slate-500 font-medium italic border-t border-slate-200 pt-1" x-text="'Notes: ' + log.notes"></div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
