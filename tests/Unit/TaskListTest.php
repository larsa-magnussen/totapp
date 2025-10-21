<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\TaskList;
use App\Models\TaskListTask;
use App\Models\User;
use Tests\TestCase;

class TaskListTest extends TestCase
{
    private User $user;
    private Project $project;
    private TaskList $taskList;
    private TaskListTask $task;
    private TaskListTask $otherTaskListTask;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->createUser();
        $this->project = $this->createProject($this->user);
        $this->taskList = $this->createTaskList($this->project);
        $this->taskListTask = $this->createTaskListTask($this->taskList);
        $this->otherTaskListTask = $this->createTaskListTask($this->taskList);
    }

    public function test_belongs_to_project(): void
    {
        $taskListProject = $this->taskList->project;
        $this->assertInstanceOf(Project::class, $taskListProject);
    }

    public function test_has_many_task_list_tasks(): void
    {
        $tasks = $this->taskList->taskListTasks;
        $this->assertTrue($tasks->contains($this->taskListTask));
        $this->assertTrue($tasks->contains($this->otherTaskListTask));
    }
}
