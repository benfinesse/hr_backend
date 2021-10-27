<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'HomeController@index')->name('home');
Route::get('links', 'HomeController@links')->name('links');

Route::get('/home', 'HomeController@index')->name('home');


Route::group(['middleware'=>'app_api'], function (){

    Route::post('login', 'API\LoginController@login');
//    Route::post('register', 'API\RegisterController@register');
    Route::post('start/reset', 'API\LoginController@startReset');
    Route::post('complete/reset', 'API\LoginController@completeReset');

    //authenticated endpoints routes
    Route::group(['middleware'=>'user_auth'], function (){

        Route::prefix('dashboard')->group(function () {
            Route::resource('admins', 'AdminController');
            Route::resource('users', 'UserController');
        });
    });


});
