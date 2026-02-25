<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $user = auth()->user();
        $baseQuery = Applicant::query();

        // Adjust base query based on role
        if ($user->hasRole('boesl-admin')) {
            $baseQuery->where('created_by', $user->id);
        }

        $stats = [
            'total' => (clone $baseQuery)->count(),
            'sent_to_bhc' => (clone $baseQuery)->where('status', 'sent_to_bhc')->count(),
            'registered' => (clone $baseQuery)->whereNotNull('registered_at')->count(),
            'ic_received' => (clone $baseQuery)->whereNotNull('ic_received_at')->count(),
            'insurance_received' => (clone $baseQuery)->whereNotNull('insurance_received_at')->count(),
        ];

        // Monthly Trend
        $monthly = (clone $baseQuery)->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as total")
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Top Agencies
        $agency = (clone $baseQuery)->select('agency_name', DB::raw('COUNT(*) as total'))
            ->whereNotNull('agency_name')
            ->groupBy('agency_name')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // Top Companies
        $company = (clone $baseQuery)->select('company_name', DB::raw('COUNT(*) as total'))
            ->whereNotNull('company_name')
            ->groupBy('company_name')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // Registration Distribution
        $registeredCount = $stats['registered'];
        $pendingRegCount = $stats['total'] - $registeredCount;

        // IC Card status
        $icReceived = $stats['ic_received'];
        $icPending = $stats['total'] - $icReceived;

        // Insurance status
        $insReceived = $stats['insurance_received'];
        $insPending = $stats['total'] - $insReceived;

        return view('dashboard', [
            'user' => $user,
            'isBoeslAdmin' => $user->hasRole('boesl-admin'),
            'stats' => $stats,
            'monthlyLabels' => $monthly->pluck('month'),
            'monthlyValues' => $monthly->pluck('total'),
            'agencyLabels' => $agency->pluck('agency_name'),
            'agencyValues' => $agency->pluck('total'),
            'companyLabels' => $company->pluck('company_name'),
            'companyValues' => $company->pluck('total'),
            'registrationData' => [$registeredCount, $pendingRegCount],
            'icData' => [$icReceived, $icPending],
            'insData' => [$insReceived, $insPending],
        ]);
    }
}
