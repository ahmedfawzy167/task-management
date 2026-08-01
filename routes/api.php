<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ProjectController;
use App\Http\Controllers\Api\V1\TaskController;
use App\Http\Controllers\Api\V1\DashboardController;

Route::prefix('v1')->group(function () {

    // Start of Auth Routes
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:login');
    // End of Auth Routes

    Route::middleware(['auth:sanctum'])->group(function () {

        Route::post('/logout', [AuthController::class, 'logout']);

        // Start of Dashboard Routes
        Route::get('/dashboard/stats', [DashboardController::class, 'stats']);
        // End of Dashboard Routes

        // Start of Project & Task Routes
        Route::apiResource('projects', ProjectController::class);

        Route::get('/projects/{project}/tasks/status/{status}', [TaskController::class, 'filterByStatus']);

        Route::get('/projects/{project}/tasks/priority/{priority}', [TaskController::class, 'filterByPriority']);

        Route::get('/projects/{project}/tasks/search/{title}', [TaskController::class, 'searchByTitle']);

        Route::apiResource('projects.tasks', TaskController::class);
        // End of Project & Task Routes
    });
});
