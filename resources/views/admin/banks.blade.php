@extends('layouts.app')

@section('content')
<div x-data="{
    banks: [
        { id: 1, code: 'BNI', name: 'Bank Negara Indonesia', type: 'Bank Transfer', status: 'Active' },
        { id: 2, code: 'BRI', name: 'Bank Rakyat Indonesia', type: 'Bank Transfer', status: 'Active' },
        { id: 3, code: 'DANA', name: 'DANA E-Wallet', type: 'E-Wallet', status: 'Active' },
        { id: 4, code: 'GOPAY', name: 'GoPay Indonesia', type: 'E-Wallet', status: 'Active' },
        { id: 5, code: 'SHOPEEPAY', name: 'ShopeePay', type: 'E-Wallet', status: 'Active' },
        { id: 6, code: 'BLU', name: 'BLU by BCA Digital', type: 'Digital Bank', status: 'Active' },
        { id: 7, code: 'CASH', name: 'Cash (Tunai)', type: 'Physical Cash', status: 'Active' }
    ]
}" class="space-y-6">

    <!-- Page Title & Header -->
    <div class="bg-slate-900/90 p-6 rounded-3xl border border-slate-800 shadow-xl flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-1 rounded-full bg-amber-500/10 text-amber-400 text-[11px] font-bold uppercase tracking-wider">Modul Admin</span>
                <span class="text-slate-500">•</span>
                <span class="text-xs text-slate-400 font-medium">Payment Channels</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white mt-1">Master Bank & E-Wallet</h1>
            <p class="text-xs text-slate-400 mt-1">Daftar kanal institusi bank dan dompet digital yang didukung CashMind.</p>
        </div>

        <button class="px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs shadow-lg shadow-amber-500/20 transition flex items-center gap-2">
            <i class="fa-solid fa-plus text-xs"></i>
            <span>Tambah Bank / E-Wallet</span>
        </button>
    </div>

    <!-- Master Banks Table -->
    <div class="bg-slate-900/90 p-6 rounded-3xl border border-slate-800 shadow-xl space-y-4">
        <div class="overflow-x-auto rounded-2xl border border-slate-800">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-950/80 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-800">
                        <th class="py-3.5 px-4">Kode & Nama Institusi</th>
                        <th class="py-3.5 px-4">Tipe Kanal</th>
                        <th class="py-3.5 px-4">Status Integrasi</th>
                        <th class="py-3.5 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    <template x-for="b in banks" :key="b.id">
                        <tr class="hover:bg-slate-800/40 transition">
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-white text-sm" x-text="b.name"></div>
                                <span class="text-[10px] font-mono text-amber-400" x-text="b.code"></span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-300 font-medium" x-text="b.type"></td>
                            <td class="py-3.5 px-4"><span class="px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-400 font-bold text-[10px]" x-text="b.status"></span></td>
                            <td class="py-3.5 px-4 text-center">
                                <button class="px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold text-xs transition">Edit Kanal</button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
