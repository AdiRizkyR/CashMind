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
    <div class="bg-slate-900/90 p-6 rounded-3xl border border-slate-800 shadow-xl flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-1 rounded-full bg-amber-500/10 text-amber-400 text-[11px] font-bold uppercase tracking-wider">Modul Admin</span>
                <span class="text-slate-500">•</span>
                <span class="text-xs text-slate-400 font-medium">Audit Trail System</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white mt-1">Aktivitas & Audit Log Realtime</h1>
            <p class="text-xs text-slate-400 mt-1">Catatan riwayat aksi pengguna, perubahan data, dan pencatatan transaksi di seluruh platform.</p>
        </div>
    </div>

    <!-- Audit Log Table & Search Bar -->
    <div class="bg-slate-900/90 p-6 rounded-3xl border border-slate-800 shadow-xl space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-800">
            <div class="flex items-center gap-2 text-xs font-bold text-slate-300">
                <i class="fa-solid fa-clock-rotate-left text-amber-400"></i>
                <span>Log Aktivitas Realtime</span>
            </div>

            <div class="relative w-64">
                <i class="fa-solid fa-magnifying-glass text-xs text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                <input type="text" x-model="logSearch" placeholder="Cari aksi / user..." class="w-full bg-slate-800 text-white text-xs pl-9 pr-4 py-2 rounded-xl border border-slate-700 focus:outline-none focus:ring-2 focus:ring-amber-500">
            </div>
        </div>

        <div class="overflow-x-auto rounded-2xl border border-slate-800">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-950/80 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-800">
                        <th class="py-3.5 px-4">Waktu</th>
                        <th class="py-3.5 px-4">Pengguna (User)</th>
                        <th class="py-3.5 px-4">Aksi / Event</th>
                        <th class="py-3.5 px-4">Rincian Log</th>
                        <th class="py-3.5 px-4">IP Address</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    <template x-for="l in filteredLogs" :key="l.id">
                        <tr class="hover:bg-slate-800/40 transition">
                            <td class="py-3.5 px-4 font-mono text-slate-400 text-[11px]" x-text="l.time"></td>
                            <td class="py-3.5 px-4 font-bold text-white" x-text="l.user"></td>
                            <td class="py-3.5 px-4 font-semibold text-amber-300" x-text="l.action"></td>
                            <td class="py-3.5 px-4 text-slate-300" x-text="l.details"></td>
                            <td class="py-3.5 px-4 font-mono text-slate-500 text-[11px]" x-text="l.ip"></td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
