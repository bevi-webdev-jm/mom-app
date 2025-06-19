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
        $subject = "MOM SUBMISSION [".$this->mom->mom_number.']';
        $greeting = "Hello, {$notifiable->name}";
        $introLines = [
            "A new Minutes of Meeting (MOM) with number \"<strong>{$this->mom->mom_number}</strong>\" has been submitted and requires your attention.",
            "Here are the details:"
        ];
        $tableData = [
            'MOM Number' => $this->mom->mom_number,
            'Agenda' => $this->mom->agenda,
            'Meeting Date' => \Carbon\Carbon::parse($this->mom->meeting_date)->format('F j, Y'),
            'Created By' => $this->mom->user->name
        ];
        $outroLines = [
            "Please review the submitted MOM at your earliest convenience by clicking the button above."
        ];

        $url = url('mom/' . encrypt($this->mom->id));

        return (new MailMessage)
            ->subject($subject)
            ->view('pages.mails.mail-template', [
                'emailTitle' => $subject,
                'emailHeading' => 'MOM DETAIL SUBMITTED',
                'greeting' => $greeting,
                'introLines' => $introLines,
                'outroLines' => $outroLines,
                'tableData' => $tableData,
                'url' => $url,
            ]);
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
