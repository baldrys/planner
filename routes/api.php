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
Route::middleware('auth:api')->post('/logout', 'Api\AuthController@logout');

// добавить аутентификацию и миделвер, проверку что юзер совпадает с аутентифецированным юзером
Route::get('/users/{user}', 'Api\UserController@getUser');
Route::get('/users/{user}/activities', 'Api\UserActivityController@getUserActivities');
Route::post('/users/{user}/activities', 'Api\UserActivityController@addUserActivity');
Route::patch('/users/{user}/activities/{activity}', 'Api\ActivitiesController@editActivity');
Route::delete('/users/{user}/activities/{activity}', 'Api\ActivitiesController@deleteActivity');
Route::get('/users/{user}/day-activities', 'Api\DayActivityController@getDayActivities');
Route::post('/users/{user}/set-default-day-activities', 'Api\DayActivityController@setDefaultDayActivities');

// перенести к в группу пользовтелей, потому что пользователь может редактировать свои группы
// проверить что пользователь может редактировать только свои группы

