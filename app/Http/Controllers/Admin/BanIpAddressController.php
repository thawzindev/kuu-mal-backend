<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BanIpAddress;
use Illuminate\Http\Request;

class BanIpAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $route = route('admin.ips.store');
        $ips = BanIpAddress::get();

        return view('admin.banned_ips.index', compact('ips', 'route'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        BanIpAddress::truncate();
        
        foreach ($request->ips as $key => $ip) {

            BanIpAddress::create(
                ['ip_address'   => $ip]
            );
        }

        return back()->with('flash', 'Successfully updated!.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BanIpAddress  $banIpAddress
     * @return \Illuminate\Http\Response
     */
    public function show(BanIpAddress $banIpAddress)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BanIpAddress  $banIpAddress
     * @return \Illuminate\Http\Response
     */
    public function edit(BanIpAddress $banIpAddress)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BanIpAddress  $banIpAddress
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BanIpAddress $banIpAddress)
    {
        //
    }

    public function banIp($ip)
    {
        BanIpAddress::updateOrCreate(
            ['ip_address' => $ip]
        );

        return back()->with('flash', 'Banned Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BanIpAddress  $banIpAddress
     * @return \Illuminate\Http\Response
     */
    public function destroy(BanIpAddress $banIpAddress)
    {
        //
    }
}
