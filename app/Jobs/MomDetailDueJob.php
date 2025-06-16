<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\MomDetail;
use Carbon\Carbon;
use App\Http\Traits\SettingTrait;

use Illuminate\Support\Facades\Notification;
use App\Notifications\MomDueNotification;

class MomDetailDueJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use SettingTrait;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $current_date = Carbon::today();
        $three_days_later = Carbon::today()->addDays($this->getNotificationDaysBefore());

        // check all details with less than 3 days
        $details = MomDetail::where('status', '<>', 'completed')
            ->whereBetween('target_date', [$current_date, $three_days_later])
            ->get();

        foreach($details as $detail) {
            foreach($detail->responsibles as $responsible) {
                try {
                    Notification::send($responsible, new MomDueNotification($detail));
                } catch(\Exception $e) {
                    Log::error('Notification failed: '.$e->getMessage());
                }
            }
        }
    }
}
