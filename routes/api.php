<?php

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

Route::post('/login', 'Api\AuthController@login');
Route::post('/register', 'Api\AuthController@register');

Route::middleware(['auth:api'])->group(function () {
    Route::get('/me', 'Api\AuthController@getUserInfo');
    Route::post('/logout', 'Api\AuthController@logout');
    Route::resource('users', 'Api\UserControllerResource');
    Route::resource('users.activities', 'Api\UserActivityResourceController');
    Route::middleware(['can:view,user'])->group(function () {
        Route::get('/users/{user}/day-activities', 'Api\DayActivityController@getDayActivities');
        Route::patch('/users/{user}/day-activities/{dayActivity}', 'Api\DayActivityController@editDayActivities')
            ->middleware('can:update,dayActivity');
    });
});