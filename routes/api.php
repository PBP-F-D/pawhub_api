<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('register','Api\AuthController@register');
Route::post('login','Api\AuthController@login');
Route::get('email/verify/{id}', 'Api\VerificationApiController@verify')->name('verificationapi.verify');
Route::get('email/resend', 'Api\VerificationApiController@resend')->name('verificationapi.resend');

Route::group(['middleware' => 'auth:api'],function(){
    Route::get('catalog', 'Api\CatalogController@index');
    Route::get('catalog/{id}', 'Api\CatalogController@show');
    Route::get('cart', 'Api\CartController@index');
    Route::get('cart/{id}', 'Api\CartController@show');

    Route::get('logout','Api\AuthController@logout');
    Route::get('detailuser','Api\AuthController@detailUser');

    Route::post('details', 'Api\AuthController@details')->middleware('verified');
    
    Route::post('catalog', 'Api\CatalogController@store');
    Route::put('catalog/{id}', 'Api\CatalogController@update');
    Route::post('cart', 'Api\CartController@store');
    Route::put('cart/{id}', 'Api\CartController@update');
    
    Route::delete('catalog/{id}', 'Api\CatalogController@destroy');   
    Route::delete('cart/{id}', 'Api\CartController@destroy');   
   
});
