@extends('layouts.app')

@section('content')
<!-- Komentar Bahasa Indonesia: Layout User Workspace 5-Group Navigation Architecture -->
<div class="min-h-screen flex flex-col md:flex-row bg-slate-50">
    
    <!-- FLOATING CURVED LEFT SIDEBAR -->
    <aside class="w-full md:w-64 bg-white/95 border border-slate-200/80 rounded-3xl m-3 sm:m-4 flex flex-col justify-between shrink-0 print:hidden z-20 shadow-lg backdrop-blur-md">
        <div>
            <!-- Brand Logo & Header -->
            <div class="p-5 border-b border-slate-100 space-y-4">
                <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center font-bold text-lg shadow-md group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                    <div>
                        <span class="text-lg font-extrabold tracking-tight text-slate-900 block leading-none">CashMind</span>
                        <span class="text-[10px] text-emerald-600 font-bold uppercase tracking-wider mt-1 block">Enterprise OS</span>
                    </div>
                </a>

                <!-- Workspace Switcher Selector -->
                <div x-data="{ openWorkspace: false }" class="relative">
                    <button @click="openWorkspace = !openWorkspace" class="w-full p-2.5 rounded-2xl bg-slate-50 border border-slate-200 hover:border-slate-300 text-xs font-bold text-slate-800 flex items-center justify-between transition text-left shadow-xs">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <div class="w-6 h-6 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-[10px] shrink-0">
                                <i class="fa-solid fa-user-gear text-[10px]"></i>
                            </div>
                            <div class="truncate">
                                <span class="text-xs font-bold text-slate-900 block truncate">Personal Workspace</span>
                                <span class="text-[10px] text-emerald-600 font-bold block">Mode Perorangan</span>
                            </div>
                        </div>
                        <i class="fa-solid fa-chevron-down text-[10px] text-slate-400"></i>
                    </button>

                    <div x-show="openWorkspace" @click.outside="openWorkspace = false" x-cloak class="absolute left-0 right-0 top-full mt-2 p-2 bg-white border border-slate-200 rounded-2xl shadow-xl z-30 text-xs space-y-1" x-transition>
                        <div class="px-2 py-1 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Mode Workspace</div>
                        <button @click="openWorkspace = false" class="w-full p-2.5 rounded-xl bg-emerald-50 text-emerald-900 font-bold text-left flex items-center gap-2">
                            <i class="fa-solid fa-user text-emerald-600 text-xs"></i>
                            <span>Personal (Perorangan)</span>
                        </button>
                        <button @click="openWorkspace = false" class="w-full p-2.5 rounded-xl hover:bg-slate-50 text-slate-700 text-left flex items-center gap-2 font-semibold transition">
                            <i class="fa-solid fa-building text-sky-600 text-xs"></i>
                            <span>Enterprise Corporate</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- CURVED 5-GROUP MENU TREE -->
            <nav class="p-3 space-y-3.5 text-xs font-bold">
                
                <!-- GROUP 1: OVERVIEW -->
                <div class="space-y-1">
                    <div class="px-3 py-1 text-[10px] font-extrabold text-slate-400 uppercase tracking-wider font-mono">Overview</div>
                    
                    <a href="{{ route('user.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-2xl transition {{ request()->is('user/dashboard') || request()->is('dashboard') ? 'bg-emerald-50 text-emerald-800 font-extrabold border-r-4 border-emerald-600 shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                        <i class="fa-solid fa-chart-pie text-sm text-emerald-600"></i>
                        <span>Dashboard Rekap</span>
                    </a>
                </div>

                <!-- GROUP 2: TRANSACTIONS -->
                <div class="space-y-1">
                    <div class="px-3 py-1 text-[10px] font-extrabold text-slate-400 uppercase tracking-wider font-mono">Pencatatan Kas</div>

                    <a href="{{ route('user.income') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-2xl transition {{ request()->is('user/income*') ? 'bg-emerald-50 text-emerald-800 font-extrabold border-r-4 border-emerald-600 shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                        <i class="fa-solid fa-hand-holding-dollar text-sm text-emerald-600"></i>
                        <span>Catat Pemasukan</span>
                    </a>

                    <a href="{{ route('user.expenses') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-2xl transition {{ request()->is('user/expenses*') ? 'bg-rose-50 text-rose-800 font-extrabold border-r-4 border-rose-600 shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                        <i class="fa-solid fa-receipt text-sm text-rose-600"></i>
                        <span>Catat Pengeluaran</span>
                    </a>
                </div>

                <!-- GROUP 3: GOALS & BUDGETING (MODUL BARU) -->
                <div class="space-y-1">
                    <div class="px-3 py-1 text-[10px] font-extrabold text-slate-400 uppercase tracking-wider font-mono">Perencanaan</div>

                    <a href="{{ route('user.categories') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-2xl transition {{ request()->is('user/categories*') ? 'bg-amber-50 text-amber-900 font-extrabold border-r-4 border-amber-500 shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                        <i class="fa-solid fa-sliders text-sm text-amber-600"></i>
                        <span>Kategori & % Budget</span>
                    </a>

                    <a href="{{ route('user.goals') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-2xl transition {{ request()->is('user/goals*') ? 'bg-purple-50 text-purple-900 font-extrabold border-r-4 border-purple-600 shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                        <i class="fa-solid fa-bullseye text-sm text-purple-600"></i>
                        <span>Target Tabungan & Goals</span>
                    </a>
                </div>

                <!-- GROUP 4: RECONCILIATION (MODUL BARU) -->
                <div class="space-y-1">
                    <div class="px-3 py-1 text-[10px] font-extrabold text-slate-400 uppercase tracking-wider font-mono">Audit Selisih</div>

                    <a href="{{ route('user.reconciliation') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-2xl transition {{ request()->is('user/reconciliation*') ? 'bg-indigo-50 text-indigo-900 font-extrabold border-r-4 border-indigo-600 shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                        <i class="fa-solid fa-scale-balanced text-sm text-indigo-600"></i>
                        <span>Rekonsiliasi Kas</span>
                    </a>
                </div>

                <!-- GROUP 5: REPORTS -->
                <div class="space-y-1">
                    <div class="px-3 py-1 text-[10px] font-extrabold text-slate-400 uppercase tracking-wider font-mono">Laporan</div>

                    <a href="{{ route('user.reports') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-2xl transition {{ request()->is('user/reports*') ? 'bg-sky-50 text-sky-800 font-extrabold border-r-4 border-sky-600 shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                        <i class="fa-solid fa-file-invoice-dollar text-sm text-sky-600"></i>
                        <span>Cetak Laporan PDF</span>
                    </a>
                </div>
            </nav>
        </div>

        <!-- Sidebar Footer -->
        <div class="p-3 border-t border-slate-100">
            <a href="{{ url('/') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-2xl text-xs text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition">
                <i class="fa-solid fa-globe text-slate-400 text-xs"></i>
                <span>Halaman Depan</span>
            </a>
        </div>
    </aside>

    <!-- AREA KONTEN UTAMA WORKSPACE -->
    <div class="flex-1 flex flex-col min-w-0">
        
        <!-- STICKY TOP HEADER BAR -->
        <header class="h-16 bg-white/80 backdrop-blur-md border-b border-slate-200/80 px-6 flex items-center justify-between gap-4 sticky top-0 z-30 print:hidden shadow-xs">
            <!-- Breadcrumb Navigation -->
            <div class="flex items-center gap-2 text-xs text-slate-500 font-semibold">
                <span>Workspace</span>
                <i class="fa-solid fa-chevron-right text-[9px] text-slate-300"></i>
                <span class="text-slate-900 font-extrabold">
                    @if(request()->is('user/dashboard')) Dashboard Rekap
                    @elseif(request()->is('user/income*')) Catat Pemasukan
                    @elseif(request()->is('user/expenses*')) Catat Pengeluaran
                    @elseif(request()->is('user/categories*')) Kategori & Budget
                    @elseif(request()->is('user/goals*')) Target Tabungan & Goals
                    @elseif(request()->is('user/reconciliation*')) Rekonsiliasi & Audit Kas
                    @elseif(request()->is('user/reports*')) Cetak Laporan PDF
                    @else Workspace
                    @endif
                </span>
            </div>

            <!-- Profile & Logout Controls -->
            <div class="flex items-center gap-3 ml-auto">
                @auth
                    <div class="flex items-center gap-3 pl-3 border-l border-slate-200">
                        <div class="w-9 h-9 rounded-2xl bg-emerald-100 border border-emerald-200 flex items-center justify-center text-xs font-bold text-emerald-800 uppercase shadow-xs">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="hidden sm:flex flex-col text-left">
                            <span class="text-xs font-extrabold text-slate-900 leading-none">{{ Auth::user()->name }}</span>
                            <span class="text-[10px] text-emerald-600 font-bold leading-none mt-1">Pengguna Akun</span>
                        </div>

                        <!-- Form Logout -->
                        <form method="POST" action="{{ route('logout') }}" class="inline ml-1">
                            @csrf
                            <button type="submit" title="Keluar Akun" class="w-9 h-9 rounded-2xl bg-slate-100 border border-slate-200 hover:bg-rose-50 hover:border-rose-200 text-slate-500 hover:text-rose-600 flex items-center justify-center transition shadow-xs">
                                <i class="fa-solid fa-right-from-bracket text-xs"></i>
                            </button>
                        </form>
                    </div>
                @endauth
            </div>
        </header>

        <!-- KONTEN HALAMAN UTAMA -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-7xl w-full mx-auto space-y-6">
            @yield('user-content')
        </main>
    </div>
</div>
@endsection
