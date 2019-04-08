<?php

namespace Tests\Feature;

use App\Task;
use App\Project;
use Carbon\Carbon;
use Tests\TestCase;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTaskTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function guests_cannot_add_tasks_to_projects()
    {
        $this->signIn();

        $project = factory(\App\Project::class)->create();

        auth()->logout();

        $this->post($project->path() . '/tasks')->assertRedirect('login');
    }
    
    /** @test */
    public function a_project_can_have_tasks()
    {
        $this->signIn();

        $project = factory(Project::class)->create();

        $start = Carbon::now();
        $end = $start->addHour();

        $this->post($project->path(). '/tasks', ['title' => 'Test task', 'start' => $start, 'end' => $end]);

        $this->assertDatabaseHas('tasks', ['title' => 'Test task']);
    }

    /** @test */
    public function a_task_can_be_updated()
    {
        $this->signIn();
        
        $project = ProjectFactory::withTasks(1)->create();

        $this->patch($project->tasks->first()->path(), [
            'title' => 'changed title',
        ]);

        $this->assertDatabaseHas('tasks', [
            'title' => 'changed title',
        ]);
    }

    /** @test */
    public function a_task_of_a_project_can_be_completed()
    {
        $this->signIn();
        
        $project = ProjectFactory::withTasks(1)->create();


        $this->patch($project->tasks->first()->path(), [
            'title' => 'changed title',
            'completed' => true
        ]);

        $this->assertDatabaseHas('tasks', [
            'title' => 'changed title',
            'completed' => true
        ]);
    }

    /** @test */
    public function a_task_can_be_marked_as_incompleted()
    {
        $this->signIn();
        
        $project = ProjectFactory::withTasks(1)->create();

        $this->patch($project->tasks->first()->path(), [
            'title' => 'changed title',
            'completed' => true
        ]);

        $this->patch($project->tasks->first()->path(), [
            'title' => 'changed title',
            'completed' => false
        ]);

        $this->assertDatabaseHas('tasks', [
            'title' => 'changed title',
            'completed' => false
        ]);
    }

    /** @test */
    public function a_task_requires_a_title()
    {
        $this->signIn();

        $project = factory(Project::class)->create(['owner_id' => auth()->id()]);

        $start = Carbon::now();
        $end = $start->addHour();

        $task = factory(Task::class)->raw([
                'title' => '',
                'start' => $start,
                'end' => $end
            ]);
    
        $this->post($project->path(). '/tasks', $task)->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_task_requires_a_start()
    {
        $this->signIn();

        $project = factory(Project::class)->create(['owner_id' => auth()->id()]);

        $start = Carbon::now();
        $end = $start->addHour();

        $this->post($project->path(). '/tasks', [
            'title' => 'Task title',
            'start' => '',
            'end' => $end
        ]);

        $this->assertDatabaseMissing('tasks', ['title' => 'Task title']);
    }

    /** @test */
    public function a_task_requires_the_end()
    {
        $this->signIn();

        $project = factory(Project::class)->create(['owner_id' => auth()->id()]);

        $start = Carbon::now();
        $end = $start->addHour();

        $this->post($project->path(). '/tasks', [
            'title' => 'Task title',
            'start' => $start,
            'end' => ''
        ]);

        $this->assertDatabaseMissing('tasks', ['title' => 'Task title']);
    }
}
