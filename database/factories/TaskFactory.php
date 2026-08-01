<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\TaskPriorityEnum;
use App\Enums\TaskStatusEnum;
use App\Models\Project;

class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'project_id' => Project::factory(),
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(),
            'priority' => fake()->randomElement(array_column(TaskPriorityEnum::cases(), 'value')),
            'status' => fake()->randomElement(array_column(TaskStatusEnum::cases(), 'value')),
            'due_date' => fake()->dateTimeBetween('-1 week', '+2 weeks'),
        ];
    }
}
