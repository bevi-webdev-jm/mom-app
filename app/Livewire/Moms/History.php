<?php

namespace App\Livewire\Moms;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\MomApproval;
use Illuminate\Support\Facades\DB;

class History extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $mom;
    public $status_arr = [
        'draft'         => 'secondary',
        'submitted'     => 'info',
        'ongoing'       => 'warning',
        'completed'     => 'success',
    ];

    public function render()
    {

        $approval_dates = MomApproval::select(DB::raw('DATE(created_at) as date'))
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->where('mom_id', $this->mom->id)
            ->paginate(2, ['*'], 'mom-approval-page');

        $approval_data = [];
        foreach($approval_dates as $data) {
            $approvals = MomApproval::with('user')
                ->orderBy('created_at', 'DESC')
                ->where('mom_id', $this->mom->id)
                ->where(DB::raw('DATE(created_at)'), $data->date)
                ->get();
            
            $approval_data[$data->date] = $approvals;
        }

        return view('livewire.moms.history')->with([
            'approval_dates' => $approval_dates,
            'approvals' => $approval_data
        ]);
    }
}
