<?php

namespace Tests\Unit;

use App\Project;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_project()
    {
        $this->signIn();

        $task = factory('App\Task')->create();

        $this->assertInstanceOf(Project::class, $task->project);
    }

    /** @test */
    public function a_task_has_a_path()
    {
        $this->signIn();
        
        $task = factory('App\Task')->create();

        $this->assertEquals('/projects/'.$task->project->id . '/tasks/'. $task->id, $task->path());
    }

    /** @test */
    public function a_task_can_be_completed()
    {
        $this->signIn();

        $task = factory('App\Task')->create();
        
        $this->assertFalse($task->completed);
        
        $task->complete();

        $this->assertTrue($task->fresh()->completed);
    }

    /** @test */
    public function a_task_can_be_marked_as_incomplete()
    {
        $this->signIn();

        $task = factory('App\Task')->create(['completed' => true]);

        $this->assertTrue($task->completed);
        
        $task->incomplete();

        $this->assertFalse($task->fresh()->completed);
    }
}
