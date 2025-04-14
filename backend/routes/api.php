<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminTaskController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

 Route::post('/login', [AdminController::class, 'login']);
 Route::post('/register', [AdminController::class, 'register']);




Route::middleware(['auth:sanctum', 'role:0'])->group(function() {
    Route::post('/logout', [AdminController::class, 'logout']);
    Route::get('/users', [AdminController::class, 'index']);
    Route::get('/users/{id}', [AdminController::class, 'show']);
    Route::put('/users/{id}', [AdminController::class, 'update']);
    Route::delete('/users/{id}', [AdminController::class, 'destroy']);

    Route::get('/tasks', [AdminTaskController::class, 'index']);
    Route::post('/tasks', [AdminTaskController::class, 'store']);
    Route::put('/tasks/{id}', [AdminTaskController::class, 'update']);
    Route::get('/tasks/{id}', [AdminTaskController::class, 'show']);
    Route::delete('/tasks/{id}', [AdminTaskController::class, 'destroy']);
    Route::post('/logout', [AdminTaskController::class, 'logout']);

});


Route::middleware(['auth:sanctum', 'role:1'])->group(function() {
    Route::get('/managers', [ManagerController::class, 'index']);
    Route::post('/logout', [ManagerController::class, 'logout']);
});

Route::middleware(['auth:sanctum', 'role:2'])->group(function() {
    Route::get('/regularusers', [UserController::class, 'index']);
    Route::post('/logout', [UserController::class, 'logout']);
});