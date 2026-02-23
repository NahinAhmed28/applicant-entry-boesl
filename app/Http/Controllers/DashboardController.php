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

        $stats = [
            'total' => (clone $baseQuery)->count(),
            'sent_to_bhc' => (clone $baseQuery)->where('status', 'send to bhc-brunei')->count(),
            'registered' => (clone $baseQuery)->whereNotNull('registration_date')->count(),
            'ic_received' => (clone $baseQuery)->where('ic_card_received', true)->count(),
            'insurance_received' => (clone $baseQuery)->where('insurance_received', true)->count(),
        ];

        $monthly = Applicant::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as total")
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $agency = Applicant::select('agency_name', DB::raw('COUNT(*) as total'))
            ->groupBy('agency_name')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return view('dashboard', [
            'user' => $user,
            'stats' => $stats,
            'monthlyLabels' => $monthly->pluck('month'),
            'monthlyValues' => $monthly->pluck('total'),
            'agencyLabels' => $agency->pluck('agency_name'),
            'agencyValues' => $agency->pluck('total'),
        ]);
    }
}
