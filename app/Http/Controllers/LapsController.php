<?php

namespace App\Http\Controllers;

use App\Laps;
use Illuminate\Http\Request;
use App\Events;

class LapsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('event') && $request->input('per_page') != 'all') {

            return Laps::whereEventId($this->getEventId($request->input('event')))->orderBy('updated_at','desc')->paginate(15);
        } else if ($request->has('per_page') && $request->input('per_page') == 'all') {
            return Laps::orderBy('updated_at','desc')->get();
        } else
        return Laps::orderBy('updated_at','desc')->paginate(15);
    }


    private function getEventId($uid) {
        return Events::whereUid($uid)->pluck('id')->first();
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
        if ($request->has('data')) {
            $lap = new Laps;
            $lap->fill($request->input('data'));
            $validator = \Validator::make($request->input('data'), [
                'title' => 'required',
                'partisipant_start_number'  => 'required'
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors();
                return \Response::json([
                    'state' => 'error',
                    'message' => 'Данные для '.$request->input('data.title').'не сохранены. <br/>'
                        .$errors->all()[0]
                ], 200);
            } else {
                $lap->save();
                return \Response::json([
                    'state' => 'success',
                    'message' => 'Данные для '.$request->input('data.title').' сохранены.'
                ], 200);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Laps  $laps
     * @return \Illuminate\Http\Response
     */
    public function show(Laps $laps)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Laps  $laps
     * @return \Illuminate\Http\Response
     */
    public function edit(Laps $laps)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Laps  $uid
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uid)
    {
        if ($request->has('data')) {
            $data = $request->input('data');
            $data = array_diff_key($data, ['updated_at'=>'', 'created_at'=>'']);
            //return $request->input('data');
            $lap = Laps::whereUid($uid)->first();
            $lap->fill($data);
            try {
                $lap->save();
                return \Response::json([
                    'state' => 'success',
                    'message' => 'Данные для '.$lap->title.' сохранены.'
                ], 200);
            } catch (Exception $e) {
                return \Response::json(['state' => 'error', 'message' => $e->getMessage()], 200);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer  $uid
     * @return \Illuminate\Http\Response
     */
    public function destroy($uid)
    {

        if (isset($uid)) {
            $lap = Laps::whereUid($uid)->first();
            $lap->delete();
            return \Response::json([
                'state' => 'success',
                'message' => 'Данные для '.$lap->title.' удалены.'
            ], 200);
        }
    }


}
