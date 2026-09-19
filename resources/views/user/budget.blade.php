@extends('layouts.user')

@section('content')
<div x-data="{ 
    openSheet: false,
    rawAmount: '',
    formattedAmount: '',
    formatRupiah(val) {
        let digits = String(val).replace(/[^0-9]/g, '');
        this.rawAmount = digits;
        this.formattedAmount = digits ? 'Rp ' + Number(digits).toLocaleString('id-ID') : '';
    }
}" class="space-y-6">

    <!-- PAGE HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-[#0F172A] tracking-tight">Perencanaan Anggaran (Budget)</h1>
            <p class="text-[#667085] text-xs font-medium mt-1">Batasi batas maksimal pengeluaran kategori untuk kesehatan finansial.</p>
        </div>

        <div class="flex items-center gap-3">
            <form method="GET" action="{{ route('user.budget.index') }}" class="flex items-center gap-2">
                <select name="month" onchange="this.form.submit()" class="h-10 px-3 rounded-xl border border-[#D0D5DD] text-[#101828] text-xs font-semibold focus:border-[#0F766E] focus:ring-2 focus:ring-[#0F766E]/10 transition">
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create(null, $m, 1)->translatedFormat('F') }}
                        </option>
                    @endfor
                </select>
                <select name="year" onchange="this.form.submit()" class="h-10 px-3 rounded-xl border border-[#D0D5DD] text-[#101828] text-xs font-semibold focus:border-[#0F766E] focus:ring-2 focus:ring-[#0F766E]/10 transition">
                    @for($y = 2024; $y <= 2028; $y++)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </form>

            <button @click="openSheet = true" class="inline-flex items-center gap-2 px-4 py-2.5 text-xs font-semibold text-white bg-[#0F172A] hover:bg-[#1E293B] rounded-xl shadow-xs transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Set Budget</span>
            </button>
        </div>
    </div>

    <!-- BUDGET LIST GRID (Guideline Section 68) -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        @forelse($budgets as $b)
            @php
                $spent = $b->spent;
                $target = $b->amount;
                $percentage = $b->percentage;
                $status = $b->status;
                $statusLabel = $status === 'Safe' ? 'Aman' : ($status === 'Warning' ? 'Peringatan' : 'Melebihi Limit');
            @endphp
            <div class="cm-panel p-5 space-y-4 hover:border-[#0F766E]/40 transition">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-[#F0FDFA] text-[#0F766E] flex items-center justify-center font-bold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-[#0F172A]">{{ $b->category?->name }}</h3>
                            <span class="text-xs text-[#667085] font-medium">Periode {{ \Carbon\Carbon::create(null, $b->period_month, 1)->translatedFormat('F') }} {{ $b->period_year }}</span>
                        </div>
                    </div>

                    <!-- Status Badge -->
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider border {{ $status === 'Safe' ? 'bg-[#F0FDF4] text-[#15803D] border-[#DCFCE7]' : ($status === 'Warning' ? 'bg-[#FFFAEB] text-[#B54708] border-[#FEF08A]' : 'bg-[#FEF3F2] text-[#B42318] border-[#FEE4E2]') }}">
                        {{ $statusLabel }}
                    </span>
                </div>

                <!-- Amounts Display -->
                <div class="flex items-center justify-between text-xs font-semibold">
                    <span class="text-[#667085]">Terpakai: <strong class="text-[#0F172A] financial-number">Rp {{ number_format($spent, 0, ',', '.') }}</strong></span>
                    <span class="text-[#667085]">Batas: <strong class="text-[#0F172A] financial-number">Rp {{ number_format($target, 0, ',', '.') }}</strong></span>
                </div>

                <!-- Progress Bar -->
                <div class="space-y-1.5">
                    <div class="w-full h-2 bg-[#EAECF0] rounded-full overflow-hidden">
                        <div class="h-full rounded-full transition-all duration-300 {{ $status === 'Safe' ? 'bg-[#15803D]' : ($status === 'Warning' ? 'bg-[#B54708]' : 'bg-[#B42318]') }}" style="width: {{ min(100, $percentage) }}%"></div>
                    </div>
                    <div class="flex justify-between items-center text-[10px] font-semibold text-[#667085]">
                        <span>{{ $percentage }}% Terpakai</span>
                        <span class="financial-number">Sisa: Rp {{ number_format(max(0, $target - $spent), 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Actions -->
                <div class="pt-3 border-t border-[#EAECF0] flex justify-end">
                    <form method="POST" action="{{ route('user.budget.destroy', $b->id) }}" onsubmit="return confirm('Hapus budget kategori {{ $b->category?->name }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center gap-1.5 text-xs text-[#667085] hover:text-[#B42318] font-semibold transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            <span>Hapus Budget</span>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="cm-panel p-12 md:col-span-2 text-center space-y-3">
                <div class="w-12 h-12 rounded-2xl bg-[#F8FAFB] text-[#667085] flex items-center justify-center mx-auto">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                    </svg>
                </div>
                <h3 class="text-sm font-bold text-[#0F172A]">Belum Ada Budget Ditentukan</h3>
                <p class="text-xs text-[#667085] max-w-xs mx-auto">Tetapkan alokasi batas pengeluaran untuk periode {{ \Carbon\Carbon::create(null, $month, 1)->translatedFormat('F') }} {{ $year }}.</p>
                <button @click="openSheet = true" class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-white bg-[#0F172A] hover:bg-[#1E293B] rounded-xl shadow-xs transition mt-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Set Budget Kategori</span>
                </button>
            </div>
        @endforelse
    </div>

    <!-- SIDE SHEET (Guideline Section 29) -->
    <div x-show="openSheet" x-cloak class="fixed inset-0 z-50 overflow-hidden">
        <div x-show="openSheet" x-transition.opacity @click="openSheet = false" class="fixed inset-0 bg-[#0F172A]/40 backdrop-blur-xs"></div>

        <div class="fixed inset-y-0 right-0 max-w-full flex pl-10">
            <div x-show="openSheet" x-transition:enter="transform transition ease-in-out duration-200" 
                 x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" 
                 x-transition:leave="transform transition ease-in-out duration-200" 
                 x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" 
                 class="w-screen max-w-md bg-white border-l border-[#E4E7EC] shadow-2xl flex flex-col justify-between">
                
                <div class="px-6 py-5 border-b border-[#EAECF0] flex items-center justify-between">
                    <div>
                        <h2 class="text-base font-bold text-[#0F172A]">Set Budget Kategori</h2>
                        <p class="text-xs text-[#667085] mt-0.5">Atur limit maksimal pengeluaran bulanan.</p>
                    </div>
                    <button @click="openSheet = false" class="p-1 rounded-lg text-[#667085] hover:text-[#0F172A] hover:bg-[#F8FAFB]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form method="POST" action="{{ route('user.budget.store') }}" class="p-6 space-y-5 flex-1 overflow-y-auto text-xs">
                    @csrf
                    <div>
                        <label class="block font-semibold text-[#344054] mb-1.5">Kategori Pengeluaran <span class="text-[#B42318]">*</span></label>
                        <select name="category_id" required class="w-full h-11 px-3.5 rounded-xl border border-[#D0D5DD] text-[#101828] text-sm focus:border-[#0F766E] focus:ring-3 focus:ring-[#0F766E]/10 transition">
                            @foreach($expenseCategories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block font-semibold text-[#344054] mb-1.5">Bulan <span class="text-[#B42318]">*</span></label>
                            <select name="period_month" required class="w-full h-11 px-3.5 rounded-xl border border-[#D0D5DD] text-[#101828] text-sm focus:border-[#0F766E] focus:ring-3 focus:ring-[#0F766E]/10 transition">
                                @for($m = 1; $m <= 12; $m++)
                                    <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create(null, $m, 1)->translatedFormat('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label class="block font-semibold text-[#344054] mb-1.5">Tahun <span class="text-[#B42318]">*</span></label>
                            <select name="period_year" required class="w-full h-11 px-3.5 rounded-xl border border-[#D0D5DD] text-[#101828] text-sm focus:border-[#0F766E] focus:ring-3 focus:ring-[#0F766E]/10 transition">
                                @for($y = 2024; $y <= 2028; $y++)
                                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <!-- Amount Input with Rp Masking (Guideline Section 36) -->
                    <div>
                        <label class="block font-semibold text-[#344054] mb-1.5">Batas Maksimal Anggaran <span class="text-[#B42318]">*</span></label>
                        <div class="relative">
                            <input type="text" 
                                   x-model="formattedAmount" 
                                   @input="formatRupiah($event.target.value)" 
                                   placeholder="Rp 0" 
                                   required 
                                   class="w-full h-12 px-3.5 rounded-xl border border-[#D0D5DD] text-[#0F172A] text-xl font-extrabold financial-number focus:border-[#0F766E] focus:ring-3 focus:ring-[#0F766E]/10 transition">
                        </div>
                        <input type="hidden" name="amount" x-model="rawAmount">
                    </div>

                    <div class="pt-6 border-t border-[#EAECF0] flex items-center justify-end gap-3">
                        <button type="button" @click="openSheet = false" class="px-4 py-2.5 text-xs font-semibold text-[#344054] bg-white border border-[#D0D5DD] hover:bg-[#F9FAFB] rounded-xl transition">Batal</button>
                        <button type="submit" class="px-5 py-2.5 text-xs font-semibold text-white bg-[#0F172A] hover:bg-[#1E293B] rounded-xl shadow-xs transition">Simpan Budget</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
