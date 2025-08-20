<?php

namespace Tests\Traits;

use App\Models\Project;
use App\Models\TaskList;
use App\Models\User;

trait TestData
{
    // users
    public function createUser(): User
    {
        return User::factory()->create();
    }

    // projects
    public function createProject(User $user): Project
    {
        return Project::factory()->withParents($user)->create();
    }

    public function createPrivateProject(User $user): Project
    {
        return Project::factory()->withParents($user)->private()->create();
    }

    // task lists
    public function createTaskList(Project $project): TaskList
    {
        return TaskList::factory()->withParents($project)->create();
    }
}