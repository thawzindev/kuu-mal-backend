<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HelpRequestList;
use App\Models\State;
use Illuminate\Http\Request;
use App\Filters\HelpRequestListFilter;
use App\Http\Requests\HelpRequestListRequest;

class HelpRequestListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(HelpRequestListFilter $filter)
    {
        $requests = HelpRequestList::filter($filter)->latest()->paginate();
        $states = State::get();

        return view('admin.help_requests.index', compact('requests', 'states'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $route = route('admin.requests.store');
        $states = State::get();
        return view('admin.help_requests.create', compact('states', 'route'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HelpRequestListRequest $request)
    {
        $data = $request->validated();

        $data['uuid'] = help_uuid();
        HelpRequestList::create($data);

        return redirect()->route('admin.requests.index')->with('flash', 'Successfully updated');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HelpRequestList  $helpRequestList
     * @return \Illuminate\Http\Response
     */
    public function show(HelpRequestList $helpRequestList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HelpRequestList  $helpRequestList
     * @return \Illuminate\Http\Response
     */
    public function edit(HelpRequestList $request)
    {
        $route = route('admin.requests.update', $request->id);
        $states = State::get();
        return view('admin.help_requests.edit' , compact('states', 'request', 'states', 'route'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HelpRequestList  $helpRequestList
     * @return \Illuminate\Http\Response
     */
    public function update(HelpRequestListRequest $req, HelpRequestList $request)
    {   
        $data = $req->validated();

        $request->update($data);

        return redirect()->route('admin.requests.index')->with('flash', 'Successfully updated');
    }

    public function updateStatus(HelpRequestList $request)
    {
        $request->update(['status'  => !$request->status]);

        return back()->with('flash', 'Successfully updated!.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HelpRequestList  $helpRequestList
     * @return \Illuminate\Http\Response
     */
    public function destroy(HelpRequestList $request)
    {
        $request->delete();

        return back()->with('flash', 'Successfully deleted.!');
    }
}
