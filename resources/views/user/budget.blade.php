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
}" class="space-y-8">

    <!-- PAGE HEADER -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-[#E2E8F0] pb-6">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#ECFDF5] text-[#059669] border border-[#A7F3D0] text-xs font-bold mb-2">
                <span class="w-2 h-2 rounded-full bg-[#059669]"></span>
                <span>Smart ML Budget Allocation Advisor</span>
            </div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-[#0F172A] font-display tracking-tight">Perencanaan Anggaran (Budget)</h1>
            <p class="text-[#64748B] text-xs md:text-sm mt-1 font-medium">Kelola batas pengeluaran kategori dan manfaatkan analisis Machine Learning berbasis profil finansial Anda.</p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <form method="GET" action="{{ route('user.budget.index') }}" class="flex items-center gap-2">
                <select name="month" onchange="this.form.submit()" class="cm-input h-10 text-xs font-bold w-auto border-[#CBD5E1]">
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create(null, $m, 1)->translatedFormat('F') }}
                        </option>
                    @endfor
                </select>
                <select name="year" onchange="this.form.submit()" class="cm-input h-10 text-xs font-bold w-auto border-[#CBD5E1]">
                    @for($y = 2024; $y <= 2028; $y++)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </form>

            <button @click="openSheet = true" class="btn-primary text-xs shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Set Budget Manual</span>
            </button>
        </div>
    </div>

    <!-- 1. SMART MACHINE LEARNING BUDGET ADVISOR PANEL -->
    <div class="cm-panel p-6 md:p-8 space-y-6 bg-gradient-to-br from-[#0B132B] via-[#0F172A] to-[#1C2541] text-white border-[#1C2541] shadow-cm-dark-glow relative overflow-hidden">
        <div class="absolute -top-16 -right-16 w-64 h-64 rounded-full bg-[#059669]/20 blur-3xl pointer-events-none"></div>

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 border-b border-slate-800 pb-6 relative z-10">
            <div class="space-y-2">
                <div class="flex items-center gap-2">
                    <span class="px-3 py-1 rounded-full bg-[#059669]/20 text-[#34D399] border border-[#059669]/40 text-xs font-bold uppercase tracking-wider">
                        Hasil Analisis Machine Learning
                    </span>
                    <span class="text-xs text-slate-300 font-medium">Jadwal: {{ $mlRecommendation['schedule_label'] }}</span>
                </div>
                <h2 class="text-xl md:text-2xl font-bold font-display text-white">Rekomendasi Alokasi Anggaran Cerdas</h2>
                <p class="text-xs text-slate-300 font-medium max-w-2xl">
                    Dihitung berdasarkan estimasi pendapatan bersih Rp {{ number_format($mlRecommendation['monthly_income'], 0, ',', '.') }}, formula 50/30/20, {{ $mlRecommendation['dependents_count'] }} tanggungan keluarga, dan tren transaksi 60 hari terakhir.
                </p>
            </div>

            <!-- Health Score & Profile Settings Link -->
            <div class="flex items-center gap-4 bg-white/5 p-4 rounded-2xl border border-white/10 shrink-0">
                <div class="text-center">
                    <span class="text-[10px] font-bold uppercase text-slate-400 block">Financial Health Score</span>
                    <span class="text-3xl font-extrabold font-display text-[#34D399] financial-number">{{ $mlRecommendation['health_score'] }}/100</span>
                </div>
                <a href="{{ route('user.profile.index') }}" class="px-3.5 py-2 rounded-xl bg-white/10 hover:bg-white/20 border border-white/10 text-xs font-bold text-white transition text-center" title="Atur Jadwal & Profil ML">
                    Atur Profil & ML
                </a>
            </div>
        </div>

        <!-- ML Recommendations Grid -->
        <div class="space-y-4 relative z-10">
            <div class="flex items-center justify-between">
                <h3 class="text-xs font-bold uppercase tracking-wider text-[#A7F3D0]">Saran Alokasi Per Kategori (Bulan {{ \Carbon\Carbon::create(null, $month, 1)->translatedFormat('F') }} {{ $year }})</h3>
                <form method="POST" action="{{ route('user.budget.apply-ai') }}">
                    @csrf
                    <input type="hidden" name="period_month" value="{{ $month }}">
                    <input type="hidden" name="period_year" value="{{ $year }}">
                    <button type="submit" class="btn-emerald text-xs shadow-lg shadow-[#059669]/30">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        <span>Terapkan Semua Rekomendasi ML</span>
                    </button>
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($mlRecommendation['recommendations'] as $rec)
                    <div class="p-4 rounded-2xl bg-[#090D16] border border-[#1C2541] space-y-2 hover:border-[#059669]/50 transition">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-white font-display">{{ $rec['category_name'] }}</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ str_contains($rec['type_group'], 'Needs') ? 'bg-[#059669]/20 text-[#34D399] border border-[#059669]/40' : 'bg-slate-800 text-slate-300' }}">
                                {{ $rec['percentage'] }}% gaji
                            </span>
                        </div>

                        <div class="text-lg font-bold text-[#34D399] financial-number font-display">
                            Rp {{ number_format($rec['recommended_amount'], 0, ',', '.') }}
                        </div>

                        <p class="text-[11px] text-slate-400 font-medium leading-normal">
                            {{ $rec['reason'] }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- 2. EXISTING ACTIVE BUDGET LIST GRID -->
    <div class="space-y-4">
        <h2 class="text-lg font-bold text-[#0F172A] font-display">Daftar Anggaran Aktif Periode {{ \Carbon\Carbon::create(null, $month, 1)->translatedFormat('F') }} {{ $year }}</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            @forelse($budgets as $b)
                @php
                    $spent = $b->spent;
                    $target = $b->amount;
                    $percentage = $b->percentage;
                    $status = $b->status;
                    $statusLabel = $status === 'Safe' ? 'Aman' : ($status === 'Warning' ? 'Peringatan' : 'Melebihi Limit');
                @endphp
                <div class="cm-panel p-5 space-y-4 hover:border-[#059669]/40 transition">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-[#ECFDF5] text-[#059669] border border-[#A7F3D0] flex items-center justify-center font-bold">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-[#0F172A] font-display">{{ $b->category?->name }}</h3>
                                <span class="text-xs text-[#64748B] font-medium">Periode {{ \Carbon\Carbon::create(null, $b->period_month, 1)->translatedFormat('F') }} {{ $b->period_year }}</span>
                            </div>
                        </div>

                        <!-- Status Badge -->
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider border {{ $status === 'Safe' ? 'bg-[#ECFDF5] text-[#059669] border-[#A7F3D0]' : ($status === 'Warning' ? 'bg-[#FEF3C7] text-[#D97706] border-[#FDE68A]' : 'bg-[#FFF1F2] text-[#E11D48] border-[#FECDD3]') }}">
                            {{ $statusLabel }}
                        </span>
                    </div>

                    <!-- Amounts Display -->
                    <div class="flex items-center justify-between text-xs font-semibold">
                        <span class="text-[#64748B]">Terpakai: <strong class="text-[#0F172A] financial-number">Rp {{ number_format($spent, 0, ',', '.') }}</strong></span>
                        <span class="text-[#64748B]">Batas: <strong class="text-[#0F172A] financial-number">Rp {{ number_format($target, 0, ',', '.') }}</strong></span>
                    </div>

                    <!-- Progress Bar -->
                    <div class="space-y-1.5">
                        <div class="w-full h-2 bg-[#E2E8F0] rounded-full overflow-hidden">
                            <div class="h-full rounded-full transition-all duration-300 {{ $status === 'Safe' ? 'bg-[#059669]' : ($status === 'Warning' ? 'bg-[#D97706]' : 'bg-[#E11D48]') }}" style="width: {{ min(100, $percentage) }}%"></div>
                        </div>
                        <div class="flex justify-between items-center text-[10px] font-semibold text-[#64748B]">
                            <span>{{ $percentage }}% Terpakai</span>
                            <span class="financial-number">Sisa: Rp {{ number_format(max(0, $target - $spent), 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="pt-3 border-t border-[#E2E8F0] flex justify-end">
                        <form method="POST" action="{{ route('user.budget.destroy', $b->id) }}" onsubmit="return confirm('Hapus budget kategori {{ $b->category?->name }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center gap-1.5 text-xs text-[#64748B] hover:text-[#E11D48] font-bold transition">
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
                    <div class="w-12 h-12 rounded-2xl bg-[#F8FAFC] text-[#64748B] flex items-center justify-center mx-auto">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                        </svg>
                    </div>
                    <h3 class="text-sm font-bold text-[#0F172A] font-display">Belum Ada Budget Ditentukan</h3>
                    <p class="text-xs text-[#64748B] max-w-xs mx-auto">Klik tombol <strong>Terapkan Semua Rekomendasi ML</strong> di atas atau set budget kategori secara manual.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- SIDE SHEET -->
    <div x-show="openSheet" x-cloak class="fixed inset-0 z-50 overflow-hidden">
        <div x-show="openSheet" x-transition.opacity @click="openSheet = false" class="fixed inset-0 bg-[#090D16]/60 backdrop-blur-xs"></div>

        <div class="fixed inset-y-0 right-0 max-w-full flex pl-10">
            <div x-show="openSheet" x-transition:enter="transform transition ease-in-out duration-200" 
                 x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" 
                 x-transition:leave="transform transition ease-in-out duration-200" 
                 x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" 
                 class="w-screen max-w-md bg-white border-l border-[#E2E8F0] shadow-2xl flex flex-col justify-between">
                
                <div class="px-6 py-5 bg-[#0B132B] text-white flex items-center justify-between">
                    <div>
                        <h2 class="text-base font-bold font-display">Set Budget Manual</h2>
                        <p class="text-xs text-slate-300 mt-0.5">Atur limit maksimal pengeluaran bulanan.</p>
                    </div>
                    <button @click="openSheet = false" class="p-1 rounded-lg text-slate-400 hover:text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form method="POST" action="{{ route('user.budget.store') }}" class="p-6 space-y-5 flex-1 overflow-y-auto text-xs">
                    @csrf
                    <div>
                        <label class="block font-bold text-[#344054] mb-1.5 uppercase tracking-wider">Kategori Pengeluaran <span class="text-[#E11D48]">*</span></label>
                        <select name="category_id" required class="cm-input">
                            @foreach($expenseCategories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block font-bold text-[#344054] mb-1.5 uppercase tracking-wider">Bulan <span class="text-[#E11D48]">*</span></label>
                            <select name="period_month" required class="cm-input">
                                @for($m = 1; $m <= 12; $m++)
                                    <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create(null, $m, 1)->translatedFormat('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label class="block font-bold text-[#344054] mb-1.5 uppercase tracking-wider">Tahun <span class="text-[#E11D48]">*</span></label>
                            <select name="period_year" required class="cm-input">
                                @for($y = 2024; $y <= 2028; $y++)
                                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <!-- Amount Input with Rp Masking -->
                    <div>
                        <label class="block font-bold text-[#344054] mb-1.5 uppercase tracking-wider">Batas Maksimal Anggaran <span class="text-[#E11D48]">*</span></label>
                        <div class="relative">
                            <input type="text" 
                                   x-model="formattedAmount" 
                                   @input="formatRupiah($event.target.value)" 
                                   placeholder="Rp 0" 
                                   required 
                                   class="cm-input text-xl font-extrabold text-[#0F172A] financial-number">
                        </div>
                        <input type="hidden" name="amount" x-model="rawAmount">
                    </div>

                    <div class="pt-6 border-t border-[#E2E8F0] flex items-center justify-end gap-3">
                        <button type="button" @click="openSheet = false" class="btn-secondary">Batal</button>
                        <button type="submit" class="btn-emerald">Simpan Budget</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
