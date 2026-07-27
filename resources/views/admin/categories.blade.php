@extends('layouts.app')

@section('content')
<div x-data="{
    categories: [
        { id: 1, name: 'Makanan', defaultPct: '40%', type: 'Expense', status: 'Active' },
        { id: 2, name: 'Belanja', defaultPct: '10%', type: 'Expense', status: 'Active' },
        { id: 3, name: 'Tabungan', defaultPct: '30%', type: 'Allocation', status: 'Active' },
        { id: 4, name: 'Hiburan', defaultPct: '8%', type: 'Expense', status: 'Active' },
        { id: 5, name: 'Kendaraan', defaultPct: '10%', type: 'Expense', status: 'Active' },
        { id: 6, name: 'Admin', defaultPct: '2%', type: 'Fee', status: 'Active' },
        { id: 7, name: 'Dana HP', defaultPct: '15%', type: 'Expense', status: 'Active' }
    ]
}" class="space-y-6">

    <!-- Page Title & Header -->
    <div class="bg-slate-900/90 p-6 rounded-3xl border border-slate-800 shadow-xl flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-1 rounded-full bg-amber-500/10 text-amber-400 text-[11px] font-bold uppercase tracking-wider">Modul Admin</span>
                <span class="text-slate-500">•</span>
                <span class="text-xs text-slate-400 font-medium">System Master Data</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white mt-1">Master Kategori Transaksi</h1>
            <p class="text-xs text-slate-400 mt-1">Pengaturan kategori default sistem dan persentase rekomendasi alokasi.</p>
        </div>

        <button class="px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs shadow-lg shadow-amber-500/20 transition flex items-center gap-2">
            <i class="fa-solid fa-plus text-xs"></i>
            <span>Tambah Kategori System</span>
        </button>
    </div>

    <!-- Master Categories Table -->
    <div class="bg-slate-900/90 p-6 rounded-3xl border border-slate-800 shadow-xl space-y-4">
        <div class="overflow-x-auto rounded-2xl border border-slate-800">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-950/80 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-800">
                        <th class="py-3.5 px-4">Nama Kategori System</th>
                        <th class="py-3.5 px-4">Persentase Default</th>
                        <th class="py-3.5 px-4">Tipe Kategori</th>
                        <th class="py-3.5 px-4">Status System</th>
                        <th class="py-3.5 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    <template x-for="c in categories" :key="c.id">
                        <tr class="hover:bg-slate-800/40 transition">
                            <td class="py-3.5 px-4 font-bold text-white text-sm" x-text="c.name"></td>
                            <td class="py-3.5 px-4 font-semibold text-emerald-400 text-sm" x-text="c.defaultPct"></td>
                            <td class="py-3.5 px-4 text-slate-300" x-text="c.type"></td>
                            <td class="py-3.5 px-4"><span class="px-2 py-0.5 rounded bg-emerald-500/10 text-emerald-400 font-bold text-[10px]" x-text="c.status"></span></td>
                            <td class="py-3.5 px-4 text-center">
                                <button class="px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold text-xs transition">Edit Kategori</button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
