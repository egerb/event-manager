<?php

namespace App\Http\Controllers;


use App\Participants;
use App\Profiles;
use App\PromoCodes;
use App\User;
use Illuminate\Http\Request;
use App\Events;
use App\Laps;
use Illuminate\Http\Response;
use Validator;


class RegisterController extends Controller
{
    public function allLaps(Request $request)
    {
        $events = Events::whereActive(true)->whereMainPage(true)->get();
        return view('front.events', [
            'events' => $events,
            'message' => 'Ивенты отсутствуют'
        ]);

    }

    public function getEvent($date, $slug)
    {
        /** @var Event $event */
        $event = Events::where('date', '=', $date)->whereSlug($slug)->first();
        return view('events.event_'.$event->uid,['event' =>$event]);
        //return \Response::json($event, 200);

    }

    public function firstStep($lapUid, Request $request)
    {
        $request->session()->forget('lap_uid','user_uid');
        //return $lapUid;
        $lap = Laps::findOrFail($this->getLapId($lapUid));
        if ($lap) session(['lap_uid' => $lap->uid]);
        return view('front.register.first-step',['lap' => $lap]);
    }

    private function getLapId($lapUid)
    {
        return Laps::whereUid($lapUid)->pluck('id')->first();
    }


    public function findUser(Request $request)
    {

            $fields = $request->all();

            $fields['phone'] = str_replace(['(',')','-'],'',$request->input('phone'));
            /** @var Validator $validation */
            $validation = Validator::make($fields, [
                'email' => 'required|email',
                'phone' => 'required',
            ]);

            if ($validation->fails()) {
                return \Response::json([
                    'state' => 'error',
                    'html' => view('front.register.message', [
                        'message' => $validation->errors()->all()[0],
                        'type' =>'warning'
                    ])->render()
                ], 200);
            } else {

                $user = User::whereEmail($fields['email'])->wherePhone($fields['phone'])->first();
                session([
                    'phone' => $fields['phone'],
                    'email' => $fields['email']
                ]);

                ($user) ? session(['user_uid' => $user->uid]) : $request->session()->forget('user_uid');

                return \Response::json([
                    'state' => 'success',
                    'profile' => ($user) ? Profiles::whereUserId($user->id)->first([
                        'first_name',
                        'last_name',
                        'birth_date',
                        'gender',
                        'city',
                        'contacts_data',
                        'team',
                        'club',
                        't_shirt_size'
                    ]) : null
                ], 200);
            }

    }


    public function registerParticipant(Request $request)
    {
        $data = $request->all();
        $lapUid = $data['lapUid'];
        unset($data['lapUid']);
        $partFields = [
            'additional_info' => $data['additional_info'],
            'additional_distance' => $data['additional_distance']
        ];
        unset($data['additional_info']);
        unset($data['additional_distance']);
        //Validation ???
        //return var_dump($request->session()->has('user_uid'));

        //Create new user and profile
        if (!$request->session()->has('user_uid')) {
            //Create new user
            $user = new User();
            $user->fill([
                'phone' => $request->session()->get('phone'),
                'email' => $request->session()->get('email'),
                'password' => bcrypt($request->session()->get('phone'))
            ]);
            $user->save();
            $partFields['user_id'] = $data['user_id'] = $user['id'];
            //Create new profile
            $profile = new Profiles();
            $profile->fill($data);
            $profile->save();
            session(['user_uid' => $user->uid]);
        }
        //Update existing profile
        else {
            //Update profile
            $data['user_id'] = $this->getUserId($request->session()->get('user_uid'));
            $profile = Profiles::whereUserId(
                $this->getUserId($request->session()->get('user_uid'))
            )->get()->first();
            $profile->fill($data);
            $profile->save();

            }

        // Fetch promo code
        //
        $price = Laps::whereId($this->getLapId($lapUid))->pluck('price')->first();
        if (!empty($data['promo_code'])) {
            $discount = PromoCodes::whereLapId($this->getLapId($lapUid))
                ->wherePromoCode($data['promo_code'])
                ->whereUsed(false)
                ->pluck('discount_percent')
                ->first();
            $price = ($discount) ? $price-$price/$discount : $price;
        }

        //Check participant


        if (Participants::whereUserId($data['user_id'])
                ->whereLapId($this->getLapId($lapUid))
                ->count()  == 0) {

        }

        //Register participant
        if (!empty($lapUid)
            && Participants::whereUserId($data['user_id'])
                ->whereLapId($this->getLapId($lapUid))
                ->count()  == 0) {
            $participant = new Participants();
            $participant->fill($partFields);
            $participant->lap_id = $this->getLapId($lapUid);
            $participant->save();
            return \Response::json([
                'state' => 'success',
                'html' => view('front.register.message', [
                    'message' => 'Вы успешно зарегистрированы! Произвести оплату? Цена:'.$price,
                    'type' =>'success'
                ])->render()
            ], 200);
        } else
            return \Response::json([
                'state' => 'error',
                'html' => view('front.register.message', [
                    'message' => 'Пользователь с такими данными уже зарегистрирован. Произвести оплату?Цена:'.$price,
                    'type' =>'warning'
                ])->render()
            ], 200);


    }

    private function getUserId($uid)
    {
        return User::whereUid($uid)->pluck('id')->first();
    }


    public function getExisitingUserProfile(Request $request)
    {

    }

    public function registerWithSocials(Request $request)
    {

    }
}
