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


Route::post('/login', 'Api\AuthController@login');
Route::post('/register', 'Api\AuthController@register');
Route::middleware('auth:api')->post('/logout', 'Api\AuthController@logout');

// добавить аутентификацию и миделвер, проверку что юзер совпадает с аутентифецированным юзером
Route::group(['prefix' => 'users'], function () {
    Route::get('/{user}', 'Api\UserController@getUser');
    Route::get('/{user}/activities', 'Api\UserActivityController@getUserActivities');
    Route::post('/{user}/activities', 'Api\UserActivityController@addUserActivities');

    Route::get('/{user}/day-activities', 'Api\DayActivityController@getDayActivities');
    Route::post('/{user}/set-default-day-activities', 'Api\DayActivityController@setDefaultDayActivities');
});

Route::group(['prefix' => 'activities'], function () {
    Route::patch('/{activity}', 'Api\ActivitiesController@editActivity');
    Route::delete('/{activity}', 'Api\ActivitiesController@deleteActivity');
});

