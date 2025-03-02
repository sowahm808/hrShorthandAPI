<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\Auth\SocialAuthController;

use Laravel\Sanctum\Http\Controllers\CsrfCookieController;

use Illuminate\Support\Facades\Route;


// CSRF Route
Route::get('/sanctum/csrf-cookie', [CsrfCookieController::class, 'show']);

// Public routes (No authentication required)
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);  // Registration route
Route::get('/auth/google', [SocialAuthController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);

// Admin Routes (Restricted to Admins)
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    // Route::post('/questions', action: [QuestionController::class, 'store']);
    //Route::put('/questions/{id}', [QuestionController::class, 'update']);
    // Route::delete('/questions/{id}', [QuestionController::class, 'destroy']);
});
// Protected routes (Require authentication)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Admin Routes (Restricted to Admins)
    Route::put('/questions/{id}', [QuestionController::class, 'update']);
    Route::post('/questions', action: [QuestionController::class, 'store']);
    Route::delete('/questions/{id}', [QuestionController::class, 'destroy']);


    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/rewards/{employee_id}', [RewardController::class, 'show']);
    Route::put('/rewards/{employee_id}', [RewardController::class, 'update']);

    Route::get('/survey', [SurveyController::class, 'index']);
    Route::post('/survey', [SurveyController::class, 'store']);


    // Route::post('/questions', [QuestionController::class, 'store']);  // Add question
    // Route::put('/questions/{id}', [QuestionController::class, 'update']);  // Update question
    // Route::delete('/questions/{id}', [QuestionController::class, 'destroy']);  // Delete question



    Route::get('/audit-logs', [AuditLogController::class, 'index']);
});
