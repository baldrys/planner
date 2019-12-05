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
    Route::get('/users', 'Api\UserController@getUsers')->middleware('can:viewAny,user');
    Route::get('/users/{user}', 'Api\UserController@getUser')->middleware('can:view,user');
    Route::post('/users', 'Api\UserController@addUser')->middleware('can:create,user');
    Route::patch('/users/{user}', 'Api\UserController@updateUser')->middleware('can:update,user');
    Route::delete('/users/{user}', 'Api\UserController@deleteUser')->middleware('can:delete,user');

    Route::middleware(['can:view,user'])->group(function () {
        Route::get('/users/{user}/activities', 'Api\UserActivityController@getUserActivities');
        Route::get('/users/{user}/day-activities', 'Api\DayActivityController@getDayActivities');
        Route::patch('/users/{user}/activities/{activity}', 'Api\ActivitiesController@editActivity')
            ->middleware('can:update,activity');
        Route::post('/users/{user}/activities', 'Api\UserActivityController@addUserActivity');
        Route::delete('/users/{user}/activities/{activity}', 'Api\ActivitiesController@deleteActivity')
            ->middleware('can:delete,activity');
        Route::post('/users/{user}/set-default-day-activities', 'Api\DayActivityController@setDefaultDayActivities')
            ->middleware('admin');
    });
});