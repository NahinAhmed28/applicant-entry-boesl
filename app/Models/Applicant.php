<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    use HasFactory;

    protected $fillable = [
        'bhc_no',
        'applicant_name',
        'passport_no',
        'agency_name',
        'company_name',
        'flight_date',
        'created_by',
        'status',
        'phone_number',
        'registration_no',
        'registered_at',
        'ic_received_at',
        'insurance_received_at',
    ];

    protected $casts = [
        'flight_date' => 'datetime',
        'registered_at' => 'datetime',
        'ic_received_at' => 'datetime',
        'insurance_received_at' => 'datetime',
    ];
}
?>
