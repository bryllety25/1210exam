<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['namespace' => "App\Http\Controllers"], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', 'AuthController@login');
        Route::post('register', 'AuthController@register');
    });

    Route::group(['prefix' => 'task'], function () {
    Route::get('download/{id}', 'TaskController@download');
    });

    Route::group(['middleware' => "auth:sanctum"], function () {
      Route::group(['prefix' => 'auth'], function () {
        Route::get('me', 'AuthController@me');
        });

        Route::group(['prefix' => 'task'], function () {
            Route::get('', 'TaskController@index');
            Route::post('', 'TaskController@create');
            
            Route::get('{id}', 'TaskController@show');
            Route::put('{id}', 'TaskController@update');
            Route::put('update-status/{id}', 'TaskController@updateStatus');
            Route::delete('{id}', 'TaskController@delete');
        });


    });

});
