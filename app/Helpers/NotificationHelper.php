<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;

use App\Notifications\MomSubmittedNotification;
use App\Notifications\MomDetailSubmittedNotification;

class NotificationHelper {

    public static function sendNotification($model, $users = []) {
        try {
            if(!empty($users)) {
                Notification::send($users, new $model());
            }
        } catch(\Exception $e) {
            Log::error('Notification failed: '.$e->getMessage());
        }
    }

    public static function NotifyMomSubmitted($mom) {
        $users = $mom->participants;
        // notify all participants
        self::sendNotification(MomSubmittedNotification::class, $users);

        $responsibles = [];
        foreach($mom->details as $detail) {
            foreach($detail->responsibles as $responsible) {
                $responsibles[$responsible->id] = $responsible;
            }
        }

        // notify responsible users for their respective details
        self::sendNotification(MomDetailSubmittedNotification::class, $responsibles);
    }
}
