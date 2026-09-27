@extends('layouts.user')

@section('content')
<div x-data="{ activeMasterTab: '{{ request('tab', $tab ?? 'income_categories') }}' }" class="space-y-6">

    <!-- PAGE HEADER -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-[#0F172A] font-display tracking-tight">Master Data Keuangan</h1>
            <p class="text-[#64748B] text-xs md:text-sm mt-1 font-medium">Kelola referensi Kategori Income, Kategori Expenses, E-Wallet, dan Rekening Bank dengan status Aktif/Nonaktif.</p>
        </div>
    </div>

    <!-- 4 CORE TABS: Kategori Income | Kategori Expenses | Dompet Digital | Rekening Bank -->
    <div class="cm-panel p-1.5 bg-[#F1F5F9] flex flex-wrap items-center gap-2 border border-[#E2E8F0]">
        <button type="button" @click="activeMasterTab = 'income_categories'" :class="activeMasterTab === 'income_categories' ? 'bg-[#0F172A] text-white font-bold shadow-xs' : 'text-[#64748B] hover:text-[#0F172A]'" class="py-2.5 px-4 rounded-xl text-xs transition whitespace-nowrap">
            Kategori Income
        </button>
        <button type="button" @click="activeMasterTab = 'expense_categories'" :class="activeMasterTab === 'expense_categories' ? 'bg-[#0F172A] text-white font-bold shadow-xs' : 'text-[#64748B] hover:text-[#0F172A]'" class="py-2.5 px-4 rounded-xl text-xs transition whitespace-nowrap">
            Kategori Expenses
        </button>
        <button type="button" @click="activeMasterTab = 'ewallets'" :class="activeMasterTab === 'ewallets' ? 'bg-[#0F172A] text-white font-bold shadow-xs' : 'text-[#64748B] hover:text-[#0F172A]'" class="py-2.5 px-4 rounded-xl text-xs transition whitespace-nowrap">
            Dompet Digital (E-Wallet)
        </button>
        <button type="button" @click="activeMasterTab = 'banks'" :class="activeMasterTab === 'banks' ? 'bg-[#0F172A] text-white font-bold shadow-xs' : 'text-[#64748B] hover:text-[#0F172A]'" class="py-2.5 px-4 rounded-xl text-xs transition whitespace-nowrap">
            Rekening Bank & Cash
        </button>
    </div>

    <!-- TAB 1: KATEGORI INCOME -->
    <div x-show="activeMasterTab === 'income_categories'" transition:enter="transition ease-out duration-150" transition:enter-start="opacity-0" transition:enter-end="opacity-100" class="space-y-6">
        
        <!-- Add Custom Income Category Form -->
        <div class="cm-panel p-6 space-y-4">
            <h3 class="text-base font-bold text-[#0F172A] font-display">Tambah Kategori Income Baru</h3>
            <form method="POST" action="{{ route('user.categories.store') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-end">
                @csrf
                <input type="hidden" name="type" value="income">
                <div class="sm:col-span-8">
                    <label class="block text-xs font-bold text-[#344054] mb-1 uppercase tracking-wider">Nama Kategori Income</label>
                    <input type="text" name="name" placeholder="Contoh: Gaji, Bonus, Freelance, Dividen, Saldo Awal" required class="cm-input text-xs">
                </div>
                <div class="sm:col-span-4">
                    <button type="submit" class="btn-emerald w-full text-xs">Simpan Kategori Income</button>
                </div>
            </form>
        </div>

        <!-- Income Categories Table List -->
        <div class="cm-panel p-6 space-y-4">
            <h3 class="text-base font-bold text-[#0F172A] font-display">Daftar Master Kategori Income</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                @foreach($userIncomeCategories as $cat)
                    <div class="p-4 rounded-2xl border border-[#E2E8F0] bg-[#F8FAFC] flex items-center justify-between">
                        <div>
                            <span class="text-xs font-bold text-[#0F172A] block">{{ $cat->name }}</span>
                            <span class="text-[10px] text-[#059669] font-bold block mt-0.5">Custom User</span>
                        </div>
                        <form method="POST" action="{{ route('user.categories.destroy', $cat->id) }}" onsubmit="return confirm('Hapus kategori {{ $cat->name }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-[#EF4444] text-xs font-bold hover:underline">Hapus</button>
                        </form>
                    </div>
                @endforeach

                @foreach($systemIncomeCategories as $cat)
                    <div class="p-4 rounded-2xl border border-[#E2E8F0] bg-white flex items-center justify-between">
                        <div>
                            <span class="text-xs font-bold text-[#0F172A] block">{{ $cat->name }}</span>
                            <span class="text-[10px] text-[#4F46E5] font-bold block mt-0.5">Template System</span>
                        </div>
                        <form method="POST" action="{{ route('user.categories.toggle-system', $cat->id) }}">
                            @csrf
                            <button type="submit" class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $cat->user_active ? 'bg-[#ECFDF5] text-[#059669] border border-[#A7F3D0]' : 'bg-[#F1F5F9] text-[#64748B] border border-[#CBD5E1]' }}">
                                {{ $cat->user_active ? 'Status: Aktif' : 'Status: Nonaktif' }}
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- TAB 2: KATEGORI EXPENSES -->
    <div x-show="activeMasterTab === 'expense_categories'" transition:enter="transition ease-out duration-150" transition:enter-start="opacity-0" transition:enter-end="opacity-100" class="space-y-6">
        
        <!-- Add Custom Expense Category Form -->
        <div class="cm-panel p-6 space-y-4">
            <h3 class="text-base font-bold text-[#0F172A] font-display">Tambah Kategori Expenses Baru</h3>
            <form method="POST" action="{{ route('user.categories.store') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-end">
                @csrf
                <input type="hidden" name="type" value="expense">
                <div class="sm:col-span-8">
                    <label class="block text-xs font-bold text-[#344054] mb-1 uppercase tracking-wider">Nama Kategori Expense</label>
                    <input type="text" name="name" placeholder="Contoh: Makanan, Kendaraan, Tagihan, Hiburan" required class="cm-input text-xs">
                </div>
                <div class="sm:col-span-4">
                    <button type="submit" class="btn-primary w-full text-xs">Simpan Kategori Expense</button>
                </div>
            </form>
        </div>

        <!-- Expense Categories Table List -->
        <div class="cm-panel p-6 space-y-4">
            <h3 class="text-base font-bold text-[#0F172A] font-display">Daftar Master Kategori Expenses</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                @foreach($userExpenseCategories as $cat)
                    <div class="p-4 rounded-2xl border border-[#E2E8F0] bg-[#F8FAFC] flex items-center justify-between">
                        <div>
                            <span class="text-xs font-bold text-[#0F172A] block">{{ $cat->name }}</span>
                            <span class="text-[10px] text-[#059669] font-bold block mt-0.5">Custom User</span>
                        </div>
                        <form method="POST" action="{{ route('user.categories.destroy', $cat->id) }}" onsubmit="return confirm('Hapus kategori {{ $cat->name }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-[#EF4444] text-xs font-bold hover:underline">Hapus</button>
                        </form>
                    </div>
                @endforeach

                @foreach($systemExpenseCategories as $cat)
                    <div class="p-4 rounded-2xl border border-[#E2E8F0] bg-white flex items-center justify-between">
                        <div>
                            <span class="text-xs font-bold text-[#0F172A] block">{{ $cat->name }}</span>
                            <span class="text-[10px] text-[#4F46E5] font-bold block mt-0.5">Template System</span>
                        </div>
                        <form method="POST" action="{{ route('user.categories.toggle-system', $cat->id) }}">
                            @csrf
                            <button type="submit" class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $cat->user_active ? 'bg-[#ECFDF5] text-[#059669] border border-[#A7F3D0]' : 'bg-[#F1F5F9] text-[#64748B] border border-[#CBD5E1]' }}">
                                {{ $cat->user_active ? 'Status: Aktif' : 'Status: Nonaktif' }}
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- TAB 3: DOMPET DIGITAL (E-WALLET) -->
    <div x-show="activeMasterTab === 'ewallets'" transition:enter="transition ease-out duration-150" transition:enter-start="opacity-0" transition:enter-end="opacity-100" class="space-y-6">
        
        <!-- Add E-Wallet Form -->
        <div class="cm-panel p-6 space-y-4">
            <h3 class="text-base font-bold text-[#0F172A] font-display">Tambah Dompet Digital (E-Wallet)</h3>
            <form method="POST" action="{{ route('user.accounts.store') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-end">
                @csrf
                <input type="hidden" name="type" value="e_wallet">
                <div class="sm:col-span-5">
                    <label class="block text-xs font-bold text-[#344054] mb-1 uppercase tracking-wider">Nama E-Wallet</label>
                    <input type="text" name="name" placeholder="Contoh: GoPay, OVO, DANA, ShopeePay" required class="cm-input text-xs">
                </div>
                <div class="sm:col-span-4">
                    <label class="block text-xs font-bold text-[#344054] mb-1 uppercase tracking-wider">Saldo Awal (Rp)</label>
                    <input type="number" name="initial_balance" value="0" min="0" required class="cm-input text-xs financial-number">
                </div>
                <div class="sm:col-span-3">
                    <button type="submit" class="btn-emerald w-full text-xs">Simpan E-Wallet</button>
                </div>
            </form>
        </div>

        <!-- E-Wallets List -->
        <div class="cm-panel p-6 space-y-4">
            <h3 class="text-base font-bold text-[#0F172A] font-display">Daftar Dompet Digital Aktif</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                @forelse($ewalletAccounts as $acc)
                    <div class="p-4 rounded-2xl border border-[#E2E8F0] bg-[#F8FAFC] flex items-center justify-between">
                        <div>
                            <span class="text-xs font-bold text-[#0F172A] block">{{ $acc->name }}</span>
                            <span class="text-xs font-bold text-[#10B981] financial-number block mt-0.5">Rp {{ number_format($acc->balance, 0, ',', '.') }}</span>
                        </div>
                        <form method="POST" action="{{ route('user.accounts.destroy', $acc->id) }}" onsubmit="return confirm('Hapus e-wallet {{ $acc->name }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-[#EF4444] text-xs font-bold hover:underline">Hapus</button>
                        </form>
                    </div>
                @empty
                    <div class="col-span-full py-8 text-center text-xs text-[#64748B]">
                        Belum ada dompet digital terdaftar.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- TAB 4: REKENING BANK & CASH -->
    <div x-show="activeMasterTab === 'banks'" transition:enter="transition ease-out duration-150" transition:enter-start="opacity-0" transition:enter-end="opacity-100" class="space-y-6">
        
        <!-- Add Bank / Cash Account Form -->
        <div class="cm-panel p-6 space-y-4">
            <h3 class="text-base font-bold text-[#0F172A] font-display">Tambah Rekening Bank / Kas / Tabungan</h3>
            <form method="POST" action="{{ route('user.accounts.store') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-end">
                @csrf
                <div class="sm:col-span-4">
                    <label class="block text-xs font-bold text-[#344054] mb-1 uppercase tracking-wider">Nama Rekening / Akun</label>
                    <input type="text" name="name" placeholder="Contoh: BCA Utama, Mandiri Tabungan, Cash" required class="cm-input text-xs">
                </div>
                <div class="sm:col-span-3">
                    <label class="block text-xs font-bold text-[#344054] mb-1 uppercase tracking-wider">Jenis Media</label>
                    <select name="type" required class="cm-input text-xs">
                        <option value="bank">Rekening Bank</option>
                        <option value="cash">Cash / Kas Tunai</option>
                        <option value="other">Lainnya / Investasi</option>
                    </select>
                </div>
                <div class="sm:col-span-3">
                    <label class="block text-xs font-bold text-[#344054] mb-1 uppercase tracking-wider">Saldo Awal (Rp)</label>
                    <input type="number" name="initial_balance" value="0" min="0" required class="cm-input text-xs financial-number">
                </div>
                <div class="sm:col-span-2">
                    <button type="submit" class="btn-primary w-full text-xs">Simpan</button>
                </div>
            </form>
        </div>

        <!-- Bank & Cash Accounts List -->
        <div class="cm-panel p-6 space-y-4">
            <h3 class="text-base font-bold text-[#0F172A] font-display">Daftar Rekening Bank & Kas Tunai</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                @foreach($cashAccounts->concat($bankAccounts) as $acc)
                    <div class="p-4 rounded-2xl border border-[#E2E8F0] bg-[#F8FAFC] flex items-center justify-between">
                        <div>
                            <span class="text-xs font-bold text-[#0F172A] block">{{ $acc->name }}</span>
                            <span class="text-[10px] text-[#64748B] uppercase font-bold block">{{ strtoupper($acc->type) }}</span>
                            <span class="text-xs font-bold text-[#4F46E5] financial-number block mt-1">Rp {{ number_format($acc->balance, 0, ',', '.') }}</span>
                        </div>
                        <form method="POST" action="{{ route('user.accounts.destroy', $acc->id) }}" onsubmit="return confirm('Hapus akun {{ $acc->name }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-[#EF4444] text-xs font-bold hover:underline">Hapus</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</div>
@endsection
