@extends('layouts.user')

@section('content')
<div x-data="{ openFilterPopover: false, activeTab: '{{ request('tab', $tab ?? 'all') }}' }" class="space-y-6">

    <!-- PAGE HEADER -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-[#0F172A] font-display tracking-tight">Income & Expenses</h1>
            <p class="text-[#64748B] text-xs md:text-sm mt-1 font-medium">Kelola transaksi pemasukan, alokasi pengeluaran, dan transfer dana antar rekening.</p>
        </div>

        <div class="flex items-center gap-3">
            <button @click="openSideSheet = true" class="btn-emerald">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                <span>Catat Transaksi</span>
            </button>
        </div>
    </div>

    <!-- 3 CORE NAVIGATION TABS (Income, Expenses, Transfer Dana, Semua) -->
    <div class="cm-panel p-1.5 bg-[#F1F5F9] flex flex-wrap items-center justify-between gap-2 border border-[#E2E8F0]">
        <div class="flex items-center gap-1 w-full sm:w-auto overflow-x-auto">
            <a href="{{ route('user.transactions.index', ['tab' => 'all', 'month' => $month, 'year' => $year]) }}" class="py-2.5 px-4 rounded-xl text-xs font-bold transition-all whitespace-nowrap {{ $tab === 'all' ? 'bg-[#0F172A] text-white shadow-sm' : 'text-[#64748B] hover:text-[#0F172A] hover:bg-white/60' }}">
                Semua Transaksi
            </a>
            <a href="{{ route('user.transactions.index', ['tab' => 'income', 'month' => $month, 'year' => $year]) }}" class="py-2.5 px-4 rounded-xl text-xs font-bold transition-all whitespace-nowrap {{ $tab === 'income' ? 'bg-[#10B981] text-white shadow-sm' : 'text-[#64748B] hover:text-[#0F172A] hover:bg-white/60' }}">
                Tab Income (Pemasukan)
            </a>
            <a href="{{ route('user.transactions.index', ['tab' => 'expenses', 'month' => $month, 'year' => $year]) }}" class="py-2.5 px-4 rounded-xl text-xs font-bold transition-all whitespace-nowrap {{ $tab === 'expenses' ? 'bg-[#EF4444] text-white shadow-sm' : 'text-[#64748B] hover:text-[#0F172A] hover:bg-white/60' }}">
                Tab Expenses (Pengeluaran)
            </a>
            <a href="{{ route('user.transactions.index', ['tab' => 'transfer', 'month' => $month, 'year' => $year]) }}" class="py-2.5 px-4 rounded-xl text-xs font-bold transition-all whitespace-nowrap {{ $tab === 'transfer' ? 'bg-[#4F46E5] text-white shadow-sm' : 'text-[#64748B] hover:text-[#0F172A] hover:bg-white/60' }}">
                Transfer Dana
            </a>
        </div>

        <div class="px-3 py-1 bg-white rounded-lg border border-[#CBD5E1] text-[11px] font-bold text-[#475467] font-display">
            Periode: {{ \Carbon\Carbon::createFromDate($year, $month, 1)->translatedFormat('F Y') }}
        </div>
    </div>

    <!-- TAB EXPENSES SPECIFIC: CATEGORY ALLOCATION CONTROL MODE (Docx Section 4.2 B) -->
    @if($tab === 'expenses')
        <div x-data="{ mode: 'nominal' }" class="cm-panel p-6 space-y-5 border-l-4 border-l-[#EF4444]">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-[#E2E8F0] pb-4">
                <div>
                    <h3 class="text-base font-bold text-[#0F172A] font-display">Mode Alokasi Budget Pengeluaran</h3>
                    <p class="text-xs text-[#64748B] font-medium">Tetapkan batas alokasi budget per kategori menggunakan mode <strong>Persentase (%)</strong> atau <strong>Nominal (Rp)</strong>.</p>
                </div>
                <!-- Segmented Control for Percent / Nominal -->
                <div class="inline-flex p-1 bg-[#F1F5F9] rounded-xl border border-[#CBD5E1] self-start sm:self-auto">
                    <button type="button" @click="mode = 'nominal'" :class="mode === 'nominal' ? 'bg-white text-[#0F172A] font-bold shadow-xs' : 'text-[#64748B] hover:text-[#0F172A]'" class="py-1.5 px-3 rounded-lg text-xs transition">
                        Mode Nominal (Rp)
                    </button>
                    <button type="button" @click="mode = 'percentage'" :class="mode === 'percentage' ? 'bg-white text-[#0F172A] font-bold shadow-xs' : 'text-[#64748B] hover:text-[#0F172A]'" class="py-1.5 px-3 rounded-lg text-xs transition">
                        Mode Persentase (%)
                    </button>
                </div>
            </div>

            <form method="POST" action="{{ route('user.budget.store') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-end">
                @csrf
                <input type="hidden" name="period_month" value="{{ $month }}">
                <input type="hidden" name="period_year" value="{{ $year }}">
                
                <div class="sm:col-span-5">
                    <label class="block text-xs font-bold text-[#344054] mb-1 uppercase tracking-wider">Kategori Pengeluaran</label>
                    <select name="category_id" required class="cm-input text-xs">
                        <option value="">Pilih kategori pengeluaran</option>
                        @foreach($expenseCategories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="sm:col-span-4">
                    <label class="block text-xs font-bold text-[#344054] mb-1 uppercase tracking-wider" x-text="mode === 'percentage' ? 'Alokasi (%) Dari Total Income' : 'Alokasi Nominal (Rp)'"></label>
                    <input type="number" name="amount" required step="any" min="1" placeholder="Masukkan angka" class="cm-input text-xs financial-number">
                </div>

                <div class="sm:col-span-3">
                    <button type="submit" class="btn-primary w-full text-xs">Simpan Alokasi</button>
                </div>
            </form>

            <p class="text-[11px] text-[#64748B] italic">
                * Pada mode persentase, total alokasi pengeluaran idealnya tidak melebihi 100% dari basis pemasukan bulan aktif (Rp {{ number_format($monthIncomeTotal, 0, ',', '.') }}).
            </p>
        </div>
    @endif

    <!-- TOOLBAR SEARCH & FILTERS -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <!-- Search Field -->
        <form method="GET" action="{{ route('user.transactions.index') }}" class="w-full sm:w-[320px]">
            <input type="hidden" name="tab" value="{{ $tab }}">
            <input type="hidden" name="month" value="{{ $month }}">
            <input type="hidden" name="year" value="{{ $year }}">
            <div class="relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari transaksi / uraian..." class="cm-input pl-9 text-xs">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#64748B" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-3.5">
                    <circle cx="11" cy="11" r="8"/>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
            </div>
        </form>

        <!-- Filter Action Trigger -->
        <div class="flex items-center gap-2 relative">
            <button @click="openFilterPopover = !openFilterPopover" class="btn-secondary text-xs flex items-center gap-2">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
                <span>Filter</span>
                @if(request()->anyFilled(['account_id', 'category_id', 'type']))
                    <span class="w-2 h-2 rounded-full bg-[#4F46E5]"></span>
                @endif
            </button>

            @if(request()->anyFilled(['search', 'type', 'account_id', 'category_id']))
                <a href="{{ route('user.transactions.index', ['tab' => $tab, 'month' => $month, 'year' => $year]) }}" class="btn-secondary text-xs px-3" title="Reset Filter">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg>
                </a>
            @endif

            <!-- Filter Panel Popover -->
            <div x-show="openFilterPopover" x-cloak @click.away="openFilterPopover = false" class="absolute right-0 top-12 z-30 w-72 bg-white border border-[#E2E8F0] rounded-2xl p-4 shadow-xl space-y-4">
                <h4 class="text-xs font-bold text-[#0F172A] border-b border-[#E2E8F0] pb-2">Filter Data Transaksi</h4>
                <form method="GET" action="{{ route('user.transactions.index') }}" class="space-y-3">
                    <input type="hidden" name="tab" value="{{ $tab }}">
                    <input type="hidden" name="month" value="{{ $month }}">
                    <input type="hidden" name="year" value="{{ $year }}">

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

                    <div class="pt-2 flex justify-end gap-2 border-t border-[#E2E8F0]">
                        <button type="submit" class="btn-primary text-xs h-9 w-full justify-center">Terapkan Filter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- TRANSACTIONS DATATABLE & CARD LIST -->
    <div class="cm-panel overflow-hidden">
        
        <!-- Desktop Table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-[#E2E8F0] bg-[#F8FAFC] text-xs font-bold text-[#475467] uppercase tracking-wider">
                        <th class="py-3.5 px-4">Tanggal</th>
                        <th class="py-3.5 px-4">Uraian / Deskripsi</th>
                        <th class="py-3.5 px-4">Rekening Sumber / Tujuan</th>
                        <th class="py-3.5 px-4">Kategori</th>
                        <th class="py-3.5 px-4 text-right">Nominal (Rp)</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E2E8F0] text-xs">
                    @forelse($transactions as $t)
                        <tr class="hover:bg-[#F8FAFC] transition-colors">
                            <td class="py-3.5 px-4 text-[#475467] whitespace-nowrap font-medium">
                                {{ $t->transaction_date->format('d M Y') }}
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="font-bold text-[#0F172A] block text-xs">{{ $t->description ?: ($t->category?->name ?? '-') }}</span>
                                @if($t->note)
                                    <span class="text-[11px] text-[#64748B] block mt-0.5 font-normal">Catatan: {{ $t->note }}</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-[#475467] font-medium">
                                @if($t->type === 'transfer')
                                    <span>{{ $t->account?->name }}</span> → <span class="text-[#4F46E5] font-bold">{{ $t->destinationAccount?->name }}</span>
                                    @if($t->admin_fee > 0)
                                        <span class="block text-[10px] text-[#EF4444] font-semibold mt-0.5">+ Fee Admin Rp {{ number_format($t->admin_fee, 0, ',', '.') }}</span>
                                    @endif
                                @else
                                    <span>{{ $t->account?->name }}</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-[#475467]">
                                <span class="px-2.5 py-1 rounded-full bg-[#F1F5F9] font-medium text-[11px] border border-[#E2E8F0]">
                                    {{ $t->category?->name ?? ($t->type === 'transfer' ? 'Transfer Internal' : '-') }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right font-bold text-xs financial-number {{ $t->type === 'income' ? 'text-[#10B981]' : ($t->type === 'expense' ? 'text-[#EF4444]' : 'text-[#4F46E5]') }}">
                                {{ $t->type === 'income' ? '+' : ($t->type === 'expense' ? '-' : '') }} Rp {{ number_format($t->amount, 0, ',', '.') }}
                            </td>
                            <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                <form method="POST" action="{{ route('user.transactions.destroy', $t->id) }}" onsubmit="return confirm('Hapus transaksi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1 text-[#64748B] hover:text-[#EF4444] transition-colors" title="Hapus">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center">
                                <div class="w-12 h-12 rounded-2xl bg-[#F1F5F9] text-[#64748B] flex items-center justify-center mx-auto mb-3">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                </div>
                                <h3 class="text-xs font-bold text-[#0F172A]">Belum Ada Transaksi pada Tab Ini</h3>
                                <p class="text-[11px] text-[#64748B] max-w-xs mx-auto mt-1 mb-4">Catat transaksi baru untuk memperbarui data periode.</p>
                                <button @click="openSideSheet = true" class="btn-emerald text-xs">
                                    <span>Catat Transaksi Baru</span>
                                </button>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile List Card View -->
        <div class="block md:hidden divide-y divide-[#E2E8F0]">
            @forelse($transactions as $t)
                <div class="p-4 space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-[#0F172A] truncate">{{ $t->description ?: ($t->category?->name ?? '-') }}</span>
                        <span class="text-xs font-bold financial-number {{ $t->type === 'income' ? 'text-[#10B981]' : ($t->type === 'expense' ? 'text-[#EF4444]' : 'text-[#4F46E5]') }}">
                            {{ $t->type === 'income' ? '+' : ($t->type === 'expense' ? '-' : '') }} Rp {{ number_format($t->amount, 0, ',', '.') }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between text-[11px] text-[#64748B]">
                        <span>{{ $t->category?->name ?? 'Transfer' }} • {{ $t->account?->name }}</span>
                        <span>{{ $t->transaction_date->format('d M Y') }}</span>
                    </div>
                </div>
            @empty
                <div class="py-10 text-center text-xs text-[#64748B]">
                    Belum ada data transaksi.
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($transactions->hasPages())
            <div class="p-4 border-t border-[#E2E8F0] bg-[#F8FAFC]">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
