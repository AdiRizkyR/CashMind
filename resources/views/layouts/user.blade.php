@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col md:flex-row bg-[#09090b]">
    
    <!-- SAAS SLIM LEFT SIDEBAR -->
    <aside class="w-full md:w-60 bg-[#0c0d12] border-r border-zinc-800/70 flex flex-col justify-between shrink-0 print:hidden z-20">
        <div>
            <!-- Brand Logo Header -->
            <div class="h-14 px-5 flex items-center justify-between border-b border-zinc-800/70">
                <a href="{{ url('/') }}" class="flex items-center gap-2.5 group">
                    <div class="w-7 h-7 rounded-lg bg-emerald-500/10 border border-emerald-500/30 flex items-center justify-center text-emerald-400 font-bold text-xs group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                    <div class="flex items-baseline gap-1.5">
                        <span class="text-sm font-extrabold tracking-tight text-zinc-100">CashMind</span>
                        <span class="text-[9px] font-mono text-zinc-500 uppercase tracking-widest">v2.0</span>
                    </div>
                </a>
            </div>

            <!-- Workspace Context Indicator -->
            <div class="px-3 py-2.5 m-3 rounded-xl bg-zinc-900/60 border border-zinc-800/80 text-xs flex items-center gap-2.5">
                <div class="w-6 h-6 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-bold text-[10px]">
                    {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                </div>
                <div class="flex flex-col min-w-0">
                    <span class="text-[11px] font-semibold text-zinc-200 truncate">{{ Auth::user()->name ?? 'Personal User' }}</span>
                    <span class="text-[9px] text-zinc-500 truncate">Personal Workspace</span>
                </div>
            </div>

            <!-- SIDEBAR NAVIGATION MENU GROUPS -->
            <nav class="px-2 space-y-4 text-xs font-medium pt-1">
                
                <!-- GROUP 1: OVERVIEW -->
                <div class="space-y-1">
                    <div class="px-3 py-1 text-[10px] font-bold text-zinc-500 uppercase tracking-wider font-mono">Overview</div>
                    
                    <a href="{{ route('user.dashboard') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition {{ request()->is('user/dashboard') || request()->is('dashboard') ? 'bg-zinc-800/80 text-zinc-100 font-semibold border-l-2 border-emerald-500' : 'text-zinc-400 hover:text-zinc-200 hover:bg-zinc-900/50' }}">
                        <i class="fa-solid fa-chart-pie text-xs text-zinc-400"></i>
                        <span>Dashboard</span>
                    </a>
                </div>

                <!-- GROUP 2: TRANSACTIONS -->
                <div class="space-y-1">
                    <div class="px-3 py-1 text-[10px] font-bold text-zinc-500 uppercase tracking-wider font-mono">Transactions</div>

                    <a href="{{ route('user.income') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition {{ request()->is('user/income*') ? 'bg-zinc-800/80 text-zinc-100 font-semibold border-l-2 border-emerald-500' : 'text-zinc-400 hover:text-zinc-200 hover:bg-zinc-900/50' }}">
                        <i class="fa-solid fa-arrow-down-left text-xs text-emerald-400"></i>
                        <span>Pemasukan</span>
                    </a>

                    <a href="{{ route('user.expenses') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition {{ request()->is('user/expenses*') ? 'bg-zinc-800/80 text-zinc-100 font-semibold border-l-2 border-emerald-500' : 'text-zinc-400 hover:text-zinc-200 hover:bg-zinc-900/50' }}">
                        <i class="fa-solid fa-arrow-up-right text-xs text-rose-400"></i>
                        <span>Pengeluaran</span>
                    </a>
                </div>

                <!-- GROUP 3: BUDGET & CATEGORIES -->
                <div class="space-y-1">
                    <div class="px-3 py-1 text-[10px] font-bold text-zinc-500 uppercase tracking-wider font-mono">Management</div>

                    <a href="{{ route('user.categories') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition {{ request()->is('user/categories*') ? 'bg-zinc-800/80 text-zinc-100 font-semibold border-l-2 border-emerald-500' : 'text-zinc-400 hover:text-zinc-200 hover:bg-zinc-900/50' }}">
                        <i class="fa-solid fa-sliders text-xs text-zinc-400"></i>
                        <span>Kategori & Budget</span>
                    </a>
                </div>

                <!-- GROUP 4: REPORTS -->
                <div class="space-y-1">
                    <div class="px-3 py-1 text-[10px] font-bold text-zinc-500 uppercase tracking-wider font-mono">Reports</div>

                    <a href="{{ route('user.reports') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition {{ request()->is('user/reports*') ? 'bg-zinc-800/80 text-zinc-100 font-semibold border-l-2 border-emerald-500' : 'text-zinc-400 hover:text-zinc-200 hover:bg-zinc-900/50' }}">
                        <i class="fa-solid fa-file-invoice-dollar text-xs text-zinc-400"></i>
                        <span>Laporan Keuangan</span>
                    </a>
                </div>
            </nav>
        </div>

        <!-- Sidebar Footer -->
        <div class="p-3 border-t border-zinc-800/70 space-y-1">
            <a href="{{ url('/') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg text-xs text-zinc-400 hover:text-zinc-200 hover:bg-zinc-900/50 transition">
                <i class="fa-solid fa-house text-zinc-500 text-xs"></i>
                <span>Landing Page</span>
            </a>
        </div>
    </aside>

    <!-- MAIN SAAS CONTENT AREA -->
    <div class="flex-1 flex flex-col min-w-0">
        
        <!-- STICKY TOP HEADER -->
        <header class="h-14 bg-[#0c0d12]/90 backdrop-blur-md border-b border-zinc-800/70 px-6 flex items-center justify-between gap-4 sticky top-0 z-30 print:hidden">
            <!-- Breadcrumb Navigation -->
            <div class="flex items-center gap-2 text-xs text-zinc-400">
                <span class="text-zinc-500">App</span>
                <i class="fa-solid fa-chevron-right text-[9px] text-zinc-600"></i>
                <span class="text-zinc-200 font-medium">
                    @if(request()->is('user/dashboard')) Dashboard
                    @elseif(request()->is('user/income*')) Pemasukan
                    @elseif(request()->is('user/expenses*')) Pengeluaran
                    @elseif(request()->is('user/categories*')) Kategori & Budget
                    @elseif(request()->is('user/reports*')) Laporan Keuangan
                    @else Workspace
                    @endif
                </span>
            </div>

            <!-- Right Controls: Command Bar Trigger & Profile Dropdown -->
            <div class="flex items-center gap-3 ml-auto">
                <!-- Search Trigger -->
                <button class="hidden sm:flex items-center gap-3 px-3 py-1.5 rounded-lg bg-zinc-900 border border-zinc-800 text-zinc-400 text-xs hover:border-zinc-700 transition">
                    <i class="fa-solid fa-magnifying-glass text-[10px]"></i>
                    <span class="text-[11px]">Cari data...</span>
                    <kbd class="px-1.5 py-0.5 rounded bg-zinc-800 text-[9px] text-zinc-400 font-mono">Ctrl K</kbd>
                </button>

                <!-- Notification Trigger -->
                <button class="w-8 h-8 rounded-lg bg-zinc-900 border border-zinc-800 hover:border-zinc-700 text-zinc-300 flex items-center justify-center transition relative">
                    <i class="fa-solid fa-bell text-xs"></i>
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 absolute top-2 right-2"></span>
                </button>

                <!-- User Profile & Logout -->
                @auth
                    <div class="flex items-center gap-2.5 pl-3 border-l border-zinc-800">
                        <div class="w-7 h-7 rounded-full bg-zinc-800 border border-zinc-700 flex items-center justify-center text-xs font-bold text-zinc-200 uppercase">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="hidden sm:flex flex-col text-left">
                            <span class="text-xs font-semibold text-zinc-200 leading-none">{{ Auth::user()->name }}</span>
                            <span class="text-[10px] text-zinc-500 leading-none mt-1">User Account</span>
                        </div>

                        <form method="POST" action="{{ route('logout') }}" class="inline ml-1">
                            @csrf
                            <button type="submit" title="Keluar" class="w-8 h-8 rounded-lg bg-zinc-900 border border-zinc-800 hover:bg-rose-500/10 hover:border-rose-500/30 text-zinc-400 hover:text-rose-400 flex items-center justify-center transition">
                                <i class="fa-solid fa-right-from-bracket text-xs"></i>
                            </button>
                        </form>
                    </div>
                @endauth
            </div>
        </header>

        <!-- PAGE CONTENT SLOT -->
        <main class="flex-1 p-5 sm:p-6 lg:p-8 max-w-7xl w-full mx-auto">
            @yield('user-content')
        </main>
    </div>
</div>
@endsection
