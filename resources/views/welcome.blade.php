@extends('layouts.app')

@section('content')
<div x-data="{ openFaq: null }" class="min-h-screen flex flex-col justify-between bg-[#FCFCFD] text-[#101828] selection:bg-[#0F766E] selection:text-white">
    
    <!-- 1. NAVBAR (Guideline Section 77) -->
    <header class="h-[68px] bg-white/90 backdrop-blur-md border-b border-[#E4E7EC] px-6 lg:px-12 flex items-center justify-between sticky top-0 z-50">
        <a href="{{ url('/') }}" class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-[#0F172A] text-white flex items-center justify-center font-bold text-base shadow-xs">
                <svg class="w-5 h-5 text-[#99F6E4]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <span class="text-lg font-bold tracking-tight text-[#0F172A] block leading-none">CashMind</span>
                <span class="text-[10px] text-[#0F766E] font-semibold uppercase tracking-wider mt-0.5 block">Ledger OS</span>
            </div>
        </a>

        <!-- Desktop Links -->
        <nav class="hidden md:flex items-center gap-8 text-xs font-semibold text-[#475467]">
            <a href="#beranda" class="hover:text-[#0F172A] transition">Beranda</a>
            <a href="#fitur" class="hover:text-[#0F172A] transition">Fitur Utama</a>
            <a href="#keamanan" class="hover:text-[#0F172A] transition">Keamanan & Privasi</a>
            <a href="#carakerja" class="hover:text-[#0F172A] transition">Cara Kerja</a>
            <a href="#faq" class="hover:text-[#0F172A] transition">FAQ</a>
        </nav>

        <!-- Auth Actions -->
        <div class="flex items-center gap-3">
            @guest
                <a href="{{ route('login') }}" class="px-4 py-2 text-xs font-semibold text-[#344054] bg-white border border-[#D0D5DD] rounded-xl hover:bg-[#F9FAFB] transition">Masuk</a>
                <a href="{{ route('register') }}" class="px-4 py-2 text-xs font-semibold text-white bg-[#0F172A] hover:bg-[#1E293B] rounded-xl transition">Mulai Gratis</a>
            @else
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 text-xs font-semibold text-white bg-[#B54708] hover:bg-[#923B06] rounded-xl transition">Dashboard Admin</a>
                @else
                    <a href="{{ route('user.dashboard') }}" class="px-4 py-2 text-xs font-semibold text-white bg-[#0F172A] hover:bg-[#1E293B] rounded-xl transition">Buka Workspace Saya</a>
                @endif
            @endguest
        </div>
    </header>

    <!-- 2. HERO SECTION (Guideline Section 78-79) -->
    <section id="beranda" class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 sm:pt-24 pb-16 text-center space-y-8">
        <div class="max-w-3xl mx-auto space-y-6">
            <h1 class="text-3xl sm:text-5xl font-extrabold text-[#0F172A] tracking-tight leading-[1.15]">
                Keuangan pribadi,<br>
                <span class="text-[#0F766E]">tanpa kerumitan.</span>
            </h1>
            <p class="text-[#475467] text-base sm:text-lg max-w-2xl mx-auto leading-relaxed font-medium">
                Catat transaksi, kelola rekening, susun anggaran, dan pahami arus uang dalam satu workspace pribadi yang aman.
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-wrap items-center justify-center gap-4 pt-2">
                @guest
                    <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-6 py-3.5 text-sm font-semibold text-white bg-[#0F172A] hover:bg-[#1E293B] rounded-xl shadow-xs transition">
                        <span>Mulai Gratis</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                    <a href="#fitur" class="inline-flex items-center gap-2 px-6 py-3.5 text-sm font-semibold text-[#344054] bg-white border border-[#D0D5DD] hover:bg-[#F9FAFB] rounded-xl transition">
                        <span>Lihat Produk</span>
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-6 py-3.5 text-sm font-semibold text-white bg-[#0F172A] hover:bg-[#1E293B] rounded-xl shadow-xs transition">
                        <span>Masuk ke Workspace</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                @endif
            </div>

            <!-- Privacy Guarantee Badge -->
            <div class="pt-2 text-xs font-semibold text-[#667085] flex items-center justify-center gap-2">
                <svg class="w-4 h-4 text-[#0F766E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                <span>Data finansial Anda tetap pribadi. Admin 0% akses saldo.</span>
            </div>
        </div>

        <!-- Mockup Visual -->
        <div class="pt-6 max-w-4xl mx-auto">
            <div class="p-4 sm:p-6 bg-white rounded-2xl border border-[#E4E7EC] shadow-xs text-left">
                <div class="flex items-center gap-2 mb-4 border-b border-[#EAECF0] pb-3">
                    <span class="w-3 h-3 rounded-full bg-[#EAECF0]"></span>
                    <span class="w-3 h-3 rounded-full bg-[#EAECF0]"></span>
                    <span class="w-3 h-3 rounded-full bg-[#EAECF0]"></span>
                    <span class="text-xs font-mono text-[#667085] ml-2">app.cashmind.id/ledger</span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="p-4 rounded-xl bg-[#F8FAFB] border border-[#E4E7EC]">
                        <span class="text-xs font-semibold text-[#475467] block">Total Saldo</span>
                        <span class="text-2xl font-extrabold text-[#0F172A] mt-1 block tracking-tight">Rp 8.750.000</span>
                    </div>
                    <div class="p-4 rounded-xl bg-[#F0FDF4] border border-[#DCFCE7]">
                        <span class="text-xs font-semibold text-[#15803D] block">Pemasukan Bulan Ini</span>
                        <span class="text-2xl font-extrabold text-[#15803D] mt-1 block tracking-tight">+ Rp 7.000.000</span>
                    </div>
                    <div class="p-4 rounded-xl bg-[#FEF3F2] border border-[#FEE4E2]">
                        <span class="text-xs font-semibold text-[#B42318] block">Pengeluaran Bulan Ini</span>
                        <span class="text-2xl font-extrabold text-[#B42318] mt-1 block tracking-tight">- Rp 4.250.000</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. FEATURE SECTION (Guideline Section 80) -->
    <section id="fitur" class="py-20 bg-white border-y border-[#E4E7EC]">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16 space-y-3">
                <h2 class="text-2xl sm:text-3xl font-extrabold text-[#0F172A]">Fitur Utama CashMind</h2>
                <p class="text-[#475467] text-sm font-medium">Dirancang khusus untuk pengalaman mencatat keuangan pribadi yang tenang dan presisi.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Feature 1 -->
                <div class="p-6 rounded-2xl bg-white border border-[#E4E7EC] space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-[#F0FDFA] text-[#0F766E] flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-[#0F172A]">Pencatatan Lengkap & Detail</h3>
                    <p class="text-[#667085] text-xs leading-relaxed">Catat transaksi pemasukan, pengeluaran, serta pemindahan dana (transfer) antar akun dengan deskripsi dan alasan yang jelas.</p>
                </div>

                <!-- Feature 2 -->
                <div class="p-6 rounded-2xl bg-white border border-[#E4E7EC] space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-[#F0FDFA] text-[#0F766E] flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-[#0F172A]">Banyak Akun & Dompet</h3>
                    <p class="text-[#667085] text-xs leading-relaxed">Pisahkan saldo Tunai, Bank, dan E-Wallet. Pengguna dapat memilih master template atau menambah akun kustom sendiri.</p>
                </div>

                <!-- Feature 3 -->
                <div class="p-6 rounded-2xl bg-white border border-[#E4E7EC] space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-[#F0FDFA] text-[#0F766E] flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-[#0F172A]">Kategori Terpisah (Tab UI)</h3>
                    <p class="text-[#667085] text-xs leading-relaxed">Kategori Pemasukan dan Pengeluaran dipisahkan secara tegas agar tidak campur aduk. Tidak ada kategori ganda.</p>
                </div>

                <!-- Feature 4 -->
                <div class="p-6 rounded-2xl bg-white border border-[#E4E7EC] space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-[#F0FDFA] text-[#0F766E] flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-[#0F172A]">Grafik Cash Flow & Anggaran</h3>
                    <p class="text-[#667085] text-xs leading-relaxed">Pantau tren arus kas bulanan serta kesehatan batas pengeluaran kategori dengan progress indikator visual.</p>
                </div>

                <!-- Feature 5 -->
                <div class="p-6 rounded-2xl bg-white border border-[#E4E7EC] space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-[#F0FDFA] text-[#0F766E] flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-[#0F172A]">Promosi Template oleh Admin</h3>
                    <p class="text-[#667085] text-xs leading-relaxed">Admin dapat meninjau rekomendasi kategori / lembaga populer dari user untuk dijadikan template utama sistem.</p>
                </div>

                <!-- Feature 6 -->
                <div class="p-6 rounded-2xl bg-white border border-[#E4E7EC] space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-[#F0FDF4] text-[#15803D] flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-[#0F172A]">Private by Design</h3>
                    <p class="text-[#667085] text-xs leading-relaxed">Arsitektur terisolasi mutlak. Catatan finansial Anda aman dan tidak dapat diakses oleh siapapun termasuk admin.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. PRIVACY SECTION (Guideline Section 81) -->
    <section id="keamanan" class="py-20 bg-[#0F172A] text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-8">
            <div class="space-y-3">
                <span class="px-3 py-1 rounded-full bg-[#0F766E]/20 text-[#99F6E4] border border-[#0F766E]/40 text-xs font-semibold uppercase tracking-wider">Private by Design Architecture</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold">Data Keuangan Pribadi Tetap Pribadi</h2>
                <p class="text-[#94A3B8] text-sm max-w-xl mx-auto">Sistem mengisolasi data user secara mutlak di mana admin hanya mengelola operasional akun dan master data.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-left pt-4">
                <div class="p-5 rounded-xl bg-[#1E293B] border border-[#334155] flex items-center gap-3">
                    <svg class="w-5 h-5 text-[#99F6E4] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span class="text-xs font-semibold text-[#F8FAFC]">Admin tidak dapat melihat transaksi Anda</span>
                </div>
                <div class="p-5 rounded-xl bg-[#1E293B] border border-[#334155] flex items-center gap-3">
                    <svg class="w-5 h-5 text-[#99F6E4] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span class="text-xs font-semibold text-[#F8FAFC]">Admin tidak dapat melihat saldo Anda</span>
                </div>
                <div class="p-5 rounded-xl bg-[#1E293B] border border-[#334155] flex items-center gap-3">
                    <svg class="w-5 h-5 text-[#99F6E4] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span class="text-xs font-semibold text-[#F8FAFC]">Admin tidak dapat melihat laporan keuangan Anda</span>
                </div>
                <div class="p-5 rounded-xl bg-[#1E293B] border border-[#334155] flex items-center gap-3">
                    <svg class="w-5 h-5 text-[#99F6E4] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span class="text-xs font-semibold text-[#F8FAFC]">Data antar pengguna terisolasi secara mutlak</span>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. HOW IT WORKS -->
    <section id="carakerja" class="py-20 bg-[#F8FAFB]">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16 space-y-3">
                <h2 class="text-2xl sm:text-3xl font-extrabold text-[#0F172A]">Cara Kerja CashMind</h2>
                <p class="text-[#475467] text-sm font-medium">Tiga langkah sederhana menuju keuangan pribadi yang terkontrol.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
                <div class="p-8 rounded-2xl bg-white border border-[#E4E7EC] space-y-4">
                    <span class="text-3xl font-extrabold text-[#0F766E] block font-mono">01</span>
                    <h3 class="text-base font-bold text-[#0F172A]">Buat Akun</h3>
                    <p class="text-[#667085] text-xs leading-relaxed">Daftar akun gratis dalam hitungan detik tanpa verifikasi rumit.</p>
                </div>
                <div class="p-8 rounded-2xl bg-white border border-[#E4E7EC] space-y-4">
                    <span class="text-3xl font-extrabold text-[#0F766E] block font-mono">02</span>
                    <h3 class="text-base font-bold text-[#0F172A]">Pilih/Tambah Modul</h3>
                    <p class="text-[#667085] text-xs leading-relaxed">Pilih kategori & dompet utama sistem atau tambahkan preferensi Anda sendiri.</p>
                </div>
                <div class="p-8 rounded-2xl bg-white border border-[#E4E7EC] space-y-4">
                    <span class="text-3xl font-extrabold text-[#0F766E] block font-mono">03</span>
                    <h3 class="text-base font-bold text-[#0F172A]">Catat & Evaluasi</h3>
                    <p class="text-[#667085] text-xs leading-relaxed">Catat arus kas harian dan pantau laporan keuangan per bulan dengan presisi.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. FAQ -->
    <section id="faq" class="py-20 bg-white border-t border-[#E4E7EC]">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div class="text-center space-y-3">
                <h2 class="text-2xl sm:text-3xl font-extrabold text-[#0F172A]">Pertanyaan Umum (FAQ)</h2>
            </div>

            <div class="space-y-4">
                <div class="p-4 rounded-xl bg-white border border-[#E4E7EC]">
                    <button @click="openFaq = openFaq === 1 ? null : 1" class="w-full flex items-center justify-between font-bold text-sm text-[#0F172A] text-left">
                        <span>Apakah admin platform dapat melihat catatan transaksi saya?</span>
                        <svg class="w-4 h-4 text-[#667085] transition-transform" :class="openFaq === 1 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <p x-show="openFaq === 1" class="mt-3 text-xs text-[#667085] leading-relaxed">
                        Tidak. CashMind dirancang dengan prinsip Private by Design. Data finansial (nominal, akun, deskripsi transaksi, dan laporan) hanya dapat diakses oleh pemilik akun.
                    </p>
                </div>

                <div class="p-4 rounded-xl bg-white border border-[#E4E7EC]">
                    <button @click="openFaq = openFaq === 2 ? null : 2" class="w-full flex items-center justify-between font-bold text-sm text-[#0F172A] text-left">
                        <span>Bagaimana cara pencatatan nominal dengan format Rupiah?</span>
                        <svg class="w-4 h-4 text-[#667085] transition-transform" :class="openFaq === 2 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <p x-show="openFaq === 2" class="mt-3 text-xs text-[#667085] leading-relaxed">
                        Form input otomatis memformat angka dengan pemisah ribuan (contoh: <code>Rp 1.000.000</code>) untuk kemudahan membaca, namun data yang tersimpan di database tetap berupa angka murni (<code>1000000</code>).
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- 7. FOOTER -->
    <footer class="py-8 bg-[#0F172A] text-[#94A3B8] text-xs border-t border-[#1E293B] text-center">
        <div class="max-w-6xl mx-auto px-4">
            <p>© 2026 CashMind. Private Personal Financial Operating System.</p>
        </div>
    </footer>

</div>
@endsection
