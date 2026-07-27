@extends('layouts.admin')

@section('admin-content')
<div x-data="{
    userSearch: '',
    filterStatus: 'All',
    filterRole: 'All',
    selectedUser: null,
    showUserDetailModal: false,
    showAddUserModal: false,

    users: [
        { 
            id: 'USR-001', 
            name: 'Aditya Personal', 
            email: 'user@cashmind.id', 
            role: 'User', 
            transactions: 142, 
            status: 'Active', 
            regDate: '01 Jan 2026', 
            lastActive: 'Hari ini, 23:15',
            totalIncome: 'Rp 10.959.540',
            totalExpense: 'Rp 10.722.830',
            missingCash: 'Rp 236.710',
            customCategoriesCount: 9
        },
        { 
            id: 'USR-002', 
            name: 'Super Admin CashMind', 
            email: 'admin@cashmind.id', 
            role: 'Admin', 
            transactions: 580, 
            status: 'Active', 
            regDate: '01 Jan 2026', 
            lastActive: 'Hari ini, 23:17',
            totalIncome: 'Rp 50.000.000',
            totalExpense: 'Rp 12.500.000',
            missingCash: 'Rp 0',
            customCategoriesCount: 15
        },
        { 
            id: 'USR-003', 
            name: 'Budi Santoso', 
            email: 'budi@gmail.com', 
            role: 'User', 
            transactions: 89, 
            status: 'Active', 
            regDate: '12 Feb 2026', 
            lastActive: 'Kemarin, 14:30',
            totalIncome: 'Rp 8.500.000',
            totalExpense: 'Rp 7.200.000',
            missingCash: 'Rp 50.000',
            customCategoriesCount: 6
        },
        { 
            id: 'USR-004', 
            name: 'Siti Rahma', 
            email: 'siti@yahoo.com', 
            role: 'User', 
            transactions: 54, 
            status: 'Active', 
            regDate: '25 Feb 2026', 
            lastActive: '3 hari lalu',
            totalIncome: 'Rp 6.200.000',
            totalExpense: 'Rp 5.800.000',
            missingCash: 'Rp 12.000',
            customCategoriesCount: 5
        },
        { 
            id: 'USR-005', 
            name: 'Rian Pratama', 
            email: 'rian@gmail.com', 
            role: 'User', 
            transactions: 12, 
            status: 'Suspended', 
            regDate: '04 Apr 2026', 
            lastActive: '12 Mei 2026',
            totalIncome: 'Rp 3.000.000',
            totalExpense: 'Rp 2.900.000',
            missingCash: 'Rp 100.000',
            customCategoriesCount: 4
        }
    ],

    get filteredUsers() {
        return this.users.filter(u => {
            const matchesSearch = u.name.toLowerCase().includes(this.userSearch.toLowerCase()) ||
                                  u.email.toLowerCase().includes(this.userSearch.toLowerCase()) ||
                                  u.id.toLowerCase().includes(this.userSearch.toLowerCase());
            const matchesStatus = this.filterStatus === 'All' || u.status === this.filterStatus;
            const matchesRole = this.filterRole === 'All' || u.role === this.filterRole;
            return matchesSearch && matchesStatus && matchesRole;
        });
    },

    openUserDetail(u) {
        this.selectedUser = u;
        this.showUserDetailModal = true;
    },

    toggleUserStatus(u) {
        u.status = u.status === 'Active' ? 'Suspended' : 'Active';
    }
}" class="space-y-6">

    <!-- Page Title & Header -->
    <div class="bg-slate-900/90 p-6 rounded-3xl border border-slate-800 shadow-xl flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-1 rounded-full bg-amber-500/10 text-amber-400 text-[11px] font-bold uppercase tracking-wider">Modul Admin</span>
                <span class="text-slate-500">•</span>
                <span class="text-xs text-slate-400 font-medium">Inspeksi Detail User</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white mt-1">Direktori & Detail Pengguna</h1>
            <p class="text-xs text-slate-400 mt-1">Inspeksi detail aktivitas keuangan pengguna, pengaturan status akun, dan manajemen role.</p>
        </div>

        <button @click="showAddUserModal = true" class="px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs shadow-lg shadow-amber-500/20 transition flex items-center gap-2">
            <i class="fa-solid fa-user-plus text-xs"></i>
            <span>Tambah User Baru</span>
        </button>
    </div>

    <!-- User Table & Filter Container -->
    <div class="bg-slate-900/90 p-6 rounded-3xl border border-slate-800 shadow-xl space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-800">
            <div class="flex items-center gap-2 text-xs font-bold text-slate-300">
                <i class="fa-solid fa-users-gear text-amber-400"></i>
                <span>Daftar Pengguna Platform</span>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <div class="relative">
                    <i class="fa-solid fa-magnifying-glass text-xs text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                    <input type="text" x-model="userSearch" placeholder="Cari nama, email..." class="bg-slate-800 text-white text-xs pl-9 pr-4 py-2 rounded-xl border border-slate-700 focus:outline-none focus:ring-2 focus:ring-amber-500 w-52 sm:w-64">
                </div>

                <select x-model="filterRole" class="bg-slate-800 text-slate-300 text-xs px-3 py-2 rounded-xl border border-slate-700 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    <option value="All">Semua Role</option>
                    <option value="Admin">Admin</option>
                    <option value="User">User</option>
                </select>

                <select x-model="filterStatus" class="bg-slate-800 text-slate-300 text-xs px-3 py-2 rounded-xl border border-slate-700 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    <option value="All">Semua Status</option>
                    <option value="Active">Active</option>
                    <option value="Suspended">Suspended</option>
                </select>
            </div>
        </div>

        <div class="overflow-x-auto rounded-2xl border border-slate-800">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-950/80 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-800">
                        <th class="py-3.5 px-4">User ID & Nama</th>
                        <th class="py-3.5 px-4">Email</th>
                        <th class="py-3.5 px-4">Role</th>
                        <th class="py-3.5 px-4">Total Transaksi</th>
                        <th class="py-3.5 px-4">Tgl Registrasi</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4 text-center">Aksi / Detail</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    <template x-for="u in filteredUsers" :key="u.id">
                        <tr class="hover:bg-slate-800/40 transition">
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-white text-sm" x-text="u.name"></div>
                                <span class="text-[10px] text-slate-500 font-mono" x-text="u.id"></span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-300 font-medium" x-text="u.email"></td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase"
                                      :class="u.role === 'Admin' ? 'bg-amber-500/20 text-amber-300 border border-amber-500/30' : 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30'"
                                      x-text="u.role"></span>
                            </td>
                            <td class="py-3.5 px-4 font-semibold text-slate-300" x-text="u.transactions + ' Transaksi'"></td>
                            <td class="py-3.5 px-4 text-slate-400" x-text="u.regDate"></td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold"
                                      :class="u.status === 'Active' ? 'bg-emerald-500/10 text-emerald-400' : 'bg-rose-500/10 text-rose-400'"
                                      x-text="u.status"></span>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button @click="openUserDetail(u)" class="px-3 py-1.5 rounded-xl bg-amber-500/10 hover:bg-amber-500/20 border border-amber-500/30 text-amber-300 font-bold text-xs transition flex items-center gap-1">
                                        <i class="fa-solid fa-eye text-[10px]"></i>
                                        <span>Detail User</span>
                                    </button>
                                    <button @click="toggleUserStatus(u)" class="px-2.5 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold text-xs transition" x-text="u.status === 'Active' ? 'Suspend' : 'Aktifkan'"></button>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL DETAIL USER -->
    <div x-show="showUserDetailModal && selectedUser" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm" x-transition>
        <div @click.outside="showUserDetailModal = false" class="bg-slate-900 border border-slate-800 rounded-3xl p-6 max-w-2xl w-full shadow-2xl space-y-6">
            <div class="flex items-center justify-between pb-4 border-b border-slate-800">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-amber-500/10 text-amber-400 flex items-center justify-center font-bold text-lg">
                        <i class="fa-solid fa-user-circle text-2xl"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-xl font-bold text-white" x-text="selectedUser ? selectedUser.name : ''"></h3>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase" :class="selectedUser && selectedUser.role === 'Admin' ? 'bg-amber-500/20 text-amber-300' : 'bg-emerald-500/20 text-emerald-300'" x-text="selectedUser ? selectedUser.role : ''"></span>
                        </div>
                        <p class="text-xs text-slate-400" x-text="selectedUser ? selectedUser.email + ' • User ID: ' + selectedUser.id : ''"></p>
                    </div>
                </div>
                <button @click="showUserDetailModal = false" class="text-slate-400 hover:text-white"><i class="fa-solid fa-xmark text-xl"></i></button>
            </div>

            <template x-if="selectedUser">
                <div class="space-y-6 text-xs">
                    <div class="grid grid-cols-3 gap-3 bg-slate-950/60 p-4 rounded-2xl border border-slate-800">
                        <div>
                            <span class="text-slate-400 block text-[11px]">Total Income User</span>
                            <strong class="text-emerald-400 text-sm font-extrabold" x-text="selectedUser.totalIncome"></strong>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-[11px]">Total Pengeluaran</span>
                            <strong class="text-rose-400 text-sm font-extrabold" x-text="selectedUser.totalExpense"></strong>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-[11px]">Missing Cash (Selisih)</span>
                            <strong class="text-amber-300 text-sm font-extrabold" x-text="selectedUser.missingCash"></strong>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 bg-slate-950/40 p-4 rounded-2xl border border-slate-800/80">
                        <div>
                            <span class="text-slate-400 block">Tanggal Registrasi</span>
                            <strong class="text-white font-medium" x-text="selectedUser.regDate"></strong>
                        </div>
                        <div>
                            <span class="text-slate-400 block">Terakhir Aktif</span>
                            <strong class="text-white font-medium" x-text="selectedUser.lastActive"></strong>
                        </div>
                        <div>
                            <span class="text-slate-400 block">Total Catatan Transaksi</span>
                            <strong class="text-white font-medium" x-text="selectedUser.transactions + ' Transaksi'"></strong>
                        </div>
                        <div>
                            <span class="text-slate-400 block">Kategori Kustom Dibuat User</span>
                            <strong class="text-white font-medium" x-text="selectedUser.customCategoriesCount + ' Kategori Kustom'"></strong>
                        </div>
                    </div>

                    <div class="p-4 rounded-2xl bg-amber-500/10 border border-amber-500/30 flex items-center justify-between">
                        <div>
                            <span class="font-bold text-amber-300 block">Hak Akses Role:</span>
                            <span class="text-[11px] text-slate-300">Ubah peran akun ini antara Super Admin atau User Personal.</span>
                        </div>
                        <button @click="selectedUser.role = (selectedUser.role === 'Admin' ? 'User' : 'Admin')" class="px-3 py-1.5 rounded-xl bg-amber-500 text-slate-950 font-bold text-xs hover:bg-amber-400 transition">
                            Ubah Role
                        </button>
                    </div>

                    <div class="pt-4 border-t border-slate-800 flex justify-end gap-3">
                        <button type="button" @click="showUserDetailModal = false" class="px-5 py-2 rounded-xl bg-slate-800 text-slate-300 font-bold hover:bg-slate-700">Tutup</button>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>
@endsection
