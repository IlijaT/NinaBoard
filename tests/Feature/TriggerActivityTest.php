<?php

namespace Tests\Feature;

use App\Task;
use App\Project;
use Carbon\Carbon;
use Tests\TestCase;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TriggerActivityTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function creating_a_project_triggers_activity()
    {
        $this->signIn();

        $project = ProjectFactory::create();


        tap($project->activities->last(), function ($activity) {
            $this->assertEquals('created_project', $activity->description);
            
            $this->assertNull($activity->changes);
        });
    }
    

    /** @test */
    public function updating_a_project_triggers_activity()
    {
        $this->signIn();
        
        $project = ProjectFactory::create();

        $originalTitle = $project->title;

        $project->update(['title' => 'Changed']);

        $this->assertCount(2, $project->activities);

        tap($project->activities->last(), function ($activity) use ($originalTitle) {
            $this->assertEquals('updated_project', $activity->description);
            
            $expected = [
                'before' => ['title' => $originalTitle],
                'after' => ['title' => 'Changed']
            ];

            $this->assertEquals($expected, $activity->changes);
        });
    }


    /** @test */
    public function creating_a_task_triggers_activity()
    {
        $this->withExceptionHandling();
        
        $this->signIn();

        $project = factory(Project::class)->create();
        
        $start = Carbon::now();
        $end = $start->addHour();

        $project->addTask(['title' => 'Test task', 'start' => $start, 'end' => $end]);

        $this->assertCount(2, $project->activities);
        
        tap($project->activities->last(), function ($activity) {
            $this->assertEquals('created_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
            $this->assertEquals('Test task', $activity->subject->title);
        });
    }

    
    /** @test */
    public function incompleting_a_task_triggers_activity()
    {
        $this->signIn();
        
        $project = ProjectFactory::withTasks(1)->create();
        
        $this->patch($project->tasks->first()->path(), [
            'title' => 'changed title',
            'completed' => true
            ]);
            
        $this->assertCount(3, $project->fresh()->activities);
            
        $this->patch($project->tasks->first()->path(), [
            'title' => 'changed title',
            'completed' => false
            ]);

        $project = $project->fresh();

        $this->assertCount(4, $project->activities);
        $this->assertEquals('incompleted_task', $project->activities->fresh()->last()->description);
    }
            
    /** @test */
    public function completing_a_task_triggers_activity()
    {
        $this->signIn();
        
        $project = ProjectFactory::withTasks(1)->create();
        
        $this->patch($project->tasks->first()->path(), [
            'title' => 'changed title',
            'completed' => true
            ]);

        $project = $project->fresh();
            
        $this->assertCount(3, $project->activities);

        $this->assertEquals('completed_task', $project->activities->fresh()->last()->description);
    }

    /** @test */
    public function deleting_a_task_triggers_activity()
    {
        
        $this->signIn();
        
        $project = ProjectFactory::withTasks(1)->create();

        $project->tasks[0]->delete();

        $this->assertCount(3, $project->activities);
        $this->assertEquals('deleted_task', $project->fresh()->activities->fresh()->last()->description);
    }
}
