<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#09090b] text-zinc-100 antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'CashMind — Financial Management System' }}</title>

    <!-- Google Fonts: Plus Jakarta Sans & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Tailwind CSS & Alpine.js CDN -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'Inter', 'sans-serif'],
                        mono: ['JetBrains Mono', 'Menlo', 'monospace'],
                    },
                    colors: {
                        zinc: {
                            950: '#09090b',
                            900: '#12131c',
                            850: '#181926',
                            800: '#27272a',
                            700: '#3f3f46',
                            400: '#a1a1aa',
                            500: '#71717a',
                        },
                        brand: {
                            50: '#ecfdf5',
                            500: '#10b981',
                            600: '#059669',
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
        ::-webkit-scrollbar-track { background: #09090b; }
        ::-webkit-scrollbar-thumb { background: #27272a; border-radius: 9999px; }
        ::-webkit-scrollbar-thumb:hover { background: #3f3f46; }
        
        /* SaaS Card & Button Custom Styles */
        .saas-card {
            background-color: rgba(18, 19, 28, 0.6);
            border: 1px solid rgba(39, 39, 42, 0.8);
            border-radius: 0.875rem;
            backdrop-filter: blur(12px);
        }
        .saas-input {
            background-color: #12131c;
            border: 1px solid #27272a;
            color: #f4f4f5;
            border-radius: 0.625rem;
            padding: 0.5rem 0.75rem;
            font-size: 0.75rem;
            transition: all 0.15s ease;
        }
        .saas-input:focus {
            outline: none;
            border-color: #10b981;
            box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.2);
        }
        .saas-btn-primary {
            background-color: #10b981;
            color: #09090b;
            font-weight: 700;
            border-radius: 0.625rem;
            padding: 0.5rem 1rem;
            font-size: 0.75rem;
            transition: all 0.15s ease;
        }
        .saas-btn-primary:hover {
            background-color: #34d399;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
        }
        .saas-btn-secondary {
            background-color: #181926;
            border: 1px solid #27272a;
            color: #d4d4d8;
            font-weight: 600;
            border-radius: 0.625rem;
            padding: 0.5rem 1rem;
            font-size: 0.75rem;
            transition: all 0.15s ease;
        }
        .saas-btn-secondary:hover {
            background-color: #27272a;
            color: #ffffff;
        }
    </style>
</head>
<body class="h-full bg-[#09090b] text-zinc-100 font-sans antialiased selection:bg-emerald-500 selection:text-zinc-950">
    {{ $slot ?? '' }}
    @yield('content')
</body>
</html>
