<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;

use App\Notifications\MomSubmittedNotification;
use App\Notifications\MomDetailSubmittedNotification;
use App\Notifications\MomCompletedNotification;

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

    public static function notifyMomDetailCompleted($detail) {
        $users = $detail->mom->participants;
        // if current user is in the participants remove them from the list
        if ($users instanceof \Illuminate\Support\Collection) {
            // Remove the current user from the collection if they exist
            $currentUser = auth()->user();
            $users = $users->reject(function ($participant) use ($currentUser) {
                return $participant->id === $currentUser->id;
            });
        } elseif (is_array($users)) {
            // Handle if $users is an array of user objects or IDs
            $users = array_filter($users, function ($participant) use ($currentUser) {
                return is_object($participant) && isset($participant->id) && $participant->id !== $currentUser->id;
            });
        }

        self::sendNotification($users, MomCompletedNotification::class, $detail);
    }

    
}
