<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use Illuminate\Http\Request;

class BhcApplicantController extends Controller
{
    public function index()
    {
        $applicants = Applicant::latest()->get();
        return view('bhc.applicants.index', compact('applicants'));
    }

    public function edit(Applicant $applicant)
    {
        return view('bhc.applicants.edit', compact('applicant'));
    }

    public function update(Request $request, Applicant $applicant)
    {
        $validated = $request->validate([
            'phone_number' => 'nullable|string|max:255',
            'registration_no' => 'nullable|string|max:255',
        ]);

        $applicant->update($validated);

        return redirect()->route('bhc.applicants.index')->with('success', 'Applicant info updated.');
    }

    public function markRegistered(Applicant $applicant)
    {
        $applicant->update([
            'registration_date' => $applicant->registration_date ?? now(),
            'status' => 'registered',
        ]);

        return redirect()->back()->with('success', 'Applicant marked as registered.');
    }

    public function updateTracking(Request $request, Applicant $applicant)
    {
        $request->validate([
            'ic_card_received' => 'nullable|boolean',
            'insurance_received' => 'nullable|boolean',
        ]);

        // We use checkbox so if it's missing it's false
        $applicant->update([
            'ic_card_received' => $request->has('ic_card_received'),
            'insurance_received' => $request->has('insurance_received'),
        ]);

        return redirect()->back()->with('success', 'Tracking updated.');
    }
}
