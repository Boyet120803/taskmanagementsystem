<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminTaskController;
use App\Http\Controllers\TeamController;


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
    Route::post('/assign-task', [AdminTaskController::class, 'assignTask']);
    Route::get('/assignable-users', [AdminTaskController::class, 'getAssignableUsers']);
    Route::get('/profile', [AdminController::class, 'profile']);
});


Route::middleware(['auth:sanctum', 'role:1'])->group(function() {
    Route::get('/managers', [ManagerController::class, 'index']);
    Route::post('/logout', [ManagerController::class, 'logout']);
    Route::get('/profile', [ManagerController::class, 'profile']);

    Route::get('/team-available-users', [TeamController::class, 'getAvailableUsers']);
    Route::get('/team-members', [TeamController::class, 'getTeamMembers']);
    Route::post('/team-assign', [TeamController::class, 'assignToTeam']);
    Route::delete('/team-remove/{user_id}', [TeamController::class, 'removeFromTeam']);
    Route::get('/managertasks', [ManagerController::class, 'getMyAssignedTasks']);
  
    Route::get('/manager-team-members', [ManagerController::class, 'getTeamMembers']);
    Route::post('/assign-task', [ManagerController::class, 'assignTaskToTeam']);
    Route::get('/submission/{task_id}/{user_id}', [ManagerController::class, 'showUserSubmission']);
    Route::put('submissions/{id}/update-status', [ManagerController::class, 'updateStatus']);
});


Route::middleware(['auth:sanctum', 'role:2'])->group(function() {
    Route::get('/regularusers', [UserController::class, 'index']);
    Route::post('/logout', [UserController::class, 'logout']);
    Route::get('/profile', [UserController::class, 'profile']);
    Route::get('/user-tasks', [UserController::class, 'userTasks']);
    Route::get('/userprofile', [UserController::class, 'userprofile']);
    Route::put('/updateprofile', [UserController::class, 'update']);
    Route::post('/submit-user-task', [UserController::class, 'submit']);

});

