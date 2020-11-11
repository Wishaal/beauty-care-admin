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
    return redirect()->route('dashboard');
});

Auth::routes(['register' => false]);

Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:clear');
    return 'Config cache cleared';
});

//Clear route cache:
Route::get('/route-cache', function() {
    $exitCode = Artisan::call('route:clear');
    return 'Routes cache cleared';
});

// Clear view cache:
Route::get('/view-cache', function() {
    $exitCode = Artisan::call('view:clear');
    return 'View cache cleared';
});

// Clear application cache:
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return 'Application cache cleared';
});
Route::get('dashboard/upload', 'DashboardController@upload2server')->name('upload2server')->middleware('auth');
Route::get('dashboard/import', 'DashboardController@import2db')->name('import2db');
Route::get('service-payments/createclient', 'ServicePaymentController@createclient')->name('service-payments.createclient')->middleware('auth');
Route::post('service-payments/createclient', 'ServicePaymentController@storeclient')->name('service-payments.storeclient')->middleware('auth');
Route::get('dashboard', 'DashboardController@index')->name('dashboard')->middleware('auth');
Route::get('appointments/clients','AppointmentController@getClients');
Route::get('update','UpdateRecordsController@index');
Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles','RoleController');
    Route::resource('service-payments','ServicePaymentController');
    Route::resource('users','UserController');
    Route::resource('currencies','CurrencyController');
    Route::resource('categories','CategoryController');
    Route::resource('services','ServiceController');
    Route::resource('clients','ClientController');
    Route::resource('permissions', 'PermissionController');
    Route::resource('types', 'TypeController');
    Route::resource('products', 'ProductController');
    Route::resource('appointments', 'AppointmentController');
    Route::resource('costs', 'CostController');
    Route::get('appointments/clients','AppointmentController@getClients');
    Route::post('appointments/create','AppointmentController@create');
    Route::post('appointments/update','AppointmentController@update');
    Route::post('appointments/delete','AppointmentController@destroy');
    Route::post('appointments/store','AppointmentController@store');
    Route::get('reports/overview','ReportController@index')->name('totaloverview');
    Route::post('reports/overview','ReportController@totaloverview')->name('totaloverview');
});
