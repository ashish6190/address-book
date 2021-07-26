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

Route::get('/', function () {
    return redirect()->route('address.index');
}); 

Route::namespace('Backend')->group(function () {

    Route::post('address/email/checkexists', 'AddressController@emailCheckexists')->name('user.email');
    Route::get('address/list', 'AddressController@list')->name('address.list');
    Route::get('address/{slug}/edit', 'AddressController@edit')->name('address.edit');
    Route::post('address/{slug}/edit', 'AddressController@update')->name('address.update');
    Route::resource('address', 'AddressController');
});
