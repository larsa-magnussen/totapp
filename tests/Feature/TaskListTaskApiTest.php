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
    private TaskList $taskList;
    private TaskList $otherProjectTaskList;
    private TaskListTask $taskListTask;
    private TaskListTask $completedTaskListTask;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->createUser();
        $this->otherUser = $this->createUser();
        $this->project = $this->createProject($this->user);
        $this->otherProject = $this->createProject($this->user);
        $this->taskList = $this->createTaskList($this->project);
        $this->otherProjectTaskList = $this->createTaskList($this->otherProject);
        $this->taskListTask = $this->createTaskListTask($this->taskList);
        $this->completedTaskListTask = $this->createCompletedTaskListTask($this->taskList);

        $this->user->refresh();
    }

    public function indexRoute($projectId, $taskListId): string
    {
        return route('project.task-list.tasks.index', ['project' => $projectId, 'task_list' => $taskListId]);
    }

    public function storeRoute($projectId, $taskListId): string
    {
        return route('project.task-list.tasks.store', ['project' => $projectId, 'task_list' => $taskListId]);
    }

    public function destroyRoute($projectId, $taskListId, $taskId): string
    {
        return route('project.task-list.tasks.destroy', [
            'project' => $projectId,
            'task_list' => $taskListId,
            'task' => $taskId
        ]);
    }

    public function completeRoute($projectId, $taskListId, $taskId): string
    {
        return route('project.task-list.tasks.complete', [
            'project' => $projectId,
            'task_list' => $taskListId,
            'task' => $taskId
        ]);
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

    // destroy
    public function test_user_can_destroy_task_list_task(): void
    {
        $url = $this->destroyRoute($this->project->{Project::ID}, $this->taskList->{TaskList::ID}, $this->taskListTask->{TaskListTask::ID});
        $this->deleteAsUser($this->user, $url)
            ->assertOk();

        $this->assertSoftDeleted(TaskListTask::TABLE, [
            TaskListTask::ID => $this->taskListTask->{TaskListTask::ID},
            TaskListTask::DESCRIPTION => $this->taskListTask->{TaskListTask::DESCRIPTION},
        ]);
    }

    public function test_user_can_not_destroy_other_user_task_list_task(): void
    {
        $url = $this->destroyRoute($this->project->{Project::ID}, $this->taskList->{TaskList::ID}, $this->taskListTask->{TaskListTask::ID});
        $this->deleteAsUser($this->otherUser, $url)
            ->assertForbidden();

        $this->assertNotSoftDeleted(TaskListTask::TABLE, [
            TaskListTask::ID => $this->taskListTask->{TaskListTask::ID},
            TaskListTask::DESCRIPTION => $this->taskListTask->{TaskListTask::DESCRIPTION},
        ]);
    }

    // complete
    public function test_user_can_complete_task_list_task(): void
    {
        $url = $this->completeRoute($this->project->{Project::ID}, $this->taskList->{TaskList::ID}, $this->taskListTask->{TaskListTask::ID});
        $this->patchAsUser($this->user, $url);

        $this->taskListTask->refresh();

        $this->assertNotNull($this->taskListTask->{TaskListTask::COMPLETED_AT});
    }

    public function test_user_can_reverse_completed_task_list_task(): void
    {
        $url = $this->completeRoute($this->project->{Project::ID}, $this->taskList->{TaskList::ID}, $this->completedTaskListTask->{TaskListTask::ID});
        $this->patchAsUser($this->user, $url);

        $this->taskListTask->refresh();

        $this->assertNull($this->taskListTask->{TaskListTask::COMPLETED_AT});
    }

    public function test_user_can_not_complete_other_user_task_list_task(): void
    {
        $url = $this->completeRoute($this->project->{Project::ID}, $this->taskList->{TaskList::ID}, $this->taskListTask->{TaskListTask::ID});
        $this->deleteAsUser($this->otherUser, $url)
            ->assertForbidden();

        $this->taskListTask->refresh();

        $this->assertNull($this->taskListTask->{TaskListTask::COMPLETED_AT});
    }
}
