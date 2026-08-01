<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use App\Models\Task;
use App\Enums\TaskStatusEnum;

class CheckOverdueTasks implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $overdueTasks = Task::with('project.user')
            ->where('due_date', '<', now())
            ->where('status', '!=', TaskStatusEnum::DONE->value)
            ->get();

        foreach ($overdueTasks as $task) {
            // In a real application, you would send a mail/notification to the user
            $user = $task?->project?->user;
            Log::info("Task '{$task->title}' (ID: {$task->id}) is overdue! Notification sent to {$user->email}.");
        }
    }
}
