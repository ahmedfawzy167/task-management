<?php

namespace App\Services;

use App\Models\Project;
use App\Repositories\ProjectRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class ProjectService
{
    public function __construct(protected ProjectRepository $projectRepository)
    {
    }

    public function createProject(int $userId, array $data): Project
    {
        $data['user_id'] = $userId;
        return $this->projectRepository->create($data);
    }

    public function getUserProjects(int $userId, int $perPage = 10): LengthAwarePaginator
    {
        return $this->projectRepository->getPaginatedForUser($userId, $perPage);
    }

    public function getProjectById(int $projectId): ?Project
    {
        return $this->projectRepository->findById($projectId);
    }

    public function getUserProject(int $userId, int $projectId): Project
    {
        return $this->projectRepository->findForUser($userId, $projectId);
    }

    public function updateProject(Project $project, array $data): Project
    {
        $this->projectRepository->update($project, $data);
        return $project->refresh();
    }

    public function deleteProject(Project $project): void
    {
        $this->projectRepository->delete($project);
    }
}
