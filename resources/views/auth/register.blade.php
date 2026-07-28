<x-guest-layout>
    <div class="mb-5 text-center">
        <h2 class="text-lg font-bold text-zinc-100 tracking-tight">Buat Akun Baru</h2>
        <p class="text-xs text-zinc-400 mt-1">Mulai kelola pemasukan, pengeluaran & alokasi anggaran Anda.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4 text-xs">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block font-medium text-zinc-300 mb-1">Nama Lengkap</label>
            <div class="relative">
                <i class="fa-solid fa-user text-zinc-500 absolute left-3 top-1/2 -translate-y-1/2 text-xs"></i>
                <input id="name" type="text" name="name" :value="old('name')" required autofocus class="w-full bg-zinc-950 border border-zinc-800 rounded-lg pl-9 pr-3 py-2 text-zinc-100 text-xs focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 focus:outline-none" placeholder="Nama Anda">
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-1 text-rose-400 text-[11px]" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block font-medium text-zinc-300 mb-1">Alamat Email</label>
            <div class="relative">
                <i class="fa-solid fa-envelope text-zinc-500 absolute left-3 top-1/2 -translate-y-1/2 text-xs"></i>
                <input id="email" type="email" name="email" :value="old('email')" required class="w-full bg-zinc-950 border border-zinc-800 rounded-lg pl-9 pr-3 py-2 text-zinc-100 text-xs focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 focus:outline-none" placeholder="nama@email.com">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-rose-400 text-[11px]" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block font-medium text-zinc-300 mb-1">Password</label>
            <div class="relative">
                <i class="fa-solid fa-lock text-zinc-500 absolute left-3 top-1/2 -translate-y-1/2 text-xs"></i>
                <input id="password" type="password" name="password" required class="w-full bg-zinc-950 border border-zinc-800 rounded-lg pl-9 pr-3 py-2 text-zinc-100 text-xs focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 focus:outline-none" placeholder="Minimal 8 karakter">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-rose-400 text-[11px]" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block font-medium text-zinc-300 mb-1">Konfirmasi Password</label>
            <div class="relative">
                <i class="fa-solid fa-lock text-zinc-500 absolute left-3 top-1/2 -translate-y-1/2 text-xs"></i>
                <input id="password_confirmation" type="password" name="password_confirmation" required class="w-full bg-zinc-950 border border-zinc-800 rounded-lg pl-9 pr-3 py-2 text-zinc-100 text-xs focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 focus:outline-none" placeholder="Ulangi password">
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-rose-400 text-[11px]" />
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit" class="w-full py-2.5 rounded-lg bg-emerald-500 hover:bg-emerald-400 text-zinc-950 font-bold text-xs transition shadow-lg shadow-emerald-500/10">
                Daftar Akun Baru
            </button>
        </div>

        <!-- Login Link -->
        <div class="text-center pt-3 text-zinc-400 text-[11px]">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-emerald-400 font-semibold hover:underline">Masuk sekarang</a>
        </div>
    </form>
</x-guest-layout>
