<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\SocialAuthController;

use Laravel\Sanctum\Http\Controllers\CsrfCookieController;

use Illuminate\Support\Facades\Route;


// CSRF Route
Route::get('/sanctum/csrf-cookie', [CsrfCookieController::class, 'show']);

// Public routes (No authentication required)
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);  // Registration route
Route::get('/auth/google', [SocialAuthController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);

// Protected routes (Require authentication)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/rewards/{employee_id}', [RewardController::class, 'show']);
    Route::put('/rewards/{employee_id}', [RewardController::class, 'update']);

    Route::get('/survey', [SurveyController::class, 'index']);
    Route::post('/survey', [SurveyController::class, 'store']);

    Route::get('/audit-logs', [AuditLogController::class, 'index']);
});
