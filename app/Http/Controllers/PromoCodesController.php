<?php

namespace App\Http\Controllers;

use App\Laps;
use App\PromoCodes;
use Illuminate\Http\Request;


class PromoCodesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->has('lap')) {
            return PromoCodes::whereLapId($this->getLapId($request->input('lap')))
                ->orderBy('updated_at','desc')
                ->paginate(10);
        }
        else
            return PromoCodes::orderBy('updated_at','desc')->paginate($request->input('per_page'));
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
        if ($request->has('data')) {
            $lap = new PromoCodes;
            $lap->fill($request->input('data'));
            $validator = \Validator::make($request->input('data'), [
                'promo_code' => 'required'
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors();
                return \Response::json([
                    'state' => 'error',
                    'message' => 'Данные для '.$request->input('data.promo_code').'не сохранены. <br/>'
                        .$errors->all()[0]
                ], 200);
            } else {
                $lap->save();
                return \Response::json([
                    'state' => 'success',
                    'message' => 'Данные для '.$request->input('data.promo_code').' сохранены.'
                ], 200);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PromoCodes  $promoCodes
     * @return \Illuminate\Http\Response
     */
    public function show(PromoCodes $promoCodes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PromoCodes  $promoCodes
     * @return \Illuminate\Http\Response
     */
    public function edit(PromoCodes $promoCodes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PromoCodes  $promoCodes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uid)
    {
        if ($request->has('data')) {
            $data = $request->input('data');
            $data = array_diff_key($data, ['id'=>'','uid'=>'','updated_at'=>'', 'created_at'=>'']);
            $promo = PromoCodes::whereUid($uid)->first();
            $promo->fill($data);
            try {
                $promo->save();
                return \Response::json([
                    'state' => 'success',
                    'message' => 'Данные для '.$promo->promo_code.' сохранены.'
                ], 200);
            } catch (Exception $e) {
                return \Response::json(['state' => 'error', 'message' => $e->getMessage()], 200);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $uid
     * @return \Illuminate\Http\Response
     */
    public function destroy($uid)
    {

        if (isset($uid)) {
            $promo = PromoCodes::whereUid($uid)->first();
            $promo->delete();
            return \Response::json([
                'state' => 'success',
                'message' => 'Данные для '.$promo->title.' удалены.'
            ], 200);
        }
    }
}
