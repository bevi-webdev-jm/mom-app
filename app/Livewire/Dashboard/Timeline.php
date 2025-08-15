<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Mom;
use App\Models\MomDetail;
use Illuminate\Support\Facades\DB;

class Timeline extends Component
{
    public function render()
    {
        // Define colors for different derived statuses
        $statusColors = [
            'Overdue' => '#f15c80', // Reddish
            'Extended' => '#f7a35c', // Orangish
            'On time' => '#90ed7d', // Greenish
            'Open' => '#7cb5ec',   // Bluish
            'completed' => '#90ed7d', // Default completed, though 'On time' and 'Extended' are more specific
            'open' => '#7cb5ec',     // Default open, though 'Overdue' is more specific
            // Add more statuses if needed
        ];

        // Fetch Mom records, eager load details, and apply user role filtering
        $moms = Mom::orderBy('meeting_date')
             ->when(!auth()->user()->hasRole('superadmin') && !auth()->user()->hasRole('admin'), function($query) {
                 $query->whereHas('participants', function($qry) {
                     $qry->where('id', auth()->user()->id);
                 })
                 ->orWhere('user_id', auth()->user()->id);
             })
             ->where('status', '<>', 'draft')
             ->with('details') // Eager load details to avoid N+1 query problem in the loop
             ->get();

        $chartData = [];
        $drilldownData = []; // Initialize drilldownData array for Highcharts drilldown

        foreach($moms as $mom) {
            // Find the detail with the latest target_date for the 'end' point of the timeline bar
            $longestDetail = $mom->details->sortByDesc('target_date')->first();

            if(!empty($longestDetail)) {
                // Calculate the percentage of completed details for this MOM
                $details = $mom->details;
                $totalDetails = $details->count();
                $completedDetails = $details->where('status', 'completed')->count();
                $completionPercentage = $totalDetails > 0 ? $completedDetails / $totalDetails : 0;

                // Create a unique ID for this MOM's drilldown series
                $momDrilldownId = 'mom-' . $mom->id;

                // Add data for the main timeline chart
                $chartData[] = [
                    'start' => $mom->meeting_date, // Convert to milliseconds for Highcharts
                    'end'   => $longestDetail->target_date, // Convert to milliseconds
                    'completed' => [
                        'amount' => $completionPercentage,
                        'fill' => 'green', // Color for the completion fill
                    ],
                    'color' => 'navy', // Color for the main timeline bar
                    'name' => $mom->mom_number,
                    'title' => $mom->agenda ?? '',
                    'status' => $mom->status ?? '',
                    'drilldown' => $momDrilldownId, // Link to the drilldown data for this MOM
                ];

                // --- Prepare drilldown data for the current MOM's details ---
                $drilldownItems = [];

                // Iterate through each detail of the current MOM to categorize its status and prepare drilldown data
                foreach ($details as $detail) {
                    $derivedStatus = '';
                    // Determine the derived status based on the same logic used in the Status component
                    if ($detail->status === 'open' && now()->greaterThan($detail->target_date)) {
                        $derivedStatus = 'Overdue';
                    } elseif ($detail->status === 'completed' && !empty($detail->completed_date) && $detail->completed_date->greaterThan($detail->target_date)) {
                        $derivedStatus = 'Extended';
                    } elseif ($detail->status === 'completed' && !empty($detail->completed_date) && $detail->completed_date->lessThanOrEqualTo($detail->target_date)) {
                        $derivedStatus = 'On time';
                    } elseif ($detail->status === 'open' && now()->lessThanOrEqualTo($detail->target_date)) {
                        $derivedStatus = 'Open';
                    } else {
                        $derivedStatus = $detail->status; // Fallback for any other custom statuses
                    }

                    // Add the individual MomDetail as a drilldown data point
                    $drilldownItems[] = [
                        'name' => $detail->topic, // Use the detail's topic or description as the name
                        'start' => $mom->meeting_date, // Start from the MoM meeting date
                        'end' => $detail->target_date, // End at the detail's target date
                        'color' => $statusColors[$derivedStatus] ?? '#cccccc', // Assign color based on derived status, fallback to grey
                        'next_step' => $detail->next_step,
                        'status'    =>$derivedStatus
                    ];
                }

                // Add the drilldown series for this MOM
                $drilldownData[] = [
                    'id' => $momDrilldownId, // Must match the 'drilldown' key in chartData
                    'name' => 'Details for ' . $mom->mom_number, // Name for the drilldown series
                    'data' => $drilldownItems
                ];  
            }
        }

        // Dispatch the event to update the chart, including the new drilldownData
        $this->dispatch('update-chart-3', data: $chartData, drilldownData: $drilldownData);

        return view('livewire.dashboard.timeline');
    }
}
