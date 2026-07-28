@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col md:flex-row bg-[#09090b]">
    
    <!-- SAAS SLIM LEFT SIDEBAR (ADMIN CONSOLE) -->
    <aside class="w-full md:w-60 bg-[#0c0d12] border-r border-zinc-800/70 flex flex-col justify-between shrink-0 print:hidden z-20">
        <div>
            <!-- Brand Logo Header -->
            <div class="h-14 px-5 flex items-center justify-between border-b border-zinc-800/70">
                <a href="{{ url('/') }}" class="flex items-center gap-2.5 group">
                    <div class="w-7 h-7 rounded-lg bg-amber-500/10 border border-amber-500/30 flex items-center justify-center text-amber-400 font-bold text-xs group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <div class="flex items-baseline gap-1.5">
                        <span class="text-sm font-extrabold tracking-tight text-zinc-100">CashMind</span>
                        <span class="text-[9px] font-mono text-amber-400 uppercase tracking-widest">Admin</span>
                    </div>
                </a>
            </div>

            <!-- Workspace Context Indicator -->
            <div class="px-3 py-2.5 m-3 rounded-xl bg-amber-500/5 border border-amber-500/20 text-xs flex items-center gap-2.5">
                <div class="w-6 h-6 rounded-lg bg-amber-500/20 text-amber-400 flex items-center justify-center font-bold text-[10px]">
                    <i class="fa-solid fa-user-shield"></i>
                </div>
                <div class="flex flex-col min-w-0">
                    <span class="text-[11px] font-semibold text-zinc-200 truncate">{{ Auth::user()->name ?? 'Administrator' }}</span>
                    <span class="text-[9px] text-amber-400 font-mono truncate">Super Administrator</span>
                </div>
            </div>

            <!-- SIDEBAR NAVIGATION MENU GROUPS -->
            <nav class="px-2 space-y-4 text-xs font-medium pt-1">
                
                <!-- GROUP 1: OVERVIEW -->
                <div class="space-y-1">
                    <div class="px-3 py-1 text-[10px] font-bold text-zinc-500 uppercase tracking-wider font-mono">Overview</div>
                    
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition {{ request()->is('admin/dashboard') ? 'bg-zinc-800/80 text-zinc-100 font-semibold border-l-2 border-amber-500' : 'text-zinc-400 hover:text-zinc-200 hover:bg-zinc-900/50' }}">
                        <i class="fa-solid fa-chart-line text-xs text-zinc-400"></i>
                        <span>Trafik & Analytics</span>
                    </a>
                </div>

                <!-- GROUP 2: USER MANAGEMENT -->
                <div class="space-y-1">
                    <div class="px-3 py-1 text-[10px] font-bold text-zinc-500 uppercase tracking-wider font-mono">Management</div>

                    <a href="{{ route('admin.users') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition {{ request()->is('admin/users*') ? 'bg-zinc-800/80 text-zinc-100 font-semibold border-l-2 border-amber-500' : 'text-zinc-400 hover:text-zinc-200 hover:bg-zinc-900/50' }}">
                        <i class="fa-solid fa-users-gear text-xs text-zinc-400"></i>
                        <span>Direktori User</span>
                    </a>
                </div>

                <!-- GROUP 3: SYSTEM AUDIT -->
                <div class="space-y-1">
                    <div class="px-3 py-1 text-[10px] font-bold text-zinc-500 uppercase tracking-wider font-mono">System</div>

                    <a href="{{ route('admin.logs') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition {{ request()->is('admin/logs*') ? 'bg-zinc-800/80 text-zinc-100 font-semibold border-l-2 border-amber-500' : 'text-zinc-400 hover:text-zinc-200 hover:bg-zinc-900/50' }}">
                        <i class="fa-solid fa-clock-rotate-left text-xs text-zinc-400"></i>
                        <span>Audit Log Aktivitas</span>
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
                <span class="text-zinc-500">Admin Console</span>
                <i class="fa-solid fa-chevron-right text-[9px] text-zinc-600"></i>
                <span class="text-zinc-200 font-medium">
                    @if(request()->is('admin/dashboard')) Analytics
                    @elseif(request()->is('admin/users*')) User Directory
                    @elseif(request()->is('admin/logs*')) Audit Trail
                    @else Workspace
                    @endif
                </span>
            </div>

            <!-- Right Controls -->
            <div class="flex items-center gap-3 ml-auto">
                <div class="px-2.5 py-1 rounded-md bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-[11px] font-mono flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Server OK</span>
                </div>

                <!-- User Profile & Logout -->
                @auth
                    <div class="flex items-center gap-2.5 pl-3 border-l border-zinc-800">
                        <div class="w-7 h-7 rounded-full bg-amber-500/20 border border-amber-500/30 flex items-center justify-center text-xs font-bold text-amber-400 uppercase">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="hidden sm:flex flex-col text-left">
                            <span class="text-xs font-semibold text-zinc-200 leading-none">{{ Auth::user()->name }}</span>
                            <span class="text-[10px] text-amber-400 leading-none mt-1">Super Admin</span>
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
            @yield('admin-content')
        </main>
    </div>
</div>
@endsection
