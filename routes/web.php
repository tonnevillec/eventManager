<?php

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

Route::get('/', [
    'as' => 'home',
    'uses' => 'EventController@index'
]);

Route::group(['prefix' => 'event'], function () {
    Route::post('create', [
        'as' => 'event.create',
        'uses' => 'EventController@create'
    ]);

    Route::post('edit', [
        'as' => 'event.edit',
        'uses' => 'EventController@edit'
    ]);

    Route::get('{eventType}-{eventId}', [
        'as' => 'event.get',
        'uses' => 'EventController@get'
    ]);

    Route::delete('delete', [
        'as' => 'event.delete',
        'uses' => 'EventController@delete'
    ]);
});

