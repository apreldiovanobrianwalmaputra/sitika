<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\TicketController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {

        Route::get('/tickets', [TicketController::class, 'index']);

        Route::get('/tickets/{ticket}', [TicketController::class, 'show']);

        Route::post('/tickets', [TicketController::class, 'store']);

        Route::patch('/tickets/{ticket}/status', [TicketController::class, 'updateStatus']);

        Route::post('/logout', [AuthController::class, 'logout']);
    });
});