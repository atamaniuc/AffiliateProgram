<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', 'HomeController@index');
Route::post('/chargeUserAmount', 'HomeController@chargeUserAmount');
Route::resource('admin/users', 'UsersController'); // ADMIN PANEL

/*Route::get('/register', 'AuthController@register');
Route::post('register/{referrer_id}', 'Auth\AuthController@register');*/

// Registration Routes...
/*Route::get('register', 'Auth\AuthController@showRegistrationForm');
Route::post('register/{referrer_id}', 'Auth\AuthController@register');*/
/*Route::post('register/{referrer_id}', [
    'as' => 'register/{referrer_id}', 'uses' => 'Auth\AuthController@register'
]);*/





#Route::post('register/{referrer_id}', 'Auth\AuthController@postRegister');





/*Route::post('register/{referrer_id}', 'Auth\AuthController@register');
Route::get('register/{referrer_id}', ['as' => 'register', 'uses' => 'Auth\AuthController@register']);*/
