<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#F4F6F8] text-[#101828] antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'CashMind | Private Personal Financial Management' }}</title>

    <!-- Google Fonts: Manrope -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Tailwind CSS & Alpine.js CDN -->
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
                            bgSoft: '#F8FAFB',
                            surface: '#FFFFFF',
                            text: '#101828',
                            textSecondary: '#475467',
                            textMuted: '#667085',
                            border: '#E4E7EC',
                            borderSoft: '#EAECF0',
                            primary: '#0F172A',
                            primaryHover: '#1E293B',
                            accent: '#0F766E',
                            accentSoft: '#F0FDFA',
                            accentBorder: '#99F6E4',
                            income: '#15803D',
                            incomeSoft: '#F0FDF4',
                            expense: '#B42318',
                            expenseSoft: '#FEF3F2',
                            warning: '#B54708',
                            warningSoft: '#FFFAEB',
                        }
                    }
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        [x-cloak] { display: none !important; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #F4F6F8; }
        ::-webkit-scrollbar-thumb { background: #D0D5DD; border-radius: 9999px; }
        ::-webkit-scrollbar-thumb:hover { background: #98A2B3; }
        
        .financial-number {
            font-variant-numeric: tabular-nums;
            letter-spacing: -0.01em;
        }

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
        @media (max-width: 768px) {
            .cm-input {
                height: 48px;
            }
        }
        .cm-input:focus {
            outline: none;
            border-color: #0F766E;
            box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.12);
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
        .btn-secondary:hover {
            background-color: #F9FAFB;
            color: #101828;
        }
    </style>
</head>
<body class="h-full bg-[#F4F6F8] text-[#101828] font-sans antialiased selection:bg-[#0F766E] selection:text-white">
    {{ $slot ?? '' }}
    @yield('content')
</body>
</html>
