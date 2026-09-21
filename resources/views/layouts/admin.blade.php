<!DOCTYPE html>
<html lang="id" class="h-full bg-[#F4F6F8] text-[#101828] antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'CashMind | Platform Operations Console' }}</title>

    <!-- Google Fonts: Manrope -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Tailwind CSS & Alpine.js -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Manrope', 'Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        cm: {
                            bg: '#F4F6F8',
                            surface: '#FFFFFF',
                            text: '#101828',
                            border: '#E4E7EC',
                            primary: '#0F172A',
                            accent: '#0F766E',
                        }
                    }
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: #0F172A; }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 9999px; }
        
        .cm-panel {
            background-color: #FFFFFF;
            border: 1px solid #E4E7EC;
            border-radius: 16px;
        }
        
        .cm-input {
            background-color: #FFFFFF;
            border: 1px solid #D0D5DD;
            color: #101828;
            border-radius: 10px;
            padding: 0 14px;
            height: 44px;
            font-size: 0.875rem;
            width: 100%;
            transition: all 0.15s ease;
        }
        .cm-input:focus {
            outline: none;
            border-color: #0F766E;
            box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.10);
        }

        .btn-primary {
            background-color: #0F172A;
            color: #FFFFFF;
            font-weight: 600;
            border-radius: 10px;
            height: 42px;
            padding: 0 18px;
            font-size: 0.875rem;
            transition: all 0.15s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-primary:hover {
            background-color: #1E293B;
        }

        .btn-secondary {
            background-color: #FFFFFF;
            border: 1px solid #D0D5DD;
            color: #344054;
            font-weight: 600;
            border-radius: 10px;
            height: 42px;
            padding: 0 18px;
            font-size: 0.875rem;
            transition: all 0.15s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
    </style>
</head>
<body class="h-full bg-[#F4F6F8] text-[#101828] font-sans antialiased">
    <div class="min-h-screen flex">

        <!-- ADMIN SIDEBAR (Compact 72px) -->
        <aside class="w-[72px] bg-[#0F172A] text-slate-300 border-r border-slate-800 flex flex-col justify-between hidden md:flex fixed inset-y-0 z-30">
            <div class="flex flex-col items-center">
                <!-- Brand Logo Header -->
                <div class="h-16 w-full flex items-center justify-center border-b border-slate-800">
                    <a href="{{ route('admin.dashboard') }}" class="w-10 h-10 rounded-xl bg-[#0F766E] text-white flex items-center justify-center font-bold" title="Admin Operations">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    </a>
                </div>

                <!-- Navigation Links -->
                <nav class="py-6 space-y-4 w-full flex flex-col items-center">
                    <a href="{{ route('admin.dashboard') }}" class="relative w-12 h-12 rounded-xl flex items-center justify-center transition-colors group {{ request()->routeIs('admin.dashboard') ? 'bg-slate-800 text-amber-400 font-bold' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}" title="Ringkasan Sistem">
                        @if(request()->routeIs('admin.dashboard'))
                            <div class="absolute left-0 top-2 bottom-2 w-1 bg-[#0F766E] rounded-r-full"></div>
                        @endif
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/></svg>
                    </a>

                    <a href="{{ route('admin.users.index') }}" class="relative w-12 h-12 rounded-xl flex items-center justify-center transition-colors group {{ request()->routeIs('admin.users.*') ? 'bg-slate-800 text-amber-400 font-bold' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}" title="Manajemen Pengguna">
                        @if(request()->routeIs('admin.users.*'))
                            <div class="absolute left-0 top-2 bottom-2 w-1 bg-[#0F766E] rounded-r-full"></div>
                        @endif
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </a>

                    <a href="{{ route('admin.master.index') }}" class="relative w-12 h-12 rounded-xl flex items-center justify-center transition-colors group {{ request()->routeIs('admin.master.*') ? 'bg-slate-800 text-amber-400 font-bold' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}" title="Master Data">
                        @if(request()->routeIs('admin.master.*'))
                            <div class="absolute left-0 top-2 bottom-2 w-1 bg-[#0F766E] rounded-r-full"></div>
                        @endif
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/></svg>
                    </a>

                    <a href="{{ route('admin.features.index') }}" class="relative w-12 h-12 rounded-xl flex items-center justify-center transition-colors group {{ request()->routeIs('admin.features.*') ? 'bg-slate-800 text-amber-400 font-bold' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}" title="Fitur Platform">
                        @if(request()->routeIs('admin.features.*'))
                            <div class="absolute left-0 top-2 bottom-2 w-1 bg-[#0F766E] rounded-r-full"></div>
                        @endif
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                    </a>

                    <a href="{{ route('admin.logs.index') }}" class="relative w-12 h-12 rounded-xl flex items-center justify-center transition-colors group {{ request()->routeIs('admin.logs.*') ? 'bg-slate-800 text-amber-400 font-bold' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}" title="Log Keamanan">
                        @if(request()->routeIs('admin.logs.*'))
                            <div class="absolute left-0 top-2 bottom-2 w-1 bg-[#0F766E] rounded-r-full"></div>
                        @endif
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    </a>
                </nav>
            </div>

            <!-- Profile Footer -->
            <div class="p-3 flex flex-col items-center border-t border-slate-800 gap-3">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-10 h-10 rounded-xl flex items-center justify-center text-slate-400 hover:text-rose-400 hover:bg-slate-800 transition-colors" title="Keluar">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    </button>
                </form>
            </div>
        </aside>

        <!-- MAIN CONTAINER -->
        <div class="flex-1 md:ml-[72px] flex flex-col min-w-0">
            
            <!-- HEADER (68px) -->
            <header class="h-[68px] bg-white border-b border-[#EAECF0] px-4 md:px-8 flex items-center justify-between sticky top-0 z-20">
                <div class="flex items-center gap-3">
                    <span class="px-3 py-1 rounded-md bg-amber-50 border border-amber-200 text-amber-800 text-xs font-semibold flex items-center gap-1.5">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        <span>Admin Console</span>
                    </span>
                    <span class="text-xs text-[#667085] hidden sm:inline">| Manajemen Platform (Isolasi Data Finansial User)</span>
                </div>
            </header>

            <!-- FLASH NOTIFICATIONS -->
            <div class="px-4 md:px-8 pt-6">
                @if(session('success'))
                    <div class="p-4 rounded-xl bg-[#ECFDF3] border border-[#ABE5C6] text-[#15803D] text-xs font-semibold flex items-center justify-between shadow-xs">
                        <div class="flex items-center gap-2.5">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="p-4 rounded-xl bg-[#FEF3F2] border border-[#FECDCA] text-[#B42318] text-xs font-semibold space-y-1 shadow-xs">
                        <div class="flex items-center gap-2 mb-1">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            <span>Mohon periksa kembali inputan Anda:</span>
                        </div>
                        <ul class="list-disc list-inside text-xs font-normal pl-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <!-- MAIN CONTENT -->
            <main class="w-full max-w-[1360px] mx-auto p-4 md:p-8 flex-1">
                @yield('content')
            </main>
        </div>

    </div>
</body>
</html>
