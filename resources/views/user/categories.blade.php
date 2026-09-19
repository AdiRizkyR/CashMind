@extends('layouts.user')

@section('content')
<div x-data="{ activeTab: 'expense', openAddModal: false, openEditModal: false, editCat: { id: '', name: '', type: 'expense', icon: '' } }" class="space-y-6">

    <!-- PAGE HEADER (Guideline v4 Section 14) -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-[24px] md:text-[30px] font-bold text-[#101828] tracking-tight">Categories</h1>
            <p class="text-[#667085] text-xs md:text-sm mt-1">Kelola kategori pemasukan dan pengeluaran serta visibilitas template sistem.</p>
        </div>

        <button @click="editCat.type = activeTab; openAddModal = true" class="btn-primary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            <span>Tambah Kategori Kustom</span>
        </button>
    </div>

    <!-- TABS SWITCHER (Guideline v4) -->
    <div class="flex items-center gap-2 border-b border-[#EAECF0]">
        <button @click="activeTab = 'expense'"
                :class="activeTab === 'expense' ? 'border-[#0F766E] text-[#0F766E] font-bold border-b-2' : 'border-transparent text-[#667085] font-medium hover:text-[#101828]'"
                class="py-3 px-4 text-sm transition-all flex items-center gap-2">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#B42318" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="19" x2="12" y2="5"/><polyline points="5 12 12 5 19 12"/></svg>
            <span>Pengeluaran</span>
        </button>

        <button @click="activeTab = 'income'"
                :class="activeTab === 'income' ? 'border-[#0F766E] text-[#0F766E] font-bold border-b-2' : 'border-transparent text-[#667085] font-medium hover:text-[#101828]'"
                class="py-3 px-4 text-sm transition-all flex items-center gap-2">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#15803D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 19 5 12"/></svg>
            <span>Pemasukan</span>
        </button>
    </div>

    <!-- TAB 1: PENGELUARAN (EXPENSE) -->
    <div x-show="activeTab === 'expense'" class="space-y-6" x-cloak>
        <!-- SYSTEM TEMPLATES (EXPENSE) -->
        <div class="cm-panel p-6 space-y-4">
            <div>
                <h2 class="text-base font-bold text-[#101828] flex items-center gap-2">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#667085" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="7" x="3" y="3" rx="1"/><rect width="7" height="7" x="14" y="3" rx="1"/><rect width="7" height="7" x="14" y="14" rx="1"/><rect width="7" height="7" x="3" y="14" rx="1"/></svg>
                    <span>Template Sistem (Pengeluaran)</span>
                </h2>
                <p class="text-xs text-[#667085] mt-0.5">Aktifkan atau sembunyikan visibilitas kategori sistem saat mencatat transaksi.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                @forelse($systemExpenseCategories as $sysCat)
                    <div class="p-3.5 rounded-xl border border-[#EAECF0] flex items-center justify-between {{ $sysCat->user_active ? 'bg-white' : 'bg-[#F8FAFB] opacity-70' }}">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg {{ $sysCat->user_active ? 'bg-[#FEF3F2] text-[#B42318]' : 'bg-[#EAECF0] text-[#667085]' }} flex items-center justify-center text-xs">
                                <i class="{{ $sysCat->icon }}"></i>
                            </div>
                            <div>
                                <span class="text-xs font-semibold text-[#101828] block">{{ $sysCat->name }}</span>
                                <span class="text-[11px] {{ $sysCat->user_active ? 'text-[#15803D]' : 'text-[#667085]' }}">
                                    {{ $sysCat->user_active ? 'Aktif' : 'Disembunyikan' }}
                                </span>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('user.categories.toggle-system', $sysCat->id) }}">
                            @csrf
                            <button type="submit" class="px-2.5 py-1 text-xs font-semibold rounded-lg border transition-all {{ $sysCat->user_active ? 'bg-white border-[#D0D5DD] text-[#344054] hover:bg-[#F9FAFB]' : 'bg-[#0F172A] border-[#0F172A] text-white hover:bg-[#1E293B]' }}">
                                {{ $sysCat->user_active ? 'Sembunyikan' : 'Aktifkan' }}
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="text-xs text-[#667085] py-2 col-span-full">Tidak ada kategori sistem.</div>
                @endforelse
            </div>
        </div>

        <!-- CUSTOM CATEGORIES (EXPENSE) -->
        <div class="cm-panel p-6 space-y-4">
            <div>
                <h2 class="text-base font-bold text-[#101828] flex items-center gap-2">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#B42318" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                    <span>Kategori Kustom (Pengeluaran)</span>
                </h2>
                <p class="text-xs text-[#667085] mt-0.5">Kategori khusus pengeluaran yang Anda buat sendiri.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                @forelse($userExpenseCategories as $cat)
                    <div class="p-3.5 rounded-xl border border-[#EAECF0] bg-white flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-[#FEF3F2] text-[#B42318] flex items-center justify-center text-xs">
                                <i class="{{ $cat->icon }}"></i>
                            </div>
                            <div>
                                <span class="text-xs font-semibold text-[#101828] block">{{ $cat->name }}</span>
                                <span class="text-[11px] text-[#667085] block">Pengeluaran Kustom</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-1">
                            <button @click="editCat = { id: '{{ $cat->id }}', name: '{{ $cat->name }}', type: '{{ $cat->type }}', icon: '{{ $cat->icon }}' }; openEditModal = true" class="p-1.5 text-[#667085] hover:text-[#0F172A] transition">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                            </button>
                            <form method="POST" action="{{ route('user.categories.destroy', $cat->id) }}" onsubmit="return confirm('Hapus kategori {{ $cat->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 text-[#667085] hover:text-[#B42318] transition">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full p-4 border border-dashed border-[#EAECF0] rounded-xl text-center text-xs text-[#667085]">
                        Belum ada kategori kustom pengeluaran.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- TAB 2: PEMASUKAN (INCOME) -->
    <div x-show="activeTab === 'income'" class="space-y-6" x-cloak>
        <!-- SYSTEM TEMPLATES (INCOME) -->
        <div class="cm-panel p-6 space-y-4">
            <div>
                <h2 class="text-base font-bold text-[#101828] flex items-center gap-2">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#667085" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="7" x="3" y="3" rx="1"/><rect width="7" height="7" x="14" y="3" rx="1"/><rect width="7" height="7" x="14" y="14" rx="1"/><rect width="7" height="7" x="3" y="14" rx="1"/></svg>
                    <span>Template Sistem (Pemasukan)</span>
                </h2>
                <p class="text-xs text-[#667085] mt-0.5">Aktifkan atau sembunyikan visibilitas kategori sistem pemasukan.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                @forelse($systemIncomeCategories as $sysCat)
                    <div class="p-3.5 rounded-xl border border-[#EAECF0] flex items-center justify-between {{ $sysCat->user_active ? 'bg-white' : 'bg-[#F8FAFB] opacity-70' }}">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg {{ $sysCat->user_active ? 'bg-[#F0FDF4] text-[#15803D]' : 'bg-[#EAECF0] text-[#667085]' }} flex items-center justify-center text-xs">
                                <i class="{{ $sysCat->icon }}"></i>
                            </div>
                            <div>
                                <span class="text-xs font-semibold text-[#101828] block">{{ $sysCat->name }}</span>
                                <span class="text-[11px] {{ $sysCat->user_active ? 'text-[#15803D]' : 'text-[#667085]' }}">
                                    {{ $sysCat->user_active ? 'Aktif' : 'Disembunyikan' }}
                                </span>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('user.categories.toggle-system', $sysCat->id) }}">
                            @csrf
                            <button type="submit" class="px-2.5 py-1 text-xs font-semibold rounded-lg border transition-all {{ $sysCat->user_active ? 'bg-white border-[#D0D5DD] text-[#344054] hover:bg-[#F9FAFB]' : 'bg-[#0F172A] border-[#0F172A] text-white hover:bg-[#1E293B]' }}">
                                {{ $sysCat->user_active ? 'Sembunyikan' : 'Aktifkan' }}
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="text-xs text-[#667085] py-2 col-span-full">Tidak ada kategori sistem.</div>
                @endforelse
            </div>
        </div>

        <!-- CUSTOM CATEGORIES (INCOME) -->
        <div class="cm-panel p-6 space-y-4">
            <div>
                <h2 class="text-base font-bold text-[#101828] flex items-center gap-2">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#15803D" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                    <span>Kategori Kustom (Pemasukan)</span>
                </h2>
                <p class="text-xs text-[#667085] mt-0.5">Kategori khusus pemasukan yang Anda buat sendiri.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                @forelse($userIncomeCategories as $cat)
                    <div class="p-3.5 rounded-xl border border-[#EAECF0] bg-white flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-[#F0FDF4] text-[#15803D] flex items-center justify-center text-xs">
                                <i class="{{ $cat->icon }}"></i>
                            </div>
                            <div>
                                <span class="text-xs font-semibold text-[#101828] block">{{ $cat->name }}</span>
                                <span class="text-[11px] text-[#667085] block">Pemasukan Kustom</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-1">
                            <button @click="editCat = { id: '{{ $cat->id }}', name: '{{ $cat->name }}', type: '{{ $cat->type }}', icon: '{{ $cat->icon }}' }; openEditModal = true" class="p-1.5 text-[#667085] hover:text-[#0F172A] transition">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                            </button>
                            <form method="POST" action="{{ route('user.categories.destroy', $cat->id) }}" onsubmit="return confirm('Hapus kategori {{ $cat->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 text-[#667085] hover:text-[#B42318] transition">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full p-4 border border-dashed border-[#EAECF0] rounded-xl text-center text-xs text-[#667085]">
                        Belum ada kategori kustom pemasukan.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- MODAL ADD CATEGORY TEMPLATE -->
    <div x-show="openAddModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-[#0F172A]/40 backdrop-blur-xs">
        <div @click.away="openAddModal = false" class="cm-panel w-full max-w-[480px] p-6 space-y-4 shadow-2xl">
            <div class="flex items-center justify-between border-b border-[#EAECF0] pb-3">
                <h3 class="text-base font-bold text-[#101828]">Tambah Kategori Kustom</h3>
                <button @click="openAddModal = false" class="text-[#98A2B3] hover:text-[#101828]">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>

            <form method="POST" action="{{ route('user.categories.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-[#344054] mb-1.5">Nama Kategori <span class="text-[#B42318]">*</span></label>
                    <input type="text" name="name" placeholder="Contoh: Investasi Emas, Kopi Harian" required class="cm-input">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-[#344054] mb-1.5">Tipe <span class="text-[#B42318]">*</span></label>
                    <select name="type" x-model="editCat.type" required class="cm-input">
                        <option value="expense">Pengeluaran</option>
                        <option value="income">Pemasukan</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-[#344054] mb-1.5">Class Ikon FontAwesome (Opsional)</label>
                    <input type="text" name="icon" value="fa-solid fa-tag" placeholder="fa-solid fa-utensils" class="cm-input">
                </div>

                <div class="pt-3 border-t border-[#EAECF0] flex justify-end gap-3">
                    <button type="button" @click="openAddModal = false" class="btn-secondary">Batal</button>
                    <button type="submit" class="btn-primary">Simpan Kategori</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
