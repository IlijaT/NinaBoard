<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    
    /** @test */
    public function a_user_can_create_a_project()
    {
        
        $this->withoutExceptionHandling();
        $this->actingAs(factory(\App\User::class)->create());

        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->sentence
        ];

        $this->post('/projects', $attributes)->assertRedirect('/projects');

        $this->assertDatabaseHas('projects', $attributes);

        $this->get('/projects')->assertSee($attributes['title']);
    }

    /** @test */
    public function a_user_can_view_project() 
    
    {

        $this->withoutExceptionHandling();
        
        $project = factory(\App\Project::class)->create();

        $this->get($project->path())
                ->assertSee($project->title)
                ->assertSee($project->description);
    
    }

    /** @test */
    public function a_project_requires_a_title()
    {
        $this->actingAs(factory(\App\User::class)->create());

        $project = factory(\App\Project::class)->raw([
            'title' => '',
        ]);

        $this->post('/projects',  $project)->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_project_requires_a_description()
    {
        $this->actingAs(factory(\App\User::class)->create());

        $project = factory(\App\Project::class)->raw([
            'description' => '',
        ]);

        $this->post('/projects',  $project)->assertSessionHasErrors('description');
    }

    /** @test */
    public function only_authenticated_users_can_create_a_project()
    {

        
        $project = factory(\App\Project::class)->raw( );

        $this->post('/projects',  $project)->assertRedirect('/login');
    }
}
