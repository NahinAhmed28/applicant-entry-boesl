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
                    // Force strict Y-m-d check if not a spreadsheet date object
                    $d = \DateTime::createFromFormat('Y-m-d', $rawDate);
                    if ($d && $d->format('Y-m-d') === $rawDate) {
                        $flightDate = $rawDate;
                    } else {
                        // Try fallback if strtotime works but it's not a random string
                        $timestamp = strtotime($rawDate);
                        if ($timestamp && $timestamp > 0) {
                            $flightDate = date('Y-m-d', $timestamp);
                        }
                    }
                }
            } catch (\Exception $e) {
                $flightDate = null;
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
            'bhc_no' => 'required|string',
            'applicant_name' => 'required|string',
            'passport_no' => 'required|string',
            'agency_name' => 'required|string',
            'company_name' => 'required|string',
            'flight_date_y_m_d' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (is_numeric($value)) {
                        try {
                            \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value);
                        } catch (\Exception $e) {
                            $fail('The ' . $attribute . ' is not a valid Excel date.');
                        }
                    } else {
                        $d = \DateTime::createFromFormat('Y-m-d', $value);
                        if (!($d && $d->format('Y-m-d') === $value)) {
                            // Try strtotime as fallback but only if it results in a sane date
                            $ts = strtotime($value);
                            if (!$ts || $ts <= 0) {
                                $fail('The ' . $attribute . ' must be in Y-m-d format (e.g. 2024-12-31).');
                            }
                        }
                    }
                },
            ],
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
