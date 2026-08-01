<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Services\ProjectService;
use App\Services\TaskService;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Tag(name: 'Tasks', description: 'Project task management endpoints')]
class TaskController extends Controller
{
    use ApiResponder;

    public function __construct(
        protected TaskService $taskService,
        protected ProjectService $projectService
    ) {
    }

    private function verifyProjectAccess(Request $request, int $projectId): ?\Illuminate\Http\JsonResponse
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

    private function listProjectTasks(Request $request, int $projectId, array $filters = []): \Illuminate\Http\JsonResponse
    {
        $response = $this->verifyProjectAccess($request, $projectId);

        if ($response) {
            return $response;
        }

        $queryFilters = array_filter([
            'status' => $request->query('status'),
            'priority' => $request->query('priority'),
            'search' => $request->query('search'),
        ], static fn ($value) => $value !== null && $value !== '');

        $tasks = $this->taskService->getProjectTasks(
            $projectId,
            array_merge($queryFilters, $filters),
            $request->get('limit', 10)
        );

        return $this->success(TaskResource::collection($tasks)->response()->getData(true), 'api.tasks_retrieved_successfully');
    }

    #[OA\Get(
        path: '/api/v1/projects/{project}/tasks',
        summary: 'List tasks',
        description: 'Retrieve tasks for a project owned by the authenticated user.',
        tags: ['Tasks'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'project', in: 'path', required: true, description: 'Project id', schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'status', in: 'query', description: 'Filter by task status', schema: new OA\Schema(type: 'string')),
            new OA\Parameter(name: 'priority', in: 'query', description: 'Filter by task priority', schema: new OA\Schema(type: 'string')),
            new OA\Parameter(name: 'search', in: 'query', description: 'Search tasks by title', schema: new OA\Schema(type: 'string')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Tasks retrieved successfully'),
            new OA\Response(response: 403, description: 'Access forbidden'),
            new OA\Response(response: 404, description: 'Project not found'),
        ]
    )]
    public function index(Request $request, int $projectId)
    {
        return $this->listProjectTasks($request, $projectId);
    }

    #[OA\Get(
        path: '/api/v1/projects/{project}/tasks/{task}',
        summary: 'Show task',
        description: 'Retrieve one task by id for a project owned by the authenticated user.',
        tags: ['Tasks'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'project', in: 'path', required: true, description: 'Project id', schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'task', in: 'path', required: true, description: 'Task id', schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Task retrieved successfully'),
            new OA\Response(response: 403, description: 'Access forbidden'),
            new OA\Response(response: 404, description: 'Task or project not found'),
        ]
    )]
    public function show(Request $request, int $projectId, int $taskId)
    {
        $response = $this->verifyProjectAccess($request, $projectId);

        if ($response) {
            return $response;
        }

        $task = $this->taskService->getProjectTask($projectId, $taskId);

        if (! $task) {
            return $this->notFound('api.not_found');
        }

        return $this->success(new TaskResource($task), 'api.tasks_retrieved_successfully');
    }

    #[OA\Get(
        path: '/api/v1/projects/{project}/tasks/status/{status}',
        summary: 'Filter tasks by status',
        description: 'List tasks for a project filtered by status.',
        tags: ['Tasks'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'project', in: 'path', required: true, description: 'Project id', schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'status', in: 'path', required: true, description: 'Task status', schema: new OA\Schema(type: 'string')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Tasks retrieved successfully'),
        ]
    )]
    public function filterByStatus(Request $request, int $projectId, string $status)
    {
        return $this->listProjectTasks($request, $projectId, ['status' => $status]);
    }

    #[OA\Get(
        path: '/api/v1/projects/{project}/tasks/priority/{priority}',
        summary: 'Filter tasks by priority',
        description: 'List tasks for a project filtered by priority.',
        tags: ['Tasks'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'project', in: 'path', required: true, description: 'Project id', schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'priority', in: 'path', required: true, description: 'Task priority', schema: new OA\Schema(type: 'string')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Tasks retrieved successfully'),
        ]
    )]
    public function filterByPriority(Request $request, int $projectId, string $priority)
    {
        return $this->listProjectTasks($request, $projectId, ['priority' => $priority]);
    }

    #[OA\Get(
        path: '/api/v1/projects/{project}/tasks/search/{title}',
        summary: 'Search tasks by title',
        description: 'Search tasks for a project by title keyword.',
        tags: ['Tasks'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'project', in: 'path', required: true, description: 'Project id', schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'title', in: 'path', required: true, description: 'Title search term', schema: new OA\Schema(type: 'string')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Tasks retrieved successfully'),
        ]
    )]
    public function searchByTitle(Request $request, int $projectId, string $title)
    {
        return $this->listProjectTasks($request, $projectId, ['search' => $title]);
    }

    #[OA\Post(
        path: '/api/v1/projects/{project}/tasks',
        summary: 'Create task',
        description: 'Create a new task for a project owned by the authenticated user.',
        tags: ['Tasks'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'project', in: 'path', required: true, description: 'Project id', schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['title'],
                properties: [
                    new OA\Property(property: 'title', type: 'string', example: 'Write API docs'),
                    new OA\Property(property: 'description', type: 'string', example: 'Document the task management endpoints'),
                    new OA\Property(property: 'priority', type: 'string', example: 'high'),
                    new OA\Property(property: 'status', type: 'string', example: 'pending'),
                    new OA\Property(property: 'due_date', type: 'string', example: '2026-08-15 17:00:00'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Task created successfully'),
            new OA\Response(response: 403, description: 'Access forbidden'),
            new OA\Response(response: 404, description: 'Project not found'),
        ]
    )]
    public function store(StoreTaskRequest $request, int $projectId)
    {
        $response = $this->verifyProjectAccess($request, $projectId);

        if ($response) {
            return $response;
        }

        $task = $this->taskService->createTask($projectId, $request->validated());

        return $this->created(new TaskResource($task), 'api.task_created_successfully');
    }

    #[OA\Put(
        path: '/api/v1/projects/{project}/tasks/{task}',
        summary: 'Update task',
        description: 'Update an existing task for a project owned by the authenticated user.',
        tags: ['Tasks'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'project', in: 'path', required: true, description: 'Project id', schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'task', in: 'path', required: true, description: 'Task id', schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'title', type: 'string', example: 'Write API docs'),
                    new OA\Property(property: 'description', type: 'string', example: 'Document the task management endpoints'),
                    new OA\Property(property: 'priority', type: 'string', example: 'high'),
                    new OA\Property(property: 'status', type: 'string', example: 'completed'),
                    new OA\Property(property: 'due_date', type: 'string', example: '2026-08-15 17:00:00'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Task updated successfully'),
            new OA\Response(response: 403, description: 'Access forbidden'),
            new OA\Response(response: 404, description: 'Task or project not found'),
        ]
    )]
    public function update(UpdateTaskRequest $request, int $projectId, int $taskId)
    {
        $response = $this->verifyProjectAccess($request, $projectId);

        if ($response) {
            return $response;
        }

        $task = $this->taskService->getProjectTask($projectId, $taskId);

        if (! $task) {
            return $this->notFound('api.not_found');
        }

        $task = $this->taskService->updateTask($task, $request->validated());

        return $this->success(new TaskResource($task), 'api.task_updated_successfully');
    }

    #[OA\Delete(
        path: '/api/v1/projects/{project}/tasks/{task}',
        summary: 'Delete task',
        description: 'Delete a task for a project owned by the authenticated user.',
        tags: ['Tasks'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'project', in: 'path', required: true, description: 'Project id', schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'task', in: 'path', required: true, description: 'Task id', schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Task deleted successfully'),
            new OA\Response(response: 403, description: 'Access forbidden'),
            new OA\Response(response: 404, description: 'Task or project not found'),
        ]
    )]
    public function destroy(Request $request, int $projectId, int $taskId)
    {
        $response = $this->verifyProjectAccess($request, $projectId);

        if ($response) {
            return $response;
        }

        $task = $this->taskService->getProjectTask($projectId, $taskId);

        if (! $task) {
            return $this->notFound('api.not_found');
        }

        $this->taskService->deleteTask($task);

        return $this->success(null, 'api.task_deleted_successfully');
    }
}
