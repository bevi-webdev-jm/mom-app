<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Http\Requests\LocationAddRequest;
use App\Http\Requests\LocationEditRequest;

use App\Http\Traits\SettingTrait;

class LocationController extends Controller
{
    use SettingTrait;

    public function index(Request $request)
    {
        $search = trim($request->get('search'));

        $locations = Location::orderBy('created_at', 'desc')
            ->when(!empty($search), function($query) use($search) {
                $query->where('location_name', 'LIKE', '%'.$search.'%')
                    ->orWhere('address', 'LIKE', '%'.$search.'%');
            })
            ->paginate($this->getDataPerPage())
            ->appends(request()->query());

        return view('pages.locations.index', [
            'search' => $search,
            'locations' => $locations,
        ]);
    }

    public function create()
    {
        return view('pages.locations.create');
    }

    public function store(LocationAddRequest $request)
    {
        $location = new Location([
            'location_name' => $request->location_name,
            'address' => $request->address,
        ]);
        $location->save();

        // logs
        activity('created')
            ->performedOn($location)
            ->log(':causer.name has created a new location ['.$location->location_name.']');

        return redirect()->route('location.index')->with([
            'message_success' => __('adminlte::locations.location_create_success')
        ]);
    }

    public function show($id)
    {
        $location = Location::findOrFail(decrypt($id));

        return view('pages.locations.show', [
            'location' => $location,
        ]);
    }

    public function edit($id)
    {
        $location = Location::findOrFail(decrypt($id));

        return view('pages.locations.edit', [
            'location' => $location,
        ]);
    }

    public function update(LocationEditRequest $request, $id)
    {
        $location = Location::findOrFail(decrypt($id));

        $changes_arr['old'] = $location->getOriginal();

        $location->update([
            'location_name' => $request->location_name,
            'address' => $request->address,
        ]);

        $changes_arr['changes'] = $location->getChanges();

        // logs
        activity('updated')
            ->performedOn($location)
            ->withProperties($changes_arr)
            ->log(':causer.name has updated location ['.$location->location_name.']');

        return back()->with([
            'message_success' => __('adminlte::locations.location_update_success')
        ]);
    }
}
