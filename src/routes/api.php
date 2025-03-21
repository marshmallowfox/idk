<?php

use App\Http\Controllers\GuestController;
use Illuminate\Support\Facades\Route;

Route::prefix('guests')->group(function () {
    Route::get('/', [GuestController::class, 'indexGuests']);
    Route::post('/', [GuestController::class, 'createGuest']);
    Route::get('{guest}', [GuestController::class, 'showGuest'])->where('guest', '[0-9a-fA-F-]{36}');
    Route::put('{guest}', [GuestController::class, 'updateGuest'])->where('guest', '[0-9a-fA-F-]{36}');
    Route::delete('{guest}', [GuestController::class, 'deleteGuest'])->where('guest', '[0-9a-fA-F-]{36}');
});

