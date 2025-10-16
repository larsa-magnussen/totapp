<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskListIndexRequest;
use App\Http\Requests\TaskListTaskCompleteRequest;
use App\Http\Requests\TaskListTaskDestroyRequest;
use App\Models\TaskListTask;
use App\Http\Requests\TaskListTaskStoreRequest;
use App\Http\Resources\TaskListTaskResource;
use App\Models\Project;
use App\Models\TaskList;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TaskListTaskApiController extends Controller
{
    public function index(TaskListIndexRequest $request, Project $project, TaskList $taskList): AnonymousResourceCollection
    {
        $tasks = TaskListTask::where(TaskListTask::TASK_LIST_ID, $taskList->{TaskList::ID})->get();

        return TaskListTaskResource::collection($tasks);
    }

    public function store(TaskListTaskStoreRequest $request, Project $project, TaskList $taskList): TaskListTaskResource
    {
        $task = TaskListTask::create($request->validated());

        return TaskListTaskResource::make($task);
    }

    public function destroy(TaskListTaskDestroyRequest $request, Project $project, TaskList $taskList, TaskListTask $taskListTask): TaskListTaskResource
    {
        $taskListTask->delete();

        return TaskListTaskResource::make($taskListTask);
    }

    public function complete(TaskListTaskCompleteRequest $request, Project $project, TaskList $taskList, TaskListTask $taskListTask)
    {
        if ($taskListTask->{TaskListTask::COMPLETED_AT}) {
            $taskListTask->update([TaskListTask::COMPLETED_AT => null]);

            return TaskListTaskResource::make($taskListTask);
        }

        $taskListTask->update([TaskListTask::COMPLETED_AT => Carbon::now()]);

        return TaskListTaskResource::make($taskListTask);
    }
}
