<?php

namespace Tests\Traits;

use App\Models\Notepad;
use App\Models\Project;
use App\Models\TaskList;
use App\Models\TaskListTask;
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

    // task list tasks
    public function createTaskListTask(TaskList $taskList): TaskListTask
    {
        return TaskListTask::factory()->withParents($taskList)->create();
    }

    public function createCompletedTaskListTask(TaskList $taskList): TaskListTask
    {
        return TaskListTask::factory()->withParents($taskList)->completed()->create();
    }

    // notepads
    public function createNotepad(Project $project): Notepad
    {
        return Notepad::factory()->withParents($project)->create();
    }
}
