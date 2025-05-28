<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Mom;

use App\Http\Traits\SettingTrait;

class MomController extends Controller
{
    use SettingTrait;

    public function index(Request $request) {
        $search = trim($request->get('search'));

        $moms = Mom::orderBy('mom_number', 'DESC')
            ->when(!empty($search), function($query) {
                $query->where('mom_number', 'LIKE', '%'.$search.'%');
            })
            ->paginate($this->getDataPerPage())
            ->appends(request()->query());

        return view('pages.moms.index')->with([
            'search' => $search,
            'moms' => $moms,
        ]);
    }

    private function generateMomNumber() {
        $date_code = date('Ymd');

        do {
            $mom_number = 'MOM-'.$date_code.'-0001';
            // get the most recent sales order
            $mom = Mom::withTrashed()->orderBy('mom_number', 'DESC')
                ->first();
            if(!empty($mom)) {
                $latest_mom_number = $mom->mom_number;
                list(, $prev_date, $last_number) = explode('-', $latest_control_number);

                // Increment the number based on the date
                $number = ($date_code == $prev_date) ? ((int)$last_number + 1) : 1;

                // Format the number with leading zeros
                $formatted_number = str_pad($number, 4, '0', STR_PAD_LEFT);

                // Construct the new control number
                $mom_number = "MOM-$date_code-$formatted_number";
            }

        } while(Mom::withTrashed()->where('mom_number', $mom_number)->exists());

        return $mom_number;
    }

    public function create() {
        $mom = Mom::create([
            'mom_type_id' => NULL,
            'user_id' => auth()->user()->id,
            'mom_number' => $this->generateMomNumber(),
            'agenda' => '',
            'meeting_date' => date('Y-m-d'),
            'status' => 'draft',
        ]);

        // logs
        activity('created')
            ->performedOn($mom)
            ->log(':causer.name has created a new mom :subject.mom_number');

        return view('pages.moms.create')->with([
            'mom' => $mom
        ]);
    }


    public function edit($id) {
        $mom = Mom::findOrFail(decrypt($id));

        return view('pages.moms.edit')->with([
            'mom' => $mom
        ]);
    }
    
}
