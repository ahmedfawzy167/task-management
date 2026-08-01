<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
class TaskApiTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
     public function test_task_creation_returns_not_found_when_project_does_not_exist()
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'sanctum')->postJson('/api/v1/projects/99999/tasks', [
            'title' => 'New task',
            'description' => 'A task',
            'status' => 'todo',
            'priority' => 'medium',
            'due_date' => now()->addDay()->format('Y-m-d H:i:s'),
        ])
         ->assertStatus(404)
         ->assertJsonPath('success', false);
    }
}
