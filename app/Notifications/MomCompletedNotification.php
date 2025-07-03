<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Http\Traits\SettingTrait;

class MomCompletedNotification extends Notification
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
        $subject = "MOM Topic Completed: {$this->detail->mom->mom_number} - {$this->detail->topic}";
        $greeting = "Hello, {$notifiable->name}";
        $introLines = [
            "The following MOM topic has been marked as completed:",
            "MOM Number: <strong>{$this->detail->mom->mom_number}</strong>",
            "Here are the details:"
        ];
        $tableData = [
            'Topic' => $this->detail->topic,
            'Original Next Step' => $this->detail->next_step,
            'Target Date' => \Carbon\Carbon::parse($this->detail->target)->format('F j, Y'),
            'Status' => ucfirst($this->detail->status), // Should reflect 'Completed'
            'Completed On' => $this->detail->updated_at->format('F j, Y'), // Assuming updated_at reflects completion
        ];
        $outroLines = [
            "This item is now considered closed. No further action is required for this specific topic.",
            "You can view the full MOM topic details by clicking the button below."
        ];

        $url = url('mom-topic/' . encrypt($this->detail->id));

        return (new MailMessage)
            ->subject($subject)
            ->view('pages.mails.mail-template', [
                'emailTitle' => $subject,
                'emailHeading' => 'MOM TOPIC COMPLETED',
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
            'title' => "MOM Topic Completed",
            'message' => "The MOM topic '{$this->detail->topic}' for MOM #{$this->detail->mom->mom_number} has been marked as completed.",
            'action_url' => url('mom-topic/'.encrypt($this->detail->id)),
        ];
    }
}
