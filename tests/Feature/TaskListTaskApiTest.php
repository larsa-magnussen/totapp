<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\TaskList;
use App\Models\TaskListTask;
use App\Models\User;
use Tests\TestCase;

class TaskListTaskApiTest extends TestCase
{
    private User $user;
    private User $otherUser;
    private Project $project;
    private Project $otherProject;
    private Project $otherUserProject;
    private TaskList $taskList;
    private TaskList $otherProjectTaskList;
    private TaskList $otherUserTaskList;
    private TaskListTask $taskListTask;
    private TaskListTask $otherTaskListTask;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->createUser();
        $this->otherUser = $this->createUser();
        $this->project = $this->createProject($this->user);
        $this->otherProject = $this->createProject($this->user);
        $this->otherUserProject = $this->createProject($this->otherUser);
        $this->taskList = $this->createTaskList($this->project);
        $this->otherProjectTaskList = $this->createTaskList($this->otherProject);
        $this->otherUserTaskList = $this->createTaskList($this->otherUserProject);
        $this->taskListTask = $this->createTaskListTask($this->taskList);
        $this->otherTaskListTask = $this->createTaskListTask($this->otherProjectTaskList);

        $this->user->refresh();
    }

    public function indexRoute($projectId, $taskListId): string
    {
        return route('project.task-list.task-list-task.index', ['project' => $projectId, 'task_list' => $taskListId]);
    }

    public function storeRoute($projectId, $taskListId): string
    {
        return route('project.task-list.task-list-task.store', ['project' => $projectId, 'task_list' => $taskListId]);
    }

    // index
    public function test_user_can_index_task_list_tasks(): void
    {
        $this->getAsUser($this->user, $this->indexRoute($this->project->{Project::ID}, $this->taskList->{TaskList::ID}))
            ->assertOk()
            ->assertSee($this->taskListTask->{TaskListTask::DESCRIPTION});
    }

    public function test_user_can_not_index_other_user_task_list_tasks(): void
    {
        $this->getAsUser($this->otherUser, $this->indexRoute($this->project->{Project::ID}, $this->taskList->{TaskList::ID}))
            ->assertForbidden()
            ->assertDontSee($this->taskListTask->{TaskListTask::DESCRIPTION});
    }

    public function test_user_can_not_see_other_task_list_tasks(): void
    {
        $this->getAsUser($this->user, $this->indexRoute($this->otherProject->{Project::ID}, $this->otherProjectTaskList->{TaskList::ID}))
            ->assertOk()
            ->assertDontSee($this->taskListTask->{TaskListTask::DESCRIPTION});
    }

    // store
    public function test_user_can_store_task_list_task(): void
    {
        $data = [TaskListTask::DESCRIPTION => 'description'];
        $this->postAsUser($this->user, $this->storeRoute($this->project->{Project::ID}, $this->taskList->{TaskList::ID}), $data)
            ->assertCreated();

        $this->assertDatabaseHas(TaskListTask::TABLE, $data);
    }

    public function test_store_task_list_task_validation_description_is_required(): void
    {
        $data = [];
        $this->postAsUser($this->user, $this->storeRoute($this->project->{Project::ID}, $this->taskList->{TaskList::ID}), $data)
            ->assertUnprocessable()
            ->assertInvalid(TaskListTask::DESCRIPTION);
    }

    public function test_store_task_list_task_validation_description_is_string(): void
    {
        $data = [TaskListTask::DESCRIPTION => 123123];
        $this->postAsUser($this->user, $this->storeRoute($this->project->{Project::ID}, $this->taskList->{TaskList::ID}), $data)
            ->assertUnprocessable()
            ->assertInvalid(TaskListTask::DESCRIPTION);
    }

    public function test_store_task_list_task_validation_description_max_length(): void
    {
        $data = [TaskListTask::DESCRIPTION => str_repeat('a', 151)];
        $this->postAsUser($this->user, $this->storeRoute($this->project->{Project::ID}, $this->taskList->{TaskList::ID}), $data)
            ->assertUnprocessable()
            ->assertInvalid(TaskListTask::DESCRIPTION);
    }
}
