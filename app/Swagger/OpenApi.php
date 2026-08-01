<?php

namespace App\Swagger;

use OpenApi\Attributes as OA;

#[OA\Info(title: 'Task Management API', version: '1.0.0', description: 'Authentication, project management, task management, and dashboard statistics API')]
#[OA\OpenApi(
    security: [['sanctum' => []]],
    servers: [new OA\Server(url: '/api/v1')]
)]
class OpenApi
{
}
