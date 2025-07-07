<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\MomDetail;
use Illuminate\Support\Facades\DB;

class Status extends Component
{
    public function render()
    {
        $data = MomDetail::select(
            DB::raw("
                CASE
                    WHEN status = 'Open' AND DATE(NOW()) > target_date THEN 'Overdue'
                    WHEN status = 'Completed' AND completed_date > target_date THEN 'Extended'
                    WHEN status = 'Completed' AND completed_date <= target_date THEN 'On time'
                    WHEN status = 'Open' AND DATE(NOW()) <= target_date THEN 'Open'
                END as derived_status
            "),
            DB::raw('COUNT(*) as total')
        )
        ->when(!auth()->user()->hasRole('superadmin') && !auth()->user()->hasRole('admin'), function($query) {
            $query->whereHas('mom', function($qry) {
                $qry->whereHas('participants', function($qry1) {
                    $qry1->where('id', auth()->user()->id);
                })
                ->orWhere('user_id', auth()->user()->id);
            });
        })
        ->groupBy('derived_status')
        ->get();

        $chartData = [];
        $totalTopic = 0;
        foreach($data as $val) {
            $chartData[] = [
                'name' => $val->derived_status,
                'y' => $val->total
            ];
            $totalTopic += $val->total;
        }

        $this->dispatch('update-chart-1', data: $chartData, totalTopic: $totalTopic);

        return view('livewire.dashboard.status');
    }
}
