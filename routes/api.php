<?php

use App\Http\Controllers\Api\ProjectApiController;
use App\Http\Controllers\Api\TaskListApiController;
use App\Http\Controllers\Api\TaskListTaskApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('/project', ProjectApiController::class);
Route::apiResource('/project.task-list', TaskListApiController::class);
Route::apiResource('/project.task-list.task-list-task', TaskListTaskApiController::class)->only(['index', 'store', 'destroy']);
Route::patch('/project/{project}/task-list/{task_list}/task-list-task/{task_list_task}', [TaskListTaskApiController::class, 'complete'])->name('project.task-list.task-list-task.complete');
