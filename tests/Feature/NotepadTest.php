<?php

namespace Tests\Feature;

use App\Models\Notepad;
use App\Models\Project;
use App\Models\User;
use Tests\TestCase;

class NotepadTest extends TestCase
{
    private User $user;
    private Project $project;
    private Notepad $notepad;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->createUser();
        $this->project = $this->createProject($this->user);
        $this->notepad = $this->createNotepad($this->project);
    }

    public function test_belongs_to_project(): void
    {
        $notepadProject = $this->notepad->project;
        $this->assertInstanceOf(Project::class, $notepadProject);
    }
}
