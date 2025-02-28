<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NegativeResponseAlert extends Notification
{
    use Queueable;

    protected $survey;

    public function __construct($survey)
    {
        $this->survey = $survey;
    }

    public function via($notifiable)
    {
        return ['mail']; // You can also add SMS or database channels
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Alert: Negative Survey Response Detected')
                    ->line('An employee has submitted a survey with responses below the acceptable threshold.')
                    ->line('Employee ID: ' . $this->survey->employee_id)
                    ->action('Review Survey', url('/dashboard'))
                    ->line('Please review the details and take appropriate action.');
    }
}
