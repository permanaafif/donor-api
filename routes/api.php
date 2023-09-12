<?php

use App\Http\Controllers\GolonganDarahController;
use App\Http\Controllers\PendonorController;
use App\Http\Controllers\RoleUserController;
use App\Http\Controllers\StokDarahController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => 'api'], function($routes){
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/logout', [UserController::class, 'logout']);
    Route::get('/profile', [UserController::class, 'profile']);
    Route::post('/role/create', [RoleUserController::class, 'create']);
    Route::get('/role', [RoleUserController::class, 'show']);
    Route::get('/stok-darah', [StokDarahController::class, 'show']);
    Route::post('/stok-darah/create', [StokDarahController::class, 'create']);
    Route::get('/golongan-darah', [GolonganDarahController::class, 'show']);
    Route::post('/golongan-darah/create', [GolonganDarahController::class, 'create']);
    Route::post('/pendonor/register', [PendonorController::class, 'register']);
    Route::post('/pendonor/login', [PendonorController::class, 'login']);
    Route::get('/pendonor/logout', [PendonorController::class, 'logout']);
    Route::get('/pendonor', [PendonorController::class, 'show']);
});
