<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Illuminate\Support\Collection;

class ApplicantsExport implements FromCollection, WithHeadings, WithStyles, WithColumnFormatting
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Return a collection with one example row to show formatting
        return new Collection([
            [
                'Example-001',
                'John Doe',
                'A1234567',
                'Trustworthy Agency',
                'Tech Corp',
                '2024-12-31',
            ]
        ]);
    }

    public function headings(): array
    {
        return [
            'BHC No',
            'Applicant Name',
            'Passport No',
            'Agency Name',
            'Company Name',
            'Flight Date (Y-M-D)',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function columnFormats(): array
    {
        return [
            // Format column F (Flight Date) as YYYY-MM-DD
            'F' => NumberFormat::FORMAT_DATE_YYYYMMDD,
        ];
    }
}
