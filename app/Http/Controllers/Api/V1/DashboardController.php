<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\DashboardResource;
use App\Services\DashboardService;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Tag(name: 'Dashboard', description: 'Dashboard statistics endpoints')]
class DashboardController extends Controller
{
    use ApiResponder;

    public function __construct(protected DashboardService $dashboardService)
    {
    }

    #[OA\Get(
        path: '/api/v1/dashboard/stats',
        summary: 'Dashboard statistics',
        description: 'Retrieve dashboard statistics for the authenticated user.',
        tags: ['Dashboard'],
        security: [['sanctum' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Dashboard stats retrieved successfully'),
        ]
    )]
    public function stats(Request $request)
    {
        $stats = $this->dashboardService->getStats($request->user()->id);

        return $this->success(new DashboardResource($stats), 'api.dashboard_stats_retrieved_successfully');
    }
}
