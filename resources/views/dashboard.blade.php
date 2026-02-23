<x-app-layout>
    <x-slot name="header">
        <h2>Dashboard</h2>
    </x-slot>

    <div class="space-y-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-4">
            @foreach ([
                ['Total Applicants', $stats['total']],
                ['Sent to BHC', $stats['sent_to_bhc']],
                ['Registered', $stats['registered']],
                ['IC Card Received', $stats['ic_received']],
                ['Insurance Received', $stats['insurance_received']],
            ] as [$label, $value])
                <div class="bg-white rounded-lg shadow p-4">
                    <p class="text-xs text-gray-500">{{ $label }}</p>
                    <p class="text-2xl font-bold text-slate-700">{{ $value }}</p>
                </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
            <div class="bg-white rounded-lg shadow p-4">
                <h3 class="font-semibold mb-3">Applicants Created by Month</h3>
                <canvas id="monthlyChart" height="120"></canvas>
            </div>
            <div class="bg-white rounded-lg shadow p-4">
                <h3 class="font-semibold mb-3">Top Agencies</h3>
                <canvas id="agencyChart" height="120"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const monthlyCtx = document.getElementById('monthlyChart');
        const agencyCtx = document.getElementById('agencyChart');

        new Chart(monthlyCtx, {
            type: 'line',
            data: {
                labels: @json($monthlyLabels),
                datasets: [{
                    label: 'Applicants',
                    data: @json($monthlyValues),
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37, 99, 235, 0.2)',
                    fill: true,
                    tension: 0.3,
                }]
            }
        });

        new Chart(agencyCtx, {
            type: 'bar',
            data: {
                labels: @json($agencyLabels),
                datasets: [{
                    label: 'Applicants',
                    data: @json($agencyValues),
                    backgroundColor: '#0f766e',
                }]
            }
        });
    </script>
</x-app-layout>
