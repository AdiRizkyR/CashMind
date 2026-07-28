<x-guest-layout>
    <!-- Komentar Bahasa Indonesia: Form Login Masuk dengan Quick Demo Access & Validasi Interactive -->
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
    }" class="horizon-card p-8 space-y-6">
        
        <div class="text-center space-y-1">
            <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Selamat Datang Kembali</h2>
            <p class="text-xs text-slate-500 font-medium">Masuk ke akun Anda untuk mengelola pemasukan & pengeluaran kas.</p>
        </div>

        <!-- Quick Demo Access Bar -->
        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2.5 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-extrabold text-emerald-700 uppercase tracking-wider font-mono">1-Click Quick Demo Login</span>
                <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[9px] font-bold font-mono">Siap Digunakan</span>
            </div>
            <div class="grid grid-cols-2 gap-2.5">
                <button type="button" @click="fillAdmin()" class="p-2.5 rounded-xl bg-white hover:bg-amber-50 border border-slate-200 hover:border-amber-300 text-slate-800 text-xs font-bold transition text-left shadow-xs">
                    <div class="flex items-center gap-1.5 text-amber-700 font-extrabold text-[11px]"><i class="fa-solid fa-shield-halved text-[10px]"></i> Mode Admin</div>
                    <div class="text-[10px] text-slate-500 font-mono mt-0.5">admin@cashmind.id</div>
                </button>

                <button type="button" @click="fillUser()" class="p-2.5 rounded-xl bg-white hover:bg-emerald-50 border border-slate-200 hover:border-emerald-300 text-slate-800 text-xs font-bold transition text-left shadow-xs">
                    <div class="flex items-center gap-1.5 text-emerald-700 font-extrabold text-[11px]"><i class="fa-solid fa-user text-[10px]"></i> Mode User</div>
                    <div class="text-[10px] text-slate-500 font-mono mt-0.5">user@cashmind.id</div>
                </button>
            </div>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4 text-emerald-600 text-xs font-bold text-center" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-4 text-xs">
            @csrf

            <!-- Email Address with Interactive Validation Helper -->
            <div class="space-y-1">
                <div class="flex items-center justify-between">
                    <label for="email" class="block font-bold text-slate-700">Alamat Email</label>
                    <span x-show="email.length > 0" class="text-[10px] font-bold" :class="isEmailValid ? 'text-emerald-600' : 'text-rose-500'">
                        <i :class="isEmailValid ? 'fa-solid fa-circle-check' : 'fa-solid fa-circle-xmark'"></i>
                        <span x-text="isEmailValid ? 'Format Email Valid' : 'Email Kurang Tepat'"></span>
                    </span>
                </div>
                <div class="relative">
                    <i class="fa-solid fa-envelope text-slate-400 absolute left-4 top-1/2 -translate-y-1/2 text-xs"></i>
                    <input id="email" type="email" name="email" x-model="email" required autofocus class="horizon-input w-full pl-10" placeholder="nama@email.com">
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-1 text-rose-600 text-[11px]" />
            </div>

            <!-- Password -->
            <div class="space-y-1">
                <div class="flex items-center justify-between">
                    <label for="password" class="block font-bold text-slate-700">Password</label>
                    @if (Route::has('password.request'))
                        <a class="text-[11px] text-slate-500 hover:text-emerald-600 font-bold transition" href="{{ route('password.request') }}">
                            Lupa password?
                        </a>
                    @endif
                </div>
                <div class="relative">
                    <i class="fa-solid fa-lock text-slate-400 absolute left-4 top-1/2 -translate-y-1/2 text-xs"></i>
                    <input id="password" type="password" name="password" x-model="password" required class="horizon-input w-full pl-10" placeholder="••••••••">
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-rose-600 text-[11px]" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center pt-1">
                <label for="remember_me" class="inline-flex items-center cursor-pointer text-slate-600 text-xs font-semibold">
                    <input id="remember_me" type="checkbox" class="rounded-lg border-slate-300 text-emerald-600 focus:ring-emerald-500" name="remember">
                    <span class="ms-2">Ingat akun saya di perangkat ini</span>
                </label>
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <button type="submit" class="horizon-btn-primary w-full py-3 text-xs">
                    <i class="fa-solid fa-right-to-bracket text-xs"></i>
                    <span>Masuk ke Workspace</span>
                </button>
            </div>

            <!-- Register Link -->
            <div class="text-center pt-2 text-slate-500 text-xs font-medium">
                Belum memiliki akun? <a href="{{ route('register') }}" class="text-emerald-600 font-extrabold hover:underline">Daftar Akun Baru</a>
            </div>
        </form>
    </div>
</x-guest-layout>
