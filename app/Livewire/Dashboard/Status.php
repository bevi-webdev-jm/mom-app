<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\MomDetail;
use Illuminate\Support\Facades\DB;

class Status extends Component
{
    public function render()
    {
        // Base query for MomDetail, applying user role filtering
        $baseQuery = MomDetail::query();

        // Apply user-specific filtering if not superadmin or admin
        if (!auth()->user()->hasRole('superadmin') && !auth()->user()->hasRole('admin')) {
            $baseQuery->whereHas('mom', function($qry) {
                $qry->whereHas('participants', function($qry1) {
                    $qry1->where('id', auth()->user()->id);
                })
                ->orWhere('user_id', auth()->user()->id);
            });
        }

        // Get the aggregated status data
        $data = (clone $baseQuery)->select(
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
        ->groupBy('derived_status')
        ->get();

        $chartData = [];
        $drilldownData = [];
        $totalTopic = 0;

        foreach($data as $val) {
            $derivedStatus = $val->derived_status;
            $total = $val->total;

            $chartData[] = [
                'name' => $derivedStatus,
                'y' => $total,
                'drilldown' => $derivedStatus // Link to drilldown data
            ];

            // --- Prepare drilldown data for the current derived status ---
            $responsibleCounts = [];

            // Get the MomDetails that fall under this derived status
            $momDetailsForStatus = (clone $baseQuery)
                ->whereRaw("
                    CASE
                        WHEN status = 'open' AND DATE(NOW()) > target_date THEN 'Overdue'
                        WHEN status = 'completed' AND completed_date > target_date THEN 'Extended'
                        WHEN status = 'completed' AND completed_date <= target_date THEN 'On time'
                        WHEN status = 'open' AND DATE(NOW()) <= target_date THEN 'Open'
                        ELSE status
                    END = ?", [$derivedStatus])
                ->with('responsibles') // Assuming 'responsibles' is a relationship on MomDetail
                ->get();

            // Aggregate responsible persons for this derived status
            foreach ($momDetailsForStatus as $momDetail) {
                foreach ($momDetail->responsibles as $responsible) {
                    // Assuming 'name' is the attribute for the responsible person's name
                    $name = $responsible->name ?? 'Unassigned'; // Fallback for unassigned or missing name
                    $responsibleCounts[$name] = ($responsibleCounts[$name] ?? 0) + 1;
                }
            }

            // Convert aggregated counts to the format required by Highcharts drilldown
            $drilldownItems = [];
            foreach ($responsibleCounts as $name => $count) {
                $drilldownItems[] = [$name, $count];
            }

            $drilldownData[] = [
                'id' => $derivedStatus,
                'data' => $drilldownItems
            ];
            
            $totalTopic += $total;
        }

        $this->dispatch('update-chart-1', data: $chartData, totalTopic: $totalTopic, drilldownData: $drilldownData);

        return view('livewire.dashboard.status');
    }
}

