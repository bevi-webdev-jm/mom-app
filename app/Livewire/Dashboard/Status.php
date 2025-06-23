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
            'status',
            DB::raw('COUNT(status) as total')
        )
        ->groupBy('status')
        ->get();

        $chartData = [];
        foreach($data as $val) {
            $chartData[] = [
                'name' => $val->status,
                'y' => $val->total
            ];
        }

        $this->dispatch('update-chart-1', data: $chartData);

        return view('livewire.dashboard.status');
    }
}
