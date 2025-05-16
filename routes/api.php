<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\HotelController;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\RoomTypeController;
use App\Http\Controllers\Api\AccommodationController;

Route::prefix('hoteles')->group(function () {
    Route::get('/', [HotelController::class, 'index']);
    Route::get('/{id}', [HotelController::class, 'show']);
    Route::post('/', [HotelController::class, 'store']);
    Route::put('/{id}', [HotelController::class, 'update']);
    Route::delete('/{id}', [HotelController::class, 'destroy']);
});

Route::prefix('roomConfiguration')->group(function () {
    Route::get('/hotel/{id}', [RoomController::class, 'index']);
    Route::get('/{id}', [RoomController::class, 'show']);
    Route::post('/', [RoomController::class, 'store']);
    Route::put('/{id}', [RoomController::class, 'update']);
    Route::delete('/{id}', [RoomController::class, 'destroy']);
});

Route::prefix('roomTypes')->group(function () {
    Route::get('/', [RoomTypeController::class, 'index']);
});

Route::prefix('accommodations')->group(function () {
    Route::get('/', [AccommodationController::class, 'index']);
});