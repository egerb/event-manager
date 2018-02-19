<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('/events', 'EventsController', [
    'except' => ['create', 'edit'],
    'as' => 'events'
]);
Route::resource('/laps', 'LapsController', [
    'except' => ['create', 'edit'],
    'as' => 'laps'
]);

Route::resource('/promo', 'PromoCodesController', [
    'except' => ['create', 'edit'],
    'as' => 'promo'
]);

Route::resource('/participants', 'ParticipantsController', [
    'except' => ['create', 'edit'],
    'as' => 'participants'
]);
