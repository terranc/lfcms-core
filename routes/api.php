<?php

//use Illuminate\Http\Request;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['middle' => ['auth:api']], function () {
    Route::group(['namespace' => 'Api\V1'], function () {
        Route::get('/', 'IndexController@index');
    });
});
Route::group(['namespace' => 'Api\V1'], function () {
    Route::any('/common/ueditor_upload', 'CommonController@ueditorUpload');
});
