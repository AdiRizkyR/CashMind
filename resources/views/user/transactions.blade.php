@extends('layouts.user')

@section('content')
<div x-data="{ openFilterPopover: false }" class="space-y-6">

    <!-- PAGE HEADER (Guideline v4 Section 14) -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-[24px] md:text-[30px] font-bold text-[#101828] tracking-tight">Transactions</h1>
            <p class="text-[#667085] text-xs md:text-sm mt-1">Semua aktivitas arus kas pemasukan, pengeluaran, dan transfer Anda.</p>
        </div>

        <button @click="openSideSheet = true" class="btn-primary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            <span>Tambah Transaksi</span>
        </button>
    </div>

    <!-- TOOLBAR OUTSIDE DATATABLE (Guideline v4 Section 53 & 54) -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <!-- Search Field (Width 320px Desktop - Guideline v4 Section 54) -->
        <form method="GET" action="{{ route('user.transactions.index') }}" class="w-full sm:w-[320px]">
            <div class="relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari transaksi..." class="cm-input pl-9 text-xs">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#667085" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-3.5">
                    <circle cx="11" cy="11" r="8"/>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
            </div>
        </form>

        <!-- Filter Trigger Button (Opens Popover/Sheet - Guideline v4 Section 54 & 55) -->
        <div class="flex items-center gap-2 self-start sm:self-auto relative">
            <button @click="openFilterPopover = !openFilterPopover" class="btn-secondary text-xs flex items-center gap-2">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
                <span>Filter</span>
                @if(request()->anyFilled(['type', 'account_id', 'category_id']))
                    <span class="w-2 h-2 rounded-full bg-[#0F766E]"></span>
                @endif
            </button>

            @if(request()->anyFilled(['search', 'type', 'account_id', 'category_id']))
                <a href="{{ route('user.transactions.index') }}" class="btn-secondary text-xs px-3" title="Reset Filter">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg>
                </a>
            @endif

            <!-- Filter Popover Panel Desktop (Guideline v4 Section 55) -->
            <div x-show="openFilterPopover" x-cloak @click.away="openFilterPopover = false" class="absolute right-0 top-12 z-30 w-72 bg-white border border-[#E4E7EC] rounded-xl p-4 shadow-xl space-y-4">
                <h4 class="text-xs font-bold text-[#101828] border-b border-[#EAECF0] pb-2">Filter Transaksi</h4>
                <form method="GET" action="{{ route('user.transactions.index') }}" class="space-y-3">
                    <div>
                        <label class="block text-xs font-semibold text-[#344054] mb-1">Jenis</label>
                        <select name="type" class="cm-input text-xs">
                            <option value="">Semua jenis</option>
                            <option value="income" {{ request('type') === 'income' ? 'selected' : '' }}>Pemasukan</option>
                            <option value="expense" {{ request('type') === 'expense' ? 'selected' : '' }}>Pengeluaran</option>
                            <option value="transfer" {{ request('type') === 'transfer' ? 'selected' : '' }}>Transfer</option>
                            <option value="adjustment" {{ request('type') === 'adjustment' ? 'selected' : '' }}>Penyesuaian</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#344054] mb-1">Rekening</label>
                        <select name="account_id" class="cm-input text-xs">
                            <option value="">Semua rekening</option>
                            @foreach($accounts as $acc)
                                <option value="{{ $acc->id }}" {{ request('account_id') == $acc->id ? 'selected' : '' }}>{{ $acc->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#344054] mb-1">Kategori</label>
                        <select name="category_id" class="cm-input text-xs">
                            <option value="">Semua kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="pt-2 flex justify-end gap-2 border-t border-[#EAECF0]">
                        <a href="{{ route('user.transactions.index') }}" class="btn-secondary text-xs h-9">Reset</a>
                        <button type="submit" class="btn-primary text-xs h-9">Terapkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- DATATABLE DESKTOP & MOBILE LIST (Guideline v4 Section 52 & 59) -->
    <div class="cm-panel overflow-hidden">
        
        <!-- Desktop Table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-[#E4E7EC] bg-[#F8FAFB] text-xs font-semibold text-[#475467]">
                        <th class="py-3 px-4">Tanggal</th>
                        <th class="py-3 px-4">Transaksi</th>
                        <th class="py-3 px-4">Rekening</th>
                        <th class="py-3 px-4">Kategori</th>
                        <th class="py-3 px-4 text-right">Nominal</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#EAECF0] text-xs">
                    @forelse($transactions as $t)
                        <tr class="hover:bg-[#F8FAFB] transition-colors">
                            <td class="py-3.5 px-4 text-[#475467] whitespace-nowrap">
                                {{ $t->transaction_date->format('d M Y') }}
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="font-semibold text-[#101828] block text-xs">{{ $t->description ?: ($t->category?->name ?? '-') }}</span>
                                @if($t->note)
                                    <span class="text-[11px] text-[#667085] block mt-0.5 font-normal">Catatan: {{ $t->note }}</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-[#475467]">
                                @if($t->type === 'transfer')
                                    <span>{{ $t->account?->name }}</span> → <span class="text-[#0F766E] font-medium">{{ $t->destinationAccount?->name }}</span>
                                @else
                                    <span>{{ $t->account?->name }}</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-[#475467]">
                                {{ $t->category?->name ?? '-' }}
                            </td>
                            <td class="py-3.5 px-4 text-right font-bold text-xs financial-number {{ $t->type === 'income' ? 'text-[#15803D]' : ($t->type === 'expense' ? 'text-[#B42318]' : 'text-[#101828]') }}">
                                {{ $t->type === 'income' ? '+' : ($t->type === 'expense' ? '-' : '') }} Rp {{ number_format($t->amount, 0, ',', '.') }}
                            </td>
                            <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                <form method="POST" action="{{ route('user.transactions.destroy', $t->id) }}" onsubmit="return confirm('Hapus transaksi sebesar Rp {{ number_format($t->amount, 0, ',', '.') }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1 text-[#667085] hover:text-[#B42318] transition-colors" title="Hapus">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center">
                                <div class="w-10 h-10 rounded-full bg-[#F4F6F8] text-[#667085] flex items-center justify-center mx-auto mb-3">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                        <polyline points="14 2 14 8 20 8"/>
                                    </svg>
                                </div>
                                <h3 class="text-xs font-semibold text-[#101828]">Belum ada transaksi</h3>
                                <p class="text-[11px] text-[#667085] max-w-xs mx-auto mt-1 mb-4">Mulai catat aktivitas keuangan pertama Anda.</p>
                                <button @click="openSideSheet = true" class="btn-primary text-xs">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                    <span>Tambah Transaksi</span>
                                </button>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile List Card View (Mandatory Guideline v4 Section 59) -->
        <div class="block md:hidden divide-y divide-[#EAECF0]">
            @forelse($transactions as $t)
                <div class="p-4 space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-[#101828] truncate">{{ $t->description ?: ($t->category?->name ?? '-') }}</span>
                        <span class="text-xs font-bold financial-number {{ $t->type === 'income' ? 'text-[#15803D]' : ($t->type === 'expense' ? 'text-[#B42318]' : 'text-[#101828]') }}">
                            {{ $t->type === 'income' ? '+' : ($t->type === 'expense' ? '-' : '') }} Rp {{ number_format($t->amount, 0, ',', '.') }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between text-[11px] text-[#667085]">
                        <span>{{ $t->category?->name ?? '-' }} • {{ $t->account?->name }}</span>
                        <span>{{ $t->transaction_date->format('d M Y') }}</span>
                    </div>
                </div>
            @empty
                <div class="py-10 text-center text-xs text-[#667085]">
                    Belum ada transaksi.
                </div>
            @endforelse
        </div>

        <!-- Pagination (Guideline v4 Section 53) -->
        @if($transactions->hasPages())
            <div class="p-4 border-t border-[#EAECF0] bg-[#F8FAFB] flex items-center justify-between text-xs text-[#475467]">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
