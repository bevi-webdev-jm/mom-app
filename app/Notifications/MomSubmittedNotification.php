<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Http\Traits\SettingTrait;

class MomSubmittedNotification extends Notification
{
    use Queueable;
    use SettingTrait;

    protected $message;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        $this->message = 'A new MOM has been submitted.';
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        if($this->getEmailSending()) {
            return ['database', 'mail'];
        } else {
            return ['database'];
        }
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('New MOM Submitted')
                    ->greeting('Hello!')
                    ->line('A new MOM has been submitted and requires your attention.')
                    ->action('View MOMs', url('/moms'))
                    ->line('Please review the MOM at your earliest convenience.')
                    ->salutation('Regards, Your Application Team');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Mom Submitted',
            'message' => $this->message,
            'action_url' => url('mom'),
        ];
    }
}
