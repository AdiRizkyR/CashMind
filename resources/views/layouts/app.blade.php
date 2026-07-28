<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50 text-slate-900 antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'CashMind — Horizon Financial System' }}</title>

    <!-- Google Fonts: Plus Jakarta Sans & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- FontAwesome Icon CDN -->
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
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    },
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        [x-cloak] { display: none !important; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f8fafc; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9999px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        
        /* Horizon Slate UI Design Tokens */
        .horizon-card {
            background-color: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(226, 232, 240, 0.9);
            border-radius: 1.5rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.04), 0 8px 10px -6px rgba(0, 0, 0, 0.02);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .horizon-card:hover {
            box-shadow: 0 20px 30px -10px rgba(0, 0, 0, 0.07);
            border-color: #cbd5e1;
        }
        .horizon-input {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            color: #0f172a;
            border-radius: 1rem;
            padding: 0.625rem 1rem;
            font-size: 0.8125rem;
            transition: all 0.2s ease;
        }
        .horizon-input:focus {
            outline: none;
            background-color: #ffffff;
            border-color: #059669;
            box-shadow: 0 0 0 4px rgba(5, 150, 105, 0.12);
        }
        .horizon-btn-primary {
            background: linear-gradient(135deg, #059669 0%, #0d9488 100%);
            color: #ffffff;
            font-weight: 700;
            border-radius: 1rem;
            padding: 0.625rem 1.25rem;
            font-size: 0.8125rem;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            box-shadow: 0 4px 14px rgba(5, 150, 105, 0.25);
        }
        .horizon-btn-primary:hover {
            background: linear-gradient(135deg, #047857 0%, #0f766e 100%);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(5, 150, 105, 0.35);
        }
        .horizon-btn-secondary {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            color: #334155;
            font-weight: 700;
            border-radius: 1rem;
            padding: 0.625rem 1.25rem;
            font-size: 0.8125rem;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.03);
        }
        .horizon-btn-secondary:hover {
            background-color: #f8fafc;
            border-color: #cbd5e1;
            color: #0f172a;
        }
    </style>
</head>
<body class="h-full bg-slate-50 text-slate-900 font-sans antialiased selection:bg-emerald-500 selection:text-white">
    <!-- Komentar Bahasa Indonesia: Layout Master Horizon Slate System -->
    {{ $slot ?? '' }}
    @yield('content')
</body>
</html>
