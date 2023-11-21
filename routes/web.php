<?php

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
  return view('auth/login');
});

Auth::routes();

Route::get('upload', function() {
    $files = Storage::disk('spaces')->files('uploads');

    return view('upload', compact('files'));
});

Route::post('upload', function() {
    Storage::disk('spaces')->putFile('uploads', request()->file, 'public');

    return redirect()->back();
});

Route::get('/home', 'ReportController@index')->name('home');
Route::get('report/list', array('before' =>'authlogin', 'as' => 'reportlist', 'uses' => 'ReportController@index'));
Route::get('form/fixing', array('before' =>'authlogin', 'as' => 'fixingform', 'uses' => 'ReportController@fixing'));
Route::any('report/detail/{id}', array('before' =>'authlogin', 'as' => 'reportdetail', 'uses' => 'ReportController@detail'));
// Route::any('report/detailbug/{id}', array('before' =>'authlogin', 'as' => 'reportdetailbug', 'uses' => 'ReportController@detailbug'));
Route::get('report/detail/exel/{id}', array('before' =>'authlogin', 'as' => 'reportdetailexcel', 'uses' => 'ReportController@detailexcel'));
Route::get('report/detail/csv/{id}', array('before' =>'authlogin', 'as' => 'reportdetailcsv', 'uses' => 'ReportController@detailcsv'));
Route::get('report/detail/createtable/{id}', array('before' =>'authlogin', 'as' => 'reportdetailtable', 'uses' => 'ReportController@createtable'));
Route::get('report/maps/{id}', array('before' =>'authlogin', 'as' => 'reportmaps', 'uses' => 'ReportController@maps'));
Route::get('report/stats/{id}', array('before' =>'authlogin', 'as' => 'reportstats', 'uses' => 'ReportController@stats'));
Route::get('report/detaildata/{id}/{uid}', array('before' =>'authlogin', 'as' => 'reportdata', 'uses' => 'ReportController@data'));

Route::get('user/list', array('before' =>'authlogin', 'as' => 'userlist', 'uses' => 'UserController@index'));
Route::get('user/create', array('before' =>'authlogin', 'as' => 'usercreate', 'uses' => 'UserController@create'));
Route::post('user/store', array('before' =>'authlogin', 'as' => 'userstore', 'uses' => 'UserController@store'));
Route::get('user/edit/{id}', array('before' =>'authlogin', 'as' => 'useredit', 'uses' => 'UserController@edit'));
Route::post('user/update/{id}', array('before' =>'authlogin', 'as' => 'userupdate', 'uses' => 'UserController@update'));
Route::post('user/destroy/{id}', array('before' =>'authlogin', 'as' => 'userdestroy', 'uses' => 'UserController@destroy'));

Route::get('team/list', array('before' =>'authlogin', 'as' => 'teamlist', 'uses' => 'TeamController@index'));
Route::get('team/create', array('before' =>'authlogin', 'as' => 'teamcreate', 'uses' => 'TeamController@create'));
Route::post('team/store', array('before' =>'authlogin', 'as' => 'teamstore', 'uses' => 'TeamController@store'));
Route::get('team/edit/{id}', array('before' =>'authlogin', 'as' => 'teamedit', 'uses' => 'TeamController@edit'));
Route::post('team/update/{id}', array('before' =>'authlogin', 'as' => 'teamupdate', 'uses' => 'TeamController@update'));
Route::post('team/destroy/{id}', array('before' =>'authlogin', 'as' => 'teamdestroy', 'uses' => 'TeamController@destroy'));

Route::get('team/tmember/list/{id}', array('before' =>'authlogin', 'as' => 'tmemberlist', 'uses' => 'TmemberController@index'));
Route::post('team/tmember/create/{id}', array('before' =>'authlogin', 'as' => 'tmembercreate', 'uses' => 'TmemberController@create'));
Route::post('team/tmember/store/{id}', array('before' =>'authlogin', 'as' => 'tmemberstore', 'uses' => 'TmemberController@store'));
Route::post('team/tmember/edit/{id}/{idh}', array('before' =>'authlogin', 'as' => 'tmemberedit', 'uses' => 'TmemberController@edit'));
Route::post('team/tmember/update/{id}/{idh}', array('before' =>'authlogin', 'as' => 'tmemberupdate', 'uses' => 'TmemberController@update'));
Route::post('team/tmember/destroy/{id}/{idh}', array('before' =>'authlogin', 'as' => 'tmemberdestroy', 'uses' => 'TmemberController@destroy'));

