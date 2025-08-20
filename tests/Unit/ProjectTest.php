<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\TaskList;
use App\Models\User;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    private User $user;
    private Project $project;
    private TaskList $taskList;
    private TaskList $otherTaskList;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->createUser();
        $this->project = $this->createProject($this->user);
        $this->taskList = $this->createTaskList($this->project);
        $this->otherTaskList = $this->createTaskList($this->project);
    }

    public function test_belongs_to_user(): void
    {
        $projectUser = $this->project->user;
        $this->assertInstanceOf(User::class, $projectUser);
    }

    public function test_has_many_task_lists(): void
    {
        $taskLists = $this->project->taskLists;
        $this->assertTrue($taskLists->contains($this->taskList));
        $this->assertTrue($taskLists->contains($this->otherTaskList));
    }
}
