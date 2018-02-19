<?php

namespace App\Http\Controllers;

use App\Events;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;


class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return ($request->has('per_page') && $request->input('per_page') == 'all')
            ? Events::orderBy('updated_at','desc')->get()
            : Events::orderBy('updated_at','desc')
        ->paginate(10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

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
            $event = new Events;
            $event->fill($request->input('data'));
            $validator = Validator::make($request->input('data'), [
                'title' => 'required',
                'date'  => 'required',
                'active' => 'required',
                'place' => 'required'
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors();
                return \Response::json([
                    'state' => 'error',
                    'message' => 'Данные для '.$request->input('data.title').'не сохранены. <br/>'
                        .$errors->all()[0]
                ], 200);
            } else {
                $event->save();
                \Storage::disk('views')->copy('event_main_page.blade.php', 'event_'.$event->uid.'.blade.php');
                //return \Storage::disk('views')->files();
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
     * @param  \App\Events  $events
     * @return \Illuminate\Http\Response
     */
    public function show(Events $events)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Events  $events
     * @return \Illuminate\Http\Response
     */
    public function edit(Events $events)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Events  $events
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uid)
    {
       if ($request->has('data')) {
           $data = $request->input('data');
           $data = array_diff_key($data, ['uid'=>'','updated_at'=>'', 'created_at'=>'']);
           $event = Events::whereUid($uid)->first();
           $event->fill($data);
           try {
               $event->save();
               return \Response::json([
                   'state' => 'success',
                   'message' => 'Данные для '.$event->title.' сохранены.'
               ], 200);
           } catch (Exception $e) {
               return \Response::json(['state' => 'error', 'message' => $e], 200);
           }
       }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($uid)
    {

        if (isset($uid)) {
            $event = Events::whereUid($uid)->first();
            try {
                Storage::disk('views')->delete('event_'.$event->uid.'.blade.php');
            } catch (\Exception $exception) {

            }
            $event->delete();
            return \Response::json([
                'state' => 'success',
                'message' => 'Данные для '.$event->title.' удалены.'
            ], 200);
        }

    }
}
