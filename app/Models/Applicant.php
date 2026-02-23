<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    protected $fillable = [
        'bhc_no',
        'applicant_name',
        'passport_no',
        'agency_name',
        'company_name',
        'flight_date',
        'status',
        'phone_number',
        'registration_no',
        'registration_date',
        'ic_card_received',
        'insurance_received',
    ];

    protected function casts(): array
    {
        return [
            'flight_date' => 'date',
            'registration_date' => 'date',
            'ic_card_received' => 'boolean',
            'insurance_received' => 'boolean',
        ];
    }
}
