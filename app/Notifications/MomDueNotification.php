<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Http\Traits\SettingTrait;

class MomDueNotification extends Notification
{
    use Queueable;
    use SettingTrait;

    public $detail;

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
        $formattedTargetDate = \Carbon\Carbon::parse($this->detail->target_date)->format('F j, Y');

        $subject = "MOM Topic Due Reminder: {$this->detail->mom->mom_number} - {$this->detail->topic}";
        $greeting = "Hello, {$notifiable->name}";
        $introLines = [
            "This is a reminder that the following MOM topic is approaching its due date:",
            "MOM Number: <strong>{$this->detail->mom->mom_number}</strong>",
            "Here are the details:"
        ];
        $tableData = [
            'Topic' => $this->detail->topic,
            'Next Step' => $this->detail->next_step,
            'Target Date' => $formattedTargetDate,
            'Status' => ucfirst($this->detail->status),
        ];
        $outroLines = [
            "Please take the necessary actions to complete this item by its target date of <strong>{$formattedTargetDate}</strong>.",
            "You can view the full MOM topic details by clicking the button above."
        ];

        $url = url('mom-topic/' . encrypt($this->detail->id));

        return (new MailMessage)
            ->subject($subject)
            ->view('pages.mails.mail-template', [
                'emailTitle' => $subject,
                'emailHeading' => 'MOM TOPIC DUE REMINDER',
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
        $formattedTargetDate = \Carbon\Carbon::parse($this->detail->target_date)->format('M j, Y');
        return [
            'title' => "MOM Topiuc Due: {$this->detail->topic}",
            'message' => "The MOM topic '{$this->detail->topic}' for MOM #{$this->detail->mom->mom_number} is due on {$formattedTargetDate}.",
            'action_url' => url('mom-topic/'.encrypt($this->detail->id)),
        ];
    }
}
