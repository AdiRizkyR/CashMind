<x-guest-layout>
    <div class="mb-5 text-center">
        <h2 class="text-lg font-bold text-zinc-100 tracking-tight">Selamat Datang Kembali</h2>
        <p class="text-xs text-zinc-400 mt-1">Masuk ke akun Anda untuk melanjutkan pencatatan kas.</p>
    </div>

    <!-- Quick Demo Accounts Switcher -->
    <div class="mb-5 p-3 rounded-xl bg-zinc-950/80 border border-zinc-800/80 space-y-2">
        <span class="text-[10px] font-bold text-emerald-400 uppercase tracking-wider block text-center font-mono">Quick Demo Access</span>
        <div class="grid grid-cols-2 gap-2">
            <button type="button" onclick="fillAdmin()" class="px-2.5 py-1.5 rounded-lg bg-zinc-900 hover:bg-zinc-800 border border-zinc-700/60 text-zinc-300 text-xs font-medium transition text-left">
                <div class="flex items-center gap-1.5 text-amber-400 font-semibold text-[11px]"><i class="fa-solid fa-shield-halved text-[10px]"></i> Admin</div>
                <div class="text-[10px] text-zinc-500 font-mono">admin@cashmind.id</div>
            </button>

            <button type="button" onclick="fillUser()" class="px-2.5 py-1.5 rounded-lg bg-zinc-900 hover:bg-zinc-800 border border-zinc-700/60 text-zinc-300 text-xs font-medium transition text-left">
                <div class="flex items-center gap-1.5 text-emerald-400 font-semibold text-[11px]"><i class="fa-solid fa-user text-[10px]"></i> User</div>
                <div class="text-[10px] text-zinc-500 font-mono">user@cashmind.id</div>
            </button>
        </div>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4 text-emerald-400 text-xs font-semibold" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4 text-xs">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block font-medium text-zinc-300 mb-1">Email</label>
            <div class="relative">
                <i class="fa-solid fa-envelope text-zinc-500 absolute left-3 top-1/2 -translate-y-1/2 text-xs"></i>
                <input id="email" type="email" name="email" :value="old('email')" required autofocus class="w-full bg-zinc-950 border border-zinc-800 rounded-lg pl-9 pr-3 py-2 text-zinc-100 text-xs focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 focus:outline-none" placeholder="nama@email.com">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-rose-400 text-[11px]" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-1">
                <label for="password" class="block font-medium text-zinc-300">Password</label>
                @if (Route::has('password.request'))
                    <a class="text-[11px] text-zinc-500 hover:text-emerald-400 transition" href="{{ route('password.request') }}">
                        Lupa password?
                    </a>
                @endif
            </div>
            <div class="relative">
                <i class="fa-solid fa-lock text-zinc-500 absolute left-3 top-1/2 -translate-y-1/2 text-xs"></i>
                <input id="password" type="password" name="password" required class="w-full bg-zinc-950 border border-zinc-800 rounded-lg pl-9 pr-3 py-2 text-zinc-100 text-xs focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 focus:outline-none" placeholder="••••••••">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-rose-400 text-[11px]" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center pt-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer text-zinc-400 text-xs">
                <input id="remember_me" type="checkbox" class="rounded border-zinc-800 bg-zinc-950 text-emerald-500 focus:ring-emerald-500 focus:ring-offset-zinc-950" name="remember">
                <span class="ms-2">Ingat saya</span>
            </label>
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit" class="w-full py-2.5 rounded-lg bg-emerald-500 hover:bg-emerald-400 text-zinc-950 font-bold text-xs transition shadow-lg shadow-emerald-500/10">
                Masuk ke Dashboard
            </button>
        </div>

        <!-- Register Link -->
        <div class="text-center pt-3 text-zinc-400 text-[11px]">
            Belum punya akun? <a href="{{ route('register') }}" class="text-emerald-400 font-semibold hover:underline">Daftar sekarang</a>
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
