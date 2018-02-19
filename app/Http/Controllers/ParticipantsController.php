<?php

namespace App\Http\Controllers;

use App\Events;
use App\Laps;
use App\Participants;
use App\Profiles;
use Illuminate\Http\Request;

class ParticipantsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Participants::whereLapId($this->getLapId(
            $request->input('lapUid')
        ))->with('user')->paginate(10);
        //return Participants::whereLapId($this->getLapId($lapUid))->paginate($request->input('pre_page',10))->get();
    }

    private function getLapId($uid)
    {
        return Laps::whereUid($uid)->pluck('id')->first();
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Participants  $participants
     * @return \Illuminate\Http\Response
     */
    public function show(Participants $participants)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Participants  $participants
     * @return \Illuminate\Http\Response
     */
    public function edit(Participants $participants)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Participants  $participants
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Participants $participants)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Participants  $participants
     * @return \Illuminate\Http\Response
     */
    public function destroy(Participants $participants)
    {
        //
    }
}
