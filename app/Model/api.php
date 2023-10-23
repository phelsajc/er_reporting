<?php

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('search_meds', 'MedicineController@searchMedicine');   
    Route::post('checkotp', 'AuthController@checkotp');   
    Route::post('search_medicine', 'MedicineController@searchMedicine');   
    Route::get('get_medicine_detail/{id}', 'MedicineController@show');   
    Route::post('add_to_cart', 'TransactionController@add_to_cart');   
    Route::get('get_items_cart/{id}', 'TransactionController@getCartItems');   
    Route::get('place_order/{id}', 'TransactionController@transfer_peds');   
    Route::get('get_basket/{id}', 'TransactionController@getBasket');   
    Route::get('get_basket_detail/{id}', 'TransactionController@getBasketDetail');  
    Route::post('store-geolocation', 'GeolocationController@store');   
    Route::get('get-geolocation', 'GeolocationController@getCoordinates');   
    Route::get('update-geolocation/{id}', 'GeolocationController@update');   
    Route::get('order-get-logs/{id}', 'TransactionController@getLogs');   
    Route::get('encrypt', 'MedicineController@encrypt');   
    Route::post('ResendOtp', 'AuthController@resend_otp');
    
    
});