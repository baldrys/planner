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
    Route::post('/logout', 'Api\AuthController@logout');
    Route::resource('users', 'Api\UserControllerResource');
    Route::middleware(['can:view,user'])->group(function () {
        Route::get('/users/{user}/day-activities', 'Api\DayActivityController@getDayActivities');
        Route::patch('/users/{user}/day-activities/{dayActivity}', 'Api\DayActivityController@editDayActivities');

        // вынести в ресурсы и ресурс контроллелр объединить в один контроллер
        Route::patch('/users/{user}/activities/{activity}', 'Api\ActivitiesController@editActivity')
            ->middleware('can:update,activity');
        Route::delete('/users/{user}/activities/{activity}', 'Api\ActivitiesController@deleteActivity')
            ->middleware('can:delete,activity');

        Route::get('/users/{user}/activities', 'Api\UserActivityController@getUserActivities');
        Route::post('/users/{user}/activities', 'Api\UserActivityController@addUserActivity');

    });
});