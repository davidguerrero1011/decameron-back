<?php

use App\Http\Controllers\HotelsController;
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

Route::post('hotels', [HotelsController::class, 'obtein'])->name('hotels');
Route::post('cities', [HotelsController::class, 'getCities'])->name('cities');
Route::post('store', [HotelsController::class, 'storeHotels'])->name('store');
Route::post('activate', [HotelsController::class, 'activateHotels'])->name('activate');
Route::post('rooms', [HotelsController::class, 'getRooms'])->name('rooms');
Route::post('acommodations', [HotelsController::class, 'getAcommodations'])->name('acommodations');
Route::post('store-conf', [HotelsController::class, 'storeRoomsConf'])->name('store-conf');
Route::post('get-room', [HotelsController::class, 'getRoomConf'])->name('get-room');
Route::post('store-configuration', [HotelsController::class, 'storeConfiguration'])->name('store-configuration');
Route::post('get-room-conf', [HotelsController::class, 'getRoomConfiguration'])->name('get-room-conf');
Route::post('update-configuration', [HotelsController::class, 'updateConfiguration'])->name('update-configuration');
Route::delete('delete-room-conf/{id}', [HotelsController::class, 'deleteRoomConfiguration'])->name('delete-room-conf');
Route::delete('delete-hotel/{id}', [HotelsController::class, 'deleteHotel'])->name('delete-hotel');
