@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col md:flex-row">
    
    <!-- ADMIN LEFT SIDEBAR MENU -->
    <aside class="w-full md:w-64 bg-[#0f172a] border-r border-slate-800/80 flex flex-col justify-between shrink-0 print:hidden">
        <div>
            <!-- Sidebar Header -->
            <div class="h-16 px-6 flex items-center justify-between border-b border-slate-800/80">
                <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-amber-500 to-orange-400 flex items-center justify-center shadow-lg shadow-amber-500/20 group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-shield-halved text-slate-950 text-lg font-bold"></i>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-lg font-extrabold tracking-tight bg-gradient-to-r from-white via-slate-200 to-amber-400 bg-clip-text text-transparent">CashMind</span>
                        <span class="text-[9px] font-medium text-amber-400 uppercase tracking-widest -mt-1">Admin Console</span>
                    </div>
                </a>
            </div>

            <!-- Role Badge -->
            <div class="px-4 py-3 m-4 rounded-2xl bg-amber-500/10 border border-amber-500/30 text-amber-300 text-xs font-semibold flex items-center gap-2.5">
                <span class="w-2.5 h-2.5 rounded-full bg-amber-400 animate-ping"></span>
                <div class="flex flex-col">
                    <span class="text-[10px] text-slate-400 uppercase tracking-wider font-bold">Console Mode</span>
                    <span class="font-extrabold text-white">Super Administrator</span>
                </div>
            </div>

            <!-- ADMIN NAVIGATION LINKS -->
            <nav class="px-3 space-y-1 text-xs font-semibold">
                <div class="px-3 py-2 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Navigasi Admin</div>

                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl transition {{ request()->is('admin/dashboard') ? 'bg-amber-500/10 text-amber-400 font-bold border-r-4 border-amber-500' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                    <i class="fa-solid fa-chart-line text-sm"></i>
                    <span>Trafik Platform & Analytics</span>
                </a>

                <a href="{{ route('admin.users') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl transition {{ request()->is('admin/users*') ? 'bg-amber-500/10 text-amber-400 font-bold border-r-4 border-amber-500' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                    <i class="fa-solid fa-users-gear text-sm"></i>
                    <span>Direktori & Detail User</span>
                </a>

                <a href="{{ route('admin.logs') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl transition {{ request()->is('admin/logs*') ? 'bg-amber-500/10 text-amber-400 font-bold border-r-4 border-amber-500' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                    <i class="fa-solid fa-clock-rotate-left text-sm"></i>
                    <span>Aktivitas & Audit Trail</span>
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
                <input type="text" placeholder="Cari user / log aktivitas..." class="w-full bg-slate-900 text-white text-xs pl-9 pr-4 py-2 rounded-xl border border-slate-800 focus:outline-none focus:ring-2 focus:ring-amber-500">
            </div>

            <div class="flex items-center gap-4 ml-auto">
                <div class="px-3 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs font-bold flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Server: Healthy</span>
                </div>

                @auth
                    <div class="flex items-center gap-3 pl-3 border-l border-slate-800">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-amber-600 to-orange-500 flex items-center justify-center text-xs font-bold text-slate-950 shadow-inner uppercase">
                            {{ substr(Auth::user()->name, 0, 2) }}
                        </div>
                        <div class="hidden sm:flex flex-col text-left">
                            <span class="text-xs font-bold text-slate-200">{{ Auth::user()->name }}</span>
                            <span class="text-[10px] text-amber-400 font-semibold uppercase">Super Admin</span>
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
            @yield('admin-content')
        </main>
    </div>
</div>
@endsection
