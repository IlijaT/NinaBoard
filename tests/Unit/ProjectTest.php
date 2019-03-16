<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_a_path()
    {
        $this->signIn();

        $project = factory('App\Project')->create();

        $this->assertEquals('/projects/'.$project->id, $project->path());
    }

    /** @test */
    public function it_belongs_to_an_owner()
    {
        $this->signIn();
            
        $project = factory('App\Project')->create();
            
        $this->assertInstanceOf('App\User', $project->owner);
    }

    /** @test */
    public function it_can_add_a_task()
    {
        $this->withoutExceptionHandling();

        $this->signIn();
            
        $project = factory('App\Project')->create();
        
        $task = [
        'title'      => 'New Task',
        'start'      => $start = Carbon::now(),
        'end'        => $start->addHour(),
        'completed'  => false];
        
        $project->addTask($task);

        $this->assertTrue($project->tasks->contains('title', 'New Task'));
        $this->assertCount(1, $project->tasks);
    }
}
