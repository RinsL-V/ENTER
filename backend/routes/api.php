<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\OrderController;

// Публичные маршруты
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/chapters', [ChapterController::class, 'index']);

// Защищённые маршруты
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Заказы пользователя
    Route::prefix('orders')->group(function () {
        Route::get('/my-orders', [OrderController::class, 'userOrders']);
        Route::get('/completed', [OrderController::class, 'completedOrders']);
        Route::get('/{id}', [OrderController::class, 'show']);
        Route::post('/', [OrderController::class, 'store']);
    });

    // Админские маршруты
    Route::prefix('admin')->group(function () {
        Route::get('/orders', [OrderController::class, 'index']);
        Route::post('/orders/{id}/approve', [OrderController::class, 'approve']);
        Route::post('/orders/{id}/reject', [OrderController::class, 'reject']);
    });
});
