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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


// Log viewer route
Route::get('logs', [
    'middleware' => ['auth', 'role:Gymie'],
    'uses' => '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index'
]);

// Data Migration
Route::get('data/migration', [
    'middleware' => ['auth', 'role:Gymie'],
    'uses' => 'DataMigrationController@migrate',
]);

Route::get('data/media/migration', [
    'middleware' => ['auth', 'role:Gymie'],
    'uses' => 'DataMigrationController@migrationMedia'
]);

Route::get('excel/migration', [
    'middleware' => ['auth', 'role:Gymie'],
    'uses' => 'DataMigrationController@migrateExcel',
]);

// Report Data
Route::get('reportData/members', 'ReportData\MembersController@details');