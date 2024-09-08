<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_fetch_tasks()
    {
        $tasks = Task::factory()->count(3)->create();

        $this->getJson(route('tasks.index'))
            ->assertStatus(Response::HTTP_OK)
            ->assertJson($tasks->toArray());

        $this->get(route('tasks.index'))
            ->assertStatus(Response::HTTP_OK)
            ->assertViewIs('index')
            ->assertViewHas('tasks', $tasks);
    }

    public function test_can_create_task()
    {
        $taskData = Task::factory()->make()->toArray();

        $this->postJson(route('tasks.store'), $taskData)
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure(['message', 'task']);

        $this->assertDatabaseHas('tasks', $taskData);

        $this->post(route('tasks.store'), $taskData)
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', $taskData);
    }




    public function test_can_update_task()
    {
        $task = Task::factory()->create();
        $updatedData = Task::factory()->make()->toArray();

        $this->putJson(route('tasks.update', $task), $updatedData)
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(['message', 'task']);

        $this->assertDatabaseHas('tasks', $updatedData);

        $this->put(route('tasks.update', $task), $updatedData)
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', $updatedData);
    }

  
}
