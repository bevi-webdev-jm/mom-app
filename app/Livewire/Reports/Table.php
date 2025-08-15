<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Models\MomDetail;
use Illuminate\Support\Facades\DB;

class Table extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $selected_users;
    public $status;

    public $status_arr = [
        'open' => 'secondary',
        'overdue' => 'danger',
        'extended' => 'warning',
        'on-time' => 'success',
    ];

    public function render()
    {
        $topics = MomDetail::select('*') // Start by selecting all existing columns
            ->addSelect(DB::raw("
                CASE
                    WHEN status = 'open' AND DATE(NOW()) > target_date THEN 'overdue'
                    WHEN status = 'completed' AND completed_date > target_date THEN 'extended'
                    WHEN status = 'completed' AND completed_date <= target_date THEN 'on-time'
                    WHEN status = 'open' AND DATE(NOW()) <= target_date THEN 'open'
                    ELSE status
                END as derived_status
            "))
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
            ->whereHas('mom', function($query) {
                $query->where('status', '<>', 'draft');
            })
            ->orderBy('target_date')
            ->with('responsibles', 'mom')
            ->paginate(10, ['*'], 'mom-page');
        
        return view('livewire.reports.table')->with([
            'topics' => $topics
        ]);
    }

    #[On('filter-user-selected')]
    public function updateResponsibles($selected, $status) {
        $this->selected_users = $selected;
        $this->status = $status;

        $this->resetPage('mom-page');
    }
}
