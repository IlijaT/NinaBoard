<?php

namespace Tests\Feature;

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

        $this->actingAs(factory(\App\User::class)->create());

        $this->get('/projects/create')->assertStatus(200);

        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->sentence
        ];

        $this->post('/projects', $attributes)->assertRedirect('/projects');

        $this->assertDatabaseHas('projects', $attributes);

        $this->get('/projects')->assertSee($attributes['title']);
    }

    /** @test */
    public function a_user_can_view_their_project()
    {
        $this->withoutExceptionHandling();
        
        $this->be($user = factory('App\User')->create());
        
        $project = factory(\App\Project::class)->create(['owner_id' => $user->id]);

        $this->get($project->path())
                ->assertSee($project->title)
                ->assertSee($project->description);
    }

        /** @test */
        public function an_authenticted_user_cannot_view_others_project() 
        
        {
        
            $this->be($user = factory('App\User')->create());
            
            $project = factory(\App\Project::class)->create();

            $this->get($project->path())->assertStatus(403);

        
        }

    /** @test */
    public function a_project_requires_a_title()
    {
        $this->actingAs(factory(\App\User::class)->create());

        $project = factory(\App\Project::class)->raw([
            'title' => '',
        ]);

        $this->post('/projects', $project)->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_project_requires_a_description()
    {
        $this->actingAs(factory(\App\User::class)->create());

        $project = factory(\App\Project::class)->raw([
            'description' => '',
        ]);

        $this->post('/projects', $project)->assertSessionHasErrors('description');
    }



   
}
