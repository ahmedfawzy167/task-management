<?php

namespace App\Services;

use App\Models\Project;
use App\Models\Task;
use App\Enums\ProjectStatusEnum;
use App\Enums\TaskStatusEnum;

class DashboardService
{
    public function getStats(int $userId): array
    {
        $projectQuery = Project::where('user_id', $userId);
        $taskQuery = Task::whereHas('project', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        });

        return [
            'projects' => [
                'total' => (clone $projectQuery)->count(),
                'active' => (clone $projectQuery)->where('status', ProjectStatusEnum::ACTIVE->value)->count(),
            ],
            'tasks' => [
                'total' => (clone $taskQuery)->count(),
                'completed' => (clone $taskQuery)->where('status', TaskStatusEnum::DONE->value)->count(),
                'pending' => (clone $taskQuery)->whereIn('status', [TaskStatusEnum::TODO->value, TaskStatusEnum::IN_PROGRESS->value])->count(),
                'overdue' => (clone $taskQuery)->where('due_date', '<', now())
                    ->where('status', '!=', TaskStatusEnum::DONE->value)
                    ->count(),
            ],
        ];
    }
}
