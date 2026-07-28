<x-guest-layout>
    <!-- Komentar Bahasa Indonesia: Halaman Registrasi Akun Baru dengan Validasi Interaktif -->
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
    }" class="horizon-card p-8 space-y-6">
        
        <div class="text-center space-y-1">
            <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Buat Akun Baru</h2>
            <p class="text-xs text-slate-500 font-medium">Mulai kelola pemasukan, pengeluaran & alokasi anggaran Anda.</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4 text-xs">
            @csrf

            <!-- Name -->
            <div class="space-y-1">
                <label for="name" class="block font-bold text-slate-700">Nama Lengkap</label>
                <div class="relative">
                    <i class="fa-solid fa-user text-slate-400 absolute left-4 top-1/2 -translate-y-1/2 text-xs"></i>
                    <input id="name" type="text" name="name" x-model="name" required autofocus class="horizon-input w-full pl-10" placeholder="Nama Anda">
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-1 text-rose-600 text-[11px]" />
            </div>

            <!-- Email Address -->
            <div class="space-y-1">
                <div class="flex items-center justify-between">
                    <label for="email" class="block font-bold text-slate-700">Alamat Email</label>
                    <span x-show="email.length > 0" class="text-[10px] font-bold" :class="isEmailValid ? 'text-emerald-600' : 'text-rose-500'">
                        <i :class="isEmailValid ? 'fa-solid fa-circle-check' : 'fa-solid fa-circle-xmark'"></i>
                        <span x-text="isEmailValid ? 'Email Valid' : 'Format Email Kurang Tepat'"></span>
                    </span>
                </div>
                <div class="relative">
                    <i class="fa-solid fa-envelope text-slate-400 absolute left-4 top-1/2 -translate-y-1/2 text-xs"></i>
                    <input id="email" type="email" name="email" x-model="email" required class="horizon-input w-full pl-10" placeholder="nama@email.com">
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-1 text-rose-600 text-[11px]" />
            </div>

            <!-- Password -->
            <div class="space-y-1">
                <label for="password" class="block font-bold text-slate-700">Password</label>
                <div class="relative">
                    <i class="fa-solid fa-lock text-slate-400 absolute left-4 top-1/2 -translate-y-1/2 text-xs"></i>
                    <input id="password" type="password" name="password" x-model="password" required class="horizon-input w-full pl-10" placeholder="Minimal 8 karakter">
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-rose-600 text-[11px]" />
            </div>

            <!-- Confirm Password -->
            <div class="space-y-1">
                <div class="flex items-center justify-between">
                    <label for="password_confirmation" class="block font-bold text-slate-700">Konfirmasi Password</label>
                    <span x-show="password_confirmation.length > 0" class="text-[10px] font-bold" :class="isPasswordMatch ? 'text-emerald-600' : 'text-rose-500'">
                        <i :class="isPasswordMatch ? 'fa-solid fa-circle-check' : 'fa-solid fa-circle-xmark'"></i>
                        <span x-text="isPasswordMatch ? 'Password Cocok' : 'Password Belum Cocok'"></span>
                    </span>
                </div>
                <div class="relative">
                    <i class="fa-solid fa-lock text-slate-400 absolute left-4 top-1/2 -translate-y-1/2 text-xs"></i>
                    <input id="password_confirmation" type="password" name="password_confirmation" x-model="password_confirmation" required class="horizon-input w-full pl-10" placeholder="Ulangi password">
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-rose-600 text-[11px]" />
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <button type="submit" class="horizon-btn-primary w-full py-3 text-xs">
                    <i class="fa-solid fa-user-plus text-xs"></i>
                    <span>Daftar Akun Baru</span>
                </button>
            </div>

            <!-- Login Link -->
            <div class="text-center pt-2 text-slate-500 text-xs font-medium">
                Sudah memiliki akun? <a href="{{ route('login') }}" class="text-emerald-600 font-extrabold hover:underline">Masuk Sekarang</a>
            </div>
        </form>
    </div>
</x-guest-layout>
