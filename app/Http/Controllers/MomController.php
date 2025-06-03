<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Mom;
use App\Http\Traits\SettingTrait;
use Illuminate\Support\Facades\Session;
use App\Helpers\MomNumberHelper;

class MomController extends Controller
{
    use SettingTrait;

    public $status_arr = [
        'draft'         => 'secondary',
        'submitted'     => 'info',
        'ongoing'       => 'warning',
        'completed'     => 'success',
    ];

    public function index(Request $request) {
        $search = trim($request->get('search'));

        Session::forget('mom_data');

        $moms = Mom::orderBy('mom_number', 'DESC')
            ->when(!empty($search), function($query) use($search) {
                $query->where('mom_number', 'LIKE', '%'.$search.'%')
                    ->orWhere('agenda', 'LIKE', '%'.$search.'%')
                    ->orWhere('meeting_date', 'LIKE', '%'.$search.'%')
                    ->orWhere('status', 'LIKE', '%'.$search.'%')
                    ->orWhereHas('user', function($qry) use($search) {
                        $qry->where('name', 'LIKE', '%'.$search.'%');
                    });
            })
            ->paginate($this->getDataPerPage())
            ->appends(request()->query());

        return view('pages.moms.index')->with([
            'search' => $search,
            'moms' => $moms,
            'status_arr' => $this->status_arr,
        ]);
    }

    public function create() {
        $mom_data = Session::get('mom_data');
        if(empty($mom_data)) {
            $mom = Mom::create([
                'mom_type_id' => NULL,
                'user_id' => auth()->user()->id,
                'mom_number' => MomNumberHelper::generateMomNumber(),
                'agenda' => '',
                'meeting_date' => date('Y-m-d'),
                'status' => 'draft',
            ]);

            Session::put('mom_data', $mom);
    
            // logs
            activity('created')
                ->performedOn($mom)
                ->log(':causer.name has created a new mom :subject.mom_number');
        } else {
            $mom = $mom_data;
        }

        return view('pages.moms.create')->with([
            'mom' => $mom
        ]);
    }

    public function show($id) {
        $mom = Mom::findOrFail(decrypt($id));

        return view('pages.moms.show')->with([
            'mom' => $mom,
            'status_arr' => $this->status_arr,
        ]);
    }

    public function edit($id) {
        $mom = Mom::findOrFail(decrypt($id));

        return view('pages.moms.edit')->with([
            'mom' => $mom
        ]);
    }

    public function upload() {
        return view('pages.moms.upload');
    }
    
}
