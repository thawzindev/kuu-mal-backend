<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Volunteer;
use App\Models\State;
use Illuminate\Http\Request;
use App\Http\Requests\VolunteerRequest;
use App\Filters\VolunteerFilter;

class VolunteerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(VolunteerFilter $filter, Request $request)
    {
        $states = State::get();
        $volunteers = Volunteer::filter($filter)->with(['state', 'township'])->paginate();

        return view('admin.volunteers.index', compact('volunteers', 'states'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $route = route('admin.volunteers.store');
        $states = State::get();
        return view('admin.volunteers.create', compact('states', 'route'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VolunteerRequest $request)
    {
        $data = $request->validated();

        $data['password'] = bcrypt($request->password);

        Volunteer::create($data);

        return redirect()->route('admin.volunteers.index')->with('flash', 'Success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Volunteer  $volunteer
     * @return \Illuminate\Http\Response
     */
    public function show(Volunteer $volunteer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Volunteer  $volunteer
     * @return \Illuminate\Http\Response
     */
    public function edit(Volunteer $volunteer)
    {
        $route = route('admin.volunteers.update', $volunteer->id);
        $states = State::get();
        return view('admin.volunteers.edit' , compact('states', 'volunteer', 'states', 'route'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Volunteer  $volunteer
     * @return \Illuminate\Http\Response
     */
    public function update(VolunteerRequest $request, Volunteer $volunteer)
    {
        $data = $request->validated();

        $data['password'] = $data['password'] == null ? $volunteer->password : bcrypt($data['password']);

        $volunteer->update($data);

        return redirect()->route('admin.volunteers.index')->with('flash', 'Successfully updated.!');
    }

    public function updateStatus(Volunteer $volunteer)
    {
        $volunteer->update(['active' => !$volunteer->active]);

        return back()->with('flash', 'Successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Volunteer  $volunteer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Volunteer $volunteer)
    {
        $volunteer->delete();

        return back()->with('flash', 'Successfully deleted.');
    }
}
