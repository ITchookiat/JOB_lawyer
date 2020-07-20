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
    return redirect('/home');   // redirect เป็นการบังคับวิ่งเข้าหน้า web
});

Auth::routes();

Route::group(['middleware' => 'auth'], function(){

    Route::get('/lawyer/view/{type}', 'LawyerController@index')->name('lawyer');
    Route::get('/ExportPDFIndex', 'LawyerController@ReportPDFIndex');
    Route::get('/updateNotis', 'LawyerController@updateNotis');
    Route::post('/import_excel/import', 'LawyerController@import');
    Route::delete('/delete/{id}', 'LawyerController@destroy');
    
    Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('/{name}', 'HomeController@index')->name('index');
});