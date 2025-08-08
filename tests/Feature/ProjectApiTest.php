<?php

namespace Tests\Feature;

use Tests\TestCase;

class ProjectApiTest extends TestCase
{
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

    public function update($projectId): string
    {
        return route('project.update', ['project' => $projectId]);
    }

    public function destroy($projectId): string
    {
        return route('project.destroy', ['project' => $projectId]);
    }
}
