@extends('layouts.app')

@section('content')
<!-- Komentar Bahasa Indonesia: Layout Admin Console Floating Curved Sidebar -->
<div class="min-h-screen flex flex-col md:flex-row bg-slate-50">
    
    <!-- FLOATING CURVED LEFT SIDEBAR ADMIN -->
    <aside class="w-full md:w-64 bg-white/95 border border-slate-200/80 rounded-3xl m-3 sm:m-4 flex flex-col justify-between shrink-0 print:hidden z-20 shadow-lg backdrop-blur-md">
        <div>
            <!-- Brand Logo & Admin Badge -->
            <div class="p-5 border-b border-slate-100 space-y-4">
                <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-amber-600 to-yellow-500 text-white flex items-center justify-center font-bold text-lg shadow-md group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <div>
                        <span class="text-lg font-extrabold tracking-tight text-slate-900 block leading-none">CashMind</span>
                        <span class="text-[10px] text-amber-600 font-mono font-extrabold block mt-1 uppercase tracking-wider">Admin Console</span>
                    </div>
                </a>

                <div class="p-2.5 rounded-2xl bg-amber-50 border border-amber-200 text-xs flex items-center gap-2.5 shadow-xs">
                    <div class="w-6 h-6 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center font-bold text-[10px] shrink-0">
                        <i class="fa-solid fa-user-shield"></i>
                    </div>
                    <div class="truncate">
                        <span class="text-xs font-bold text-slate-900 block truncate">{{ Auth::user()->name ?? 'Administrator' }}</span>
                        <span class="text-[10px] text-amber-700 font-mono block font-bold">Super Admin</span>
                    </div>
                </div>
            </div>

            <!-- CURVED MENU ITEMS ADMIN -->
            <nav class="p-3 space-y-4 text-xs font-bold">
                
                <!-- GROUP 1: MONITORING -->
                <div class="space-y-1">
                    <div class="px-3 py-1 text-[10px] font-extrabold text-slate-400 uppercase tracking-wider font-mono">Monitoring</div>
                    
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-2xl transition {{ request()->is('admin/dashboard') ? 'bg-amber-50 text-amber-900 font-extrabold border-r-4 border-amber-500 shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                        <i class="fa-solid fa-chart-line text-sm text-amber-600"></i>
                        <span>Trafik & Analytics</span>
                    </a>
                </div>

                <!-- GROUP 2: USER DIRECTORY -->
                <div class="space-y-1">
                    <div class="px-3 py-1 text-[10px] font-extrabold text-slate-400 uppercase tracking-wider font-mono">Direktori</div>

                    <a href="{{ route('admin.users') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-2xl transition {{ request()->is('admin/users*') ? 'bg-amber-50 text-amber-900 font-extrabold border-r-4 border-amber-500 shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                        <i class="fa-solid fa-users-gear text-sm text-amber-600"></i>
                        <span>Direktori User</span>
                    </a>
                </div>

                <!-- GROUP 3: SYSTEM AUDIT -->
                <div class="space-y-1">
                    <div class="px-3 py-1 text-[10px] font-extrabold text-slate-400 uppercase tracking-wider font-mono">System Audit</div>

                    <a href="{{ route('admin.logs') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-2xl transition {{ request()->is('admin/logs*') ? 'bg-amber-50 text-amber-900 font-extrabold border-r-4 border-amber-500 shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                        <i class="fa-solid fa-clock-rotate-left text-sm text-amber-600"></i>
                        <span>Audit Log Aktivitas</span>
                    </a>
                </div>
            </nav>
        </div>

        <!-- Footer Sidebar Admin -->
        <div class="p-3 border-t border-slate-100">
            <a href="{{ url('/') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-2xl text-xs text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition">
                <i class="fa-solid fa-globe text-slate-400 text-xs"></i>
                <span>Halaman Depan</span>
            </a>
        </div>
    </aside>

    <!-- AREA KONTEN UTAMA ADMIN -->
    <div class="flex-1 flex flex-col min-w-0">
        
        <!-- STICKY TOP HEADER BAR ADMIN -->
        <header class="h-16 bg-white/80 backdrop-blur-md border-b border-slate-200/80 px-6 flex items-center justify-between gap-4 sticky top-0 z-30 print:hidden shadow-xs">
            <!-- Breadcrumb Navigation -->
            <div class="flex items-center gap-2 text-xs text-slate-500 font-semibold">
                <span>Admin Console</span>
                <i class="fa-solid fa-chevron-right text-[9px] text-slate-300"></i>
                <span class="text-slate-900 font-extrabold">
                    @if(request()->is('admin/dashboard')) Trafik & Analytics
                    @elseif(request()->is('admin/users*')) Direktori User
                    @elseif(request()->is('admin/logs*')) Audit Log Aktivitas
                    @else Workspace Admin
                    @endif
                </span>
            </div>

            <!-- Profile & Logout Controls -->
            <div class="flex items-center gap-3 ml-auto">
                <div class="px-3 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 text-[11px] font-mono font-bold flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>System Active</span>
                </div>

                @auth
                    <div class="flex items-center gap-3 pl-3 border-l border-slate-200">
                        <div class="w-9 h-9 rounded-2xl bg-amber-100 border border-amber-200 flex items-center justify-center text-xs font-bold text-amber-800 uppercase shadow-xs">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="hidden sm:flex flex-col text-left">
                            <span class="text-xs font-extrabold text-slate-900 leading-none">{{ Auth::user()->name }}</span>
                            <span class="text-[10px] text-amber-600 font-bold leading-none mt-1">Super Admin</span>
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

        <!-- KONTEN HALAMAN UTAMA ADMIN -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-7xl w-full mx-auto space-y-6">
            @yield('admin-content')
        </main>
    </div>
</div>
@endsection
