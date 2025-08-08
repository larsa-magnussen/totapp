<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectStoreRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

class ProjectApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): ResourceCollection
    {
        $user = Auth::user();
        $projects = Project::where(Project::USER_ID, $user->{User::ID})->get();

        return ProjectResource::collection($projects);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectStoreRequest $request): ProjectResource
    {
        $project = Project::create($request->validated());

        return ProjectResource::make($project);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project): ProjectResource
    {
        return ProjectResource::make($project);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectUpdateRequest $request, Project $project): ProjectResource
    {
        $project = Project::update($request->validated());

        return ProjectResource::make($project);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project): ProjectResource
    {
        $project = $project->delete();

        return ProjectResource::make($project);
    }
}
