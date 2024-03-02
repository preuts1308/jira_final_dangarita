<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UserstoriesController;
use App\Http\Controllers\ProjectsController;
//use app\Http\Controllers\TaskController
//use app\Http\Controllers\TaskController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::get('projects', [ProjectsController::class,'index']);

Route::post('register', [AuthController::class, 'register']);

Route::post('login', [AuthController::class, 'login']);



Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('projects', [ProjectsController::class, 'create']);
    Route::get('projects', [ProjectsController::class, 'index']);
    Route::post('projects/{projectId}/add-developers', [ProjectsController::class, 'addDevelopers']);
    Route::delete('projects/{projectId}/developers/{developerId}', [ProjectsController::class, 'removeDeveloper']);
    Route::get('projects/{projectId}/user-stories', [UserStoriesController::class, 'index']);
    Route::post('projects/{projectId}/user-stories', [UserStoriesController::class, 'create']);
    Route::put('projects/{projectId}/user-stories/{userStoryId}', [UserStoriesController::class, 'update']);
    Route::delete('projects/{projectId}/user-stories/{userStoryId}', [UserStoriesController::class, 'destroy']);
    Route::post('projects/{projectId}/user-stories/{userStoryId}/tasks', [TaskController::class, 'create']);
    Route::post('projects/{projectId}/user-stories/{userStoryId}/tasks/{taskId}', [TaskController::class, 'update']);
    Route::delete('projects/{projectId}/user-stories/{userStoryId}/tasks/{taskId}', [TaskController::class, 'destroy']);
    Route::post('projects/{projectId}/user-stories/{userStoryId}/tasks', [TaskController::class, 'create']);
    Route::post('logout', [AuthController::class, 'logout']);
});
