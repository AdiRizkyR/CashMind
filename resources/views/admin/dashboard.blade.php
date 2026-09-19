@extends('layouts.admin')

@section('content')
<div class="space-y-6">

    <!-- PAGE HEADER (Guideline Section 73) -->
    <div>
        <h1 class="text-2xl font-extrabold text-[#0F172A] tracking-tight">Platform Overview</h1>
        <p class="text-[#667085] text-xs font-medium mt-1">Monitoring statistik pengguna, kesehatan sistem, dan log keamanan platform.</p>
    </div>

    <!-- 1. PLATFORM METRICS GRID -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Card 1: Total Pengguna -->
        <div class="cm-panel p-5 space-y-2">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-[#667085]">Total Pengguna</span>
                <div class="w-8 h-8 rounded-lg bg-[#F8FAFB] text-[#0F172A] flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
            <div class="text-2xl font-extrabold text-[#0F172A] financial-number">
                {{ number_format($totalUsers, 0, ',', '.') }}
            </div>
            <span class="text-[11px] text-[#98A2B3] font-medium block">Pengguna Terdaftar Platform</span>
        </div>

        <!-- Card 2: Pengguna Aktif -->
        <div class="cm-panel p-5 space-y-2">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-[#667085]">Pengguna Aktif</span>
                <div class="w-8 h-8 rounded-lg bg-[#F0FDF4] text-[#15803D] flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div class="text-2xl font-extrabold text-[#15803D] financial-number">
                {{ number_format($activeUsers, 0, ',', '.') }}
            </div>
            <span class="text-[11px] text-[#98A2B3] font-medium block">Akun Berstatus Aktif</span>
        </div>

        <!-- Card 3: Pengguna Baru (Bulan Ini) -->
        <div class="cm-panel p-5 space-y-2">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-[#667085]">Pengguna Baru (Bulan Ini)</span>
                <div class="w-8 h-8 rounded-lg bg-[#EFF8FF] text-[#175CD3] flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                </div>
            </div>
            <div class="text-2xl font-extrabold text-[#175CD3] financial-number">
                +{{ number_format($newUsersThisMonth, 0, ',', '.') }}
            </div>
            <span class="text-[11px] text-[#98A2B3] font-medium block">Registrasi Bulan Ini</span>
        </div>

        <!-- Card 4: Akun Dinonaktifkan -->
        <div class="cm-panel p-5 space-y-2">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-[#667085]">Akun Dinonaktifkan</span>
                <div class="w-8 h-8 rounded-lg bg-[#FEF3F2] text-[#B42318] flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                    </svg>
                </div>
            </div>
            <div class="text-2xl font-extrabold text-[#B42318] financial-number">
                {{ number_format($suspendedUsers, 0, ',', '.') }}
            </div>
            <span class="text-[11px] text-[#98A2B3] font-medium block">Akun Suspended</span>
        </div>
    </div>

    <!-- 2. USER GROWTH CHART & SYSTEM STATUS -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- User Growth Chart -->
        <div class="cm-panel p-5 lg:col-span-2 space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-base font-bold text-[#0F172A]">Pertumbuhan Pengguna</h2>
                    <p class="text-[#667085] text-xs font-medium">Tren pendaftaran user 6 bulan terakhir</p>
                </div>
            </div>
            <div class="h-64">
                <canvas id="userGrowthChart"></canvas>
            </div>
        </div>

        <!-- System Health Status -->
        <div class="cm-panel p-5 space-y-4">
            <h2 class="text-base font-bold text-[#0F172A] border-b border-[#EAECF0] pb-2">Status Sistem Platform</h2>

            <div class="space-y-2.5 text-xs">
                <div class="flex items-center justify-between p-2.5 rounded-lg bg-[#F8FAFB]">
                    <span class="text-[#667085] font-medium">Versi PHP</span>
                    <span class="font-bold text-[#0F172A] font-mono">{{ $systemStatus['php_version'] }}</span>
                </div>
                <div class="flex items-center justify-between p-2.5 rounded-lg bg-[#F8FAFB]">
                    <span class="text-[#667085] font-medium">Framework Laravel</span>
                    <span class="font-bold text-[#0F172A] font-mono">v{{ $systemStatus['laravel_version'] }}</span>
                </div>
                <div class="flex items-center justify-between p-2.5 rounded-lg bg-[#F8FAFB]">
                    <span class="text-[#667085] font-medium">Koneksi Database</span>
                    <span class="font-bold text-[#15803D] flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-[#15803D] animate-pulse"></span>
                        <span>{{ $systemStatus['database_status'] }}</span>
                    </span>
                </div>
                <div class="flex items-center justify-between p-2.5 rounded-lg bg-[#F8FAFB]">
                    <span class="text-[#667085] font-medium">Status Antrean (Queue)</span>
                    <span class="font-bold text-[#0F172A]">{{ $systemStatus['queue_status'] }}</span>
                </div>
            </div>
        </div>

    </div>

    <!-- 3. RECENT SECURITY LOGS -->
    <div class="cm-panel p-5 space-y-4">
        <div class="flex items-center justify-between border-b border-[#EAECF0] pb-3">
            <h2 class="text-base font-bold text-[#0F172A]">Log Keamanan Audit Terkini</h2>
            <a href="{{ route('admin.logs.index') }}" class="text-xs font-bold text-[#0F766E] hover:underline transition">
                Lihat Semua Log →
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="border-b border-[#E4E7EC] bg-[#F8FAFB] text-[10px] font-bold uppercase tracking-wider text-[#475467]">
                        <th class="py-2.5 px-3">Waktu</th>
                        <th class="py-2.5 px-3">Pengguna</th>
                        <th class="py-2.5 px-3">Event Keamanan</th>
                        <th class="py-2.5 px-3">IP Address</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#EAECF0]">
                    @forelse($recentSecurityLogs as $log)
                        <tr>
                            <td class="py-2.5 px-3 text-[#667085] whitespace-nowrap font-mono">{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                            <td class="py-2.5 px-3 font-bold text-[#0F172A]">{{ $log->user?->name ?? 'Guest / System' }}</td>
                            <td class="py-2.5 px-3 font-mono text-[#B54708] font-semibold">{{ $log->event }}</td>
                            <td class="py-2.5 px-3 text-[#667085] font-mono">{{ $log->ip_address }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-6 text-center text-[#98A2B3] font-medium">Belum ada log keamanan terdekat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Chart Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctxGrowth = document.getElementById('userGrowthChart').getContext('2d');
        new Chart(ctxGrowth, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartMonths) !!},
                datasets: [{
                    label: 'Pendaftaran User Baru',
                    data: {!! json_encode($userGrowthSeries) !!},
                    borderColor: '#0F766E',
                    backgroundColor: 'rgba(15, 118, 110, 0.06)',
                    fill: true,
                    tension: 0.3,
                    borderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false } },
                    y: { ticks: { stepSize: 1 } }
                }
            }
        });
    });
</script>
@endsection
