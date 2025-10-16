<?php

namespace Database\Factories;

use App\Models\TaskList;
use App\Models\TaskListTask;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TaskListTask>
 */
class TaskListTaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            TaskListTask::DESCRIPTION => $this->faker->sentence(2),
        ];
    }

    public function withParents(TaskList $taskList): TaskListTaskFactory
    {
        return $this->state(function () use ($taskList) {
            return [TaskListTask::TASK_LIST_ID => $taskList->{TaskList::ID}];
        });
    }

    public function completed(): TaskListTaskFactory
    {
        return $this->state(function () {
            return [TaskListTask::COMPLETED_AT => Carbon::now()];
        });
    }

    public function deleted(): TaskListTaskFactory
    {
        return $this->state(function () {
            return [TaskListTask::DELETED_AT => Carbon::now()];
        });
    }
}
