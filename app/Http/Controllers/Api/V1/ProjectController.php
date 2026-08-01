<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Services\ProjectService;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Tag(name: 'Projects', description: 'Project management endpoints')]
class ProjectController extends Controller
{
    use ApiResponder;

    public function __construct(protected ProjectService $projectService)
    {
    }

    #[OA\Get(
        path: '/api/v1/projects',
        summary: 'List projects',
        description: 'Retrieve all projects owned by the authenticated user.',
        tags: ['Projects'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'limit', in: 'query', description: 'Number of projects to return', schema: new OA\Schema(type: 'integer', default: 10)),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Projects retrieved successfully'),
        ]
    )]
    public function index(Request $request)
    {
        $projects = $this->projectService->getUserProjects($request->user()->id, $request->get('limit', 10));

        return $this->success(ProjectResource::collection($projects)->response()->getData(true), 'api.projects_retrieved_successfully');
    }

    #[OA\Post(
        path: '/api/v1/projects',
        summary: 'Create project',
        description: 'Create a new project for the authenticated user.',
        tags: ['Projects'],
        security: [['sanctum' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name'],
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'Website Redesign'),
                    new OA\Property(property: 'description', type: 'string', example: 'Redesign the main website'),
                    new OA\Property(property: 'status', type: 'string', example: 'pending'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Project created successfully'),
            new OA\Response(response: 422, description: 'Validation failed'),
        ]
    )]
    public function store(StoreProjectRequest $request)
    {
        $project = $this->projectService->createProject($request->user()->id, $request->validated());

        return $this->created(new ProjectResource($project), 'api.project_created_successfully');
    }

    private function ensureProjectAccess(Request $request, int $projectId): ?\Illuminate\Http\JsonResponse
    {
        $project = $this->projectService->getProjectById($projectId);

        if (! $project) {
            return $this->notFound('api.not_found');
        }

        if ((int) $project->user_id !== (int) $request->user()->id) {
            return $this->forbidden('api.forbidden');
        }

        return null;
    }

    #[OA\Get(
        path: '/api/v1/projects/{project}',
        summary: 'Show project',
        description: 'Retrieve one project by id if it belongs to the authenticated user.',
        tags: ['Projects'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'project', in: 'path', required: true, description: 'Project id', schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Project retrieved successfully'),
            new OA\Response(response: 403, description: 'Access forbidden'),
            new OA\Response(response: 404, description: 'Project not found'),
        ]
    )]
    public function show(Request $request, int $id)
    {
        $response = $this->ensureProjectAccess($request, $id);

        if ($response) {
            return $response;
        }

        $project = $this->projectService->getUserProject($request->user()->id, $id);

        return $this->success(new ProjectResource($project), 'api.project_viewed_successfully');
    }

    #[OA\Put(
        path: '/api/v1/projects/{project}',
        summary: 'Update project',
        description: 'Update an existing project owned by the authenticated user.',
        tags: ['Projects'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'project', in: 'path', required: true, description: 'Project id', schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'Website Redesign'),
                    new OA\Property(property: 'description', type: 'string', example: 'Updated description'),
                    new OA\Property(property: 'status', type: 'string', example: 'in_progress'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Project updated successfully'),
            new OA\Response(response: 403, description: 'Access forbidden'),
            new OA\Response(response: 404, description: 'Project not found'),
        ]
    )]
    public function update(UpdateProjectRequest $request, int $id)
    {
        $response = $this->ensureProjectAccess($request, $id);

        if ($response) {
            return $response;
        }

        $project = $this->projectService->getUserProject($request->user()->id, $id);

        $project = $this->projectService->updateProject($project, $request->validated());

        return $this->success(new ProjectResource($project), 'api.project_updated_successfully');
    }

    #[OA\Delete(
        path: '/api/v1/projects/{project}',
        summary: 'Delete project',
        description: 'Delete a project owned by the authenticated user.',
        tags: ['Projects'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'project', in: 'path', required: true, description: 'Project id', schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Project deleted successfully'),
            new OA\Response(response: 403, description: 'Access forbidden'),
            new OA\Response(response: 404, description: 'Project not found'),
        ]
    )]
    public function destroy(Request $request, int $id)
    {
        $response = $this->ensureProjectAccess($request, $id);

        if ($response) {
            return $response;
        }

        $project = $this->projectService->getUserProject($request->user()->id, $id);

        $this->projectService->deleteProject($project);

        return $this->success(null, 'api.project_deleted_successfully');
    }
}
