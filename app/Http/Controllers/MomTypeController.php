<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\MomType;

use App\Http\Requests\MomTypeAddRequest;
use App\Http\Requests\MomTypeEditRequest;

use App\Http\Traits\SettingTrait;

class MomTypeController extends Controller
{
    use SettingTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = trim($request->get('search'));

        $types = MomType::orderBy('created_at', 'DESC')
            ->when(!empty($search), function($query) use($search) {
                $query->where('type', 'like', '%'.$search.'%');
            })
            ->paginate($this->getDataPerPage())
            ->appends(request()->query());
        
        return view('pages.types.index')->with([
            'search' => $search,
            'types' => $types
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MomTypeAddRequest $request)
    {
        $type = new MomType([
            'type' => $request->type
        ]);
        $type->save();

        // logs
        activity('created')
            ->performedOn($type)
            ->log(':causer.name has created type :subject.type');

        return redirect()->route('type.index')->with([
            'message_success' => __('adminlte::types.type_create_success')
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $type = MomType::findOrfail(decrypt($id));

        return view('pages.types.show')->with([
            'mom_type' => $type
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $type = MomType::findOrFail(decrypt($id));
        
        return view('pages.types.edit')->with([
            'type' => $type
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MomTypeEditRequest $request, $id)
    {
        $type = MomType::findOrFail(decrypt($id));

        $changes_arr['old'] = $type->getOriginal();

        $type->update([
            'type' => $request->type
        ]);

        $changes_arr['changes'] = $type->getChanges();

        // logs
        activity('updated')
            ->performedOn($type)
            ->withProperties($changes_arr)
            ->log(':causer.name has updated the type :subject.type');

        return back()->with([
            'message_success' => __('adminlte::types.type_update_success')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MomType $momType)
    {
        //
    }
}