Route::get('team/tmanager/list/{id}', array('before' =>'authlogin', 'as' => 'tmanagerlist', 'uses' => 'TmanagerController@index'));
Route::post('team/tmanager/create/{id}', array('before' =>'authlogin', 'as' => 'tmanagercreate', 'uses' => 'TmanagerController@create'));
Route::post('team/tmanager/store/{id}', array('before' =>'authlogin', 'as' => 'tmanagerstore', 'uses' => 'TmanagerController@store'));
Route::post('team/tmanager/edit/{id}/{idh}', array('before' =>'authlogin', 'as' => 'tmanageredit', 'uses' => 'TmanagerController@edit'));
Route::post('team/tmanager/update/{id}/{idh}', array('before' =>'authlogin', 'as' => 'tmanagerupdate', 'uses' => 'TmanagerController@update'));
Route::post('team/tmanager/destroy/{id}/{idh}', array('before' =>'authlogin', 'as' => 'tmanagerdestroy', 'uses' => 'TmanagerController@destroy'));

Route::get('project/list', array('before' =>'authlogin', 'as' => 'projectlist', 'uses' => 'ProjectController@index'));
Route::get('project/create', array('before' =>'authlogin', 'as' => 'projectcreate', 'uses' => 'ProjectController@create'));
Route::post('project/store', array('before' =>'authlogin', 'as' => 'projectstore', 'uses' => 'ProjectController@store'));
Route::get('project/edit/{id}', array('before' =>'authlogin', 'as' => 'projectedit', 'uses' => 'ProjectController@edit'));
Route::post('project/update/{id}', array('before' =>'authlogin', 'as' => 'projectupdate', 'uses' => 'ProjectController@update'));
Route::post('project/destroy/{id}', array('before' =>'authlogin', 'as' => 'projectdestroy', 'uses' => 'ProjectController@destroy'));
Route::post('project/publish/{id}', array('before' =>'authlogin', 'as' => 'projectpublish', 'uses' => 'ProjectController@publish'));

Route::get('project/form/list/{id}', array('before' =>'authlogin', 'as' => 'formlist', 'uses' => 'FormController@index'));
Route::post('project/form/create/{id}', array('before' =>'authlogin', 'as' => 'formcreate', 'uses' => 'FormController@create'));
Route::post('project/form/store/{id}', array('before' =>'authlogin', 'as' => 'formstore', 'uses' => 'FormController@store'));
Route::post('project/form/edit/{id}/{idh}', array('before' =>'authlogin', 'as' => 'formedit', 'uses' => 'FormController@edit'));
Route::post('project/form/update/{id}/{idh}', array('before' =>'authlogin', 'as' => 'formupdate', 'uses' => 'FormController@update'));
Route::post('project/form/destroy/{id}/{idh}', array('before' =>'authlogin', 'as' => 'formdestroy', 'uses' => 'FormController@destroy'));
Route::post('project/form/publish/{id}/{idh}', array('before' =>'authlogin', 'as' => 'formpublish', 'uses' => 'FormController@publish'));
Route::post('project/form/lock/{id}/{idh}', array('before' =>'authlogin', 'as' => 'formlock', 'uses' => 'FormController@lock'));
Route::post('project/form/duplicate/{id}/{idh}', array('before' =>'authlogin', 'as' => 'duplicate', 'uses' => 'FormController@duplicate'));

