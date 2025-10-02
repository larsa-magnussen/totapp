<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskListIndexRequest;
use App\Models\TaskListTask;
use App\Http\Requests\TaskListStoreRequest;
use App\Http\Resources\TaskListTaskResource;
use App\Models\Project;
use App\Models\TaskList;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TaskListTaskApiController extends Controller
{
    public function index(TaskListIndexRequest $request, Project $project, TaskList $taskList): AnonymousResourceCollection
    {
        $tasks = TaskListTask::where(TaskListTask::TASK_LIST_ID, $taskList->{TaskList::ID})->get();

        return TaskListTaskResource::collection($tasks);
    }

    public function store(TaskListStoreRequest $request, Project $project, TaskList $taskList)
    {
        //
    }

    public function destroy(TaskListTask $taskListTask, Project $project, TaskList $taskList)
    {
        //
    }

    public function complete(TaskListTask $taskListTask, Project $project, TaskList $taskList)
    {
        //
    }
}
