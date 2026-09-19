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
    <div>
        <h1 class="text-2xl font-extrabold text-[#0F172A] tracking-tight">Rekonsiliasi Saldo Akun</h1>
        <p class="text-[#667085] text-xs font-medium mt-1">Audit dan cocokan saldo fisik tunai atau saldo bank aktual Anda dengan catatan saldo sistem.</p>
    </div>

    <!-- RECONCILIATION FORM PANEL -->
    <div class="cm-panel p-6 max-w-3xl space-y-6">
        <div class="border-b border-[#EAECF0] pb-3">
            <h2 class="text-base font-bold text-[#0F172A]">Form Audit Saldo Akun</h2>
            <p class="text-xs text-[#667085] mt-0.5">Pilih akun dan masukkan saldo fisik aktual hasil perhitungan fisik.</p>
        </div>

        <form method="POST" action="{{ route('user.reconciliation.store') }}" class="space-y-5 text-xs">
            @csrf

            <!-- Account Selector -->
            <div>
                <label class="block font-semibold text-[#344054] mb-1.5">Pilih Akun / Rekening <span class="text-[#B42318]">*</span></label>
                <select name="account_id" required x-model="selectedAccount" @change="
                    const opt = $event.target.options[$event.target.selectedIndex];
                    systemBalance = parseFloat(opt.getAttribute('data-balance') || 0);
                " class="w-full h-11 px-3.5 rounded-xl border border-[#D0D5DD] text-[#101828] text-sm focus:border-[#0F766E] focus:ring-3 focus:ring-[#0F766E]/10 transition">
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
                <div class="p-4 rounded-xl bg-[#F8FAFB] border border-[#E4E7EC]">
                    <span class="text-[10px] font-bold uppercase text-[#667085] block">Saldo Catatan Sistem</span>
                    <div class="text-lg font-extrabold text-[#0F172A] financial-number mt-1">
                        Rp <span x-text="Number(systemBalance).toLocaleString('id-ID')">0</span>
                    </div>
                </div>

                <!-- Actual Balance Input (Guideline Section 36) -->
                <div class="p-4 rounded-xl bg-[#F0FDFA] border border-[#99F6E4]">
                    <label class="text-[10px] font-bold uppercase text-[#0F766E] block mb-1">Saldo Fisik / Real Aktual</label>
                    <input type="text" 
                           x-model="formattedActualBalance" 
                           @input="formatRupiah($event.target.value)" 
                           placeholder="Rp 0" 
                           required 
                           class="w-full h-10 px-3 rounded-lg border border-[#D0D5DD] text-[#0F172A] font-extrabold financial-number text-base focus:border-[#0F766E] focus:ring-2 focus:ring-[#0F766E]/10 transition">
                    <input type="hidden" name="actual_balance" x-model="rawActualBalance">
                </div>

                <!-- Calculated Difference -->
                <div class="p-4 rounded-xl border" :class="(rawActualBalance - systemBalance) === 0 ? 'bg-[#F0FDF4] border-[#DCFCE7]' : 'bg-[#FFFAEB] border-[#FEF08A]'">
                    <span class="text-[10px] font-bold uppercase block" :class="(rawActualBalance - systemBalance) === 0 ? 'text-[#15803D]' : 'text-[#B54708]'">Selisih (Difference)</span>
                    <div class="text-lg font-extrabold financial-number mt-1" :class="(rawActualBalance - systemBalance) === 0 ? 'text-[#15803D]' : 'text-[#B54708]'">
                        <span x-text="(rawActualBalance - systemBalance) > 0 ? '+' : ''"></span>
                        Rp <span x-text="Number(rawActualBalance - systemBalance).toLocaleString('id-ID')">0</span>
                    </div>
                </div>
            </div>

            <!-- Catatan Audit -->
            <div>
                <label class="block font-semibold text-[#344054] mb-1.5">Catatan Audit Penyesuaian</label>
                <input type="text" name="note" placeholder="Contoh: Audit fisik dompet tunai mingguan" class="w-full h-11 px-3.5 rounded-xl border border-[#D0D5DD] text-[#101828] text-sm focus:border-[#0F766E] focus:ring-3 focus:ring-[#0F766E]/10 transition">
            </div>

            <!-- Create Adjustment Transaction Checkbox -->
            <div class="p-4 rounded-xl bg-[#F8FAFB] border border-[#E4E7EC]">
                <label class="flex items-center gap-2 text-xs font-semibold text-[#0F172A] cursor-pointer">
                    <input type="checkbox" name="create_adjustment" value="1" checked class="rounded-md border-[#D0D5DD] text-[#0F766E] focus:ring-[#0F766E]">
                    <span>Otomatis buat transaksi adjustment jika terdapat selisih saldo</span>
                </label>
                <p class="text-[11px] text-[#667085] mt-1 pl-6">
                    Transaksi penyesuaian (type = adjustment) akan dicatat untuk menyelaraskan saldo sistem dengan saldo fisik aktual Anda.
                </p>
            </div>

            <div class="pt-2 flex justify-end">
                <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 text-xs font-semibold text-white bg-[#0F172A] hover:bg-[#1E293B] rounded-xl shadow-xs transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>Simpan Hasil Rekonsiliasi</span>
                </button>
            </div>
        </form>
    </div>

    <!-- RECONCILIATION HISTORY LOGS -->
    <div class="cm-panel p-6 space-y-4">
        <h2 class="text-base font-bold text-[#0F172A] border-b border-[#EAECF0] pb-3">Riwayat Audit Rekonsiliasi</h2>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="border-b border-[#E4E7EC] bg-[#F8FAFB] text-[11px] font-semibold text-[#475467]">
                        <th class="py-3 px-4">Tanggal Audit</th>
                        <th class="py-3 px-4">Akun Rekening</th>
                        <th class="py-3 px-4 text-right">Saldo Sistem</th>
                        <th class="py-3 px-4 text-right">Saldo Aktual</th>
                        <th class="py-3 px-4 text-right">Selisih</th>
                        <th class="py-3 px-4">Catatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#EAECF0]">
                    @forelse($reconciliations as $r)
                        <tr class="hover:bg-[#F8FAFB]">
                            <td class="py-3.5 px-4 font-medium text-[#475467] whitespace-nowrap">
                                {{ $r->reconciled_at->format('d M Y H:i') }}
                            </td>
                            <td class="py-3.5 px-4 font-bold text-[#0F172A]">
                                {{ $r->account?->name }}
                            </td>
                            <td class="py-3.5 px-4 text-right financial-number text-[#667085]">
                                Rp {{ number_format($r->system_balance, 0, ',', '.') }}
                            </td>
                            <td class="py-3.5 px-4 text-right financial-number font-extrabold text-[#0F172A]">
                                Rp {{ number_format($r->actual_balance, 0, ',', '.') }}
                            </td>
                            <td class="py-3.5 px-4 text-right financial-number font-bold {{ $r->difference == 0 ? 'text-[#15803D]' : 'text-[#B54708]' }}">
                                {{ $r->difference > 0 ? '+' : '' }} Rp {{ number_format($r->difference, 0, ',', '.') }}
                            </td>
                            <td class="py-3.5 px-4 text-[#667085]">
                                {{ $r->note ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-[#667085] font-medium">
                                Belum ada riwayat rekonsiliasi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
