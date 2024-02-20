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

Route::prefix('ga')->group(function () {
    // Route::get('/', 'PinjamMobilController@index');
    Route::resource('/pinjammobil', 'VehiclesController');
    Route::resource('/borrow-vehicles', 'BorrowController');
    Route::post('/export-borrow-vehicles', 'BorrowController@export')->name('export.borrow_vehicles');
    Route::resource('/location-vehicles', 'VehicleslocationsController');
    Route::resource('/pic-vehicles', 'VehiclespicController');
    Route::post('/driver-store', 'VehiclesController@storeDriver')->name('driver.store');
    Route::resource('/drivers', 'DriversController');
});
