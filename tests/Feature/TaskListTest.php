<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\TaskList;
use App\Models\User;
use Tests\TestCase;

class TaskListTest extends TestCase
{
    private User $user;
    private Project $project;
    private TaskList $taskList;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->createUser();
        $this->project = $this->createProject($this->user);
        $this->taskList = $this->createTaskList($this->project);
    }

    public function test_belongs_to_project(): void
    {
        $taskListProject = $this->taskList->project;
        $this->assertInstanceOf(Project::class, $taskListProject);
    }
}
