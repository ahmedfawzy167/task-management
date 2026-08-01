<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\DashboardController;
use App\Http\Controllers\Api\V1\ProjectController;
use App\Http\Controllers\Api\V1\TaskController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:login');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/dashboard/stats', [DashboardController::class, 'stats']);

    Route::apiResource('projects', ProjectController::class);
    Route::get('/projects/{project}/tasks/status/{status}', [TaskController::class, 'filterByStatus']);
    Route::get('/projects/{project}/tasks/priority/{priority}', [TaskController::class, 'filterByPriority']);
    Route::get('/projects/{project}/tasks/search/{title}', [TaskController::class, 'searchByTitle']);
    Route::apiResource('projects.tasks', TaskController::class);
});

Route::prefix('v1')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:login');

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/dashboard/stats', [DashboardController::class, 'stats']);
        Route::apiResource('projects', ProjectController::class);
        Route::get('/projects/{project}/tasks/status/{status}', [TaskController::class, 'filterByStatus']);
        Route::get('/projects/{project}/tasks/priority/{priority}', [TaskController::class, 'filterByPriority']);
        Route::get('/projects/{project}/tasks/search/{title}', [TaskController::class, 'searchByTitle']);
        Route::apiResource('projects.tasks', TaskController::class);
    });
});
