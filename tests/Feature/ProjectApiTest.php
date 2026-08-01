<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_a_project()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/v1/projects', [
            'name' => 'My New Project',
            'description' => 'Test project description',
            'status' => 'active',
        ]);

        $response->assertStatus(201)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.name', 'My New Project')
            ->assertJsonPath('data.user.name', $user->name);
    }

    public function test_user_can_fetch_their_projects()
    {
        $user = User::factory()->create();
        Project::factory(3)->create(['user_id' => $user->id]);

        $otherUser = User::factory()->create();
        Project::factory(2)->create(['user_id' => $otherUser->id]);

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/v1/projects');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    public function test_user_can_not_access_other_users_project()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $otherProject = Project::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->actingAs($user, 'sanctum')->getJson("/api/v1/projects/{$otherProject->id}");

        $response->assertStatus(403);
    }

    public function test_show_update_and_delete_project_return_not_found_when_project_does_not_exist()
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'sanctum')->getJson('/api/v1/projects/99999')
            ->assertStatus(404)
            ->assertJsonPath('success', false);

        $this->actingAs($user, 'sanctum')->putJson('/api/v1/projects/99999', ['name' => 'Updated'])
            ->assertStatus(404)
            ->assertJsonPath('success', false);

        $this->actingAs($user, 'sanctum')->deleteJson('/api/v1/projects/99999')
            ->assertStatus(404)
            ->assertJsonPath('success', false);
    }

}
