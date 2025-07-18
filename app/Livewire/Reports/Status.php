<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\MomDetail;
use Illuminate\Support\Facades\DB;

class Status extends Component
{
    public $selected_users = [];
    public $status;
    
    public function render()
    {
        $data = MomDetail::select(
            DB::raw("
                CASE
                    WHEN status = 'open' AND DATE(NOW()) > target_date THEN 'Overdue'
                    WHEN status = 'completed' AND completed_date > target_date THEN 'Extended'
                    WHEN status = 'completed' AND completed_date <= target_date THEN 'On time'
                    WHEN status = 'open' AND DATE(NOW()) <= target_date THEN 'Open'
                    ELSE status
                END as derived_status
            "),
            DB::raw('COUNT(*) as total')
        )
        ->when(!empty($this->selected_users), function($query) {
            $query->whereHas('responsibles', function($qry) {
                $qry->whereIn('id', array_keys($this->selected_users));
            });
        })
        ->when(!empty($this->status), function($query) {
            $query->whereRaw("
                CASE
                    WHEN status = 'open' AND DATE(NOW()) > target_date THEN 'overdue'
                    WHEN status = 'completed' AND completed_date > target_date THEN 'extended'
                    WHEN status = 'completed' AND completed_date <= target_date THEN 'on-time'
                    WHEN status = 'open' AND DATE(NOW()) <= target_date THEN 'open'
                    ELSE status
                END = ?
            ", [$this->status]);
        })
        ->groupBy('derived_status')
        ->get();

        return view('livewire.reports.status')->with([
            'data' => $data
        ]);
    }

    #[On('filter-user-selected')]
    public function updateResponsibles($selected, $status) {
        $this->selected_users = $selected;
        $this->status = $status;
    }
}
