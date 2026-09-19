<x-guest-layout>
    <!-- Guideline Section 82-83: Clean login form with quick demo switches -->
    <div x-data="{
        email: 'user@cashmind.id',
        password: 'password',
        get isEmailValid() {
            return this.email.includes('@') && this.email.includes('.');
        },
        get isPasswordValid() {
            return this.password.length >= 6;
        },
        fillAdmin() {
            this.email = 'admin@cashmind.id';
            this.password = 'password';
        },
        fillUser() {
            this.email = 'user@cashmind.id';
            this.password = 'password';
        }
    }" class="p-8 space-y-6 bg-white border border-[#E4E7EC] rounded-2xl shadow-xs">
        
        <div class="text-center space-y-1">
            <h2 class="text-2xl font-extrabold text-[#0F172A] tracking-tight">Selamat Datang Kembali</h2>
            <p class="text-xs text-[#667085] font-medium">Masuk ke akun Anda untuk mengelola arus kas & pencatatan.</p>
        </div>

        <!-- Quick Demo Access Bar -->
        <div class="p-3.5 rounded-xl bg-[#F8FAFB] border border-[#E4E7EC] space-y-2">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-bold text-[#0F766E] uppercase tracking-wider">1-Click Quick Demo Login</span>
                <span class="px-2 py-0.5 rounded-full bg-[#F0FDFA] text-[#0F766E] border border-[#99F6E4] text-[9px] font-bold">Demo Ready</span>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <button type="button" @click="fillAdmin()" class="p-2.5 rounded-lg bg-white hover:bg-[#FFFAEB] border border-[#E4E7EC] hover:border-[#FEF08A] text-[#101828] text-xs font-semibold transition text-left">
                    <div class="flex items-center gap-1.5 text-[#B54708] font-bold text-[11px]">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <span>Mode Admin</span>
                    </div>
                    <div class="text-[10px] text-[#667085] font-mono mt-0.5">admin@cashmind.id</div>
                </button>

                <button type="button" @click="fillUser()" class="p-2.5 rounded-lg bg-white hover:bg-[#F0FDFA] border border-[#E4E7EC] hover:border-[#99F6E4] text-[#101828] text-xs font-semibold transition text-left">
                    <div class="flex items-center gap-1.5 text-[#0F766E] font-bold text-[11px]">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span>Mode User</span>
                    </div>
                    <div class="text-[10px] text-[#667085] font-mono mt-0.5">user@cashmind.id</div>
                </button>
            </div>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4 text-[#15803D] text-xs font-bold text-center" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-4 text-xs">
            @csrf

            <!-- Email Address -->
            <div class="space-y-1.5">
                <label for="email" class="block font-semibold text-[#344054]">Alamat Email <span class="text-[#B42318]">*</span></label>
                <div class="relative">
                    <input id="email" type="email" name="email" x-model="email" required autofocus 
                           class="w-full h-11 px-3.5 rounded-xl border border-[#D0D5DD] text-[#101828] text-sm focus:border-[#0F766E] focus:ring-3 focus:ring-[#0F766E]/10 transition" 
                           placeholder="nama@email.com">
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-1 text-[#B42318] text-[11px]" />
            </div>

            <!-- Password -->
            <div class="space-y-1.5">
                <div class="flex items-center justify-between">
                    <label for="password" class="block font-semibold text-[#344054]">Password <span class="text-[#B42318]">*</span></label>
                    @if (Route::has('password.request'))
                        <a class="text-[11px] text-[#667085] hover:text-[#0F766E] font-semibold transition" href="{{ route('password.request') }}">
                            Lupa password?
                        </a>
                    @endif
                </div>
                <div class="relative">
                    <input id="password" type="password" name="password" x-model="password" required 
                           class="w-full h-11 px-3.5 rounded-xl border border-[#D0D5DD] text-[#101828] text-sm focus:border-[#0F766E] focus:ring-3 focus:ring-[#0F766E]/10 transition" 
                           placeholder="••••••••">
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-[#B42318] text-[11px]" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center pt-1">
                <label for="remember_me" class="inline-flex items-center cursor-pointer text-[#475467] text-xs font-medium">
                    <input id="remember_me" type="checkbox" class="rounded-md border-[#D0D5DD] text-[#0F766E] focus:ring-[#0F766E]" name="remember">
                    <span class="ms-2">Ingat akun saya di perangkat ini</span>
                </label>
            </div>

            <!-- Submit Button (Guideline Section 23: Ink #0F172A Primary) -->
            <div class="pt-2">
                <button type="submit" class="w-full h-11 text-xs font-semibold text-white bg-[#0F172A] hover:bg-[#1E293B] rounded-xl shadow-xs transition flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    <span>Masuk ke Workspace</span>
                </button>
            </div>

            <!-- Register Link -->
            <div class="text-center pt-2 text-[#667085] text-xs font-medium">
                Belum memiliki akun? <a href="{{ route('register') }}" class="text-[#0F766E] font-bold hover:underline">Daftar Akun Baru</a>
            </div>
        </form>
    </div>
</x-guest-layout>
