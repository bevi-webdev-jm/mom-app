<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;

use App\Notifications\MomSubmittedNotification;
use App\Notifications\MomDetailSubmittedNotification;

class NotificationHelper {

    public static function sendNotification($users = [], $model, ...$params) {
        try {
            if(!empty($users)) {
                Notification::send($users, new $model(...$params));
            }
        } catch(\Exception $e) {
            Log::error('Notification failed: '.$e->getMessage());
        }
    }

    public static function notifyMomSubmitted($mom) {
        $users = $mom->participants;
        // notify all participants
        self::sendNotification($users, MomSubmittedNotification::class, $mom);

        foreach($mom->details as $detail) {
            $responsibles = [];
            foreach($detail->responsibles as $responsible) {
                $responsibles[$responsible->id] = $responsible;
            }

            // notify responsible users for their respective details
            self::sendNotification($responsibles, MomDetailSubmittedNotification::class, $detail);
        }

    }
}
