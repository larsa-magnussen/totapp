<?php

namespace Database\Factories;

use App\Models\Notepad;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notepad>
 */
class NotepadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
        ];
    }

    public function withParents(Project $project): NotepadFactory
    {
        return $this->state(function () use ($project) {
            return [Notepad::PROJECT_ID => $project->{Project::ID}];
        });
    }
}
