<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectDestroyRequest;
use App\Http\Requests\ProjectShowRequest;
use App\Http\Requests\ProjectStoreRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

class ProjectApiController extends Controller
{
    public function index(): ResourceCollection
    {
        $user = Auth::user();
        $projects = Project::where(Project::USER_ID, $user->{User::ID})->get();

        return ProjectResource::collection($projects);
    }

    public function store(ProjectStoreRequest $request): ProjectResource
    {
        $project = Project::create($request->validated());

        return ProjectResource::make($project);
    }

    public function show(ProjectShowRequest $request, Project $project): ProjectResource
    {
        return ProjectResource::make($project);
    }

    public function update(ProjectUpdateRequest $request, Project $project): ProjectResource
    {
        $project->update($request->validated());

        return ProjectResource::make($project);
    }

    public function destroy(ProjectDestroyRequest $request, Project $project): ProjectResource
    {
        $project->delete();

        return ProjectResource::make($project);
    }
}
