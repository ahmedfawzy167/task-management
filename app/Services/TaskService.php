<?php

namespace App\Services;

use App\Models\Task;
use App\Repositories\TaskRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class TaskService
{
    public function __construct(protected TaskRepository $taskRepository)
    {
    }

    public function createTask(int $projectId, array $data): Task
    {
        $data['project_id'] = $projectId;
        return $this->taskRepository->create($data);
    }

    public function getProjectTasks(int $projectId, array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        return $this->taskRepository->getPaginated($projectId, $filters, $perPage);
    }

    public function getProjectTask(int $projectId, int $taskId): ?Task
    {
        return $this->taskRepository->find($projectId, $taskId);
    }

    public function updateTask(Task $task, array $data): Task
    {
        $this->taskRepository->update($task, $data);
        return $task->refresh();
    }

    public function deleteTask(Task $task): void
    {
        $this->taskRepository->delete($task);
    }
}
