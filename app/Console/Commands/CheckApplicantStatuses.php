<?php

namespace App\Console\Commands;

use App\Models\Applicant;
use App\Models\User;
use App\Notifications\ICCardPendingNotification;
use App\Notifications\InsurancePendingNotification;
use Illuminate\Console\Command;
use Carbon\Carbon;

class CheckApplicantStatuses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-applicant-statuses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check applicants for pending IC card (3 months after flight) and Insurance (6 months after registration).';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $bhcAdmins = User::role('bhc-admin')->get();

        if ($bhcAdmins->isEmpty()) {
            $this->warn('No BHC Admins found to notify.');
            return;
        }

        // 1. IC Card Pending (3 months after flight date)
        $icCardPendingApplicants = Applicant::where('ic_card_received', false)
            ->whereNotNull('flight_date')
            ->whereDate('flight_date', '<=', Carbon::now()->subMonths(3)->toDateString())
            ->get();

        foreach ($icCardPendingApplicants as $applicant) {
            foreach ($bhcAdmins as $admin) {
                // Send notification. You might want to prevent duplicate notifications.
                // For simplicity, we just send it every time this command runs until resolved
                $admin->notify(new ICCardPendingNotification($applicant));
            }
        }

        $this->info("Notified BHC Admin about {$icCardPendingApplicants->count()} pending IC cards.");

        // 2. Insurance Pending (6 months after registration date)
        $insurancePendingApplicants = Applicant::where('insurance_received', false)
            ->whereNotNull('registration_date')
            ->whereDate('registration_date', '<=', Carbon::now()->subMonths(6)->toDateString())
            ->get();

        foreach ($insurancePendingApplicants as $applicant) {
            foreach ($bhcAdmins as $admin) {
                $admin->notify(new InsurancePendingNotification($applicant));
            }
        }

        $this->info("Notified BHC Admin about {$insurancePendingApplicants->count()} pending Insurances.");
    }
}
