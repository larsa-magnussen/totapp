<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\TaskList;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TaskList>
 */
class TaskListFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            TaskList::TITLE => $this->faker->sentence(2),
        ];
    }

    public function withParents(Project $project): TaskListFactory
    {
        return $this->state(function () use ($project) {
            return [TaskList::PROJECT_ID => $project->{Project::ID}];
        });
    }
}
