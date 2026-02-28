<?php

namespace App\Notifications;

use App\Models\Applicant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplicantUpdateReminder extends Notification
{
    use Queueable;

    protected $applicant;
    protected $months;

    /**
     * Create a new notification instance.
     */
    public function __construct(Applicant $applicant, int $months)
    {
        $this->applicant = $applicant;
        $this->months = $months;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'applicant_id' => $this->applicant->id,
            'applicant_name' => $this->applicant->applicant_name,
            'passport_no' => $this->applicant->passport_no,
            'message' => "Applicant {$this->applicant->applicant_name} ({$this->applicant->passport_no}) has reached {$this->months} months since registration. Please update their info.",
            'months' => $this->months,
        ];
    }
}
