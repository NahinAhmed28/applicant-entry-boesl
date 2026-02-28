<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 leading-tight">
            {{ __('Analytics Overview') }}
        </h2>
    </x-slot>

    <div class="py-4 space-y-4 max-w-[1600px] mx-auto px-2 sm:px-4 lg:px-6">
        <!-- Summary Cards - More Compact -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3">
            @php
                $allStats = [
                    ['label' => 'Total', 'value' => $stats['total'], 'color' => 'blue', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
                    ['label' => 'Sent to BHC', 'value' => $stats['sent_to_bhc'], 'color' => 'indigo', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01'],
                ];
                
                if (!$isBoeslAdmin) {
                    $allStats[] = ['label' => 'Registered', 'value' => $stats['registered'], 'color' => 'green', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'];
                    $allStats[] = ['label' => 'IC Received', 'value' => $stats['ic_received'], 'color' => 'teal', 'icon' => 'M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14'];
                    $allStats[] = ['label' => 'Ins. Received', 'value' => $stats['insurance_received'], 'color' => 'orange', 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'];
                }
            @endphp

            @foreach ($allStats as $card)
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-3 flex items-center gap-3 transition-all hover:shadow-md border-l-4 border-l-{{ $card['color'] }}-500">
                    <div class="p-2 rounded-lg bg-{{ $card['color'] }}-50 text-{{ $card['color'] }}-600 shrink-0">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}" />
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider truncate">{{ $card['label'] }}</p>
                        <p class="text-lg font-black text-slate-800">{{ number_format($card['value']) }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Main Content Area -->
        <div class="grid grid-cols-1 xl:grid-cols-4 gap-4">
            <!-- Left Column: Growth & Distribution -->
            <div class="xl:col-span-3 space-y-4">
                <!-- Trend Chart - Large -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-4">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-bold text-slate-800 uppercase tracking-tight">Registration Trends</h3>
                        <div class="flex gap-2">
                            <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                            <span class="text-[10px] text-slate-400 font-bold uppercase">Monthly Growth</span>
                        </div>
                    </div>
                    <div class="h-[280px]">
                        <canvas id="monthlyChart"></canvas>
                    </div>
                </div>

                <!-- Demographic Bar Charts -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-4">
                        <h3 class="text-xs font-bold text-slate-400 mb-4 border-b pb-2 border-slate-50 uppercase tracking-widest flex items-center gap-2">
                            <svg class="w-3 h-3 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                            Top Performance Agencies
                        </h3>
                        <div class="h-[240px]">
                            <canvas id="agencyChart"></canvas>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-4">
                        <h3 class="text-xs font-bold text-slate-400 mb-4 border-b pb-2 border-slate-50 uppercase tracking-widest flex items-center gap-2">
                            <svg class="w-3 h-3 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            Major Employer Groups
                        </h3>
                        <div class="h-[240px]">
                            <canvas id="companyChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Specific Logic -->
            <div class="space-y-4">
                @if(!$isBoeslAdmin)
                    <!-- Workflow Distribution - Compact -->
                    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-4 h-full flex flex-col">
                        <h3 class="text-sm font-bold text-slate-800 mb-4 uppercase tracking-wider flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            Workflow Status
                        </h3>
                        
                        <div class="flex-1 flex flex-col justify-around gap-6 py-2">
                            <!-- Registration Rate -->
                            <div class="flex items-center gap-4">
                                <div class="w-20 h-20 shrink-0 relative">
                                    <canvas id="regStatusChart"></canvas>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <span class="text-[10px] font-black text-slate-800">{{ $stats['total'] > 0 ? round(($stats['registered'] / $stats['total']) * 100) : 0 }}%</span>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Registration</h4>
                                    <p class="text-sm font-bold text-slate-600">{{ number_format($stats['registered']) }} / {{ number_format($stats['total']) }}</p>
                                </div>
                            </div>

                            <hr class="border-slate-50">

                            <!-- IC Cards -->
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-16 shrink-0 relative">
                                    <canvas id="icStatusChart"></canvas>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <span class="text-[9px] font-black text-slate-800">{{ $stats['total'] > 0 ? round(($stats['ic_received'] / $stats['total']) * 100) : 0 }}%</span>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">IC Cards</h4>
                                    <p class="text-sm font-bold text-slate-600">{{ number_format($stats['ic_received']) }} Received</p>
                                </div>
                            </div>

                            <!-- Insurance -->
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-16 shrink-0 relative">
                                    <canvas id="insStatusChart"></canvas>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <span class="text-[9px] font-black text-slate-800">{{ $stats['total'] > 0 ? round(($stats['insurance_received'] / $stats['total']) * 100) : 0 }}%</span>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Insurance</h4>
                                    <p class="text-sm font-bold text-slate-600">{{ number_format($stats['insurance_received']) }} Received</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 pt-4 border-t border-slate-50">
                            <a href="{{ route('bhc.applicants.index') }}" class="block w-full text-center py-2 px-4 bg-slate-50 hover:bg-slate-100 text-slate-600 rounded-lg text-xs font-bold transition-colors">
                                View Full Directory
                            </a>
                        </div>
                    </div>
                @else
                    <!-- BOESL Quick Actions & Activity -->
                    <div class="space-y-4 h-full">
                        <div class="bg-indigo-600 rounded-xl p-5 text-white shadow-md relative overflow-hidden group">
                            <div class="absolute -right-4 -bottom-4 text-white/10 transition-transform group-hover:scale-110 duration-500">
                                <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                            </div>
                            <h3 class="text-sm font-black uppercase tracking-wider mb-1">Queue Overview</h3>
                            <p class="text-[11px] text-indigo-100 mb-4 leading-normal">You have {{ number_format($stats['sent_to_bhc']) }} applicants pending BHC registration.</p>
                            <a href="{{ route('boesl.applicants.create') }}" class="inline-flex items-center gap-2 px-3 py-2 bg-white text-indigo-600 rounded-lg text-xs font-bold shadow-sm hover:translate-x-1 transition-all">
                                Add Applicant
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                            </a>
                        </div>

                        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-4">
                            <h4 class="text-xs font-bold text-slate-400 mb-4 uppercase tracking-widest flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                System Activity
                            </h4>
                            <div class="space-y-4">
                                <div class="flex gap-3">
                                    <div class="p-1.5 rounded-lg bg-blue-50 text-blue-500 shrink-0">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
                                    </div>
                                    <div>
                                        <p class="text-[11px] font-bold text-slate-700">Database Synchronized</p>
                                        <p class="text-[9px] text-slate-400 uppercase font-medium">Just now</p>
                                    </div>
                                </div>
                                <div class="flex gap-3">
                                    <div class="p-1.5 rounded-lg bg-slate-50 text-slate-400 shrink-0">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5" /></svg>
                                    </div>
                                    <div>
                                        <p class="text-[11px] font-bold text-slate-500">Statistics updated</p>
                                        <p class="text-[9px] text-slate-400 uppercase font-medium">12 minutes ago</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Combined and Optimized Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Global Chart Defaults
            Chart.defaults.font.family = "'Figtree', sans-serif";
            Chart.defaults.color = '#94a3b8';
            Chart.defaults.font.size = 10;
            
            const commonOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 8,
                        titleFont: { size: 11, weight: 'bold' },
                        bodyFont: { size: 11 },
                        cornerRadius: 6,
                        displayColors: false
                    }
                }
            };

            // 1. Monthly Trend Chart
            new Chart(document.getElementById('monthlyChart'), {
                type: 'line',
                data: {
                    labels: @json($monthlyLabels),
                    datasets: [{
                        data: @json($monthlyValues),
                        borderColor: '#2563eb',
                        backgroundColor: 'rgba(37, 99, 235, 0.04)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#2563eb',
                        pointBorderWidth: 1.5,
                        pointRadius: 3,
                    }]
                },
                options: {
                    ...commonOptions,
                    scales: {
                        y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#f8fafc' } },
                        x: { grid: { display: false } }
                    }
                }
            });

            // 2. Bar Charts
            const barOptions = {
                ...commonOptions,
                indexAxis: 'y',
                scales: {
                    x: { beginAtZero: true, grid: { color: '#f8fafc' } },
                    y: { grid: { display: false } }
                }
            };

            // Agency Chart
            new Chart(document.getElementById('agencyChart'), {
                type: 'bar',
                data: {
                    labels: @json($agencyLabels),
                    datasets: [{
                        data: @json($agencyValues),
                        backgroundColor: '#14b8a6',
                        borderRadius: 3,
                        barThickness: 12
                    }]
                },
                options: barOptions
            });

            // Company Chart
            new Chart(document.getElementById('companyChart'), {
                type: 'bar',
                data: {
                    labels: @json($companyLabels),
                    datasets: [{
                        data: @json($companyValues),
                        backgroundColor: '#6366f1',
                        borderRadius: 3,
                        barThickness: 12
                    }]
                },
                options: barOptions
            });

            // 3. Doughnut Charts (Only for BHC/Super Admin)
            @if(!$isBoeslAdmin)
            const doughnutConfig = (data, color) => ({
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: data,
                        backgroundColor: [color, '#f8fafc'],
                        borderWidth: 0,
                        cutout: '82%'
                    }]
                },
                options: {
                    ...commonOptions,
                    animation: { duration: 1500, easing: 'easeOutQuart' }
                }
            });

            new Chart(document.getElementById('regStatusChart'), doughnutConfig(@json($registrationData), '#10b981'));
            new Chart(document.getElementById('icStatusChart'), doughnutConfig(@json($icData), '#3b82f6'));
            new Chart(document.getElementById('insStatusChart'), doughnutConfig(@json($insData), '#f59e0b'));
            @endif
        });
    </script>
</x-app-layout>
