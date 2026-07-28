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
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-zinc-100 tracking-tight">Direktori & Detail Pengguna</h1>
            <p class="text-xs text-zinc-400 mt-0.5">Inspeksi statistik keuangan pengguna, manajemen role, dan status akses akun.</p>
        </div>

        <button @click="showAddUserModal = true" class="saas-btn-primary bg-amber-500 hover:bg-amber-400 text-zinc-950 flex items-center gap-1.5">
            <i class="fa-solid fa-user-plus text-[10px]"></i>
            <span>Tambah User Baru</span>
        </button>
    </div>

    <!-- User Table Card -->
    <div class="saas-card p-6 space-y-4">
        
        <!-- Controls Bar -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-4 border-b border-zinc-800/80">
            <div class="relative w-full md:w-64">
                <i class="fa-solid fa-magnifying-glass text-xs text-zinc-500 absolute left-3 top-1/2 -translate-y-1/2"></i>
                <input type="text" x-model="userSearch" placeholder="Cari nama, email..." class="saas-input w-full pl-9">
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <select x-model="filterRole" class="saas-input cursor-pointer">
                    <option value="All">Semua Role</option>
                    <option value="Admin">Admin</option>
                    <option value="User">User</option>
                </select>

                <select x-model="filterStatus" class="saas-input cursor-pointer">
                    <option value="All">Semua Status</option>
                    <option value="Active">Active</option>
                    <option value="Suspended">Suspended</option>
                </select>
            </div>
        </div>

        <!-- Users Table -->
        <div class="overflow-x-auto rounded-xl border border-zinc-800/80">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-zinc-950/80 text-[11px] font-semibold text-zinc-400 uppercase tracking-wider border-b border-zinc-800">
                        <th class="py-3 px-4">User ID & Nama</th>
                        <th class="py-3 px-4">Email</th>
                        <th class="py-3 px-4">Role</th>
                        <th class="py-3 px-4">Total Transaksi</th>
                        <th class="py-3 px-4">Registrasi</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-center">Aksi / Detail</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-800/60">
                    <template x-for="u in filteredUsers" :key="u.id">
                        <tr class="hover:bg-zinc-900/40 transition">
                            <td class="py-3 px-4">
                                <div class="font-semibold text-zinc-100 text-sm" x-text="u.name"></div>
                                <span class="text-[10px] font-mono text-zinc-500" x-text="u.id"></span>
                            </td>
                            <td class="py-3 px-4 font-medium text-zinc-300" x-text="u.email"></td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-mono font-semibold uppercase"
                                      :class="u.role === 'Admin' ? 'bg-amber-500/10 text-amber-300 border border-amber-500/20' : 'bg-emerald-500/10 text-emerald-300 border border-emerald-500/20'"
                                      x-text="u.role"></span>
                            </td>
                            <td class="py-3 px-4 font-mono text-zinc-400" x-text="u.transactions + ' Item'"></td>
                            <td class="py-3 px-4 text-zinc-400" x-text="u.regDate"></td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-medium"
                                      :class="u.status === 'Active' ? 'bg-emerald-500/10 text-emerald-400' : 'bg-rose-500/10 text-rose-400'"
                                      x-text="u.status"></span>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <button @click="openUserDetail(u)" class="px-2.5 py-1 rounded-md bg-amber-500/10 hover:bg-amber-500/20 border border-amber-500/20 text-amber-300 font-medium text-[11px] transition flex items-center gap-1">
                                        <i class="fa-solid fa-eye text-[10px]"></i>
                                        <span>Detail</span>
                                    </button>
                                    <button @click="toggleUserStatus(u)" class="px-2.5 py-1 rounded-md bg-zinc-900 hover:bg-zinc-800 border border-zinc-700/80 text-zinc-300 font-medium text-[11px] transition" x-text="u.status === 'Active' ? 'Suspend' : 'Aktifkan'"></button>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL DETAIL USER VIEWER -->
    <div x-show="showUserDetailModal && selectedUser" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm" x-transition>
        <div @click.outside="showUserDetailModal = false" class="bg-[#12131c] border border-zinc-800 rounded-2xl p-6 max-w-xl w-full shadow-2xl space-y-5">
            <div class="flex items-center justify-between pb-3 border-b border-zinc-800">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-400 flex items-center justify-center font-bold text-lg">
                        <i class="fa-solid fa-user-circle"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-base font-bold text-zinc-100" x-text="selectedUser ? selectedUser.name : ''"></h3>
                            <span class="px-2 py-0.5 rounded text-[9px] font-mono uppercase font-bold" :class="selectedUser && selectedUser.role === 'Admin' ? 'bg-amber-500/10 text-amber-300' : 'bg-emerald-500/10 text-emerald-300'" x-text="selectedUser ? selectedUser.role : ''"></span>
                        </div>
                        <p class="text-xs text-zinc-400 font-mono" x-text="selectedUser ? selectedUser.email + ' • ID: ' + selectedUser.id : ''"></p>
                    </div>
                </div>
                <button @click="showUserDetailModal = false" class="text-zinc-500 hover:text-zinc-200"><i class="fa-solid fa-xmark text-sm"></i></button>
            </div>

            <template x-if="selectedUser">
                <div class="space-y-5 text-xs">
                    <!-- Key Financials Grid -->
                    <div class="grid grid-cols-3 gap-3 bg-zinc-950/60 p-3.5 rounded-xl border border-zinc-800">
                        <div>
                            <span class="text-zinc-500 block text-[10px]">Total Income User</span>
                            <strong class="text-emerald-400 font-mono font-bold text-sm" x-text="selectedUser.totalIncome"></strong>
                        </div>
                        <div>
                            <span class="text-zinc-500 block text-[10px]">Total Pengeluaran</span>
                            <strong class="text-rose-400 font-mono font-bold text-sm" x-text="selectedUser.totalExpense"></strong>
                        </div>
                        <div>
                            <span class="text-zinc-500 block text-[10px]">Missing Cash (Selisih)</span>
                            <strong class="text-amber-300 font-mono font-bold text-sm" x-text="selectedUser.missingCash"></strong>
                        </div>
                    </div>

                    <!-- User Metadata Grid -->
                    <div class="grid grid-cols-2 gap-3 bg-zinc-950/40 p-3.5 rounded-xl border border-zinc-800/60">
                        <div>
                            <span class="text-zinc-500 block text-[11px]">Tanggal Registrasi</span>
                            <strong class="text-zinc-200 font-medium" x-text="selectedUser.regDate"></strong>
                        </div>
                        <div>
                            <span class="text-zinc-500 block text-[11px]">Terakhir Aktif</span>
                            <strong class="text-zinc-200 font-medium" x-text="selectedUser.lastActive"></strong>
                        </div>
                        <div>
                            <span class="text-zinc-500 block text-[11px]">Total Catatan Transaksi</span>
                            <strong class="text-zinc-200 font-medium" x-text="selectedUser.transactions + ' Items'"></strong>
                        </div>
                        <div>
                            <span class="text-zinc-500 block text-[11px]">Kategori Kustom User</span>
                            <strong class="text-zinc-200 font-medium" x-text="selectedUser.customCategoriesCount + ' Kategori'"></strong>
                        </div>
                    </div>

                    <!-- Role Switch Bar -->
                    <div class="p-3.5 rounded-xl bg-amber-500/5 border border-amber-500/20 flex items-center justify-between">
                        <div>
                            <span class="font-bold text-amber-300 block">Hak Akses Role:</span>
                            <span class="text-[11px] text-zinc-400">Ubah peran akun ini antara Super Admin atau User.</span>
                        </div>
                        <button @click="selectedUser.role = (selectedUser.role === 'Admin' ? 'User' : 'Admin')" class="saas-btn-primary bg-amber-500 hover:bg-amber-400 text-zinc-950">
                            Ubah Role
                        </button>
                    </div>

                    <div class="pt-3 border-t border-zinc-800 flex justify-end">
                        <button type="button" @click="showUserDetailModal = false" class="saas-btn-secondary">Tutup Modal</button>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>
@endsection
