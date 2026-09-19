<x-guest-layout>
    <!-- Guideline Section 82-83: Clean register form -->
    <div x-data="{
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        get isEmailValid() {
            return this.email.includes('@') && this.email.includes('.');
        },
        get isPasswordMatch() {
            return this.password.length >= 8 && this.password === this.password_confirmation;
        }
    }" class="p-8 space-y-6 bg-white border border-[#E4E7EC] rounded-2xl shadow-xs">
        
        <div class="text-center space-y-1">
            <h2 class="text-2xl font-extrabold text-[#0F172A] tracking-tight">Buat Akun Baru</h2>
            <p class="text-xs text-[#667085] font-medium">Mulai kelola pemasukan, pengeluaran & alokasi anggaran Anda.</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4 text-xs">
            @csrf

            <!-- Name -->
            <div class="space-y-1.5">
                <label for="name" class="block font-semibold text-[#344054]">Nama Lengkap <span class="text-[#B42318]">*</span></label>
                <div class="relative">
                    <input id="name" type="text" name="name" x-model="name" required autofocus 
                           class="w-full h-11 px-3.5 rounded-xl border border-[#D0D5DD] text-[#101828] text-sm focus:border-[#0F766E] focus:ring-3 focus:ring-[#0F766E]/10 transition" 
                           placeholder="Nama Anda">
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-1 text-[#B42318] text-[11px]" />
            </div>

            <!-- Email Address -->
            <div class="space-y-1.5">
                <div class="flex items-center justify-between">
                    <label for="email" class="block font-semibold text-[#344054]">Alamat Email <span class="text-[#B42318]">*</span></label>
                    <span x-show="email.length > 0" class="text-[10px] font-bold" :class="isEmailValid ? 'text-[#15803D]' : 'text-[#B42318]'">
                        <span x-text="isEmailValid ? 'Format Email Valid' : 'Email Kurang Tepat'"></span>
                    </span>
                </div>
                <div class="relative">
                    <input id="email" type="email" name="email" x-model="email" required 
                           class="w-full h-11 px-3.5 rounded-xl border border-[#D0D5DD] text-[#101828] text-sm focus:border-[#0F766E] focus:ring-3 focus:ring-[#0F766E]/10 transition" 
                           placeholder="nama@email.com">
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-1 text-[#B42318] text-[11px]" />
            </div>

            <!-- Password -->
            <div class="space-y-1.5">
                <label for="password" class="block font-semibold text-[#344054]">Password <span class="text-[#B42318]">*</span></label>
                <div class="relative">
                    <input id="password" type="password" name="password" x-model="password" required 
                           class="w-full h-11 px-3.5 rounded-xl border border-[#D0D5DD] text-[#101828] text-sm focus:border-[#0F766E] focus:ring-3 focus:ring-[#0F766E]/10 transition" 
                           placeholder="Minimal 8 karakter">
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-[#B42318] text-[11px]" />
            </div>

            <!-- Confirm Password -->
            <div class="space-y-1.5">
                <div class="flex items-center justify-between">
                    <label for="password_confirmation" class="block font-semibold text-[#344054]">Konfirmasi Password <span class="text-[#B42318]">*</span></label>
                    <span x-show="password_confirmation.length > 0" class="text-[10px] font-bold" :class="isPasswordMatch ? 'text-[#15803D]' : 'text-[#B42318]'">
                        <span x-text="isPasswordMatch ? 'Password Cocok' : 'Password Belum Cocok'"></span>
                    </span>
                </div>
                <div class="relative">
                    <input id="password_confirmation" type="password" name="password_confirmation" x-model="password_confirmation" required 
                           class="w-full h-11 px-3.5 rounded-xl border border-[#D0D5DD] text-[#101828] text-sm focus:border-[#0F766E] focus:ring-3 focus:ring-[#0F766E]/10 transition" 
                           placeholder="Ulangi password">
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-[#B42318] text-[11px]" />
            </div>

            <!-- Submit Button (Guideline Section 23: Ink #0F172A Primary) -->
            <div class="pt-2">
                <button type="submit" class="w-full h-11 text-xs font-semibold text-white bg-[#0F172A] hover:bg-[#1E293B] rounded-xl shadow-xs transition flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                    <span>Daftar Akun Baru</span>
                </button>
            </div>

            <!-- Login Link -->
            <div class="text-center pt-2 text-[#667085] text-xs font-medium">
                Sudah memiliki akun? <a href="{{ route('register') }}" class="text-[#0F766E] font-bold hover:underline">Masuk Sekarang</a>
            </div>
        </form>
    </div>
</x-guest-layout>
