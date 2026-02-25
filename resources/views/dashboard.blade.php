<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight">
            {{ __('Analytics Overview') }}
        </h2>
    </x-slot>

    <div class="py-4 lg:py-6 space-y-6 max-w-[1600px] mx-auto">
        <!-- Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 @if(!$isBoeslAdmin) lg:grid-cols-5 @else lg:grid-cols-2 @endif gap-4">
            @php
                $allStats = [
                    ['label' => 'Total Submissions', 'value' => $stats['total'], 'color' => 'blue', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
                    ['label' => 'Sent to BHC', 'value' => $stats['sent_to_bhc'], 'color' => 'indigo', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01'],
                ];
                
                if (!$isBoeslAdmin) {
                    $allStats[] = ['label' => 'Registered', 'value' => $stats['registered'], 'color' => 'green', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'];
                    $allStats[] = ['label' => 'IC Received', 'value' => $stats['ic_received'], 'color' => 'teal', 'icon' => 'M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14'];
                    $allStats[] = ['label' => 'Ins. Received', 'value' => $stats['insurance_received'], 'color' => 'orange', 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'];
                }
            @endphp

            @foreach ($allStats as $card)
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 transition-all hover:border-{{ $card['color'] }}-300 hover:shadow-md group">
                    <div class="flex items-center gap-4">
                        <div class="p-3 rounded-xl bg-{{ $card['color'] }}-50 text-{{ $card['color'] }}-600 group-hover:bg-{{ $card['color'] }}-600 group-hover:text-white transition-colors">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">{{ $card['label'] }}</p>
                            <p class="text-2xl font-black text-slate-800">{{ number_format($card['value']) }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Main Content Area -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column: Primary Charts -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Trend Chart -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-slate-800">Registration Velocity</h3>
                        <span class="text-xs font-semibold px-2 py-1 bg-blue-50 text-blue-600 rounded-full border border-blue-100">Monthly Trend</span>
                    </div>
                    <div class="h-[320px]">
                        <canvas id="monthlyChart"></canvas>
                    </div>
                </div>

                <!-- Demographic Bar Charts -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                        <h3 class="text-md font-bold text-slate-800 mb-4 border-b pb-2 border-slate-100 uppercase tracking-tight">Top Performance Agencies</h3>
                        <div class="h-[280px]">
                            <canvas id="agencyChart"></canvas>
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                        <h3 class="text-md font-bold text-slate-800 mb-4 border-b pb-2 border-slate-100 uppercase tracking-tight">Major Employer Groups</h3>
                        <div class="h-[280px]">
                            <canvas id="companyChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Distribution / Info -->
            <div class="space-y-6">
                @if(!$isBoeslAdmin)
                    <!-- Progress Distribution -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 overflow-hidden">
                        <h3 class="text-lg font-bold text-slate-800 mb-6">Workflow Status</h3>
                        
                        <div class="space-y-8">
                            <!-- Registration -->
                            <div class="relative">
                                <h4 class="text-xs font-bold text-slate-500 mb-4 uppercase text-center">Registration Rate</h4>
                                <div class="h-[140px]">
                                    <canvas id="regStatusChart"></canvas>
                                </div>
                                <div class="mt-2 text-center">
                                    <span class="text-lg font-black text-green-600">{{ $stats['total'] > 0 ? round(($stats['registered'] / $stats['total']) * 100) : 0 }}%</span>
                                    <p class="text-[10px] text-slate-400 font-medium">Completed</p>
                                </div>
                            </div>

                            <hr class="border-slate-100">

                            <!-- Cards & Insurance Mini Charts -->
                            <div class="grid grid-cols-2 gap-4">
                                <div class="text-center">
                                    <h4 class="text-[10px] font-bold text-slate-500 mb-2 uppercase">IC Cards</h4>
                                    <div class="h-[80px]">
                                        <canvas id="icStatusChart"></canvas>
                                    </div>
                                    <p class="mt-1 text-sm font-bold text-blue-600">{{ $stats['total'] > 0 ? round(($stats['ic_received'] / $stats['total']) * 100) : 0 }}%</p>
                                </div>
                                <div class="text-center">
                                    <h4 class="text-[10px] font-bold text-slate-500 mb-2 uppercase">Insurance</h4>
                                    <div class="h-[80px]">
                                        <canvas id="insStatusChart"></canvas>
                                    </div>
                                    <p class="mt-1 text-sm font-bold text-orange-600">{{ $stats['total'] > 0 ? round(($stats['insurance_received'] / $stats['total']) * 100) : 0 }}%</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Quick Action for BOESL Admin instead of Stats -->
                    <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl shadow-lg p-6 text-white overflow-hidden relative">
                        <div class="absolute -right-10 -bottom-10 opacity-10">
                            <svg class="h-40 w-40" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Ready to Submit?</h3>
                        <p class="text-blue-100 text-sm mb-6 leading-relaxed">Continue building your applicant list. You can add individuals or upload batch files instantly.</p>
                        <div class="space-y-3 relative z-10">
                            <a href="{{ route('boesl.applicants.index') }}" class="block w-full py-3 px-4 bg-white text-blue-600 font-bold rounded-xl text-center hover:bg-blue-50 transition-colors">
                                Manage Applicants
                            </a>
                            <a href="{{ route('boesl.applicants.index') }}?input=batch" class="block w-full py-3 px-4 bg-white/10 text-white font-bold rounded-xl text-center hover:bg-white/20 transition-colors border border-white/20">
                                Import Excel
                            </a>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                        <h4 class="text-sm font-bold text-slate-800 mb-4 border-b border-slate-100 pb-2">Recent Activity Log</h4>
                        <div class="space-y-4">
                            <!-- Placeholder for actual activity -->
                            <div class="flex gap-3">
                                <div class="w-1.5 h-1.5 rounded-full bg-blue-500 mt-1.5"></div>
                                <div>
                                    <p class="text-xs font-bold text-slate-700">Dashboard Synchronized</p>
                                    <p class="text-[10px] text-slate-400">Just now</p>
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <div class="w-1.5 h-1.5 rounded-full bg-slate-200 mt-1.5"></div>
                                <div>
                                    <p class="text-xs font-bold text-slate-500">Applicant statistics updated</p>
                                    <p class="text-[10px] text-slate-400">5 mins ago</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Global Chart Styling
        Chart.defaults.font.family = "'Figtree', sans-serif";
        Chart.defaults.color = '#94a3b8';
        Chart.defaults.font.size = 11;
        
        const chartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b',
                    padding: 10,
                    titleFont: { size: 12, weight: 'bold' },
                    bodyFont: { size: 12 },
                    cornerRadius: 8,
                    displayColors: false
                }
            }
        };

        // Trend Chart
        new Chart(document.getElementById('monthlyChart'), {
            type: 'line',
            data: {
                labels: @json($monthlyLabels),
                datasets: [{
                    data: @json($monthlyValues),
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37, 99, 235, 0.05)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#2563eb',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                }]
            },
            options: {
                ...chartOptions,
                plugins: { ...chartOptions.plugins, legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 },
                        grid: { color: '#f1f5f9' }
                    },
                    x: { grid: { display: false } }
                }
            }
        });

        // Agencies Chart
        new Chart(document.getElementById('agencyChart'), {
            type: 'bar',
            data: {
                labels: @json($agencyLabels),
                datasets: [{
                    data: @json($agencyValues),
                    backgroundColor: '#0d9488',
                    borderRadius: 4,
                    barThickness: 16
                }]
            },
            options: {
                ...chartOptions,
                indexAxis: 'y',
                scales: {
                    x: { beginAtZero: true, grid: { color: '#f1f5f9' } },
                    y: { grid: { display: false } }
                }
            }
        });

        // Companies Chart
        new Chart(document.getElementById('companyChart'), {
            type: 'bar',
            data: {
                labels: @json($companyLabels),
                datasets: [{
                    data: @json($companyValues),
                    backgroundColor: '#6366f1',
                    borderRadius: 4,
                    barThickness: 16
                }]
            },
            options: {
                ...chartOptions,
                indexAxis: 'y',
                scales: {
                    x: { beginAtZero: true, grid: { color: '#f1f5f9' } },
                    y: { grid: { display: false } }
                }
            }
        });

        @if(!$isBoeslAdmin)
        // Doughnut Charts for BHC/Super Admin
        const doughnutConfig = (data, color) => ({
            type: 'doughnut',
            data: {
                datasets: [{
                    data: data,
                    backgroundColor: [color, '#f1f5f9'],
                    borderWidth: 0,
                    cutout: '80%'
                }]
            },
            options: {
                ...chartOptions,
                animation: { duration: 2000, easing: 'easeOutQuart' }
            }
        });

        new Chart(document.getElementById('regStatusChart'), doughnutConfig(@json($registrationData), '#22c55e'));
        new Chart(document.getElementById('icStatusChart'), doughnutConfig(@json($icData), '#3b82f6'));
        new Chart(document.getElementById('insStatusChart'), doughnutConfig(@json($insData), '#f97316'));
        @endif
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Global Chart Defaults
        Chart.defaults.font.family = "'Figtree', sans-serif";
        Chart.defaults.color = '#64748b';
        
        const chartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            }
        };

        // Monthly Trend
        new Chart(document.getElementById('monthlyChart'), {
            type: 'line',
            data: {
                labels: @json($monthlyLabels),
                datasets: [{
                    label: 'Applicants',
                    data: @json($monthlyValues),
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37, 99, 235, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#2563eb',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                ...chartOptions,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [5, 5] }
                    },
                    x: { grid: { display: false } }
                }
            }
        });

        // Top Agencies
        new Chart(document.getElementById('agencyChart'), {
            type: 'bar',
            data: {
                labels: @json($agencyLabels),
                datasets: [{
                    data: @json($agencyValues),
                    backgroundColor: '#0d9488',
                    borderRadius: 6,
                    barThickness: 30
                }]
            },
            options: {
                ...chartOptions,
                indexAxis: 'y',
                scales: {
                    x: {
                        beginAtZero: true,
                        grid: { borderDash: [5, 5] }
                    },
                    y: { grid: { display: false } }
                }
            }
        });

        // Top Companies
        new Chart(document.getElementById('companyChart'), {
            type: 'bar',
            data: {
                labels: @json($companyLabels),
                datasets: [{
                    data: @json($companyValues),
                    backgroundColor: '#4f46e5',
                    borderRadius: 6,
                    barThickness: 30
                }]
            },
            options: {
                ...chartOptions,
                indexAxis: 'y',
                scales: {
                    x: {
                        beginAtZero: true,
                        grid: { borderDash: [5, 5] }
                    },
                    y: { grid: { display: false } }
                }
            }
        });

        // Registration Distribution
        new Chart(document.getElementById('regStatusChart'), {
            type: 'doughnut',
            data: {
                labels: ['Registered', 'Pending'],
                datasets: [{
                    data: @json($registrationData),
                    backgroundColor: ['#22c55e', '#f1f5f9'],
                    borderWidth: 0,
                    cutout: '75%'
                }]
            },
            options: chartOptions
        });

        // IC Status
        new Chart(document.getElementById('icStatusChart'), {
            type: 'doughnut',
            data: {
                labels: ['Received', 'Pending'],
                datasets: [{
                    data: @json($icData),
                    backgroundColor: ['#3b82f6', '#f1f5f9'],
                    borderWidth: 0,
                    cutout: '75%'
                }]
            },
            options: chartOptions
        });

        // Insurance Status
        new Chart(document.getElementById('insStatusChart'), {
            type: 'doughnut',
            data: {
                labels: ['Received', 'Pending'],
                datasets: [{
                    data: @json($insData),
                    backgroundColor: ['#f97316', '#f1f5f9'],
                    borderWidth: 0,
                    cutout: '75%'
                }]
            },
            options: chartOptions
        });
    </script>
</x-app-layout>
