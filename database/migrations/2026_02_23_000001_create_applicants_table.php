<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
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
            $table->unsignedBigInteger('created_by')->nullable();
            $table->enum('status', ['pending', 'sent_to_bhc', 'registered', 'ic_received', 'insurance_received'])
                  ->default('pending');
            $table->string('phone_number')->nullable();
            $table->string('registration_no')->nullable();
            $table->timestamp('registered_at')->nullable();
            $table->timestamp('ic_received_at')->nullable();
            $table->timestamp('insurance_received_at')->nullable();
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
?>
