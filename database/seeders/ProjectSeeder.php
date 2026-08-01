<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->get()->each(function (User $user): void {
            Project::factory(rand(2, 4))->create([
                'user_id' => $user->id,
            ]);
        });
    }
}
