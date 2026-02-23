<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();
            $table->string('bhc_no');
            $table->string('applicant_name');
            $table->string('passport_no');
            $table->string('agency_name');
            $table->string('company_name');
            $table->date('flight_date');
            $table->string('status')->default('send to bhc-brunei');
            $table->string('phone_number')->nullable();
            $table->string('registration_no')->nullable();
            $table->date('registration_date')->nullable();
            $table->boolean('ic_card_received')->default(false);
            $table->boolean('insurance_received')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicants');
    }
};
