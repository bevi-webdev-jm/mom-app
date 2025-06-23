<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\MomDetail;
use Illuminate\Support\Facades\DB;

class UserCompleted extends Component
{
    public function render()
    {
        $data = MomDetail::query()
            ->leftJoin('mom_responsibles', 'mom_responsibles.mom_detail_id', '=', 'mom_details.id')
            ->leftJoin('users', 'users.id', '=', 'mom_responsibles.user_id')
            ->select(
                'users.name',
                DB::raw('COUNT(mom_details.id) as total'),
                DB::raw("SUM(CASE WHEN mom_details.status = 'Completed' THEN 1 ELSE 0 END) as completed_total")
            )
            ->whereNotNull('users.name')
            ->groupBy('users.name')
            ->get();

        $categories = $data->pluck('name')->unique()->values()->all();

        $series = [
            [
                'name' => 'Total',
                'data' => [],
            ],
            [
                'name' => 'Completed',
                'data' => [],
            ],
        ];

        foreach ($data as $val) {
            $series[0]['data'][] = (int) $val->total;
            $series[1]['data'][] = (int) $val->completed_total;
        }

        $chartData = [
            'categories' => $categories,
            'series' => $series,
        ];
        
        $this->dispatch('update-chart-2', data: $chartData);

        return view('livewire.dashboard.user-completed');
    }
}
