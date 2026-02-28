<?php

namespace Database\Seeders;

use App\Models\Applicant;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApplicantsSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $boeslAdmin = User::where('email', 'boesl@example.com')->first();

        $applicantsData = [
            [
                'bhc_no' => 'BHC001',
                'applicant_name' => 'Ahmad Hassan Abdullah',
                'passport_no' => 'P12345678',
                'phone_number' => '+673 7123456',
                'agency_name' => 'Global Workforce Solutions',
                'company_name' => 'Royal Brunei Airlines',
                'flight_date' => now()->addDays(30),
                'status' => 'sent_to_bhc',
                'created_by' => $boeslAdmin?->id,
            ],
            [
                'bhc_no' => 'BHC002',
                'applicant_name' => 'Nur Salamah Binti Mohd',
                'passport_no' => 'P87654321',
                'phone_number' => '+673 7234567',
                'agency_name' => 'Asia Pacific Recruitment',
                'company_name' => 'Brunei Shell Petroleum',
                'flight_date' => now()->addDays(25),
                'status' => 'sent_to_bhc',
                'created_by' => $boeslAdmin?->id,
            ],
            [
                'bhc_no' => 'BHC003',
                'applicant_name' => 'Muhammad Riaz Khan',
                'passport_no' => 'P55667788',
                'phone_number' => '+673 7345678',
                'agency_name' => 'Premier Manpower Agency',
                'company_name' => 'Brunei Energy Exploration',
                'flight_date' => now()->addDays(35),
                'status' => 'sent_to_bhc',
                'created_by' => $boeslAdmin?->id,
            ],
            [
                'bhc_no' => 'BHC004',
                'applicant_name' => 'Siti Jasmina Mohamed',
                'passport_no' => 'P11223344',
                'phone_number' => '+673 7456789',
                'agency_name' => 'International Staff Services',
                'company_name' => 'Brunei Port Authority',
                'registration_no' => 'REG-2025-101',
                'flight_date' => now()->subMonths(4)->addDays(15),
                'registered_at' => now()->subMonths(4)->addDays(20),
                'status' => 'sent_to_bhc',
                'created_by' => $boeslAdmin?->id,
            ],
            [
                'bhc_no' => 'BHC005',
                'applicant_name' => 'Razif Abdullah Rajak',
                'passport_no' => 'P99887766',
                'phone_number' => '+673 7567890',
                'agency_name' => 'Sunshine Recruitment Ltd',
                'company_name' => 'Ministry of Health',
                'registration_no' => 'REG-2025-102',
                'flight_date' => now()->subMonths(3)->subDays(10),
                'status' => 'sent_to_bhc',
                'created_by' => $boeslAdmin?->id,
            ],
            [
                'bhc_no' => 'BHC006',
                'applicant_name' => 'Fatimah Zahara Ibrahim',
                'passport_no' => 'P44556677',
                'phone_number' => '+673 7678901',
                'agency_name' => 'Global Staff Agency',
                'company_name' => 'Brunei National Takaful',
                'registration_no' => 'REG-2025-103',
                'flight_date' => now()->subMonths(8)->addDays(5),
                'registered_at' => now()->subMonths(8)->addDays(10),
                'status' => 'registered',
                'created_by' => $boeslAdmin?->id,
            ],
            [
                'bhc_no' => 'BHC007',
                'applicant_name' => 'Haji Nordin Bin Hj Mustafa',
                'passport_no' => 'P33445566',
                'phone_number' => '+673 7789012',
                'agency_name' => 'Premier HR Services',
                'company_name' => 'Royal Brunei Police Force',
                'registration_no' => 'REG-2025-104',
                'flight_date' => now()->subMonths(7),
                'registered_at' => now()->subMonths(7)->addDays(8),
                'status' => 'registered',
                'created_by' => $boeslAdmin?->id,
            ],
            [
                'bhc_no' => 'BHC008',
                'applicant_name' => 'Dewi Lestari Wijaya',
                'passport_no' => 'P22334455',
                'phone_number' => '+673 7890123',
                'agency_name' => 'Excellence Recruitment',
                'company_name' => 'University of Brunei Darussalam',
                'registration_no' => 'REG-2025-105',
                'flight_date' => now()->subMonths(10)->addDays(12),
                'registered_at' => now()->subMonths(10)->addDays(18),
                'ic_received_at' => now()->subMonths(7)->addDays(5),
                'insurance_received_at' => now()->subMonths(4)->addDays(10),
                'status' => 'ic_received',
                'created_by' => $boeslAdmin?->id,
            ],
            [
                'bhc_no' => 'BHC009',
                'applicant_name' => 'Priya Sharma Dutta',
                'passport_no' => 'P11335577',
                'phone_number' => '+673 7901234',
                'agency_name' => 'Asia Workforce Management',
                'company_name' => 'Brunei Economic Development Board',
                'registration_no' => 'REG-2025-106',
                'flight_date' => now()->subMonths(12)->addDays(5),
                'registered_at' => now()->subMonths(12)->addDays(12),
                'ic_received_at' => now()->subMonths(9)->addDays(8),
                'insurance_received_at' => now()->subMonths(6)->addDays(15),
                'status' => 'ic_received',
                'created_by' => $boeslAdmin?->id,
            ],
            [
                'bhc_no' => 'BHC010',
                'applicant_name' => 'Michael Antonio Santos',
                'passport_no' => 'P99776655',
                'phone_number' => '+673 7012345',
                'agency_name' => 'Global Staffing Solutions',
                'company_name' => 'Brunei Hotel Association',
                'registration_no' => 'REG-2025-107',
                'flight_date' => now()->subMonths(11)->subDays(20),
                'registered_at' => now()->subMonths(11)->subDays(15),
                'ic_received_at' => now()->subMonths(8)->subDays(10),
                'insurance_received_at' => now()->subMonths(5)->subDays(20),
                'status' => 'insurance_received',
                'created_by' => $boeslAdmin?->id,
            ],
            [
                'bhc_no' => 'BHC-TEST-3M',
                'applicant_name' => 'Test 3 Month Reminder',
                'passport_no' => 'T3M000000',
                'phone_number' => '+673 7000003',
                'agency_name' => 'Test Agency',
                'company_name' => 'Test Company',
                'registration_no' => 'REG-TEST-3M',
                'flight_date' => now()->subMonths(4),
                'registered_at' => now()->subMonths(3), // Exact 3 months ago
                'status' => 'registered',
                'created_by' => $boeslAdmin?->id,
            ],
            [
                'bhc_no' => 'BHC-TEST-6M',
                'applicant_name' => 'Test 6 Month Reminder',
                'passport_no' => 'T6M000000',
                'phone_number' => '+673 7000006',
                'agency_name' => 'Test Agency',
                'company_name' => 'Test Company',
                'registration_no' => 'REG-TEST-6M',
                'flight_date' => now()->subMonths(7),
                'registered_at' => now()->subMonths(6), // Exact 6 months ago
                'status' => 'registered',
                'created_by' => $boeslAdmin?->id,
            ],
        ];

        foreach ($applicantsData as $data) {
            Applicant::firstOrCreate(['bhc_no' => $data['bhc_no']], $data);
        }
    }
}
