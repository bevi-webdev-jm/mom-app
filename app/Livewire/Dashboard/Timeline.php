<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Mom;

class Timeline extends Component
{
    public function render()
    {
        $moms = Mom::orderBy('meeting_date')
             ->when(!auth()->user()->hasRole('superadmin') && !auth()->user()->hasRole('admin'), function($query) {
                $query->whereHas('participants', function($qry) {
                    $qry->where('id', auth()->user()->id);
                })
                ->orWhere('user_id', auth()->user()->id);
            })
            ->get();

        $chartData = [];
        foreach($moms as $mom) {
            $longestDetail = $mom->details()->orderBy('target_date', 'DESC')->first();

            if(!empty($longestDetail)) {
                // calculate percentage of completion
                $details = $mom->details;
                $totalDetails = $details->count();
                $completedDetails = $details->where('status', 'completed')->count();
                $completionPercentage = $totalDetails > 0 ? $completedDetails / $totalDetails : 0;

                $chartData[] = [
                    'start' => $mom->meeting_date,
                    'end'   => $longestDetail->target_date,
                    'completed' => [
                        'amount' => $completionPercentage,
                        'fill' => 'green',
                    ],
                    'color' => 'navy',
                    'name' => $mom->mom_number,
                    'title' => $mom->agenda ?? '',
                    'status' => $mom->status ?? '',
                ];
            }
        }

        $this->dispatch('update-chart-3', data: $chartData);

        return view('livewire.dashboard.timeline');
    }
}
