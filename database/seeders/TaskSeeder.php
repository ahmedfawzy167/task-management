<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Task::create([
            'title' => 'Develop Zoom Integration',
            'user_id' => 21,
            'status' => 'pending'
        ]);

        Task::create([
            'title' => 'Design App Logo',
            'user_id' => 3,
            'status' => 'pending'
        ]);

        Task::create([
            'title' => 'Add Switcher between Lang',
            'user_id' => 7,
            'status' => 'completed'
        ]);

        Task::create([
            'title' => 'Install Spatie Permissions',
            'user_id' => 8,
            'status' => 'in-progress'
        ]);

    }
}
