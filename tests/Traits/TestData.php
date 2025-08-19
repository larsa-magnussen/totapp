<?php

namespace Tests\Traits;

use App\Models\Project;
use App\Models\User;

trait TestData
{
    public function createUser(): User
    {
        return User::factory()->create();
    }

    public function createProject(User $user): Project
    {
        return Project::factory()->withParents($user)->create();
    }

    public function createPrivateProject(User $user): Project
    {
        return Project::factory()->withParents($user)->private()->create();
    }
}