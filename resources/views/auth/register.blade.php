<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-xl font-bold text-white">Buat Akun CashMind Baru</h2>
        <p class="text-xs text-slate-400 mt-1">Mulai kelola pemasukan, pengeluaran & alokasi anggaran Anda.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4 text-xs">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block font-semibold text-slate-300 mb-1">Nama Lengkap</label>
            <div class="relative">
                <i class="fa-solid fa-user text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                <input id="name" type="text" name="name" :value="old('name')" required autofocus class="w-full bg-slate-800 border border-slate-700 rounded-xl pl-9 pr-4 py-2.5 text-white focus:ring-2 focus:ring-emerald-500 focus:outline-none" placeholder="Nama Anda">
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-1 text-rose-400 text-[11px]" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block font-semibold text-slate-300 mb-1">Alamat Email</label>
            <div class="relative">
                <i class="fa-solid fa-envelope text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                <input id="email" type="email" name="email" :value="old('email')" required class="w-full bg-slate-800 border border-slate-700 rounded-xl pl-9 pr-4 py-2.5 text-white focus:ring-2 focus:ring-emerald-500 focus:outline-none" placeholder="nama@email.com">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-rose-400 text-[11px]" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block font-semibold text-slate-300 mb-1">Password</label>
            <div class="relative">
                <i class="fa-solid fa-lock text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                <input id="password" type="password" name="password" required class="w-full bg-slate-800 border border-slate-700 rounded-xl pl-9 pr-4 py-2.5 text-white focus:ring-2 focus:ring-emerald-500 focus:outline-none" placeholder="Minimal 8 karakter">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-rose-400 text-[11px]" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block font-semibold text-slate-300 mb-1">Konfirmasi Password</label>
            <div class="relative">
                <i class="fa-solid fa-lock-check text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                <input id="password_confirmation" type="password" name="password_confirmation" required class="w-full bg-slate-800 border border-slate-700 rounded-xl pl-9 pr-4 py-2.5 text-white focus:ring-2 focus:ring-emerald-500 focus:outline-none" placeholder="Ulangi password">
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-rose-400 text-[11px]" />
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit" class="w-full py-3 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 text-slate-950 font-bold text-sm hover:from-emerald-400 hover:to-teal-500 transition shadow-lg shadow-emerald-500/20">
                Daftar Akun Baru
            </button>
        </div>

        <!-- Login Link -->
        <div class="text-center pt-3 text-slate-400">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-emerald-400 font-bold hover:underline">Masuk sekarang</a>
        </div>
    </form>
</x-guest-layout>
