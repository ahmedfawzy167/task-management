<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        Project::factory(5)->create([
            'user_id' => $user->id,
        ])->each(function ($project) {
            Task::factory(10)->create([
                'project_id' => $project->id,
            ]);
        });

        $users = User::factory(3)->create();
        foreach ($users as $dummyUser) {
            Project::factory(2)->create([
                'user_id' => $dummyUser->id,
            ])->each(function ($project) {
                Task::factory(5)->create([
                    'project_id' => $project->id,
                ]);
            });
        }
    }
}
