<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\User;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    private User $user;
    private Project $project;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->getUser();
        $this->project = $this->getProject($this->user);
    }

    public function test_belongs_to_user(): void
    {
        $projectUser = $this->project->user;
        $this->assertInstanceOf(User::class, $projectUser);
    }
}
