@extends('layouts.admin')

@section('content')
<div x-data="{ openDetail: false, modalUser: {} }" class="space-y-6">

    <!-- PAGE HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-[#0F172A] tracking-tight">Manajemen Pengguna</h1>
            <p class="text-[#667085] text-xs font-medium mt-1">Kelola status keaktifan akun pengguna terdaftar platform CashMind.</p>
        </div>
    </div>

    <!-- FILTER TOOLBAR (Guideline Section 54) -->
    <form method="GET" action="{{ route('admin.users.index') }}" class="cm-panel p-4 flex flex-col sm:flex-row items-center justify-between gap-3">
        <div class="flex items-center gap-3 w-full sm:w-auto">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / email..." class="w-full sm:w-64 h-10 px-3.5 rounded-xl border border-[#D0D5DD] text-[#101828] text-xs font-medium focus:border-[#0F766E] focus:ring-2 focus:ring-[#0F766E]/10 transition">
            <select name="status" class="h-10 px-3 rounded-xl border border-[#D0D5DD] text-[#101828] text-xs font-semibold focus:border-[#0F766E] focus:ring-2 focus:ring-[#0F766E]/10 transition w-auto">
                <option value="">Semua Status</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Dinonaktifkan</option>
            </select>
        </div>

        <button type="submit" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 text-xs font-semibold text-white bg-[#0F172A] hover:bg-[#1E293B] rounded-xl shadow-xs transition w-full sm:w-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
            </svg>
            <span>Filter Pengguna</span>
        </button>
    </form>

    <!-- USER DIRECTORY TABLE (Guideline Section 74: Responsive Table for Admin) -->
    <div class="cm-panel overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="border-b border-[#E4E7EC] bg-[#F8FAFB] text-[11px] font-semibold text-[#475467]">
                        <th class="py-3 px-4">Pengguna</th>
                        <th class="py-3 px-4">Email</th>
                        <th class="py-3 px-4">Tanggal Registrasi</th>
                        <th class="py-3 px-4">Login Terakhir</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-center">Aksi Operasional</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#EAECF0]">
                    @forelse($users as $u)
                        <tr class="hover:bg-[#F8FAFB]">
                            <td class="py-3.5 px-4 font-bold text-[#0F172A]">
                                {{ $u->name }}
                            </td>
                            <td class="py-3.5 px-4 text-[#475467]">
                                {{ $u->email }}
                            </td>
                            <td class="py-3.5 px-4 text-[#667085] whitespace-nowrap">
                                {{ $u->created_at->format('d M Y H:i') }}
                            </td>
                            <td class="py-3.5 px-4 text-[#667085] whitespace-nowrap">
                                {{ $u->last_login_at ? $u->last_login_at->format('d M Y H:i') : 'Belum Pernah' }}
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider border {{ $u->status === 'active' ? 'bg-[#F0FDF4] text-[#15803D] border-[#DCFCE7]' : 'bg-[#FEF3F2] text-[#B42318] border-[#FEE4E2]' }}">
                                    {{ $u->status === 'active' ? 'Aktif' : 'Non-Aktif' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <!-- View Profile Metadata -->
                                    <button @click="
                                        fetch('{{ route('admin.users.show', $u->id) }}')
                                            .then(res => res.json())
                                            .then(data => { modalUser = data; openDetail = true; });
                                    " class="px-2.5 py-1 text-[11px] font-semibold text-[#344054] bg-white border border-[#D0D5DD] hover:bg-[#F9FAFB] rounded-lg transition" title="Detail Profil">
                                        Detail
                                    </button>

                                    <!-- Toggle Status (Suspend / Activate) -->
                                    <form method="POST" action="{{ route('admin.users.toggle-status', $u->id) }}">
                                        @csrf
                                        <button type="submit" class="px-2.5 py-1 text-[11px] font-semibold rounded-lg border transition {{ $u->status === 'active' ? 'bg-[#FEF3F2] border-[#FEE4E2] text-[#B42318] hover:bg-[#FEE4E2]' : 'bg-[#F0FDF4] border-[#DCFCE7] text-[#15803D] hover:bg-[#DCFCE7]' }}">
                                            {{ $u->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>

                                    <!-- Send Password Reset -->
                                    <form method="POST" action="{{ route('admin.users.reset-link', $u->id) }}">
                                        @csrf
                                        <button type="submit" class="p-1.5 rounded-lg text-[#667085] hover:text-[#0F172A] hover:bg-[#F8FAFB] border border-[#D0D5DD] transition" title="Kirim Link Reset Password">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-[#98A2B3] font-medium">
                                Tidak ada pengguna ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="p-4 border-t border-[#EAECF0]">
                {{ $users->links() }}
            </div>
        @endif
    </div>

    <!-- USER METADATA INSPECTION MODAL (ZERO FINANCIAL EXPOSURE) -->
    <div x-show="openDetail" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-[#0F172A]/40 backdrop-blur-xs">
        <div @click.away="openDetail = false" class="cm-panel w-full max-w-md p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-[#EAECF0] pb-3">
                <h3 class="text-base font-bold text-[#0F172A]">Detail Pengguna (Metadata Sistem)</h3>
                <button @click="openDetail = false" class="text-[#667085] hover:text-[#0F172A]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Privacy Protection Notice -->
            <div class="p-3 rounded-xl bg-[#FFFAEB] border border-[#FEF08A] text-[#B54708] text-[11px] font-semibold flex items-center gap-2">
                <svg class="w-4 h-4 shrink-0 text-[#B54708]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                <span>Data finansial dan saldo pengguna diisolasi (Terproteksi Privasi).</span>
            </div>

            <div class="space-y-3 text-xs">
                <div class="flex justify-between border-b border-[#EAECF0] pb-2">
                    <span class="text-[#667085] font-medium">ID Akun</span>
                    <span class="font-bold text-[#0F172A] font-mono">#<span x-text="modalUser.id"></span></span>
                </div>
                <div class="flex justify-between border-b border-[#EAECF0] pb-2">
                    <span class="text-[#667085] font-medium">Nama Lengkap</span>
                    <span class="font-bold text-[#0F172A]" x-text="modalUser.name"></span>
                </div>
                <div class="flex justify-between border-b border-[#EAECF0] pb-2">
                    <span class="text-[#667085] font-medium">Email</span>
                    <span class="font-bold text-[#0F172A]" x-text="modalUser.email"></span>
                </div>
                <div class="flex justify-between border-b border-[#EAECF0] pb-2">
                    <span class="text-[#667085] font-medium">Status Verifikasi Email</span>
                    <span class="font-bold text-[#344054]" x-text="modalUser.email_verified"></span>
                </div>
                <div class="flex justify-between border-b border-[#EAECF0] pb-2">
                    <span class="text-[#667085] font-medium">Tanggal Registrasi</span>
                    <span class="font-bold text-[#344054]" x-text="modalUser.created_at"></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-[#667085] font-medium">Waktu Login Terakhir</span>
                    <span class="font-bold text-[#344054]" x-text="modalUser.last_login_at"></span>
                </div>
            </div>

            <div class="pt-2 flex justify-end">
                <button type="button" @click="openDetail = false" class="px-4 py-2 text-xs font-semibold text-[#344054] bg-white border border-[#D0D5DD] hover:bg-[#F9FAFB] rounded-xl transition">Tutup</button>
            </div>
        </div>
    </div>

</div>
@endsection
