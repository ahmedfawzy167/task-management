<?php

namespace App\Repositories;

use App\Models\Task;
use Illuminate\Pagination\LengthAwarePaginator;

class TaskRepository
{
    public function create(array $data): Task
    {
        return Task::create($data);
    }

    public function getPaginated(int $projectId, array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        return Task::query()
            ->where('project_id', $projectId)
            ->when($filters['status'] ?? null, fn($q, $status) => $q->where('status', $status))
            ->when($filters['priority'] ?? null, fn($q, $priority) => $q->where('priority', $priority))
            ->when($filters['search'] ?? null, fn($q, $search) => $q->where('title', 'like', "%{$search}%"))
            ->latest()
            ->paginate($perPage);
    }

    public function find(int $projectId, int $id): ?Task
    {
        return Task::where('project_id', $projectId)->find($id);
    }

    public function update(Task $task, array $data): bool
    {
        return $task->update($data);
    }

    public function delete(Task $task): ?bool
    {
        return $task->delete();
    }
}
