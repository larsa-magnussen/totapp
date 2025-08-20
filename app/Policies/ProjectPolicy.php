<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ProjectPolicy
{
    use HandlesAuthorization;

    public const INDEX = 'index';
    public const STORE = 'store';
    public const SHOW = 'show';
    public const UPDATE = 'update';
    public const DESTROY = 'destroy';

    public function index(User $user): Response
    {
        return $this->allow();
    }

    public function store(User $user): Response
    {
        if ($user) {
            return $this->allow();
        }

        return $this->deny();
    }

    public function show(User $user, Project $project): Response
    {
        if (!$project->{Project::PRIVATE}) {
            return $this->allow();
        }

        if ($project->{Project::USER_ID} === $user->{User::ID}) {
            return $this->allow();
        }

        return $this->deny('You don\'t have access to this project');
    }

    public function update(User $user, Project $project): Response
    {
        if ($user->{User::ID} === $project->{Project::USER_ID}) {
            return $this->allow();
        }

        return $this->deny();
    }

    public function destroy(User $user, Project $project): Response
    {
        if ($user->{User::ID} === $project->{Project::USER_ID}) {
            return $this->allow();
        }

        return $this->deny();
    }
}