Route::get('project/form/detail/list/{id}', array('before' =>'authlogin', 'as' => 'formdetaillist', 'uses' => 'FormdetailController@index'));
Route::post('project/form/detail/create/{id}', array('before' =>'authlogin', 'as' => 'formdetailcreate', 'uses' => 'FormdetailController@create'));
Route::post('project/form/detail/store/{id}', array('before' =>'authlogin', 'as' => 'formdetailstore', 'uses' => 'FormdetailController@store'));
Route::post('project/form/detail/edit/{id}/{idh}', array('before' =>'authlogin', 'as' => 'formdetailedit', 'uses' => 'FormdetailController@edit'));
Route::post('project/form/detail/rule2/{id}', array('before' =>'authlogin', 'as' => 'formdetailrule2', 'uses' => 'FormdetailController@rule2'));
Route::post('project/form/detail/updaterule2/{id}', array('before' =>'authlogin', 'as' => 'formdetailupdaterule2', 'uses' => 'FormdetailController@updaterule2'));
Route::any('project/form/detail/rules/{id}/{idh}', array('before' =>'authlogin', 'as' => 'formdetailrule', 'uses' => 'FormdetailController@rule'));
Route::post('project/form/detail/rules/destroy/{id}/{idh}', array('before' =>'authlogin', 'as' => 'formdetaildestroyrule', 'uses' => 'FormdetailController@destroyrule'));
Route::post('project/form/detail/rules/update/{id}/{idh}', array('before' =>'authlogin', 'as' => 'formdetailupdaterule', 'uses' => 'FormdetailController@updaterule'));
Route::post('project/form/detail/update/{id}/{idh}', array('before' =>'authlogin', 'as' => 'formdetailupdate', 'uses' => 'FormdetailController@update'));

Route::post('project/form/detail/destroy/{id}/{idh}', array('before' =>'authlogin', 'as' => 'formdetaildestroy', 'uses' => 'FormdetailController@destroy')); // quest lvl1

Route::get('project/form/detail/group/reposition/', array('before' =>'authlogin', 'as' => 'formreposition', 'uses' => 'FormdetailController@reposition'));

Route::get('project/form/detail/group/list/{id}', array('before' =>'authlogin', 'as' => 'formgrouplist', 'uses' => 'FormgroupController@index'));
Route::get('project/form/detail/group/clone/{id}', array('before' =>'authlogin', 'as' => 'formgroupclone', 'uses' => 'FormgroupController@clone'));
Route::post('project/form/detail/group/create/{id}', array('before' =>'authlogin', 'as' => 'formgroupcreate', 'uses' => 'FormgroupController@create'));
Route::post('project/form/detail/group/store/{id}', array('before' =>'authlogin', 'as' => 'formgroupstore', 'uses' => 'FormgroupController@store'));
Route::post('project/form/detail/group/edit/{id}/{idh}', array('before' =>'authlogin', 'as' => 'formgroupedit', 'uses' => 'FormgroupController@edit'));
Route::post('project/form/detail/group/update/{id}/{idh}', array('before' =>'authlogin', 'as' => 'formgroupupdate', 'uses' => 'FormgroupController@update'));

Route::post('project/form/detail/group/destroy/{id}/{idh}', array('before' =>'authlogin', 'as' => 'formgroupdestroy', 'uses' => 'FormgroupController@destroy')); // quest child

Route::any('project/form/detail/group/rules/{id}/{idh}', array('before' =>'authlogin', 'as' => 'formgrouprule', 'uses' => 'FormgroupController@rule'));
Route::post('project/form/detail/group/rules/destroy/{id}/{idh}', array('before' =>'authlogin', 'as' => 'formgroupdestroyrule', 'uses' => 'FormgroupController@destroyrule'));
Route::post('project/form/detail/group/rules/update/{id}/{idh}', array('before' =>'authlogin', 'as' => 'formgroupupdaterule', 'uses' => 'FormgroupController@updaterule'));

Route::get('member/form/list/', array('before' =>'authlogin', 'as' => 'formmemberlist', 'uses' => 'FormmemberController@index'));
Route::get('member/form/create/{id}', array('before' =>'authlogin', 'as' => 'formmembercreate', 'uses' => 'FormmemberController@create'));
Route::post('member/form/store/{id}', array('before' =>'authlogin', 'as' => 'formmemberstore', 'uses' => 'FormmemberController@store'));
Route::post('member/form/edit/{id}/{idh}', array('before' =>'authlogin', 'as' => 'formmemberedit', 'uses' => 'FormmemberController@edit'));
Route::post('member/form/update/{id}/{idh}', array('before' =>'authlogin', 'as' => 'formmemberupdate', 'uses' => 'FormmemberController@update'));
Route::post('member/form/destroy/{id}/{idh}', array('before' =>'authlogin', 'as' => 'formmemberdestroy', 'uses' => 'FormmemberController@destroy'));
