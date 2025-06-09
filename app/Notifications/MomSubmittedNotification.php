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

    protected $mom;

    /**
     * Create a new notification instance.
     */
    public function __construct($mom)
    {
        $this->mom = $mom;
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
                    ->line('A new MOM ['.$this->mom->mom_number.'] has been submitted and requires your attention.')
                    ->action('View Details', url('/mom'.encrypt($this->mom->id)))
                    ->line('Please review the MOM at your earliest convenience.')
                    ->salutation('Regards, IT Dept');

        return (new MailMessage)
            ->subject('New MOM Submitted')
            ->view('mails.mom-mail', ['mom' => $this->mom]);
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
            'message' => 'A new MOM ['.$this->mom->mom_number.'] has been submitted and requires your attention.',
            'action_url' => url('mom/'.encrypt($this->mom->id)),
        ];
    }
}
