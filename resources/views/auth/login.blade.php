<x-guest-layout>
    <div x-data="{ email: '', password: '' }" class="p-8 sm:p-10 bg-white border border-[#E2E8F0] rounded-3xl shadow-xl shadow-slate-200/50 space-y-6">
        
        <div class="text-center space-y-1.5">
            <h2 class="text-2xl font-extrabold text-[#0F172A] font-display tracking-tight">Selamat Datang Kembali</h2>
            <p class="text-xs text-[#64748B] font-medium">Masuk ke akun Anda untuk mengelola arus kas & anggaran.</p>
        </div>

        <!-- Session Status Alert -->
        <x-auth-session-status class="mb-4 text-[#059669] text-xs font-bold text-center" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Email Address -->
            <div class="space-y-2">
                <label for="email" class="block font-semibold text-[#334155] uppercase tracking-wider text-[11px]">
                    Alamat Email <span class="text-[#EF4444]">*</span>
                </label>
                <input id="email" type="email" name="email" x-model="email" required autofocus 
                       class="cm-input text-xs" 
                       placeholder="nama@email.com">
                <x-input-error :messages="$errors->get('email')" class="mt-1 text-[#EF4444] text-[11px]" />
            </div>

            <!-- Password -->
            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <label for="password" class="block font-semibold text-[#334155] uppercase tracking-wider text-[11px]">
                        Password <span class="text-[#EF4444]">*</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a class="text-[11px] text-[#64748B] hover:text-[#4F46E5] font-semibold transition" href="{{ route('password.request') }}">
                            Lupa password?
                        </a>
                    @endif
                </div>
                <input id="password" type="password" name="password" x-model="password" required 
                       class="cm-input text-xs" 
                       placeholder="••••••••">
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-[#EF4444] text-[11px]" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center pt-1">
                <label for="remember_me" class="inline-flex items-center cursor-pointer text-[#475467] text-xs font-medium select-none">
                    <input id="remember_me" type="checkbox" class="w-4 h-4 rounded border-[#CBD5E1] text-[#4F46E5] focus:ring-[#4F46E5]" name="remember">
                    <span class="ms-2.5">Ingat akun saya di perangkat ini</span>
                </label>
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <button type="submit" class="btn-indigo w-full">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                        <polyline points="10 17 15 12 10 7"/>
                        <line x1="15" y1="12" x2="3" y2="12"/>
                    </svg>
                    <span>Masuk ke Workspace</span>
                </button>
            </div>

            <!-- Register Link -->
            <div class="text-center pt-2 text-[#64748B] text-xs font-medium border-t border-slate-100 mt-4">
                Belum memiliki akun? <a href="{{ route('register') }}" class="text-[#4F46E5] font-bold hover:underline ms-1">Daftar Akun Baru</a>
            </div>
        </form>
    </div>
</x-guest-layout>
