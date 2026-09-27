<x-guest-layout>
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
    }" class="p-8 sm:p-10 bg-white border border-[#E2E8F0] rounded-3xl shadow-xl shadow-slate-200/50 space-y-6">
        
        <div class="text-center space-y-1.5">
            <h2 class="text-2xl font-extrabold text-[#0F172A] font-display tracking-tight">Buat Akun Baru</h2>
            <p class="text-xs text-[#64748B] font-medium">Mulai kelola pemasukan, pengeluaran & alokasi anggaran Anda.</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <!-- Name -->
            <div class="space-y-2">
                <label for="name" class="block font-semibold text-[#334155] uppercase tracking-wider text-[11px]">
                    Nama Lengkap <span class="text-[#EF4444]">*</span>
                </label>
                <input id="name" type="text" name="name" x-model="name" required autofocus 
                       class="cm-input text-xs" 
                       placeholder="Nama Lengkap Anda">
                <x-input-error :messages="$errors->get('name')" class="mt-1 text-[#EF4444] text-[11px]" />
            </div>

            <!-- Email Address -->
            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <label for="email" class="block font-semibold text-[#334155] uppercase tracking-wider text-[11px]">
                        Alamat Email <span class="text-[#EF4444]">*</span>
                    </label>
                    <span x-show="email.length > 0" class="text-[10px] font-bold" :class="isEmailValid ? 'text-[#10B981]' : 'text-[#EF4444]'">
                        <span x-text="isEmailValid ? 'Format Valid' : 'Format Belum Sesuai'"></span>
                    </span>
                </div>
                <input id="email" type="email" name="email" x-model="email" required 
                       class="cm-input text-xs" 
                       placeholder="nama@email.com">
                <x-input-error :messages="$errors->get('email')" class="mt-1 text-[#EF4444] text-[11px]" />
            </div>

            <!-- Password -->
            <div class="space-y-2">
                <label for="password" class="block font-semibold text-[#334155] uppercase tracking-wider text-[11px]">
                    Password <span class="text-[#EF4444]">*</span>
                </label>
                <input id="password" type="password" name="password" x-model="password" required 
                       class="cm-input text-xs" 
                       placeholder="Minimal 8 karakter">
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-[#EF4444] text-[11px]" />
            </div>

            <!-- Confirm Password -->
            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <label for="password_confirmation" class="block font-semibold text-[#334155] uppercase tracking-wider text-[11px]">
                        Konfirmasi Password <span class="text-[#EF4444]">*</span>
                    </label>
                    <span x-show="password_confirmation.length > 0" class="text-[10px] font-bold" :class="isPasswordMatch ? 'text-[#10B981]' : 'text-[#EF4444]'">
                        <span x-text="isPasswordMatch ? 'Password Cocok' : 'Belum Cocok'"></span>
                    </span>
                </div>
                <input id="password_confirmation" type="password" name="password_confirmation" x-model="password_confirmation" required 
                       class="cm-input text-xs" 
                       placeholder="Ulangi password Anda">
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-[#EF4444] text-[11px]" />
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <button type="submit" class="btn-indigo w-full">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="8.5" cy="7" r="4"/>
                        <line x1="20" y1="8" x2="20" y2="14"/>
                        <line x1="23" y1="11" x2="17" y2="11"/>
                    </svg>
                    <span>Daftar Akun Baru</span>
                </button>
            </div>

            <!-- Login Link -->
            <div class="text-center pt-2 text-[#64748B] text-xs font-medium border-t border-slate-100 mt-4">
                Sudah memiliki akun? <a href="{{ route('login') }}" class="text-[#4F46E5] font-bold hover:underline ms-1">Masuk Sekarang</a>
            </div>
        </form>
    </div>
</x-guest-layout>
