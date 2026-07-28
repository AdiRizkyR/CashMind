@extends('layouts.admin')

@section('admin-content')
<!-- Komentar Bahasa Indonesia: Audit Trail System Aktivitas Admin Tema Terang -->
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
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Audit Trail & Activity Log</h1>
            <p class="text-xs text-slate-500 mt-1">Catatan riwayat aksi pengguna, perubahan data, dan transaksi di seluruh platform.</p>
        </div>

        <div class="px-3 py-1.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-mono font-bold flex items-center gap-2 shadow-sm">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            <span>Realtime Logging Active</span>
        </div>
    </div>

    <!-- Audit Log Card -->
    <div class="light-card p-6 space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-200">
            <div class="relative w-full sm:w-64">
                <i class="fa-solid fa-magnifying-glass text-xs text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                <input type="text" x-model="logSearch" placeholder="Cari aksi / user / IP..." class="light-input w-full pl-9">
            </div>
            
            <span class="text-xs text-slate-500 font-mono font-bold">Tercatat: <strong class="text-slate-900" x-text="filteredLogs.length + ' Logs'"></strong></span>
        </div>

        <div class="overflow-x-auto rounded-xl border border-slate-200">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-100/80 text-[11px] font-bold text-slate-500 uppercase tracking-wider border-b border-slate-200">
                        <th class="py-3.5 px-4">Waktu</th>
                        <th class="py-3.5 px-4">Pengguna</th>
                        <th class="py-3.5 px-4">Event Aksi</th>
                        <th class="py-3.5 px-4">Rincian Audit Log</th>
                        <th class="py-3.5 px-4">IP Address</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200/80">
                    <template x-for="l in filteredLogs" :key="l.id">
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3.5 px-4 font-mono text-slate-500 text-[11px] font-semibold" x-text="l.time"></td>
                            <td class="py-3.5 px-4 font-bold text-slate-900" x-text="l.user"></td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-1 rounded bg-amber-50 border border-amber-200 text-amber-800 font-bold text-[11px]" x-text="l.action"></span>
                            </td>
                            <td class="py-3.5 px-4 font-semibold text-slate-700" x-text="l.details"></td>
                            <td class="py-3.5 px-4 font-mono text-slate-500 text-[11px] font-bold" x-text="l.ip"></td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
