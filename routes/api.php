<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('user/list', array('as' => 'userlist', 'uses' => 'UserController@index'));
// Route::get('user/list', 'ApiController@listapi');
Route::post('user/login', 'ApiController@usercheck');
Route::post('user/form/test', 'ApiController@formdet');
Route::post('user/form', 'ApiController@userform');
Route::post('user/form/detail', 'ApiController@formdet');
Route::post('user/form/save', 'ApiController@saveform');
Route::post('user/form/saveimageform', 'ApiController@saveimageform');
Route::post('user/form/saveimagefile', 'ApiController@saveimagefile');
Route::post('user/form/saveimagefileoss', 'ApiController@saveimagefileossbase64');
Route::post('user/form/save/error', 'ApiController@saveformerror');
Route::post('form/fix', 'ApiController@uniqueForm');
Route::post('user/register', 'UserController@register');

Route::post('user/form/jobpucino', 'ApiController@userformjp');
Route::post('user/form/detail/jobpucino', 'ApiController@formdetjp');
Route::post('user/form/save/jobpucino', 'ApiController@saveformjp');