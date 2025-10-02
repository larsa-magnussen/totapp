<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\TaskList;
use App\Models\TaskListTask;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class TaskListTaskPolicy
{
    use HandlesAuthorization;

    public const string INDEX = 'index';
    public const string STORE = 'store';
    public const string DESTROY = 'destroy';
    public const string COMPLETE = 'complete';

    public function index(User $user, Project $project, TaskList $taskList): Response
    {
        if ($user->{User::ID} === $taskList->project->{Project::USER_ID}) {
            return $this->allow();
        }

        return $this->deny();
    }

    public function store(User $user, Project $project, TaskList $taskList, TaskListTask $taskListTask): bool
    {
        return false;
    }

    public function destroy(User $user, Project $project, TaskList $taskList, TaskListTask $taskListTask): bool
    {
        return false;
    }

    public function complete(User $user, Project $project, TaskList $taskList, TaskListTask $taskListTask): bool
    {
        return false;
    }
}
