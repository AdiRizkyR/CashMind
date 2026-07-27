@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col md:flex-row">
    
    <!-- USER LEFT SIDEBAR MENU -->
    <aside class="w-full md:w-64 bg-[#0f172a] border-r border-slate-800/80 flex flex-col justify-between shrink-0 print:hidden">
        <div>
            <!-- Sidebar Header -->
            <div class="h-16 px-6 flex items-center justify-between border-b border-slate-800/80">
                <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-emerald-500 to-teal-400 flex items-center justify-center shadow-lg shadow-emerald-500/20 group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-wallet text-slate-950 text-lg font-bold"></i>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-lg font-extrabold tracking-tight bg-gradient-to-r from-white via-slate-200 to-emerald-400 bg-clip-text text-transparent">CashMind</span>
                        <span class="text-[9px] font-medium text-slate-400 uppercase tracking-widest -mt-1">Keuangan 2026</span>
                    </div>
                </a>
            </div>

            <!-- Role Badge -->
            <div class="px-4 py-3 m-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 text-xs font-semibold flex items-center gap-2.5">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-ping"></span>
                <div class="flex flex-col">
                    <span class="text-[10px] text-slate-400 uppercase tracking-wider font-bold">Console Mode</span>
                    <span class="font-extrabold text-white">User Personal</span>
                </div>
            </div>

            <!-- USER NAVIGATION LINKS -->
            <nav class="px-3 space-y-1 text-xs font-semibold">
                <div class="px-3 py-2 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Navigasi User</div>

                <a href="{{ route('user.dashboard') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl transition {{ request()->is('user/dashboard') || request()->is('dashboard') ? 'bg-emerald-500/10 text-emerald-400 font-bold border-r-4 border-emerald-500' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                    <i class="fa-solid fa-chart-pie text-sm"></i>
                    <span>Dashboard Rekap</span>
                </a>

                <a href="{{ route('user.income') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl transition {{ request()->is('user/income*') ? 'bg-emerald-500/10 text-emerald-400 font-bold border-r-4 border-emerald-500' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                    <i class="fa-solid fa-hand-holding-dollar text-sm"></i>
                    <span>Catat Pemasukan</span>
                </a>

                <a href="{{ route('user.expenses') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl transition {{ request()->is('user/expenses*') ? 'bg-emerald-500/10 text-emerald-400 font-bold border-r-4 border-emerald-500' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                    <i class="fa-solid fa-receipt text-sm"></i>
                    <span>Catat Pengeluaran</span>
                </a>

                <a href="{{ route('user.categories') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl transition {{ request()->is('user/categories*') ? 'bg-emerald-500/10 text-emerald-400 font-bold border-r-4 border-emerald-500' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                    <i class="fa-solid fa-sliders text-sm"></i>
                    <span>Atur Kategori & % Budget</span>
                </a>

                <a href="{{ route('user.reports') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl transition {{ request()->is('user/reports*') ? 'bg-emerald-500/10 text-emerald-400 font-bold border-r-4 border-emerald-500' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                    <i class="fa-solid fa-file-invoice-dollar text-sm"></i>
                    <span>Cetak Laporan PDF</span>
                </a>
            </nav>
        </div>

        <!-- Sidebar Footer Link -->
        <div class="p-4 border-t border-slate-800/80">
            <a href="{{ url('/') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold text-slate-400 hover:text-white hover:bg-slate-800/60 transition">
                <i class="fa-solid fa-house text-slate-500"></i>
                <span>Ke Landing Page</span>
            </a>
        </div>
    </aside>

    <!-- RIGHT CONTENT AREA -->
    <div class="flex-1 flex flex-col min-w-0">
        <!-- TOP HEADER -->
        <header class="h-16 bg-[#111827]/90 backdrop-blur-md border-b border-slate-800/80 px-6 flex items-center justify-between gap-4 sticky top-0 z-30 print:hidden">
            <div class="relative w-64 hidden sm:block">
                <i class="fa-solid fa-magnifying-glass text-xs text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                <input type="text" placeholder="Cari transaksi / pemasukan..." class="w-full bg-slate-900 text-white text-xs pl-9 pr-4 py-2 rounded-xl border border-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>

            <div class="flex items-center gap-4 ml-auto">
                <button class="w-9 h-9 rounded-xl bg-slate-800 hover:bg-slate-750 text-slate-300 flex items-center justify-center transition relative">
                    <i class="fa-solid fa-bell text-xs"></i>
                    <span class="w-2 h-2 rounded-full bg-emerald-400 absolute top-2 right-2 animate-ping"></span>
                </button>

                @auth
                    <div class="flex items-center gap-3 pl-3 border-l border-slate-800">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-emerald-600 to-teal-500 flex items-center justify-center text-xs font-bold text-white shadow-inner uppercase">
                            {{ substr(Auth::user()->name, 0, 2) }}
                        </div>
                        <div class="hidden sm:flex flex-col text-left">
                            <span class="text-xs font-bold text-slate-200">{{ Auth::user()->name }}</span>
                            <span class="text-[10px] text-emerald-400 font-semibold uppercase">Personal User</span>
                        </div>

                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" title="Keluar" class="w-9 h-9 rounded-xl bg-slate-800 hover:bg-rose-500/20 text-slate-400 hover:text-rose-400 flex items-center justify-center transition border border-slate-700/60 ml-1">
                                <i class="fa-solid fa-right-from-bracket text-xs"></i>
                            </button>
                        </form>
                    </div>
                @endauth
            </div>
        </header>

        <!-- MAIN PAGE CONTENT -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8">
            @yield('user-content')
        </main>
    </div>
</div>
@endsection
