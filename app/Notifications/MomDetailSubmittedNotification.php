<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Http\Traits\SettingTrait;

class MomDetailSubmittedNotification extends Notification
{
    use Queueable;
    use SettingTrait;

    protected $detail;

    /**
     * Create a new notification instance.
     */
    public function __construct($detail)
    {
        $this->detail = $detail;
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
        $subject = "MOM TOPIC SUBMISSION {$this->detail->mom->mom_number}";
        $greeting = "Hello, {$notifiable->name}";
        $introLines = [
            "A new Mom Topic regarding the topic \"<strong>{$this->detail->topic}</strong>\" has been submitted for MOM number <strong>{$this->detail->mom->mom_number}</strong>. Your review is requested.",
            "Here are the details:"
        ];
        $tableData = [
            'Topic' => $this->detail->topic,
            'Next Step' => $this->detail->next_step,
            'Target Date' => \Carbon\Carbon::parse($this->detail->target)->format('F j, Y'),
        ];
        $outroLines = [
            "Please review the submitted MOM topic at your earliest convenience by clicking the button above."
        ];

        $url = url('mom-topic/' . encrypt($this->detail->id));

        return (new MailMessage)
            ->subject($subject)
            ->view('pages.mails.mail-template', [
                'emailTitle' => $subject,
                'emailHeading' => 'MOM TOPIC SUBMITTED',
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
            'message' => 'A MOM detail has been submitted and requires your attention.',
            'action_url' => url('mom-topic/'.encrypt($this->detail->id)),
        ];
    }
}
