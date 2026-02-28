<?php

namespace App\Console\Commands;

use App\Models\Applicant;
use App\Models\User;
use App\Notifications\ApplicantUpdateReminder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;

class CheckApplicantNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'applicants:check-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for applicants who reached 3 or 6 months since registration and notify BHC admins.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking applicant registration dates...');

        $threeMonthsAgo = now()->subMonths(3)->toDateString();
        $sixMonthsAgo = now()->subMonths(6)->toDateString();

        $bhcAdmins = User::role(['bhc-admin', 'super-admin'])->get();

        if ($bhcAdmins->isEmpty()) {
            $this->warn('No BHC admins or Super admins found to notify.');
            return;
        }

        // 3-month reminders
        $applicants3 = Applicant::whereNotNull('registered_at')
            ->whereDate('registered_at', '<=', $threeMonthsAgo)
            ->get();

        foreach ($applicants3 as $applicant) {
            if (!$this->notificationExists($applicant->id, 3)) {
                Notification::send($bhcAdmins, new ApplicantUpdateReminder($applicant, 3));
                $this->info("Sent 3-month reminder for {$applicant->applicant_name}");
            }
        }

        // 6-month reminders
        $applicants6 = Applicant::whereNotNull('registered_at')
            ->whereDate('registered_at', '<=', $sixMonthsAgo)
            ->get();

        foreach ($applicants6 as $applicant) {
            if (!$this->notificationExists($applicant->id, 6)) {
                Notification::send($bhcAdmins, new ApplicantUpdateReminder($applicant, 6));
                $this->info("Sent 6-month reminder for {$applicant->applicant_name}");
            }
        }

        $this->info('Check complete.');
    }

    protected function notificationExists($applicantId, $months)
    {
        return DB::table('notifications')
            ->where('data->applicant_id', $applicantId)
            ->where('data->months', $months)
            ->exists();
    }
}
