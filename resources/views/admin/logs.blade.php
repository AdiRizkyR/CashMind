@extends('layouts.admin')

@section('admin-content')
<div x-data="{
    logSearch: '',

    logs: [
        { id: 1, user: 'Aditya Personal (user@cashmind.id)', action: 'Input Transaksi Pengeluaran Baru', details: 'Dana HP (Dp Unit HP) - Rp 5.269.620', time: '27 Juli 2026, 23:15', ip: '180.252.12.98' },
        { id: 2, user: 'Aditya Personal (user@cashmind.id)', action: 'Pengaturan % Alokasi Budget Kategori', details: 'Mengubah alokasi Makanan ke 40%', time: '27 Juli 2026, 23:10', ip: '180.252.12.98' },
        { id: 3, user: 'Super Admin (admin@cashmind.id)', action: 'Inspeksi Detail User USR-001', details: 'Melihat ringkasan kas & status selisih', time: '27 Juli 2026, 23:05', ip: '127.0.0.1' },
        { id: 4, user: 'Budi Santoso (budi@gmail.com)', action: 'Cetak Laporan Keuangan PDF', details: 'Ekspor Laporan Bulanan Juli 2026', time: '27 Juli 2026, 21:40', ip: '114.122.45.12' },
        { id: 5, user: 'Siti Rahma (siti@yahoo.com)', action: 'Input Pemasukan Baru', details: 'Side Job Proyek Design - Rp 2.500.000', time: '27 Juli 2026, 19:22', ip: '182.1.99.44' }
    ],

    get filteredLogs() {
        return this.logs.filter(l => {
            return l.user.toLowerCase().includes(this.logSearch.toLowerCase()) ||
                   l.action.toLowerCase().includes(this.logSearch.toLowerCase()) ||
                   l.details.toLowerCase().includes(this.logSearch.toLowerCase());
        });
    }
}" class="space-y-6">

    <!-- Page Title & Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-zinc-100 tracking-tight">Audit Trail & Activity Log</h1>
            <p class="text-xs text-zinc-400 mt-0.5">Catatan riwayat aksi pengguna, perubahan data, dan transaksi di seluruh platform.</p>
        </div>

        <div class="px-3 py-1.5 rounded-lg bg-zinc-900 border border-zinc-800 text-zinc-400 text-xs font-mono flex items-center gap-1.5">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
            <span>Realtime Logging Active</span>
        </div>
    </div>

    <!-- Audit Log Card -->
    <div class="saas-card p-6 space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-zinc-800/80">
            <div class="relative w-full sm:w-64">
                <i class="fa-solid fa-magnifying-glass text-xs text-zinc-500 absolute left-3 top-1/2 -translate-y-1/2"></i>
                <input type="text" x-model="logSearch" placeholder="Cari aksi / user / IP..." class="saas-input w-full pl-9">
            </div>
            
            <span class="text-xs text-zinc-500 font-mono">Tercatat: <strong class="text-zinc-200" x-text="filteredLogs.length + ' Logs'"></strong></span>
        </div>

        <div class="overflow-x-auto rounded-xl border border-zinc-800/80">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-zinc-950/80 text-[11px] font-semibold text-zinc-400 uppercase tracking-wider border-b border-zinc-800">
                        <th class="py-3 px-4">Waktu</th>
                        <th class="py-3 px-4">Pengguna</th>
                        <th class="py-3 px-4">Event Aksi</th>
                        <th class="py-3 px-4">Rincian Audit Log</th>
                        <th class="py-3 px-4">IP Address</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-800/60 font-sans">
                    <template x-for="l in filteredLogs" :key="l.id">
                        <tr class="hover:bg-zinc-900/40 transition">
                            <td class="py-3 px-4 font-mono text-zinc-400 text-[11px]" x-text="l.time"></td>
                            <td class="py-3 px-4 font-semibold text-zinc-200" x-text="l.user"></td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-0.5 rounded bg-amber-500/10 border border-amber-500/20 text-amber-300 font-medium text-[11px]" x-text="l.action"></span>
                            </td>
                            <td class="py-3 px-4 text-zinc-300" x-text="l.details"></td>
                            <td class="py-3 px-4 font-mono text-zinc-500 text-[11px]" x-text="l.ip"></td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
