<?php

namespace Tests\Traits;

use App\Models\Project;
use App\Models\User;

trait TestDataGetters
{
    public function getUser(): User
    {
        return User::factory()->create();
    }

    public function getProject(User $user): Project
    {
        return Project::factory()->withParents($user)->create();
    }
}