<?php
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', 'RegisterController@allLAps');

Route::get('event/{date}/{slug}', 'RegisterController@getEvent')->name('firstStep');

Route::post('/find-user', 'RegisterController@findUser')->name('findUser');
Route::post('/register-participant', 'RegisterController@registerParticipant')->name('registerParticipant');


Route::post('/register-on-event/{lap?}/second-step', 'RegisterController@secondStep')->name('secondStep');

Auth::routes();

Route::get('/{place?}', function ($place=null){
     $event = ($place)
         ? App\Events::whereSlug($place)->whereActive(true)->get()->first()
         : App\Events::whereMainPage(true)->get()->first();
     return view('front.event', ['event' => $event]);
})->name('one.event');



Route::get('/home', 'HomeController@index')->name('home');



Route::group([
    'prefix' => 'admin',
    //'namespace' => 'admin',
    'middleware' => ['auth']
], function (){


    /*Route::get('/', function (){
        return 'dsfsdfsdf';
        //return redirect()->route('events-table');
    });*/



    Route::get('/events-table', function () {
        return view('admin.events');
    })->name('events-table');

    Route::get('/laps-table', function (Request $request) {
        return view('admin.laps', [
            'event' => $request->input('event', null)
        ]);
    })->name('laps-table');

    Route::get('/promo-table', function (Request $request) {
        return view('admin.promo-codes', [
            'lap' => $request->input('lap', null)
        ]);
    })->name('promo-table');

    Route::get('/participants-table', function (Request $request) {
        return view('admin.partisipants', [
            'lap' => $request->input('lap', null)
        ]);
    })->name('participants-table');

});


