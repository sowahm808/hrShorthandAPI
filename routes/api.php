<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuditLogController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth:sanctum');
Route::get('/rewards/{employee_id}', [RewardController::class, 'show'])->middleware('auth:sanctum');
Route::put('/rewards/{employee_id}', [RewardController::class, 'update'])->middleware('auth:sanctum');

Route::get('/audit-logs', [AuditLogController::class, 'index'])->middleware('auth:sanctum');
