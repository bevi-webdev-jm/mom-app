<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Notifications\MomSubmittedNotification;
use App\Notifications\TestNotification;
use Illuminate\Support\Facades\Log;

use App\Http\Traits\SettingTrait;


class NotificationController extends Controller
{
    use SettingTrait;

    public function index(Request $request) {
        $search = trim($request->get('search'));

        $notifications = auth()->user()->notifications()
            ->orderBy('created_at', 'DESC')
            ->when(!empty($search), function($query) use($search) {
                $query->where('data', 'LIKE', '%'.$search.'%');
            })
            ->paginate(10)
            ->onEachSide(1);

        return view('notifications')->with([
            'notifications' => $notifications,
            'search' => $search
        ]);
    }

    public function testNotification() {
        try {
            // auth()->user()->notify(new MomSubmittedNotification(\App\Models\Mom::first()));
            \App\Models\User::find(12)->notify(new TestNotification());
            Log::error('Notification sent');
        } catch(\Exception $e) {
            Log::error('Notification failed: '.$e->getMessage());
        }

        return back();
    }
}
