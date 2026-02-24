<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ApplicantsImport;
use App\Exports\ApplicantsExport;

class BoeslApplicantController extends Controller
{
    public function index(Request $request)
    {
        // Boesl admin can view their own submissions
        $perPage = $request->integer('per_page', 10);
        
        $applicants = Applicant::query()
            ->where('created_by', auth()->id())
            ->when($request->filled('bhc_no'), fn ($q) => $q->where('bhc_no', 'like', '%' . $request->string('bhc_no')->trim() . '%'))
            ->when($request->filled('applicant_name'), fn ($q) => $q->where('applicant_name', 'like', '%' . $request->string('applicant_name')->trim() . '%'))
            ->when($request->filled('passport_no'), fn ($q) => $q->where('passport_no', 'like', '%' . $request->string('passport_no')->trim() . '%'))
            ->when($request->filled('flight_date'), fn ($q) => $q->whereDate('flight_date', $request->string('flight_date')->toString()))
            ->when($request->filled('status'), fn ($q) => $q->where('status', 'like', '%' . $request->string('status')->trim() . '%'))
            ->when($request->filled('registered_at'), fn ($q) => $q->whereDate('registered_at', $request->string('registered_at')->toString()))
            ->when($request->filled('ic_ins'), function ($q) use ($request) {
                return match ($request->string('ic_ins')->toString()) {
                    'ic_received' => $q->whereNotNull('ic_received_at'),
                    'ic_pending' => $q->whereNull('ic_received_at'),
                    'ins_received' => $q->whereNotNull('insurance_received_at'),
                    'ins_pending' => $q->whereNull('insurance_received_at'),
                    'both_received' => $q->whereNotNull('ic_received_at')->whereNotNull('insurance_received_at'),
                    'both_pending' => $q->whereNull('ic_received_at')->whereNull('insurance_received_at'),
                    default => $q,
                };
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

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

        try {
            Excel::import(new ApplicantsImport, $request->file('excel_file'));
            return Redirect::back()->with('success', 'Excel imported successfully.')->with('input_mode', 'batch');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errors = [];
            foreach ($failures as $failure) {
                $errors[] = "Row {$failure->row()}: " . implode(', ', $failure->errors());
            }
            return Redirect::back()->withErrors(['excel_file' => $errors])->with('input_mode', 'batch');
        } catch (\Exception $e) {
            return Redirect::back()->withErrors(['excel_file' => 'There was an error importing the file: ' . $e->getMessage()])->with('input_mode', 'batch');
        }
    }

    public function downloadTemplate()
    {
        return Excel::download(new ApplicantsExport, 'applicant_template.xlsx');
    }
}
?>
