<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            Project::TITLE => $this->faker->sentence(1),
            Project::DESCRIPTION => $this->faker->sentence(3),
            Project::PRIVATE => false,
        ];
    }

    public function withParents(User $user): ProjectFactory
    {
        return $this->state(function () use ($user) {
            return [Project::USER_ID => $user->{User::ID}];
        });
    }

    public function private(): ProjectFactory
    {
        return $this->state(function () {
            return [Project::PRIVATE => true];
        });
    }
}
