<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ApplicantsImport;

class BoeslApplicantController extends Controller
{
    public function index()
    {
        // Boesl admin can view their own submissions
        $applicants = Applicant::where('created_by', auth()->id())->get();
        return view('boesl.applicants.index', compact('applicants'));
    }

    public function create()
    {
        return view('boesl.applicants.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bhc_no' => 'required|string',
            'applicant_name' => 'required|string',
            'passport_no' => 'required|string',
            'agency_name' => 'required|string',
            'company_name' => 'required|string',
            'flight_date' => 'required|date',
        ]);

        $applicant = Applicant::create(array_merge($validated, [
            'status' => 'sent_to_bhc',
            'created_by' => auth()->id(),
        ]));

        return Redirect::route('boesl.applicants.index')->with('success', 'Applicant submitted.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,csv',
        ]);
        // Simple import using maatwebsite/excel package
        Excel::import(new ApplicantsImport, $request->file('excel_file'));
        return Redirect::back()->with('success', 'Excel imported successfully.');
    }
}
?>
