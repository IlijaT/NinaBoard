<?php

namespace Tests\Feature;

use App\Project;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function guest_cannot_manage_a_project()
    {
        $project = factory(\App\Project::class)->create();

        $this->post('/projects')->assertRedirect('/login');
        $this->get('/projects/create')->assertRedirect('/login');
        $this->get($project->path())->assertRedirect('/login');
        $this->post('/projects', $project->toArray())->assertRedirect('/login');
    }

    /** @test */
    public function a_user_can_create_a_project()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $this->get('/projects/create')->assertStatus(200);

        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->sentence,
            'notes' => 'General notes here'
        ];

        $response = $this->post('/projects', $attributes);

        $project = Project::where($attributes)->first();

        $response->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', $attributes);

        $this->get($project->path())
            ->assertSee($attributes['title'])
            ->assertSee($attributes['description'])
            ->assertSee($attributes['notes']);
    }

    /** @test */
    public function a_user_can_update_a_project() 
    
    {
        $this->withoutExceptionHandling();
        
        $this->signIn();
        
        
        $project = factory(\App\Project::class)->create(['owner_id' => auth()->id()]);

        $this->patch($project->path(), ['notes' => 'Changed notes'])
            ->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', ['notes' => 'Changed notes']);
    
    }

    /** @test */
    public function a_user_can_view_their_project()
    {
        $this->withoutExceptionHandling();
        
        $this->signIn();
        
        
        $project = factory(\App\Project::class)->create(['owner_id' => auth()->id()]);

        $this->get($project->path())
                ->assertSee($project->title)
                ->assertSee($project->description);
    }

    /** @test */
    public function an_authenticted_user_cannot_view_others_project()
    {
        $this->signIn();
        
        $project = factory(\App\Project::class)->create();

        $this->get($project->path())->assertStatus(403);
    }

    /** @test */
    public function a_project_requires_a_title()
    {
        $this->signIn();

        $project = factory(\App\Project::class)->raw([
            'title' => '',
        ]);

        $this->post('/projects', $project)->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_project_requires_a_description()
    {
        $this->signIn();

        $project = factory(\App\Project::class)->raw([
            'description' => '',
        ]);

        $this->post('/projects', $project)->assertSessionHasErrors('description');
    }
}
