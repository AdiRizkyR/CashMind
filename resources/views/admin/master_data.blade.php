@extends('layouts.admin')

@section('content')
<div x-data="{ openAddInst: false, openAddCat: false }" class="space-y-6">

    <!-- PAGE HEADER (Guideline v4 Section 14) -->
    <div>
        <h1 class="text-[24px] md:text-[30px] font-bold text-[#101828] tracking-tight">Master Data</h1>
        <p class="text-[#667085] text-xs md:text-sm mt-1">Pengelolaan bank resmi, e-wallet, template kategori sistem, dan peninjauan saran pengguna.</p>
    </div>

    <!-- USER SUGGESTIONS SECTION (PROMOTION TO MASTER) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- 1. SARAN KATEGORI PENGGUNA -->
        <div class="cm-panel p-6 space-y-4">
            <div>
                <h2 class="text-base font-bold text-[#101828] flex items-center gap-2">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#D97706" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M15 14c.2-1 .7-1.7 1.5-2.5 1-.9 1.5-2.2 1.5-3.5A6 6 0 0 0 6 8c0 1 .2 2.2 1.5 3.5.7.7 1.3 1.5 1.5 2.5"/><path d="M9 18h6"/><path d="M10 22h4"/></svg>
                    <span>Saran Kategori dari Pengguna</span>
                </h2>
                <p class="text-xs text-[#667085] mt-0.5">Daftar kategori kustom pengguna yang dapat dipromosikan menjadi Template Sistem bawaan.</p>
            </div>

            <div class="space-y-2.5 max-h-72 overflow-y-auto pr-1">
                @forelse($userCategorySuggestions as $sugCat)
                    <div class="p-3.5 rounded-xl border border-[#EAECF0] bg-[#F8FAFB] flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-[#FFFBEB] text-[#D97706] flex items-center justify-center text-xs font-semibold">
                                <i class="{{ $sugCat->icon ?? 'fa-solid fa-tag' }}"></i>
                            </div>
                            <div>
                                <span class="text-xs font-bold text-[#101828] block leading-tight">{{ $sugCat->name }}</span>
                                <span class="text-[10px] text-[#667085] uppercase font-semibold block mt-0.5">{{ $sugCat->type }}</span>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('admin.master.category.promote') }}">
                            @csrf
                            <input type="hidden" name="name" value="{{ $sugCat->name }}">
                            <input type="hidden" name="type" value="{{ $sugCat->type }}">
                            <input type="hidden" name="icon" value="{{ $sugCat->icon ?? 'fa-solid fa-tag' }}">
                            <button type="submit" class="px-3 py-1.5 rounded-lg bg-[#0F172A] text-white text-xs font-semibold hover:bg-[#1E293B] transition-colors flex items-center gap-1.5">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                <span>Jadikan Template Sistem</span>
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="p-4 border border-dashed border-[#EAECF0] rounded-xl text-center text-xs text-[#667085]">
                        Belum ada saran kategori kustom baru dari pengguna.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- 2. SARAN BANK / REKENING PENGGUNA -->
        <div class="cm-panel p-6 space-y-4">
            <div>
                <h2 class="text-base font-bold text-[#101828] flex items-center gap-2">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#0F766E" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><line x1="3" x2="21" y1="22" y2="22"/><line x1="6" x2="6" y1="18" y2="11"/><line x1="10" x2="10" y1="18" y2="11"/><line x1="14" x2="14" y1="18" y2="11"/><line x1="18" x2="18" y1="18" y2="11"/><polygon points="12 2 20 7 4 7 12 2"/></svg>
                    <span>Saran Rekening/Dompet Digital Pengguna</span>
                </h2>
                <p class="text-xs text-[#667085] mt-0.5">Daftar nama lembaga kustom pengguna yang dapat dipromosikan menjadi Master Platform resmi.</p>
            </div>

            <div class="space-y-2.5 max-h-72 overflow-y-auto pr-1">
                @forelse($userAccountSuggestions as $sugAcc)
                    <div class="p-3.5 rounded-xl border border-[#EAECF0] bg-[#F8FAFB] flex items-center justify-between">
                        <div>
                            <span class="text-xs font-bold text-[#101828] block leading-tight">{{ $sugAcc->name }}</span>
                            <span class="text-[10px] text-[#667085] uppercase font-semibold block mt-0.5">{{ $sugAcc->type }}</span>
                        </div>

                        <form method="POST" action="{{ route('admin.master.institution.promote') }}">
                            @csrf
                            <input type="hidden" name="name" value="{{ $sugAcc->name }}">
                            <input type="hidden" name="type" value="{{ in_array($sugAcc->type, ['bank', 'e_wallet']) ? $sugAcc->type : 'other' }}">
                            <button type="submit" class="px-3 py-1.5 rounded-lg bg-[#0F766E] text-white text-xs font-semibold hover:bg-[#115E59] transition-colors flex items-center gap-1.5">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                <span>Jadikan Master Platform</span>
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="p-4 border border-dashed border-[#EAECF0] rounded-xl text-center text-xs text-[#667085]">
                        Belum ada saran nama bank/dompet digital baru dari pengguna.
                    </div>
                @endforelse
            </div>
        </div>

    </div>

    <!-- MASTER INSTITUTIONS (BANKS & E-WALLETS) -->
    <div class="cm-panel p-6 space-y-4">
        <div class="flex items-center justify-between border-b border-[#EAECF0] pb-4">
            <div>
                <h2 class="text-base font-bold text-[#101828]">Master Bank & E-Wallet Resmi</h2>
                <p class="text-xs text-[#667085] mt-0.5">Daftar lembaga keuangan resmi yang tersedia di platform</p>
            </div>
            <button @click="openAddInst = true" class="btn-primary text-xs">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                <span>Tambah Lembaga</span>
            </button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
            @foreach($institutions as $inst)
                <div class="p-3.5 rounded-xl border border-[#EAECF0] bg-[#F8FAFB] flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold text-[#101828] block leading-tight">{{ $inst->name }}</span>
                        <span class="text-[10px] text-[#667085] uppercase font-semibold block mt-0.5">{{ $inst->type }}</span>
                    </div>
                    <form method="POST" action="{{ route('admin.master.institution.destroy', $inst->id) }}" onsubmit="return confirm('Hapus {{ $inst->name }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-1 text-[#667085] hover:text-[#B42318] transition-colors" title="Hapus">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>

    <!-- MASTER SYSTEM CATEGORIES TEMPLATES -->
    <div class="cm-panel p-6 space-y-4">
        <div class="flex items-center justify-between border-b border-[#EAECF0] pb-4">
            <div>
                <h2 class="text-base font-bold text-[#101828]">Template Kategori Standar Sistem</h2>
                <p class="text-xs text-[#667085] mt-0.5">Kategori bawaan yang dapat digunakan oleh seluruh pengguna baru</p>
            </div>
            <button @click="openAddCat = true" class="btn-primary text-xs">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                <span>Tambah Template Kategori</span>
            </button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
            @foreach($categoryTemplates as $cat)
                <div class="p-3.5 rounded-xl border border-[#EAECF0] bg-[#F8FAFB] flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-white border border-[#E4E7EC] text-[#344054] flex items-center justify-center text-xs">
                            <i class="{{ $cat->icon }}"></i>
                        </div>
                        <div>
                            <span class="text-xs font-bold text-[#101828] block leading-tight">{{ $cat->name }}</span>
                            <span class="text-[10px] text-[#667085] uppercase font-semibold block mt-0.5">{{ $cat->type }}</span>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('admin.master.category.destroy', $cat->id) }}" onsubmit="return confirm('Hapus template {{ $cat->name }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-1 text-[#667085] hover:text-[#B42318] transition-colors" title="Hapus">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>

    <!-- MODAL ADD INSTITUTION -->
    <div x-show="openAddInst" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-[#0F172A]/40 backdrop-blur-xs">
        <div @click.away="openAddInst = false" class="cm-panel w-full max-w-[480px] p-6 space-y-4 shadow-2xl">
            <div class="flex items-center justify-between border-b border-[#EAECF0] pb-3">
                <h3 class="text-base font-bold text-[#101828]">Tambah Lembaga Keuangan</h3>
                <button @click="openAddInst = false" class="text-[#98A2B3] hover:text-[#101828]">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>

            <form method="POST" action="{{ route('admin.master.institution.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-[#344054] mb-1.5">Nama Lembaga <span class="text-[#B42318]">*</span></label>
                    <input type="text" name="name" placeholder="Contoh: Bank Syariah Indonesia, DANA" required class="cm-input">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-[#344054] mb-1.5">Tipe Lembaga <span class="text-[#B42318]">*</span></label>
                    <select name="type" required class="cm-input">
                        <option value="bank">Bank</option>
                        <option value="e_wallet">E-Wallet</option>
                        <option value="other">Lainnya</option>
                    </select>
                </div>

                <input type="hidden" name="status" value="active">

                <div class="pt-3 border-t border-[#EAECF0] flex justify-end gap-3">
                    <button type="button" @click="openAddInst = false" class="btn-secondary">Batal</button>
                    <button type="submit" class="btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL ADD CATEGORY TEMPLATE -->
    <div x-show="openAddCat" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-[#0F172A]/40 backdrop-blur-xs">
        <div @click.away="openAddCat = false" class="cm-panel w-full max-w-[480px] p-6 space-y-4 shadow-2xl">
            <div class="flex items-center justify-between border-b border-[#EAECF0] pb-3">
                <h3 class="text-base font-bold text-[#101828]">Tambah Template Kategori</h3>
                <button @click="openAddCat = false" class="text-[#98A2B3] hover:text-[#101828]">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>

            <form method="POST" action="{{ route('admin.master.category.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-[#344054] mb-1.5">Nama Template Kategori <span class="text-[#B42318]">*</span></label>
                    <input type="text" name="name" placeholder="Contoh: Asuransi, Pajak" required class="cm-input">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-[#344054] mb-1.5">Tipe <span class="text-[#B42318]">*</span></label>
                    <select name="type" required class="cm-input">
                        <option value="expense">Pengeluaran</option>
                        <option value="income">Pemasukan</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-[#344054] mb-1.5">FontAwesome Icon</label>
                    <input type="text" name="icon" value="fa-solid fa-tag" class="cm-input">
                </div>

                <div class="pt-3 border-t border-[#EAECF0] flex justify-end gap-3">
                    <button type="button" @click="openAddCat = false" class="btn-secondary">Batal</button>
                    <button type="submit" class="btn-primary">Simpan Template</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
