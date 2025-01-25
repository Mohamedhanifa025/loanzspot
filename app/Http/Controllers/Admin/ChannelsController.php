<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Channel;
use App\Role;
use http\Client\Curl\User;
use Illuminate\Http\Request;

class ChannelsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $channels = Channel::orderBy('id', 'desc')->get();

        return view('admin.channels.index', compact('channels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $count = Channel::count();
        return view('admin.channels.create', compact('count'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userData = $request;
        $userData->merge(['name' => $request->admin_full_name]);
        //dd($request->all(),$request->only('name','email', 'password'));
        $user = \App\User::where('email', $request->email)->first();
        if(is_null($user)) {
            $user = \App\User::create($userData ->only('name', 'email', 'password'));
        }
        $channelPartnerRole = Role::where('title', 'Channel Partner')->first();
        $user->roles()->attach($channelPartnerRole);
        $request->merge(['user_id' => $user->id]);
//dd($request->except('_token', 'password'));
        $channel = Channel::create($request->except('_token', 'email','password'));

        return redirect('admin/channels')->with('success', 'Channel is created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function show(Channel $channel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function edit(Channel $channel)
    {
        return view('admin.channels.edit', compact('channel'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Channel $channel)
    {
        $userData = $request;
        $userData->merge(['name' => $request->admin_full_name]);
        $channel->user()->update($userData ->only('name', 'email'));
        if(!is_null($request->password)) {
            $channel->user()->update($userData ->only('password'));
        }
        $channel->update($request->except('_token', 'email','password'));
        return redirect('admin/channels')->with('success', 'Channel is updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Channel $channel)
    {
        $channel->delete();
        return redirect('admin/channels')->with('success', 'Channel is deleted successfully!');
    }
}
