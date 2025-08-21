<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\TaskList;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class TaskListPolicy
{
    use HandlesAuthorization;

    public const INDEX = 'index';
    public const STORE = 'store';
    public const SHOW = 'show';
    public const UPDATE = 'update';
    public const DESTROY = 'destroy';

    public function index(User $user, Project $project): Response
    {
        if ($user->{User::ID} === $project->{Project::USER_ID}) {
            return $this->allow();
        }

        return $this->deny();
    }

    public function store(User $user, Project $project): Response
    {
        return $this->index($user, $project);
    }

    // public function show(User $user, Project $project, TaskList $taskList): Response
    // {
    //     return $this->deny();
    // }

    public function update(User $user, Project $project, TaskList $taskList): Response
    {
        return $this->index($user, $project);
    }

    public function delete(User $user, Project $project, TaskList $taskList): Response
    {
        return $this->deny();
    }
}
