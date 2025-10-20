<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\TaskList;
use App\Models\TaskListTask;
use App\Models\User;
use Tests\TestCase;

class TaskListTaskTest extends TestCase
{
    private User $user;
    private Project $project;
    private TaskList $taskList;
    private TaskListTask $taskListTask;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->createUser();
        $this->project = $this->createProject($this->user);
        $this->taskList = $this->createTaskList($this->project);
        $this->taskListTask = $this->createTaskListTask($this->taskList);
    }

    public function test_belongs_to_task_list(): void
    {
        $taskList = $this->taskListTask->taskList;
        $this->assertInstanceOf(TaskList::class, $taskList);
    }
}
