<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\AuthController;

// Публичные роуты
Route::post('/register', [AuthController::class, 'register']); // регистрация
Route::post('/login', [AuthController::class, 'login']); // вход
Route::post('/verify', [AuthController::class, 'verify']); // подтверждение кода
Route::get('/chapters', [ChapterController::class, 'index']); // открытый доступ к главам

// Защищённые роуты (только для авторизованных пользователей)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
});
