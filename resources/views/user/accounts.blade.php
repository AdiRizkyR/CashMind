@extends('layouts.user')

@section('content')
<div x-data="{ 
    openSheet: false, 
    isEdit: false,
    editId: null,
    formName: '',
    formType: 'bank',
    formInstitutionId: '',
    formIsActive: true,
    rawBalance: '0',
    formattedBalance: 'Rp 0',
    formatRupiah(val) {
        let digits = String(val).replace(/[^0-9]/g, '');
        this.rawBalance = digits;
        this.formattedBalance = digits ? 'Rp ' + Number(digits).toLocaleString('id-ID') : 'Rp 0';
    },
    resetForm() {
        this.isEdit = false;
        this.editId = null;
        this.formName = '';
        this.formType = 'bank';
        this.formInstitutionId = '';
        this.formIsActive = true;
        this.rawBalance = '0';
        this.formattedBalance = 'Rp 0';
    },
    openAdd() {
        this.resetForm();
        this.openSheet = true;
    },
    openEdit(acc) {
        this.isEdit = true;
        this.editId = acc.id;
        this.formName = acc.name;
        this.formType = acc.type;
        this.formInstitutionId = acc.institution_id || '';
        this.formIsActive = !!acc.is_active;
        this.formatRupiah(acc.initial_balance || 0);
        this.openSheet = true;
    }
}" class="space-y-6">

    <!-- PAGE HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-[#0F172A] tracking-tight">Rekening & Dompet Digital</h1>
            <p class="text-[#667085] text-xs font-medium mt-1">Kelola tempat penyimpanan uang tunai, bank, dan e-wallet Anda.</p>
        </div>

        <button @click="openAdd()" class="inline-flex items-center gap-2 px-4 py-2.5 text-xs font-semibold text-white bg-[#0F172A] hover:bg-[#1E293B] rounded-xl shadow-xs transition self-start sm:self-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            <span>Tambah Rekening</span>
        </button>
    </div>

    <!-- TOTAL BALANCE PANEL (Guideline Section 18) -->
    <div class="cm-panel p-6 bg-white flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="space-y-1">
            <span class="text-[11px] font-semibold text-[#667085] uppercase tracking-wider block">Total Saldo Tergabung</span>
            <div class="text-3xl font-extrabold text-[#0F172A] financial-number tracking-tight">
                Rp {{ number_format($accounts->sum(fn($a) => $a->balance), 0, ',', '.') }}
            </div>
        </div>
        <div class="text-xs text-[#667085] font-medium bg-[#F8FAFB] px-3.5 py-2 rounded-xl border border-[#E4E7EC]">
            Tersimpan di <strong class="text-[#0F172A]">{{ $accounts->count() }}</strong> akun aktif
        </div>
    </div>

    <!-- ACCOUNTS GRID (Guideline Section 66: Max 3 Columns) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($accounts as $acc)
            <div class="cm-panel p-5 flex flex-col justify-between space-y-4 hover:border-[#0F766E]/40 transition">
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="w-10 h-10 rounded-xl bg-[#F0FDFA] text-[#0F766E] flex items-center justify-center">
                            @if($acc->type === 'cash')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            @elseif($acc->type === 'bank')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            @elseif($acc->type === 'e_wallet')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                            @else
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            @endif
                        </div>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $acc->is_active ? 'bg-[#F0FDF4] text-[#15803D] border border-[#DCFCE7]' : 'bg-[#F8FAFB] text-[#667085] border border-[#E4E7EC]' }}">
                            {{ $acc->is_active ? 'Aktif' : 'Non-Aktif' }}
                        </span>
                    </div>

                    <div>
                        <h3 class="text-base font-bold text-[#0F172A]">{{ $acc->name }}</h3>
                        <span class="text-xs text-[#667085] capitalize block mt-0.5 font-medium">
                            {{ $acc->type }} {{ $acc->institution ? '• ' . $acc->institution->name : '' }}
                        </span>
                    </div>
                </div>

                <div class="pt-4 border-t border-[#EAECF0] space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-semibold text-[#667085]">Saldo Saat Ini</span>
                        <span class="text-lg font-extrabold text-[#0F172A] financial-number">
                            Rp {{ number_format($acc->balance, 0, ',', '.') }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between text-[11px] text-[#98A2B3]">
                        <span>Saldo Awal</span>
                        <span class="financial-number">Rp {{ number_format($acc->initial_balance, 0, ',', '.') }}</span>
                    </div>

                    <div class="pt-2 flex items-center justify-end gap-1.5">
                        <button @click="openEdit({{ json_encode($acc) }})" 
                                class="p-1.5 rounded-lg text-[#667085] hover:text-[#0F172A] hover:bg-[#F8FAFB] transition" title="Edit Akun">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </button>
                        <form method="POST" action="{{ route('user.accounts.destroy', $acc->id) }}" onsubmit="return confirm('Hapus akun {{ $acc->name }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1.5 rounded-lg text-[#667085] hover:text-[#B42318] hover:bg-[#FEF3F2] transition" title="Hapus Akun">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="cm-panel p-12 lg:col-span-3 text-center space-y-3">
                <div class="w-12 h-12 rounded-2xl bg-[#F8FAFB] text-[#667085] flex items-center justify-center mx-auto">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-sm font-bold text-[#0F172A]">Belum Ada Rekening / Dompet</h3>
                <p class="text-xs text-[#667085] max-w-xs mx-auto">Tambahkan dompet tunai atau rekening bank Anda untuk mulai mencatat arus kas.</p>
                <button @click="openAdd()" class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-white bg-[#0F172A] hover:bg-[#1E293B] rounded-xl shadow-xs transition mt-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Tambah Rekening</span>
                </button>
            </div>
        @endforelse
    </div>

    <!-- SIDE SHEET / FULL-SCREEN SHEET (Guideline Section 29) -->
    <div x-show="openSheet" x-cloak class="fixed inset-0 z-50 overflow-hidden">
        <!-- Backdrop -->
        <div x-show="openSheet" x-transition.opacity @click="openSheet = false" class="fixed inset-0 bg-[#0F172A]/40 backdrop-blur-xs"></div>

        <div class="fixed inset-y-0 right-0 max-w-full flex pl-10">
            <div x-show="openSheet" x-transition:enter="transform transition ease-in-out duration-200" 
                 x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" 
                 x-transition:leave="transform transition ease-in-out duration-200" 
                 x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" 
                 class="w-screen max-w-md bg-white border-l border-[#E4E7EC] shadow-2xl flex flex-col justify-between">
                
                <!-- Sheet Header -->
                <div class="px-6 py-5 border-b border-[#EAECF0] flex items-center justify-between">
                    <div>
                        <h2 class="text-base font-bold text-[#0F172A]" x-text="isEdit ? 'Ubah Rekening' : 'Tambah Rekening Baru'"></h2>
                        <p class="text-xs text-[#667085] mt-0.5">Kelola rincian akun penyimpanan dana.</p>
                    </div>
                    <button @click="openSheet = false" class="p-1 rounded-lg text-[#667085] hover:text-[#0F172A] hover:bg-[#F8FAFB]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Sheet Form Body -->
                <form :action="isEdit ? '{{ url('/app/accounts') }}/' + editId : '{{ route('user.accounts.store') }}'" method="POST" class="p-6 space-y-5 flex-1 overflow-y-auto text-xs">
                    @csrf
                    <template x-if="isEdit">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <div>
                        <label class="block font-semibold text-[#344054] mb-1.5">Nama Akun / Rekening <span class="text-[#B42318]">*</span></label>
                        <input type="text" name="name" x-model="formName" required placeholder="Contoh: Tabungan Utama BCA, GoPay" class="w-full h-11 px-3.5 rounded-xl border border-[#D0D5DD] text-[#101828] text-sm focus:border-[#0F766E] focus:ring-3 focus:ring-[#0F766E]/10 transition">
                    </div>

                    <div>
                        <label class="block font-semibold text-[#344054] mb-1.5">Tipe Akun <span class="text-[#B42318]">*</span></label>
                        <select name="type" x-model="formType" required class="w-full h-11 px-3.5 rounded-xl border border-[#D0D5DD] text-[#101828] text-sm focus:border-[#0F766E] focus:ring-3 focus:ring-[#0F766E]/10 transition">
                            <option value="cash">Tunai (Cash)</option>
                            <option value="bank">Bank</option>
                            <option value="e_wallet">E-Wallet (Dompet Digital)</option>
                            <option value="other">Lainnya</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-semibold text-[#344054] mb-1.5">Lembaga Keuangan (Opsional)</label>
                        <select name="institution_id" x-model="formInstitutionId" class="w-full h-11 px-3.5 rounded-xl border border-[#D0D5DD] text-[#101828] text-sm focus:border-[#0F766E] focus:ring-3 focus:ring-[#0F766E]/10 transition">
                            <option value="">Pilih Lembaga Keuangan</option>
                            @foreach($institutions as $inst)
                                <option value="{{ $inst->id }}">{{ $inst->name }} ({{ strtoupper($inst->type) }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Initial Balance Currency Input (Guideline Section 36) -->
                    <div>
                        <label class="block font-semibold text-[#344054] mb-1.5">Saldo Awal <span class="text-[#B42318]">*</span></label>
                        <div class="relative">
                            <input type="text" 
                                   x-model="formattedBalance" 
                                   @input="formatRupiah($event.target.value)" 
                                   placeholder="Rp 0" 
                                   required 
                                   class="w-full h-12 px-3.5 rounded-xl border border-[#D0D5DD] text-[#0F172A] text-xl font-extrabold financial-number focus:border-[#0F766E] focus:ring-3 focus:ring-[#0F766E]/10 transition">
                        </div>
                        <input type="hidden" name="initial_balance" x-model="rawBalance">
                        <span class="text-[11px] text-[#667085] mt-1 block">Saldo awal saat pertama kali dicatat.</span>
                    </div>

                    <template x-if="isEdit">
                        <div>
                            <label class="flex items-center gap-2 font-semibold text-[#344054] cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" :checked="formIsActive" class="rounded-md border-[#D0D5DD] text-[#0F766E] focus:ring-[#0F766E]">
                                <span>Status Rekening Aktif</span>
                            </label>
                        </div>
                    </template>

                    <!-- Sheet Actions Footer -->
                    <div class="pt-6 border-t border-[#EAECF0] flex items-center justify-end gap-3">
                        <button type="button" @click="openSheet = false" class="px-4 py-2.5 text-xs font-semibold text-[#344054] bg-white border border-[#D0D5DD] hover:bg-[#F9FAFB] rounded-xl transition">Batal</button>
                        <button type="submit" class="px-5 py-2.5 text-xs font-semibold text-white bg-[#0F172A] hover:bg-[#1E293B] rounded-xl shadow-xs transition" x-text="isEdit ? 'Simpan Perubahan' : 'Simpan Rekening'"></button>
                    </div>
                </form>

            </div>
        </div>
    </div>

</div>
@endsection
