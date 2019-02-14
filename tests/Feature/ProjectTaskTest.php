<?php

namespace Tests\Feature;

use App\Task;
use App\Project;
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
        $project = factory('App\Project')->create();
        $this->post($project->path() . '/tasks')->assertRedirect('login');
    }
    
    /** @test */
    public function a_project_can_have_tasks()
    {
        $this->signIn();

        $project = factory(Project::class)->create(['owner_id' => auth()->id()]);

        $this->post($project->path(). '/tasks', ['body' => 'Test task']);

        $this->get($project->path())
                ->assertSee('Test task');
    }

    /** @test */
    public function a_task_can_be_updated()
    {
        $project = ProjectFactory::withTasks(1)->create();


        $this->signIn();


        $this->patch($project->tasks->first()->path(), [
            'body' => 'changed body',
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed body',
        ]);
    }

    /** @test */
    public function a_task_can_be_completed()
    {
        $project = ProjectFactory::withTasks(1)->create();


        $this->signIn();


        $this->patch($project->tasks->first()->path(), [
            'body' => 'changed body',
            'completed' => true
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed body',
            'completed' => true
        ]);
    }

    /** @test */
    public function a_task_can_be_marked_as_incompleted()
    {
        $this->withoutExceptionHandling();
        
        $project = ProjectFactory::withTasks(1)->create();


        $this->signIn();


        $this->patch($project->tasks->first()->path(), [
            'body' => 'changed body',
            'completed' => true
        ]);

        $this->patch($project->tasks->first()->path(), [
            'body' => 'changed body',
            'completed' => false
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed body',
            'completed' => false
        ]);
    }

    /** @test */
    public function a_task_requires_a_body()
    {
        $this->signIn();

        $project = factory(Project::class)->create(['owner_id' => auth()->id()]);

        $task = factory(Task::class)->raw([
                'body' => '',
            ]);
    
        $this->post($project->path(). '/tasks', $task)->assertSessionHasErrors('body');
    }
}
