<?php

namespace App\Imports;

use App\Models\Applicant;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ApplicantsImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $flightDate = null;
        $rawDate = $row['flight_date_y_m_d'] ?? $row['flight_date'] ?? $row['applicant_flight_date'] ?? null;
        
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
            'bhc_no' => $row['bhc_no'],
            'applicant_name' => $row['applicant_name'],
            'passport_no' => $row['passport_no'],
            'agency_name' => $row['agency_name'],
            'company_name' => $row['company_name'],
            'flight_date' => $flightDate,
            'status' => 'sent_to_bhc',
            'created_by' => auth()->id(),
        ]);
    }

    public function rules(): array
    {
        return [
            'bhc_no' => 'required',
            'applicant_name' => 'required',
            'passport_no' => 'required',
            'agency_name' => 'required',
            'company_name' => 'required',
            'flight_date_y_m_d' => 'required',
        ];
    }

    public function prepareForValidation($data, $index)
    {
        // Handle variations in header slugification
        if (isset($data['flight_date_y_m_d'])) {
             // Already correct
        } elseif (isset($data['flight_date'])) {
            $data['flight_date_y_m_d'] = $data['flight_date'];
        }
        
        return $data;
    }
}
