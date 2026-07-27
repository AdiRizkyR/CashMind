<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-xl font-bold text-white">Selamat Datang Kembali</h2>
        <p class="text-xs text-slate-400 mt-1">Masuk ke akun CashMind Anda untuk melanjutkan pencatatan kas.</p>
    </div>

    <!-- Quick Demo Accounts Switcher -->
    <div class="mb-6 p-3.5 rounded-2xl bg-slate-950/70 border border-slate-800 space-y-2">
        <span class="text-[11px] font-bold text-amber-400 uppercase tracking-wider block text-center">Quick Demo Login (Akun Seeder):</span>
        <div class="grid grid-cols-2 gap-2">
            <button type="button" onclick="fillAdmin()" class="px-3 py-2 rounded-xl bg-amber-500/10 hover:bg-amber-500/20 border border-amber-500/30 text-amber-300 text-xs font-bold transition text-left">
                <div class="flex items-center gap-1.5"><i class="fa-solid fa-shield-halved text-amber-400"></i> Admin Demo</div>
                <div class="text-[10px] text-slate-400 font-normal">admin@cashmind.id</div>
            </button>

            <button type="button" onclick="fillUser()" class="px-3 py-2 rounded-xl bg-emerald-500/10 hover:bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 text-xs font-bold transition text-left">
                <div class="flex items-center gap-1.5"><i class="fa-solid fa-user text-emerald-400"></i> User Demo</div>
                <div class="text-[10px] text-slate-400 font-normal">user@cashmind.id</div>
            </button>
        </div>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4 text-emerald-400 text-xs font-semibold" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4 text-xs">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block font-semibold text-slate-300 mb-1">Alamat Email</label>
            <div class="relative">
                <i class="fa-solid fa-envelope text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                <input id="email" type="email" name="email" :value="old('email')" required autofocus class="w-full bg-slate-800 border border-slate-700 rounded-xl pl-9 pr-4 py-2.5 text-white focus:ring-2 focus:ring-emerald-500 focus:outline-none" placeholder="nama@email.com">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-rose-400 text-[11px]" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block font-semibold text-slate-300 mb-1">Password</label>
            <div class="relative">
                <i class="fa-solid fa-lock text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                <input id="password" type="password" name="password" required class="w-full bg-slate-800 border border-slate-700 rounded-xl pl-9 pr-4 py-2.5 text-white focus:ring-2 focus:ring-emerald-500 focus:outline-none" placeholder="••••••••">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-rose-400 text-[11px]" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between text-xs pt-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer text-slate-300">
                <input id="remember_me" type="checkbox" class="rounded border-slate-700 bg-slate-800 text-emerald-500 focus:ring-emerald-500" name="remember">
                <span class="ms-2">Ingat saya</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-slate-400 hover:text-emerald-400 transition" href="{{ route('password.request') }}">
                    Lupa password?
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit" class="w-full py-3 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 text-slate-950 font-bold text-sm hover:from-emerald-400 hover:to-teal-500 transition shadow-lg shadow-emerald-500/20">
                Masuk ke Dashboard
            </button>
        </div>

        <!-- Register Link -->
        <div class="text-center pt-3 text-slate-400">
            Belum punya akun? <a href="{{ route('register') }}" class="text-emerald-400 font-bold hover:underline">Daftar sekarang</a>
        </div>
    </form>

    <script>
        function fillAdmin() {
            document.getElementById('email').value = 'admin@cashmind.id';
            document.getElementById('password').value = 'password';
        }
        function fillUser() {
            document.getElementById('email').value = 'user@cashmind.id';
            document.getElementById('password').value = 'password';
        }
    </script>
</x-guest-layout>
