<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    private User $user;
    private Project $project;
    private Project $otherProject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->getUser();
        $this->project = $this->getProject($this->user);
        $this->otherProject = $this->getProject($this->user);
    }

    public function test_has_many_projects(): void
    {
        $this->assertTrue($this->user->projects->contains($this->project));
        $this->assertTrue($this->user->projects->contains($this->otherProject));
    }
}
