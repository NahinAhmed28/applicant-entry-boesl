<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class ApplicantsTemplateExport implements FromArray, WithHeadings, WithColumnFormatting, WithEvents
{
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

    public function array(): array
    {
        return [];
    }

    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_DATE_YYYYMMDD2,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Set data validation for the Flight Date column (F) from row 2 to 1000
                $cellRange = 'F2:F1000';
                $validation = $event->sheet->getDelegate()->getCell('F2')->getDataValidation();
                $validation->setType(DataValidation::TYPE_DATE);
                $validation->setErrorStyle(DataValidation::STYLE_STOP);
                $validation->setAllowBlank(false);
                $validation->setShowInputMessage(true);
                $validation->setShowErrorMessage(true);
                $validation->setShowDropDown(true);
                $validation->setOperator(DataValidation::OPERATOR_GREATERTHANOREQUAL);
                $validation->setFormula1('DATE(1900,1,1)'); // Allow any valid date
                $validation->setErrorTitle('Input error');
                $validation->setError('Value is not a valid date (Y-M-D).');
                $validation->setPromptTitle('Allowed input');
                $validation->setPrompt('Please enter a date in YYYY-MM-DD format.');
                
                for ($i = 2; $i <= 1000; $i++) {
                    $event->sheet->getDelegate()->getCell('F' . $i)->setDataValidation(clone $validation);
                }

                // Explicitly set column format
                $event->sheet->getStyle('F2:F1000')->getNumberFormat()->setFormatCode('yyyy-mm-dd');
            },
        ];
    }
}
