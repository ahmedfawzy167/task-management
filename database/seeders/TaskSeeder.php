<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        Project::query()->get()->each(function (Project $project): void {
            Task::factory(rand(3, 6))->create([
                'project_id' => $project->id,
            ]);
        });
    }
}
