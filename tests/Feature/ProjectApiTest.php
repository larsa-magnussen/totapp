<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Tests\TestCase;

class ProjectApiTest extends TestCase
{
    private User $user;
    private User $otherUser;
    private Project $project;
    private Project $otherProject;
    private Project $privateProject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->getUser();
        $this->otherUser = $this->getUser();
        $this->project = $this->getProject($this->user);
        $this->otherProject = $this->getProject($this->otherUser);
        $this->privateProject = $this->getPrivateProject($this->otherUser);

        $this->user->refresh();
    }

    public function indexRoute(): string
    {
        return route('project.index');
    }

    public function storeRoute(): string
    {
        return route('project.store');
    }

    public function showRoute($projectId): string
    {
        return route('project.show', ['project' => $projectId]);
    }

    public function updateRoute($projectId): string
    {
        return route('project.update', ['project' => $projectId]);
    }

    public function destroyRoute($projectId): string
    {
        return route('project.destroy', ['project' => $projectId]);
    }

    // index tests
    public function test_user_can_index_own_projects(): void
    {
        $this->getAsUser($this->user, $this->indexRoute())
            ->assertOk()
            ->assertSee($this->project->{Project::TITLE});
    }

    public function test_user_can_not_index_other_user_projects(): void
    {
        $this->getAsUser($this->user, $this->indexRoute())
            ->assertOk()
            ->assertDontSee($this->otherProject->{Project::TITLE});
    }

    // store tests
    public function test_user_can_store_project(): void
    {
        $data = [
            Project::TITLE => 'this is the title',
            Project::DESCRIPTION => 'this is a description of my project',
            Project::PRIVATE => false,
        ];

        $this->postAsUser($this->user, $this->storeRoute(), $data)
            ->assertCreated();

        $this->assertDatabaseHas(Project::TABLE, $data);
    }

    public function test_store_project_validation_title_is_required(): void
    {
        $data = [
            Project::DESCRIPTION => 'this is a description of my project',
            Project::PRIVATE => false,
        ];

        $this->postAsUser($this->user, $this->storeRoute(), $data)
            ->assertUnprocessable()
            ->assertInvalid(Project::TITLE);
    }

    public function test_store_project_validation_title_max_length(): void
    {
        $data = [
            Project::TITLE => str_repeat('a', 101),
            Project::DESCRIPTION => 'this is a description of my project',
            Project::PRIVATE => false,
        ];

        $this->postAsUser($this->user, $this->storeRoute(), $data)
            ->assertUnprocessable()
            ->assertInvalid(Project::TITLE);
    }

    public function test_store_project_validation_title_is_string(): void
    {
        $data = [
            Project::TITLE => 10000,
            Project::DESCRIPTION => 'this is a description of my project',
            Project::PRIVATE => false,
        ];

        $this->postAsUser($this->user, $this->storeRoute(), $data)
            ->assertUnprocessable()
            ->assertInvalid(Project::TITLE);
    }

    public function test_store_project_validation_description_is_nullable(): void
    {
        $data = [
            Project::TITLE => 'this is the title',
            Project::PRIVATE => false,
        ];

        $this->postAsUser($this->user, $this->storeRoute(), $data)
            ->assertCreated();

        $this->assertDatabaseHas(Project::TABLE, $data);
    }

    public function test_store_project_validation_description_is_string(): void
    {
        $data = [
            Project::TITLE => 'this is the title',
            Project::DESCRIPTION => 123,
            Project::PRIVATE => false,
        ];

        $this->postAsUser($this->user, $this->storeRoute(), $data)
            ->assertUnprocessable()
            ->assertInvalid(Project::DESCRIPTION);
    }

    public function test_store_project_validation_description_max_length(): void
    {
        $data = [
            Project::TITLE => 'this is the title',
            Project::DESCRIPTION => str_repeat('a', 501),
            Project::PRIVATE => false,
        ];

        $this->postAsUser($this->user, $this->storeRoute(), $data)
            ->assertUnprocessable()
            ->assertInvalid(Project::DESCRIPTION);
    }

    public function test_store_project_validation_private_is_required(): void
    {
        $data = [
            Project::TITLE => 'this is the title',
            Project::DESCRIPTION => 'this is a description of my project',
        ];

        $this->postAsUser($this->user, $this->storeRoute(), $data)
            ->assertUnprocessable()
            ->assertInvalid(Project::PRIVATE);
    }

    public function test_store_project_validation_private_is_bool(): void
    {
        $data = [
            Project::TITLE => 'this is the title',
            Project::DESCRIPTION => 'this is a description of my project',
            Project::PRIVATE => 'not bool'
        ];

        $this->postAsUser($this->user, $this->storeRoute(), $data)
            ->assertUnprocessable()
            ->assertInvalid(Project::PRIVATE);
    }

    // show tests
    public function test_user_can_show_own_project(): void
    {
        $this->getAsUser($this->user, $this->showRoute($this->project->{Project::ID}))
            ->assertOk()
            ->assertSee($this->project->{Project::TITLE});
    }

    public function test_user_can_not_show_other_user_private_project(): void
    {
        $this->getAsUser($this->user, $this->showRoute($this->privateProject->{Project::ID}))
            ->assertForbidden();
    }

    public function test_user_can_show_own_private_project(): void
    {
        $this->getAsUser($this->otherUser, $this->showRoute($this->privateProject->{Project::ID}))
            ->assertOk()
            ->assertSee($this->privateProject->{Project::TITLE});
    }

    // update tests
    public function test_user_can_update_own_project(): void
    {
        $data = [
            Project::TITLE => 'this is the title',
            Project::DESCRIPTION => 'this is a description of my project',
            Project::PRIVATE => false,
        ];

        $this->putAsUser($this->user, $this->updateRoute($this->project->{Project::ID}), $data)
            ->assertOk();

        $this->assertDatabaseHas(Project::TABLE, $data);
    }

    public function test_user_can_not_update_other_user_project(): void
    {
        $data = [
            Project::TITLE => 'this is the title',
            Project::DESCRIPTION => 'this is a description of my project',
            Project::PRIVATE => false,
        ];

        $this->putAsUser($this->user, $this->updateRoute($this->otherProject->{Project::ID}), $data)
            ->assertForbidden();
    }

    public function test_update_project_validation_title_max_length(): void
    {
        $data = [
            Project::TITLE => str_repeat('a', 101),
            Project::DESCRIPTION => 'this is a description of my project',
            Project::PRIVATE => false,
        ];

        $this->putAsUser($this->user, $this->updateRoute($this->project->{Project::ID}), $data)
            ->assertUnprocessable()
            ->assertInvalid(Project::TITLE);
    }

    public function test_update_project_validation_title_is_string(): void
    {
        $data = [
            Project::TITLE => 10000,
            Project::DESCRIPTION => 'this is a description of my project',
            Project::PRIVATE => false,
        ];

        $this->putAsUser($this->user, $this->updateRoute($this->project->{Project::ID}), $data)
            ->assertUnprocessable()
            ->assertInvalid(Project::TITLE);
    }

    public function test_update_project_validation_description_is_string(): void
    {
        $data = [
            Project::TITLE => 'this is the title',
            Project::DESCRIPTION => 123,
            Project::PRIVATE => false,
        ];

        $this->putAsUser($this->user, $this->updateRoute($this->project->{Project::ID}), $data)
            ->assertUnprocessable()
            ->assertInvalid(Project::DESCRIPTION);
    }

    public function test_update_project_validation_description_max_length(): void
    {
        $data = [
            Project::TITLE => 'this is the title',
            Project::DESCRIPTION => str_repeat('a', 501),
            Project::PRIVATE => false,
        ];

        $this->putAsUser($this->user, $this->updateRoute($this->project->{Project::ID}), $data)
            ->assertUnprocessable()
            ->assertInvalid(Project::DESCRIPTION);
    }

    public function test_update_project_validation_private_is_bool(): void
    {
        $data = [
            Project::TITLE => 'this is the title',
            Project::DESCRIPTION => 'this is a description of my project',
            Project::PRIVATE => 'not bool'
        ];

        $this->putAsUser($this->user, $this->updateRoute($this->project->{Project::ID}), $data)
            ->assertUnprocessable()
            ->assertInvalid(Project::PRIVATE);
    }

    // delete tests
    public function test_user_can_delete_own_project(): void
    {
        $this->deleteAsUser($this->user, $this->destroyRoute($this->project->{Project::ID}))
            ->assertOk();

        $this->assertDatabaseMissing(Project::TABLE, $this->project->toArray());
    }

    public function test_user_can_not_delete_other_user_project(): void
    {
        $this->deleteAsUser($this->user, $this->destroyRoute($this->otherProject->{Project::ID}))
            ->assertForbidden();

        $this->assertDatabaseHas(Project::TABLE, [Project::ID => $this->otherProject->{Project::ID}]);
    }
}
