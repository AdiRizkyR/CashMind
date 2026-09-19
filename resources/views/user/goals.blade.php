@extends('layouts.user')

@section('content')
<div x-data="{ 
    openGoalSheet: false, 
    openContribSheet: false, 
    activeGoal: {},
    rawTargetAmount: '',
    formattedTargetAmount: '',
    rawContribAmount: '',
    formattedContribAmount: '',
    formatTargetRupiah(val) {
        let digits = String(val).replace(/[^0-9]/g, '');
        this.rawTargetAmount = digits;
        this.formattedTargetAmount = digits ? 'Rp ' + Number(digits).toLocaleString('id-ID') : '';
    },
    formatContribRupiah(val) {
        let digits = String(val).replace(/[^0-9]/g, '');
        this.rawContribAmount = digits;
        this.formattedContribAmount = digits ? 'Rp ' + Number(digits).toLocaleString('id-ID') : '';
    }
}" class="space-y-6">

    <!-- PAGE HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-[#0F172A] tracking-tight">Target Keuangan (Financial Goals)</h1>
            <p class="text-[#667085] text-xs font-medium mt-1">Rencanakan dan pantau pencapaian tabungan jangka panjang Anda secara terarah.</p>
        </div>

        <button @click="openGoalSheet = true" class="inline-flex items-center gap-2 px-4 py-2.5 text-xs font-semibold text-white bg-[#0F172A] hover:bg-[#1E293B] rounded-xl shadow-xs transition self-start sm:self-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            <span>Buat Target Baru</span>
        </button>
    </div>

    <!-- GOALS CARDS GRID (Guideline Section 69) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($goals as $g)
            @php
                $current = $g->current_amount;
                $target = $g->target_amount;
                $pct = $g->percentage;
                $remaining = $g->remaining_amount;
            @endphp
            <div class="cm-panel p-5 space-y-4 flex flex-col justify-between hover:border-[#0F766E]/40 transition">
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="w-10 h-10 rounded-xl bg-[#F0FDFA] text-[#0F766E] flex items-center justify-center font-bold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider border {{ $g->status === 'completed' ? 'bg-[#F0FDF4] text-[#15803D] border-[#DCFCE7]' : 'bg-[#F8FAFB] text-[#0F766E] border-[#99F6E4]' }}">
                            {{ $g->status === 'completed' ? 'Selesai' : 'Berjalan' }}
                        </span>
                    </div>

                    <div>
                        <h3 class="text-base font-bold text-[#0F172A]">{{ $g->name }}</h3>
                        <span class="text-xs text-[#667085] font-medium block mt-0.5">
                            Target: {{ $g->target_date ? $g->target_date->format('M Y') : 'Tanpa batas waktu' }}
                        </span>
                    </div>
                </div>

                <div class="space-y-3 pt-2">
                    <!-- Progress Bar -->
                    <div class="space-y-1.5">
                        <div class="flex justify-between text-xs font-semibold">
                            <span class="text-[#0F172A] financial-number">Rp {{ number_format($current, 0, ',', '.') }}</span>
                            <span class="text-[#667085] financial-number">Target Rp {{ number_format($target, 0, ',', '.') }}</span>
                        </div>
                        <div class="w-full h-2 bg-[#EAECF0] rounded-full overflow-hidden">
                            <div class="h-full bg-[#0F766E] rounded-full transition-all duration-300" style="width: {{ min(100, $pct) }}%"></div>
                        </div>
                        <div class="flex justify-between items-center text-[10px] font-semibold text-[#667085]">
                            <span>{{ $pct }}% Terkumpul</span>
                            <span class="financial-number">Sisa: Rp {{ number_format($remaining, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="pt-3 border-t border-[#EAECF0] flex items-center justify-between">
                        <button @click="activeGoal = { id: '{{ $g->id }}', name: '{{ $g->name }}' }; openContribSheet = true" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-[#0F172A] hover:bg-[#1E293B] rounded-xl shadow-xs transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            <span>Tambah Setoran</span>
                        </button>

                        <form method="POST" action="{{ route('user.goals.destroy', $g->id) }}" onsubmit="return confirm('Hapus target {{ $g->name }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1.5 rounded-lg text-[#667085] hover:text-[#B42318] hover:bg-[#FEF3F2] transition" title="Hapus Target">
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="text-sm font-bold text-[#0F172A]">Belum Ada Target Keuangan</h3>
                <p class="text-xs text-[#667085] max-w-xs mx-auto">Buat target tabungan seperti Dana Darurat, DP Rumah, atau Gadget Impian.</p>
                <button @click="openGoalSheet = true" class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-white bg-[#0F172A] hover:bg-[#1E293B] rounded-xl shadow-xs transition mt-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Buat Target Baru</span>
                </button>
            </div>
        @endforelse
    </div>

    <!-- SIDE SHEET CREATE GOAL -->
    <div x-show="openGoalSheet" x-cloak class="fixed inset-0 z-50 overflow-hidden">
        <div x-show="openGoalSheet" x-transition.opacity @click="openGoalSheet = false" class="fixed inset-0 bg-[#0F172A]/40 backdrop-blur-xs"></div>

        <div class="fixed inset-y-0 right-0 max-w-full flex pl-10">
            <div x-show="openGoalSheet" x-transition:enter="transform transition ease-in-out duration-200" 
                 x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" 
                 x-transition:leave="transform transition ease-in-out duration-200" 
                 x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" 
                 class="w-screen max-w-md bg-white border-l border-[#E4E7EC] shadow-2xl flex flex-col justify-between">
                
                <div class="px-6 py-5 border-b border-[#EAECF0] flex items-center justify-between">
                    <div>
                        <h2 class="text-base font-bold text-[#0F172A]">Buat Target Keuangan Baru</h2>
                        <p class="text-xs text-[#667085] mt-0.5">Tetapkan nama dan nominal impian tabungan Anda.</p>
                    </div>
                    <button @click="openGoalSheet = false" class="p-1 rounded-lg text-[#667085] hover:text-[#0F172A] hover:bg-[#F8FAFB]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form method="POST" action="{{ route('user.goals.store') }}" class="p-6 space-y-5 flex-1 overflow-y-auto text-xs">
                    @csrf
                    <div>
                        <label class="block font-semibold text-[#344054] mb-1.5">Nama Target <span class="text-[#B42318]">*</span></label>
                        <input type="text" name="name" placeholder="Contoh: MacBook Pro, Dana Darurat 6 Bulan" required class="w-full h-11 px-3.5 rounded-xl border border-[#D0D5DD] text-[#101828] text-sm focus:border-[#0F766E] focus:ring-3 focus:ring-[#0F766E]/10 transition">
                    </div>

                    <!-- Target Amount Currency Input (Guideline Section 36) -->
                    <div>
                        <label class="block font-semibold text-[#344054] mb-1.5">Target Nominal <span class="text-[#B42318]">*</span></label>
                        <div class="relative">
                            <input type="text" 
                                   x-model="formattedTargetAmount" 
                                   @input="formatTargetRupiah($event.target.value)" 
                                   placeholder="Rp 0" 
                                   required 
                                   class="w-full h-12 px-3.5 rounded-xl border border-[#D0D5DD] text-[#0F172A] text-xl font-extrabold financial-number focus:border-[#0F766E] focus:ring-3 focus:ring-[#0F766E]/10 transition">
                        </div>
                        <input type="hidden" name="target_amount" x-model="rawTargetAmount">
                    </div>

                    <div>
                        <label class="block font-semibold text-[#344054] mb-1.5">Target Tanggal Pencapaian (Opsional)</label>
                        <input type="date" name="target_date" class="w-full h-11 px-3.5 rounded-xl border border-[#D0D5DD] text-[#101828] text-sm focus:border-[#0F766E] focus:ring-3 focus:ring-[#0F766E]/10 transition">
                    </div>

                    <div class="pt-6 border-t border-[#EAECF0] flex items-center justify-end gap-3">
                        <button type="button" @click="openGoalSheet = false" class="px-4 py-2.5 text-xs font-semibold text-[#344054] bg-white border border-[#D0D5DD] hover:bg-[#F9FAFB] rounded-xl transition">Batal</button>
                        <button type="submit" class="px-5 py-2.5 text-xs font-semibold text-white bg-[#0F172A] hover:bg-[#1E293B] rounded-xl shadow-xs transition">Simpan Target</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- SIDE SHEET CONTRIBUTE TO GOAL -->
    <div x-show="openContribSheet" x-cloak class="fixed inset-0 z-50 overflow-hidden">
        <div x-show="openContribSheet" x-transition.opacity @click="openContribSheet = false" class="fixed inset-0 bg-[#0F172A]/40 backdrop-blur-xs"></div>

        <div class="fixed inset-y-0 right-0 max-w-full flex pl-10">
            <div x-show="openContribSheet" x-transition:enter="transform transition ease-in-out duration-200" 
                 x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" 
                 x-transition:leave="transform transition ease-in-out duration-200" 
                 x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" 
                 class="w-screen max-w-md bg-white border-l border-[#E4E7EC] shadow-2xl flex flex-col justify-between">
                
                <div class="px-6 py-5 border-b border-[#EAECF0] flex items-center justify-between">
                    <div>
                        <h2 class="text-base font-bold text-[#0F172A]">Setor Tabungan Target</h2>
                        <p class="text-xs text-[#667085] mt-0.5" x-text="'Target: ' + activeGoal.name"></p>
                    </div>
                    <button @click="openContribSheet = false" class="p-1 rounded-lg text-[#667085] hover:text-[#0F172A] hover:bg-[#F8FAFB]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form :action="'{{ url('/app/goals') }}/' + activeGoal.id + '/contribute'" method="POST" class="p-6 space-y-5 flex-1 overflow-y-auto text-xs">
                    @csrf
                    <div>
                        <label class="block font-semibold text-[#344054] mb-1.5">Nominal Setoran <span class="text-[#B42318]">*</span></label>
                        <div class="relative">
                            <input type="text" 
                                   x-model="formattedContribAmount" 
                                   @input="formatContribRupiah($event.target.value)" 
                                   placeholder="Rp 0" 
                                   required 
                                   class="w-full h-12 px-3.5 rounded-xl border border-[#D0D5DD] text-[#0F172A] text-xl font-extrabold financial-number focus:border-[#0F766E] focus:ring-3 focus:ring-[#0F766E]/10 transition">
                        </div>
                        <input type="hidden" name="amount" x-model="rawContribAmount">
                    </div>

                    <div>
                        <label class="block font-semibold text-[#344054] mb-1.5">Tanggal Setoran <span class="text-[#B42318]">*</span></label>
                        <input type="date" name="contribution_date" value="{{ date('Y-m-d') }}" required class="w-full h-11 px-3.5 rounded-xl border border-[#D0D5DD] text-[#101828] text-sm focus:border-[#0F766E] focus:ring-3 focus:ring-[#0F766E]/10 transition">
                    </div>

                    <div>
                        <label class="block font-semibold text-[#344054] mb-1.5">Catatan / Sumber Dana</label>
                        <input type="text" name="note" placeholder="Contoh: Tabungan gaji bulan September" class="w-full h-11 px-3.5 rounded-xl border border-[#D0D5DD] text-[#101828] text-sm focus:border-[#0F766E] focus:ring-3 focus:ring-[#0F766E]/10 transition">
                    </div>

                    <div class="pt-6 border-t border-[#EAECF0] flex items-center justify-end gap-3">
                        <button type="button" @click="openContribSheet = false" class="px-4 py-2.5 text-xs font-semibold text-[#344054] bg-white border border-[#D0D5DD] hover:bg-[#F9FAFB] rounded-xl transition">Batal</button>
                        <button type="submit" class="px-5 py-2.5 text-xs font-semibold text-white bg-[#0F172A] hover:bg-[#1E293B] rounded-xl shadow-xs transition">Simpan Setoran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
