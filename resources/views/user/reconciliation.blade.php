@extends('layouts.user')

@section('content')
<div x-data="{ 
    selectedAccount: '', 
    systemBalance: 0, 
    rawActualBalance: 0,
    formattedActualBalance: '',
    formatRupiah(val) {
        let digits = String(val).replace(/[^0-9]/g, '');
        this.rawActualBalance = digits ? parseFloat(digits) : 0;
        this.formattedActualBalance = digits ? 'Rp ' + Number(digits).toLocaleString('id-ID') : '';
    }
}" class="space-y-6">

    <!-- PAGE HEADER -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-[#0F172A] font-display tracking-tight">Missing Budget & Deteksi Selisih Dana</h1>
            <p class="text-[#64748B] text-xs md:text-sm mt-1 font-medium">Mendeteksi selisih antara saldo yang secara matematis seharusnya tersisa dengan saldo aktual periode berikutnya.</p>
        </div>
    </div>

    <!-- 1. MISSING BUDGET MATHEMATICAL FORMULA PANEL (Docx Section 4.5 Requirement) -->
    <div class="cm-panel p-6 space-y-6 border-l-4 border-l-[#4F46E5]">
        <div class="border-b border-[#E2E8F0] pb-4 flex flex-col md:flex-row md:items-center justify-between gap-3">
            <div>
                <span class="px-2.5 py-0.5 rounded-full bg-[#EEF2FF] text-[#4F46E5] text-[11px] font-bold border border-[#C7D2FE] uppercase tracking-wider">Formula Matematika Missing Budget</span>
                <h2 class="text-lg font-bold text-[#0F172A] font-display mt-1">Perhitungan Selisih Saldo Seharusnya vs Saldo Aktual</h2>
            </div>
            <span class="text-xs font-bold text-[#475467] font-display bg-[#F1F5F9] px-3 py-1.5 rounded-xl border border-[#CBD5E1]">
                Periode Evaluasi: {{ \Carbon\Carbon::createFromDate($year, $month, 1)->translatedFormat('F Y') }}
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Saldo Seharusnya = Total Pemasukan - Total Pengeluaran -->
            <div class="p-5 rounded-2xl bg-[#F8FAFC] border border-[#E2E8F0] space-y-2">
                <span class="text-[11px] font-bold text-[#64748B] uppercase tracking-wider block">1. Saldo Seharusnya (Calculated)</span>
                <div class="text-2xl font-extrabold text-[#0F172A] financial-number font-display">
                    Rp {{ number_format($theoreticalBalance, 0, ',', '.') }}
                </div>
                <p class="text-[11px] text-[#64748B]">Formula: Total Income (Rp {{ number_format($totalIncome, 0, ',', '.') }}) - Total Expense (Rp {{ number_format($totalExpense, 0, ',', '.') }})</p>
            </div>

            <!-- Saldo Aktual Pembanding -->
            <div class="p-5 rounded-2xl bg-[#EEF2FF] border border-[#C7D2FE] space-y-2">
                <span class="text-[11px] font-bold text-[#4F46E5] uppercase tracking-wider block">2. Saldo Aktual Pembanding</span>
                <div class="text-2xl font-extrabold text-[#4F46E5] financial-number font-display">
                    Rp {{ number_format($totalActualAccountBalance, 0, ',', '.') }}
                </div>
                <p class="text-[11px] text-[#4F46E5] font-medium">Akumulasi net saldo fisik/rekening aktual saat ini</p>
            </div>

            <!-- Selisih / Missing Budget -->
            @php $missingBudgetAmount = $theoreticalBalance - $totalActualAccountBalance; @endphp
            <div class="p-5 rounded-2xl space-y-2 {{ $missingBudgetAmount == 0 ? 'bg-[#ECFDF5] border border-[#A7F3D0]' : 'bg-[#FFF1F2] border border-[#FECDD3]' }}">
                <span class="text-[11px] font-bold uppercase tracking-wider block {{ $missingBudgetAmount == 0 ? 'text-[#059669]' : 'text-[#EF4444]' }}">3. Selisih / Missing Budget</span>
                <div class="text-2xl font-extrabold financial-number font-display {{ $missingBudgetAmount == 0 ? 'text-[#059669]' : 'text-[#EF4444]' }}">
                    {{ $missingBudgetAmount > 0 ? '+' : '' }} Rp {{ number_format($missingBudgetAmount, 0, ',', '.') }}
                </div>
                <p class="text-[11px] font-medium {{ $missingBudgetAmount == 0 ? 'text-[#059669]' : 'text-[#EF4444]' }}">
                    {{ $missingBudgetAmount == 0 ? 'Saldo presisi 100% cocok!' : 'Terdapat selisih dana yang belum dicatat.' }}
                </p>
            </div>
        </div>

        <div class="p-4 rounded-xl bg-[#F8FAFC] border border-[#E2E8F0] text-xs text-[#64748B] space-y-1">
            <span class="font-bold text-[#0F172A] block">💡 Contoh Kasus Missing Budget (Docx Section 4.5):</span>
            <p>Jika pemasukan bulan ini Rp 2.000.000 dan pengeluaran Rp 1.500.000 → Saldo seharusnya adalah Rp 500.000. Jika saldo aktual yang tercatat masuk ke periode berikutnya hanya Rp 450.000, maka sistem mendeteksi selisih <strong>Missing Budget Rp 50.000</strong>.</p>
        </div>
    </div>

    <!-- 2. RECONCILIATION & ADJUSTMENT AUDIT FORM -->
    <div class="cm-panel p-6 max-w-3xl space-y-6">
        <div class="border-b border-[#E2E8F0] pb-3">
            <h2 class="text-base font-bold text-[#0F172A] font-display">Form Audit & Penyesuaian Saldo Rekening</h2>
            <p class="text-xs text-[#64748B] mt-0.5 font-medium">Lakukan audit fisik saldo kas / dompet digital dan simpan log rekonsiliasi selisih dana.</p>
        </div>

        <form method="POST" action="{{ route('user.reconciliation.store') }}" class="space-y-5 text-xs">
            @csrf

            <!-- Account Selector -->
            <div>
                <label class="block font-bold text-[#344054] mb-1.5 uppercase tracking-wider">Pilih Rekening / Akun Keuangan <span class="text-[#EF4444]">*</span></label>
                <select name="account_id" required x-model="selectedAccount" @change="
                    const opt = $event.target.options[$event.target.selectedIndex];
                    systemBalance = parseFloat(opt.getAttribute('data-balance') || 0);
                " class="cm-input text-xs">
                    <option value="">Pilih Akun Keuangan</option>
                    @foreach($accounts as $acc)
                        <option value="{{ $acc->id }}" data-balance="{{ $acc->balance }}">
                            {{ $acc->name }} (Saldo Sistem: Rp {{ number_format($acc->balance, 0, ',', '.') }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Balances Comparison Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-1">
                <!-- System Balance -->
                <div class="p-4 rounded-2xl bg-[#F8FAFC] border border-[#E2E8F0]">
                    <span class="text-[10px] font-bold uppercase text-[#64748B] block">Saldo Catatan Sistem</span>
                    <div class="text-lg font-extrabold text-[#0F172A] financial-number font-display mt-1">
                        Rp <span x-text="Number(systemBalance).toLocaleString('id-ID')">0</span>
                    </div>
                </div>

                <!-- Actual Balance Input -->
                <div class="p-4 rounded-2xl bg-[#EEF2FF] border border-[#C7D2FE]">
                    <label class="text-[10px] font-bold uppercase text-[#4F46E5] block mb-1">Saldo Fisik / Real Aktual</label>
                    <input type="text" 
                           x-model="formattedActualBalance" 
                           @input="formatRupiah($event.target.value)" 
                           placeholder="Rp 0" 
                           required 
                           class="cm-input text-[#0F172A] font-extrabold financial-number text-base border-[#CBD5E1]">
                    <input type="hidden" name="actual_balance" x-model="rawActualBalance">
                </div>

                <!-- Calculated Difference -->
                <div class="p-4 rounded-2xl border" :class="(rawActualBalance - systemBalance) === 0 ? 'bg-[#ECFDF5] border-[#A7F3D0]' : 'bg-[#FEF3C7] border-[#FDE68A]'">
                    <span class="text-[10px] font-bold uppercase block" :class="(rawActualBalance - systemBalance) === 0 ? 'text-[#059669]' : 'text-[#D97706]'">Selisih Dana</span>
                    <div class="text-lg font-extrabold financial-number font-display mt-1" :class="(rawActualBalance - systemBalance) === 0 ? 'text-[#059669]' : 'text-[#D97706]'">
                        <span x-text="(rawActualBalance - systemBalance) > 0 ? '+' : ''"></span>
                        Rp <span x-text="Number(rawActualBalance - systemBalance).toLocaleString('id-ID')">0</span>
                    </div>
                </div>
            </div>

            <!-- Catatan Audit -->
            <div>
                <label class="block font-bold text-[#344054] mb-1.5 uppercase tracking-wider">Catatan / Keterangan Audit</label>
                <input type="text" name="note" placeholder="Contoh: Perhitungan saldo kas fisik dompet bulanan" class="cm-input text-xs">
            </div>

            <!-- Create Adjustment Transaction Checkbox -->
            <div class="p-4 rounded-2xl bg-[#F8FAFC] border border-[#E2E8F0]">
                <label class="flex items-center gap-2 text-xs font-bold text-[#0F172A] cursor-pointer">
                    <input type="checkbox" name="create_adjustment" value="1" checked class="rounded-md border-[#CBD5E1] text-[#4F46E5] focus:ring-[#4F46E5]">
                    <span>Otomatis buat transaksi adjustment jika terdapat selisih saldo</span>
                </label>
                <p class="text-[11px] text-[#64748B] mt-1 pl-6 font-medium">
                    Transaksi penyesuaian (type = adjustment) akan dicatat untuk menyelaraskan saldo sistem secara otomatis dengan saldo aktual Anda.
                </p>
            </div>

            <div class="pt-2 flex justify-end">
                <button type="submit" class="btn-emerald text-xs">
                    <span>Simpan Deteksi Missing Budget</span>
                </button>
            </div>
        </form>
    </div>

    <!-- 3. AUDIT TRAIL RECONCILIATION HISTORY LOGS -->
    <div class="cm-panel p-6 space-y-4">
        <h2 class="text-base font-bold text-[#0F172A] border-b border-[#E2E8F0] pb-3 font-display">Riwayat Audit Missing Budget & Rekonsiliasi</h2>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="border-b border-[#E2E8F0] bg-[#F8FAFC] text-[11px] font-bold uppercase tracking-wider text-[#475467]">
                        <th class="py-3 px-4">Waktu Audit</th>
                        <th class="py-3 px-4">Akun Rekening</th>
                        <th class="py-3 px-4 text-right">Saldo Sistem</th>
                        <th class="py-3 px-4 text-right">Saldo Aktual Pembanding</th>
                        <th class="py-3 px-4 text-right">Selisih (Missing Budget)</th>
                        <th class="py-3 px-4">Catatan Audit</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E2E8F0]">
                    @forelse($reconciliations as $r)
                        <tr class="hover:bg-[#F8FAFC]">
                            <td class="py-3.5 px-4 font-medium text-[#475467] whitespace-nowrap">
                                {{ $r->reconciled_at->format('d M Y H:i') }}
                            </td>
                            <td class="py-3.5 px-4 font-bold text-[#0F172A]">
                                {{ $r->account?->name }}
                            </td>
                            <td class="py-3.5 px-4 text-right financial-number text-[#64748B]">
                                Rp {{ number_format($r->system_balance, 0, ',', '.') }}
                            </td>
                            <td class="py-3.5 px-4 text-right financial-number font-extrabold text-[#0F172A]">
                                Rp {{ number_format($r->actual_balance, 0, ',', '.') }}
                            </td>
                            <td class="py-3.5 px-4 text-right financial-number font-bold {{ $r->difference == 0 ? 'text-[#10B981]' : 'text-[#EF4444]' }}">
                                {{ $r->difference > 0 ? '+' : '' }} Rp {{ number_format($r->difference, 0, ',', '.') }}
                            </td>
                            <td class="py-3.5 px-4 text-[#64748B]">
                                {{ $r->note ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-[#64748B] font-medium">
                                Belum ada riwayat audit rekonsiliasi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
