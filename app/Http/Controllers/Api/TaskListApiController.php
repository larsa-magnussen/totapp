<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskListDeleteRequest;
use App\Http\Requests\TaskListIndexRequest;
use App\Models\TaskList;
use App\Http\Requests\TaskListStoreRequest;
use App\Http\Requests\TaskListUpdateRequest;
use App\Http\Resources\TaskListResource;
use App\Models\Project;

class TaskListApiController extends Controller
{
    public function index(TaskListIndexRequest $request, Project $project)
    {
        $taskLists = $project->taskLists;

        return TaskListResource::collection($taskLists);
    }

    public function store(TaskListStoreRequest $request, Project $project)
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

    public function update(TaskListUpdateRequest $request, Project $project, TaskList $taskList)
    {
        $taskList->update($request->validated());

        return TaskListResource::make($taskList);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskListDeleteRequest $request, Project $project, TaskList $taskList)
    {
        //
    }
}
