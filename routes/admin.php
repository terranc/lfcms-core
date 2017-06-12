<?php


Route::group(['namespace' => 'Admin'], function () {
    Route::resource('uikit', 'UikitController');
    Route::post('uikit/enable', 'UikitController@enable');
    Route::post('uikit/disable', 'UikitController@disable');
});
Route::get('home', 'Controller@home');
