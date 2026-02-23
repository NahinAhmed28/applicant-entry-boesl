<?php

namespace App\Imports;

use App\Models\Applicant;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ApplicantsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Headers after slugification by Laravel Excel:
        $bhcNo = $row['bhc_no'] ?? $row['bhc_no_'] ?? null;
        if (empty($bhcNo)) {
            return null;
        }

        $flightDate = null;
        $rawDate = $row['applicant_flight_date'] ?? $row['flight_date'] ?? null;
        if (!empty($rawDate)) {
            try {
                if (is_numeric($rawDate)) {
                    $flightDate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($rawDate)->format('Y-m-d');
                } else {
                    $flightDate = date('Y-m-d', strtotime($rawDate));
                }
            } catch (\Exception $e) {
                // Ignore or log error
            }
        }

        return new Applicant([
            'bhc_no' => $bhcNo,
            'applicant_name' => $row['applicant_name'] ?? '',
            'passport_no' => $row['passport_no'] ?? '',
            'agency_name' => $row['agency_name'] ?? '',
            'company_name' => $row['company_name'] ?? '',
            'flight_date' => $flightDate,
            'status' => 'send to bhc-brunei',
        ]);
    }
}
