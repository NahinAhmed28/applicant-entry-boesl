<?php

namespace App\Http\Controllers;

use App\Imports\ApplicantsImport;
use App\Models\Applicant;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BoeslApplicantController extends Controller
{
    public function index()
    {
        // Boesl admin sees all applicants, but we can filter if needed.
        // Assuming they can see all for now.
        $applicants = Applicant::latest()->get();
        return view('boesl.applicants.index', compact('applicants'));
    }

    public function create()
    {
        return view('boesl.applicants.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bhc_no' => 'required|string|max:255',
            'applicant_name' => 'required|string|max:255',
            'passport_no' => 'required|string|max:255',
            'agency_name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'flight_date' => 'required|date',
        ]);

        Applicant::create($validated + ['status' => 'send to bhc-brunei']);

        return redirect()->route('boesl.applicants.index')->with('success', 'Applicant added successfully.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        Excel::import(new ApplicantsImport, $request->file('excel_file'));

        return redirect()->route('boesl.applicants.index')->with('success', 'Applicants imported successfully.');
    }
}
