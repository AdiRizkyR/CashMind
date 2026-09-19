@extends('layouts.admin')

@section('content')
<div class="space-y-6">

    <!-- PAGE HEADER -->
    <div>
        <h1 class="text-2xl font-extrabold text-[#0F172A] tracking-tight">Security Audit Logs</h1>
        <p class="text-[#667085] text-xs font-medium mt-1">Log audit keamanan sistem merekam peristiwa autentikasi dan status akun. Tidak mengandung payload transaksi finansial.</p>
    </div>

    <!-- FILTER TOOLBAR (Guideline Section 54) -->
    <form method="GET" action="{{ route('admin.logs.index') }}" class="cm-panel p-4 flex flex-col sm:flex-row items-center justify-between gap-3">
        <div class="flex items-center gap-3 w-full sm:w-auto">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / email user..." class="w-full sm:w-64 h-10 px-3.5 rounded-xl border border-[#D0D5DD] text-[#101828] text-xs font-medium focus:border-[#0F766E] focus:ring-2 focus:ring-[#0F766E]/10 transition">
            <select name="event" class="h-10 px-3 rounded-xl border border-[#D0D5DD] text-[#101828] text-xs font-semibold focus:border-[#0F766E] focus:ring-2 focus:ring-[#0F766E]/10 transition w-auto">
                <option value="">Semua Event</option>
                <option value="LOGIN_SUCCESS" {{ request('event') === 'LOGIN_SUCCESS' ? 'selected' : '' }}>LOGIN_SUCCESS</option>
                <option value="LOGIN_FAILED" {{ request('event') === 'LOGIN_FAILED' ? 'selected' : '' }}>LOGIN_FAILED</option>
                <option value="ACCOUNT_SUSPENDED" {{ request('event') === 'ACCOUNT_SUSPENDED' ? 'selected' : '' }}>ACCOUNT_SUSPENDED</option>
                <option value="ACCOUNT_ACTIVATED" {{ request('event') === 'ACCOUNT_ACTIVATED' ? 'selected' : '' }}>ACCOUNT_ACTIVATED</option>
                <option value="PASSWORD_RESET_LINK_SENT" {{ request('event') === 'PASSWORD_RESET_LINK_SENT' ? 'selected' : '' }}>PASSWORD_RESET_LINK_SENT</option>
            </select>
        </div>

        <button type="submit" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 text-xs font-semibold text-white bg-[#0F172A] hover:bg-[#1E293B] rounded-xl shadow-xs transition w-full sm:w-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
            </svg>
            <span>Filter Logs</span>
        </button>
    </form>

    <!-- LOGS TABLE -->
    <div class="cm-panel overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="border-b border-[#E4E7EC] bg-[#F8FAFB] text-[11px] font-semibold text-[#475467]">
                        <th class="py-3 px-4">Waktu (Timestamp)</th>
                        <th class="py-3 px-4">Pengguna</th>
                        <th class="py-3 px-4">Security Event</th>
                        <th class="py-3 px-4">IP Address</th>
                        <th class="py-3 px-4">User Agent</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#EAECF0] font-mono">
                    @forelse($logs as $l)
                        <tr class="hover:bg-[#F8FAFB]">
                            <td class="py-3 px-4 text-[#667085] whitespace-nowrap">
                                {{ $l->created_at->format('Y-m-d H:i:s') }}
                            </td>
                            <td class="py-3 px-4 font-sans font-bold text-[#0F172A]">
                                {{ $l->user?->name ?? 'Guest / Public' }}
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-[#FFFAEB] text-[#B54708] border border-[#FEF08A]">
                                    {{ $l->event }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-[#475467]">
                                {{ $l->ip_address }}
                            </td>
                            <td class="py-3 px-4 text-[#98A2B3] text-[10px] font-sans truncate max-w-xs">
                                {{ $l->user_agent }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-[#98A2B3] font-sans font-medium">
                                Belum ada security log terekam.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
            <div class="p-4 border-t border-[#EAECF0]">
                {{ $logs->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
