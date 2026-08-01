<?php

namespace App\Jobs;

use App\Enums\TaskStatusEnum;
use App\Models\Task;
use App\Notifications\TaskOverdueNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class CheckOverdueTasks implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function handle(): void
    {
        $overdueTasks = Task::with('project.user')
            ->where('due_date', '<', now())
            ->where('status', '!=', TaskStatusEnum::DONE->value)
            ->get();

        foreach ($overdueTasks as $task) {
            $user = $task?->project?->user;

            if (! $user) {
                continue;
            }

            $user->notify(new TaskOverdueNotification($task));

            Log::info("Task '{$task->title}' (ID: {$task->id}) is overdue! Notification sent to {$user->email}.");
        }
    }
}
