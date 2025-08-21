<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\TaskList;
use App\Models\User;
use Tests\TestCase;

class TaskListApiTest extends TestCase
{
    private User $user;
    private User $otherUser;
    private Project $project;
    private Project $otherProject;
    private Project $otherUserProject;
    private Project $privateProject;
    private TaskList $taskList;
    private TaskList $otherTaskList;
    private TaskList $otherProjectTaskList;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->createUser();
        $this->otherUser = $this->createUser();
        $this->project = $this->createProject($this->user);
        $this->otherProject = $this->createProject($this->user);
        $this->otherUserProject = $this->createProject($this->otherUser);
        $this->privateProject = $this->createPrivateProject($this->otherUser);
        $this->taskList = $this->createTaskList($this->project);
        $this->otherTaskList = $this->createTaskList($this->project);
        $this->otherProjectTaskList = $this->createTaskList($this->otherProject);

        $this->user->refresh();
    }

    public function indexRoute($projectId): string
    {
        return route('project.task-list.index', ['project' => $projectId]);
    }

    public function storeRoute($projectId): string
    {
        return route('project.task-list.store', ['project' => $projectId]);
    }

    // public function showRoute($projectId, $taskListId): string
    // {
    //     return route('project.task-list.show', ['project' => $projectId, 'task_list' => $taskListId]);
    // }

    public function updateRoute($projectId, $taskListId): string
    {
        return route('project.task-list.update', ['project' => $projectId, 'task_list' => $taskListId]);
    }

    public function destroyRoute($projectId, $taskListId): string
    {
        return route('project.task-list.destroy', ['project' => $projectId, 'task_list' => $taskListId]);
    }

    // index
    public function test_user_can_index_project_task_lists(): void
    {
        $this->getAsUser($this->user, $this->indexRoute($this->project->{Project::ID}))
            ->assertOk()
            ->assertSee($this->taskList->{TaskList::TITLE});
    }

    public function test_user_can_not_index_other_user_project_task_lists(): void
    {
        $this->getAsUser($this->otherUser, $this->indexRoute($this->project->{Project::ID}))
            ->assertForbidden()
            ->assertDontSee($this->taskList->{TaskList::TITLE});
    }

    public function test_user_can_not_see_other_project_task_lists_on_index(): void
    {
        $this->getAsUser($this->user, $this->indexRoute($this->project->{Project::ID}))
            ->assertOk()
            ->assertDontSee($this->otherProjectTaskList->{TaskList::TITLE});
    }

    // store
    public function test_user_can_store_task_list(): void
    {
        $projectId = $this->project->{Project::ID};
        $data = [
            TaskList::PROJECT_ID => $projectId,
            TaskList::TITLE => 'this is a title for sure',
        ];

        $this->postAsUser($this->user, $this->storeRoute($projectId), $data)
            ->assertCreated();
        
        $this->assertDatabaseHas(TaskList::TABLE, $data);
    }

    public function test_store_task_list_validation_project_id_is_required(): void
    {
        $data = [
            TaskList::TITLE => 'this is a title for sure',
        ];

        $this->postAsUser($this->user, $this->storeRoute($this->project->{Project::ID}), $data)
            ->assertUnprocessable()
            ->assertInvalid(TaskList::PROJECT_ID);
    }

    public function test_store_task_list_validaiton_project_id_is_integer(): void
    {
        $data = [
            TaskList::PROJECT_ID => 'not an integer',
            TaskList::TITLE => 'this is a title for sure',
        ];

        $this->postAsUser($this->user, $this->storeRoute($this->project->{Project::ID}), $data)
            ->assertUnprocessable()
            ->assertInvalid(TaskList::PROJECT_ID);
    }

    public function test_store_task_list_validation_title_is_string(): void
    {
        $projectId = $this->project->{Project::ID};
        $data = [
            TaskList::PROJECT_ID => $projectId,
            TaskList::TITLE => 123123,
        ];

        $this->postAsUser($this->user, $this->storeRoute($projectId), $data)
            ->assertUnprocessable()
            ->assertInvalid(TaskList::TITLE);
    }

    public function test_store_task_list_validation_title_max_length(): void
    {
        $projectId = $this->project->{Project::ID};
        $data = [
            TaskList::PROJECT_ID => $projectId,
            TaskList::TITLE => str_repeat('a', 256),
        ];

        $this->postAsUser($this->user, $this->storeRoute($projectId), $data)
            ->assertUnprocessable()
            ->assertInvalid(TaskList::TITLE);
    }
}
