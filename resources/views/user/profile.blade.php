@extends('layouts.user')

@section('content')
<div x-data="{
    rawIncome: '{{ (int) $profile->monthly_income }}',
    formattedIncome: 'Rp {{ number_format($profile->monthly_income, 0, ',', '.') }}',
    formatRupiah(val) {
        let digits = String(val).replace(/[^0-9]/g, '');
        this.rawIncome = digits;
        this.formattedIncome = digits ? 'Rp ' + Number(digits).toLocaleString('id-ID') : 'Rp 0';
    }
}" class="space-y-8">

    <!-- PAGE HEADER -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-[#E2E8F0] pb-6">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#ECFDF5] text-[#059669] border border-[#A7F3D0] text-xs font-bold mb-2">
                <span class="w-2 h-2 rounded-full bg-[#059669]"></span>
                <span>Machine Learning Financial Data Engine</span>
            </div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-[#0F172A] font-display tracking-tight">Profil Finansial & Pengaturan ML</h1>
            <p class="text-[#64748B] text-xs md:text-sm mt-1 font-medium">Lengkapi data diri & jadwal rekomendasi alokasi anggaran otomatis berbasis kecerdasan buatan.</p>
        </div>

        <button type="submit" form="profileForm" class="btn-emerald self-start md:self-auto shadow-lg shadow-[#059669]/20">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                <polyline points="17 21 17 13 7 13 7 21"/>
                <polyline points="7 3 7 8 15 8"/>
            </svg>
            <span>Simpan Profil & Pengaturan</span>
        </button>
    </div>

    <!-- ML ADVISOR INFORMATION HIGHLIGHT BANNER -->
    <div class="p-6 rounded-3xl bg-gradient-to-br from-[#0B132B] via-[#0F172A] to-[#1C2541] text-white space-y-3 shadow-xl border border-[#1C2541] relative overflow-hidden">
        <div class="absolute -top-12 -right-12 w-48 h-48 rounded-full bg-[#059669]/20 blur-2xl pointer-events-none"></div>
        <div class="flex items-start gap-4 relative z-10">
            <div class="w-11 h-11 rounded-2xl bg-[#059669]/20 text-[#34D399] border border-[#059669]/40 flex items-center justify-center font-bold flex-shrink-0 mt-0.5">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M12 16v-4"/>
                    <path d="M12 8h.01"/>
                </svg>
            </div>
            <div class="space-y-1">
                <h3 class="text-base font-bold font-display text-white">Bagaimana Data Diri Ini Membantu Machine Learning?</h3>
                <p class="text-xs text-slate-300 leading-relaxed font-medium">
                    Algoritma Machine Learning CashMind mengombinasikan estimasi pendapatan, siklus gaji, dan tanggungan keluarga Anda dengan histori transaksi 60 hari terakhir. Hasil analisis ini menghasilkan rekomendasi alokasi anggaran paling presisi pada menu <a href="{{ route('user.budget.index') }}" class="text-[#34D399] font-bold underline">Anggaran</a>.
                </p>
            </div>
        </div>
    </div>

    <!-- MAIN PROFILE FORM -->
    <form id="profileForm" method="POST" action="{{ route('user.profile.update') }}" class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        @csrf

        <!-- LEFT PANEL: DATA DIRI & PARAMETER FINANSIAL (7 COLS) -->
        <div class="lg:col-span-7 space-y-6">
            
            <div class="cm-panel p-6 md:p-8 space-y-6">
                <div class="border-b border-[#E2E8F0] pb-4">
                    <h2 class="text-lg font-bold text-[#0F172A] font-display">1. Data Akun & Profil Pengguna</h2>
                    <p class="text-xs text-[#64748B] font-medium">Informasi identitas dasar akun pengguna CashMind.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <!-- Nama Lengkap -->
                    <div class="space-y-1.5">
                        <label class="block font-bold text-[#344054] uppercase tracking-wider">Nama Lengkap <span class="text-[#E11D48]">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="cm-input">
                    </div>

                    <!-- Alamat Email -->
                    <div class="space-y-1.5">
                        <label class="block font-bold text-[#344054] uppercase tracking-wider">Alamat Email <span class="text-[#E11D48]">*</span></label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="cm-input">
                    </div>
                </div>
            </div>

            <div class="cm-panel p-6 md:p-8 space-y-6">
                <div class="border-b border-[#E2E8F0] pb-4">
                    <h2 class="text-lg font-bold text-[#0F172A] font-display">2. Parameter Keuangan (Input Analisis ML)</h2>
                    <p class="text-xs text-[#64748B] font-medium">Data finansial ini digunakan oleh sistem kecerdasan buatan untuk mengalkulasi anggaran.</p>
                </div>

                <div class="space-y-5 text-xs">
                    <!-- Estimasi Pendapatan Bulanan -->
                    <div class="space-y-1.5">
                        <label class="block font-bold text-[#344054] uppercase tracking-wider">Estimasi Pendapatan Bersih Bulanan <span class="text-[#E11D48]">*</span></label>
                        <div class="relative">
                            <input type="text" 
                                   x-model="formattedIncome" 
                                   @input="formatRupiah($event.target.value)" 
                                   inputmode="numeric"
                                   required 
                                   class="cm-input text-xl font-bold text-[#0F172A] financial-number h-14">
                            <input type="hidden" name="monthly_income" x-model="rawIncome">
                        </div>
                        <span class="text-[11px] text-[#64748B] font-medium block">Total perkiraan gaji/pemasukan rutin bersih yang diterima dalam sebulan.</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Tanggal Gajian -->
                        <div class="space-y-1.5">
                            <label class="block font-bold text-[#344054] uppercase tracking-wider">Tanggal Gajian <span class="text-[#E11D48]">*</span></label>
                            <select name="payday_date" required class="cm-input">
                                @for($d = 1; $d <= 31; $d++)
                                    <option value="{{ $d }}" {{ old('payday_date', $profile->payday_date) == $d ? 'selected' : '' }}>
                                        Tanggal {{ $d }} setiap bulan
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <!-- Siklus Penggajian -->
                        <div class="space-y-1.5">
                            <label class="block font-bold text-[#344054] uppercase tracking-wider">Frekuensi Gaji <span class="text-[#E11D48]">*</span></label>
                            <select name="payday_frequency" required class="cm-input">
                                <option value="monthly" {{ old('payday_frequency', $profile->payday_frequency) === 'monthly' ? 'selected' : '' }}>Bulanan (1x sebulan)</option>
                                <option value="biweekly" {{ old('payday_frequency', $profile->payday_frequency) === 'biweekly' ? 'selected' : '' }}>2 Mingguan (2x sebulan)</option>
                                <option value="weekly" {{ old('payday_frequency', $profile->payday_frequency) === 'weekly' ? 'selected' : '' }}>Mingguan (Setiap minggu)</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Tujuan Keuangan Utama -->
                        <div class="space-y-1.5">
                            <label class="block font-bold text-[#344054] uppercase tracking-wider">Target Utama Finansial <span class="text-[#E11D48]">*</span></label>
                            <select name="financial_goal_type" required class="cm-input">
                                <option value="balanced" {{ old('financial_goal_type', $profile->financial_goal_type) === 'balanced' ? 'selected' : '' }}>Seimbang (Aturan 50/30/20 Standard)</option>
                                <option value="saving_focused" {{ old('financial_goal_type', $profile->financial_goal_type) === 'saving_focused' ? 'selected' : '' }}>Fokus Menabung (Aturan 45/25/30)</option>
                                <option value="debt_reduction" {{ old('financial_goal_type', $profile->financial_goal_type) === 'debt_reduction' ? 'selected' : '' }}>Pelunasan Hutang (Aturan 50/20/30)</option>
                                <option value="frugal" {{ old('financial_goal_type', $profile->financial_goal_type) === 'frugal' ? 'selected' : '' }}>Gaya Hidup Minimalis / Frugal (60/15/25)</option>
                            </select>
                        </div>

                        <!-- Jumlah Tanggungan Keluarga -->
                        <div class="space-y-1.5">
                            <label class="block font-bold text-[#344054] uppercase tracking-wider">Tanggungan Keluarga <span class="text-[#E11D48]">*</span></label>
                            <select name="dependents_count" required class="cm-input">
                                <option value="0" {{ old('dependents_count', $profile->dependents_count) == 0 ? 'selected' : '' }}>0 Orang (Sendiri)</option>
                                <option value="1" {{ old('dependents_count', $profile->dependents_count) == 1 ? 'selected' : '' }}>1 Tanggungan</option>
                                <option value="2" {{ old('dependents_count', $profile->dependents_count) == 2 ? 'selected' : '' }}>2 Tanggungan</option>
                                <option value="3" {{ old('dependents_count', $profile->dependents_count) >= 3 ? 'selected' : '' }}>3+ Tanggungan</option>
                            </select>
                        </div>
                    </div>

                    <!-- Profil Risiko -->
                    <div class="space-y-1.5">
                        <label class="block font-bold text-[#344054] uppercase tracking-wider">Profil Risiko Finansial <span class="text-[#E11D48]">*</span></label>
                        <select name="risk_profile" required class="cm-input">
                            <option value="conservative" {{ old('risk_profile', $profile->risk_profile) === 'conservative' ? 'selected' : '' }}>Konservatif (Prioritas Keamanan Dana & Kebutuhan Primer)</option>
                            <option value="moderate" {{ old('risk_profile', $profile->risk_profile) === 'moderate' ? 'selected' : '' }}>Moderat (Seimbang Antara Gaya Hidup & Tabungan)</option>
                            <option value="aggressive" {{ old('risk_profile', $profile->risk_profile) === 'aggressive' ? 'selected' : '' }}>Agresif (Memaksimalkan Alokasi Investasi / Target Masa Depan)</option>
                        </select>
                    </div>
                </div>
            </div>

        </div>

        <!-- RIGHT PANEL: PREFERENSI JADWAL ML REKOMENDASI ANGGARAN (5 COLS) -->
        <div class="lg:col-span-5 space-y-6">
            
            <div class="cm-panel p-6 md:p-8 space-y-6 border-[#A7F3D0]">
                <div class="border-b border-[#E2E8F0] pb-4">
                    <div class="flex items-center gap-2">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        </svg>
                        <h2 class="text-lg font-bold text-[#0F172A] font-display">3. Jadwal Rekomendasi ML</h2>
                    </div>
                    <p class="text-xs text-[#64748B] font-medium mt-1">Atur kapan rekomendasi penganggaran dana ingin disajikan untuk Anda.</p>
                </div>

                <div class="space-y-4 text-xs">
                    <!-- Frekuensi Rekomendasi -->
                    <div class="space-y-2">
                        <label class="block font-bold text-[#344054] uppercase tracking-wider">Jadwal Penyarana Rekomendasi <span class="text-[#E11D48]">*</span></label>
                        
                        <div class="space-y-2.5">
                            <label class="p-3.5 rounded-2xl border border-[#E2E8F0] bg-[#F8FAFC] flex items-start gap-3 cursor-pointer hover:border-[#059669] transition">
                                <input type="radio" name="recommendation_frequency" value="month_start" {{ old('recommendation_frequency', $profile->recommendation_frequency) === 'month_start' ? 'checked' : '' }} class="mt-0.5 text-[#059669] focus:ring-[#059669]">
                                <div>
                                    <span class="font-bold text-[#0F172A] block leading-tight">Setiap Awal Bulan (Tanggal 1)</span>
                                    <span class="text-[11px] text-[#64748B] font-medium block mt-0.5">Saran alokasi otomatis disiapkan untuk perencanaan bulan baru.</span>
                                </div>
                            </label>

                            <label class="p-3.5 rounded-2xl border border-[#E2E8F0] bg-[#F8FAFC] flex items-start gap-3 cursor-pointer hover:border-[#059669] transition">
                                <input type="radio" name="recommendation_frequency" value="payday" {{ old('recommendation_frequency', $profile->recommendation_frequency) === 'payday' ? 'checked' : '' }} class="mt-0.5 text-[#059669] focus:ring-[#059669]">
                                <div>
                                    <span class="font-bold text-[#0F172A] block leading-tight">Saat Gaji Masuk (Sesuai Tanggal Gajian)</span>
                                    <span class="text-[11px] text-[#64748B] font-medium block mt-0.5">Saran alokasi dihitung langsung setiap kali tanggal gaji tiba.</span>
                                </div>
                            </label>

                            <label class="p-3.5 rounded-2xl border border-[#E2E8F0] bg-[#F8FAFC] flex items-start gap-3 cursor-pointer hover:border-[#059669] transition">
                                <input type="radio" name="recommendation_frequency" value="weekly" {{ old('recommendation_frequency', $profile->recommendation_frequency) === 'weekly' ? 'checked' : '' }} class="mt-0.5 text-[#059669] focus:ring-[#059669]">
                                <div>
                                    <span class="font-bold text-[#0F172A] block leading-tight">Setiap Minggu</span>
                                    <span class="text-[11px] text-[#64748B] font-medium block mt-0.5">Evaluasi alokasi anggaran diperbarui secara mingguan.</span>
                                </div>
                            </label>

                            <label class="p-3.5 rounded-2xl border border-[#E2E8F0] bg-[#F8FAFC] flex items-start gap-3 cursor-pointer hover:border-[#059669] transition">
                                <input type="radio" name="recommendation_frequency" value="manual" {{ old('recommendation_frequency', $profile->recommendation_frequency) === 'manual' ? 'checked' : '' }} class="mt-0.5 text-[#059669] focus:ring-[#059669]">
                                <div>
                                    <span class="font-bold text-[#0F172A] block leading-tight">Manual Saja</span>
                                    <span class="text-[11px] text-[#64748B] font-medium block mt-0.5">Hanya tampil saat Anda mengeklik tombol rekomendasi di menu Anggaran.</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Otomatisasi Checkbox -->
                    <div class="pt-4 border-t border-[#E2E8F0]">
                        <label class="p-4 rounded-2xl bg-[#ECFDF5] border border-[#A7F3D0] flex items-start gap-3 cursor-pointer">
                            <input type="checkbox" name="auto_apply_recommendation" value="1" {{ old('auto_apply_recommendation', $profile->auto_apply_recommendation) ? 'checked' : '' }} class="mt-0.5 rounded text-[#059669] focus:ring-[#059669]">
                            <div>
                                <span class="font-bold text-[#0F172A] block text-xs leading-tight">Otomatiskan Alokasi Anggaran</span>
                                <span class="text-[11px] text-[#059669] font-medium block mt-1">Terapkan rekomendasi Machine Learning secara langsung ke anggaran aktif saat jadwal penyaranan tiba.</span>
                            </div>
                        </label>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="btn-emerald w-full justify-center text-xs font-bold shadow-lg shadow-[#059669]/20">
                            Simpan Preferensi Profil & ML
                        </button>
                    </div>
                </div>
            </div>

            <!-- QUICK BUDGET PAGE ACCESS -->
            <div class="cm-panel p-6 bg-[#F8FAFC] space-y-3 text-center">
                <h4 class="text-xs font-bold text-[#0F172A] font-display">Siap Melihat Rekomendasi ML?</h4>
                <p class="text-[11px] text-[#64748B] font-medium leading-relaxed">Buka menu Anggaran untuk melihat analisis rekomendasi alokasi yang telah dikalkulasi berdasarkan profil Anda.</p>
                <a href="{{ route('user.budget.index') }}" class="btn-primary w-full justify-center text-xs">
                    <span>Buka Menu Anggaran</span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                </a>
            </div>

        </div>
    </form>

</div>
@endsection
