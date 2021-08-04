<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SpecialtyController;
use App\Http\Controllers\DoctorController;
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

Route::get('specialty', [SpecialtyController::class, 'getAll']);
Route::get('specialty/{id}', [SpecialtyController::class, 'get']);
Route::get('specialty/findbyname/{name}', [SpecialtyController::class, 'getByName']);
Route::get('specialty/findbydescription/{description}', [SpecialtyController::class, 'getByDescription']);
Route::post('specialty', [SpecialtyController::class, 'create']);
Route::put('specialty', [SpecialtyController::class, 'update']);
Route::delete('specialty/{id}', [SpecialtyController::class, 'delete']);

Route::get('doctor', [DoctorController::class, 'getAll']);
Route::get('doctor/{id}', [DoctorController::class, 'get']);
Route::get('doctor/findbyname/{name}', [DoctorController::class, 'getByName']);
Route::get('doctor/findbyspecialty/{specialty}', [DoctorController::class, 'getBySpecialty']);
Route::post('doctor', [DoctorController::class, 'create']);
Route::put('doctor', [DoctorController::class, 'update']);
Route::delete('doctor/{id}',[DoctorController::class, 'delete']);
