<?php

use App\Events\OrderStatusChanged;



Route::get('/', function () {
    return view('welcome');
});



Auth::routes();

Route::get('{path}', 'HomeController@index')->name('path','([A-z\d-\/_.]+)?');


// Route::get('/home', 'HomeController@index')->name('home');
// Route::get('{path}', 'HomeController@index')->name('path','([A-z\d-\/_.]+)?');

//  if we want our custom controller in resource controller then we need to write it 
//  before registering resource controller


Route::get('orders/getOrders','OrderController@getOrders');
Route::resource('orders', 'OrderController');