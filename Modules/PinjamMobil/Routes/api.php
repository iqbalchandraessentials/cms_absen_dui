
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

Route::middleware(['auth:sanctum'])->group(function () {
    // Route::prefix('vehicles')->group(function () {
    //     Route::get('/', 'VehiclesController@index');
    // });
    Route::post('borrows/approve/ga/{id}', 'BorrowController@ga_approve_req');
    Route::post('borrows/approve/head/{id}', 'BorrowController@head_approve');
    Route::post('borrows/cancel', 'BorrowController@cancelVehicleApproval');
    Route::apiResource('/vehicles', 'VehiclesController');
    Route::apiResource('/borrows', 'BorrowController');
    Route::get('/vehicles/get/pic', 'VehiclesController@get_pic');
    Route::get('/vehicles/get/lokasi', 'VehiclesController@get_lokasi');
    Route::get('/vehicles/get/driver', 'VehiclesController@get_driver');

    // vehicles return
    Route::apiResource('/vehicles_return', 'VehiclesReturnController');
    Route::post('/vehicles_return/approve/{id}', 'VehiclesReturnController@ga_approve_return');
    Route::post('/vehicles_return/store/{id}', 'VehiclesReturnController@store');
});
// Route::middleware('auth:sanctum')->get('/pinjammobil', function (Request $request) {
//     return $request->user();
// });
