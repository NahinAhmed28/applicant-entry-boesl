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
            'registered_at' => $applicant->registered_at ?? now(),
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

        // Update timestamps when checkboxes are toggled.
        $updates = [];

        // IC card
        if ($request->has('ic_card_received')) {
            if (!$applicant->ic_received_at) {
                $updates['ic_received_at'] = now();
                $updates['status'] = 'ic_received';
            }
        } else {
            // unchecked -> clear timestamp
            $updates['ic_received_at'] = null;
        }

        // Insurance
        if ($request->has('insurance_received')) {
            if (!$applicant->insurance_received_at) {
                $updates['insurance_received_at'] = now();
                $updates['status'] = 'insurance_received';
            }
        } else {
            $updates['insurance_received_at'] = null;
        }

        if (!empty($updates)) {
            $applicant->update($updates);
        }

        return redirect()->back()->with('success', 'Tracking updated.');
    }
}
