<?php

Route::group(['namespace' => 'Admin'], function() {
    Route::resource('uikit', 'UikitController');
    Route::post('uikit/enable', 'UikitController@enable');
    Route::post('uikit/disable', 'UikitController@disable');

    Route::resource('document', 'DocumentController');
    Route::resource('document_post', 'DocumentPostController');
    Route::resource('document_model', 'DocumentModelController');

    Route::resource('category', 'CategoryController');

    Route::resource('config', 'ConfigController');

    Route::resource('recycle_bin', 'RecycleBinController', ['only' => ['index', 'destroy']]);
    Route::any('recycle_bin/{id}/restore', 'RecycleBinController@restore')->name('recycle_bin.restore');
});
