<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DashboardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'projects' => [
                'total' => $this->resource['projects']['total'],
                'active' => $this->resource['projects']['active'],
            ],
            'tasks' => [
                'total' => $this->resource['tasks']['total'],
                'completed' => $this->resource['tasks']['completed'],
                'pending' => $this->resource['tasks']['pending'],
                'overdue' => $this->resource['tasks']['overdue'],
            ],
        ];
    }
}
