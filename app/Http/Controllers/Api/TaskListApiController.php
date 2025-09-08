<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskListDeleteRequest;
use App\Http\Requests\TaskListDestroyRequest;
use App\Http\Requests\TaskListIndexRequest;
use App\Models\TaskList;
use App\Http\Requests\TaskListStoreRequest;
use App\Http\Requests\TaskListUpdateRequest;
use App\Http\Resources\TaskListResource;
use App\Models\Project;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TaskListApiController extends Controller
{
    public function index(TaskListIndexRequest $request, Project $project): ResourceCollection
    {
        $taskLists = $project->taskLists;

        return TaskListResource::collection($taskLists);
    }

    public function store(TaskListStoreRequest $request, Project $project): TaskListResource
    {
        $taskList = TaskList::create($request->validated());

        return TaskListResource::make($taskList);
    }

    /**
     * Display the specified resource.
     */
    // public function show(Project $project, TaskList $taskList)
    // {
    //     //
    // }

    public function update(TaskListUpdateRequest $request, Project $project, TaskList $taskList): TaskListResource
    {
        $taskList->update($request->validated());

        return TaskListResource::make($taskList);
    }

    public function destroy(TaskListDestroyRequest $request, Project $project, TaskList $taskList): TaskListResource
    {
        $taskList->delete();

        return TaskListResource::make($taskList);
    }
}
