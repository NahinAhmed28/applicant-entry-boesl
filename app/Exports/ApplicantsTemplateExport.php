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
            'A' => '@', // Text
            'B' => '@', // Text
            'C' => '@', // Text
            'D' => '@', // Text
            'E' => '@', // Text
            'F' => 'yyyy-mm-dd',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                
                // Set data validation for the Flight Date column (F) from row 2 to 1000
                $cellRange = 'F2:F1000';
                $validation = $sheet->getCell('F2')->getDataValidation();
                $validation->setType(DataValidation::TYPE_DATE);
                $validation->setErrorStyle(DataValidation::STYLE_STOP);
                $validation->setAllowBlank(false);
                $validation->setShowInputMessage(true);
                $validation->setShowErrorMessage(true);
                $validation->setShowDropDown(true);
                $validation->setOperator(DataValidation::OPERATOR_GREATERTHANOREQUAL);
                $validation->setFormula1('DATE(1900,1,1)'); // Allow any valid date
                $validation->setErrorTitle('Input Error');
                $validation->setError('This field is mandatory. Value must be a valid date in YYYY-MM-DD format.');
                $validation->setPromptTitle('Required Input');
                $validation->setPrompt('Please enter a date in YYYY-MM-DD format.');
                
                for ($i = 2; $i <= 1000; $i++) {
                    $sheet->getCell('F' . $i)->setDataValidation(clone $validation);
                }

                // Explicitly set column format for and alignment
                $event->sheet->getStyle('F2:F1000')->getNumberFormat()->setFormatCode('yyyy-mm-dd');
                $event->sheet->getStyle('A2:E1000')->getNumberFormat()->setFormatCode('@');
                
                // Style the header
                $event->sheet->getStyle('A1:F1')->getFont()->setBold(true);
                $event->sheet->getStyle('A1:F1')->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFD3D3D3'); // Light gray background
                
                // Auto-size columns
                foreach (range('A', 'F') as $columnID) {
                    $event->sheet->getDelegate()->getColumnDimension($columnID)->setAutoSize(true);
                }
                
                // Freeze pane
                $sheet->freezePane('A2');
            },
        ];
    }
}
