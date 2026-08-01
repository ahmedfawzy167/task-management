<?php

namespace App\Repositories;

use App\Models\Project;
use Illuminate\Pagination\LengthAwarePaginator;

class ProjectRepository
{
    public function create(array $data): Project
    {
        return Project::create($data);
    }

    public function getPaginatedForUser(int $userId, int $perPage = 10): LengthAwarePaginator
    {
        return Project::with('user')->where('user_id', $userId)->latest()->paginate($perPage);
    }

    public function findById(int $id): ?Project
    {
        return Project::find($id);
    }

    public function findForUser(int $userId, int $id): Project
    {
        return Project::where('user_id', $userId)->findOrFail($id);
    }

    public function update(Project $project, array $data): bool
    {
        return $project->update($data);
    }

    public function delete(Project $project): ?bool
    {
        return $project->delete();
    }
}
