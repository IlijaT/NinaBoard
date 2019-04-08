<?php

namespace Tests\Feature;

use App\Project;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function guest_cannot_manage_a_project()
    {
        $this->signIn();

        $project = factory(\App\Project::class)->create();

        auth()->logout();

        $this->post('/projects')->assertRedirect('/login');
        $this->get($project->path())->assertRedirect('/login');
        $this->post('/projects', $project->toArray())->assertRedirect('/login');
    }

    /** @test */
    public function a_user_can_create_a_project()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->sentence,
            'notes' => 'General notes here'
        ];

        $response = $this->post('/projects', $attributes);

        $project = Project::where($attributes)->first();

        $this->assertDatabaseHas('projects', $attributes);

        $this->get($project->path())
            ->assertSee($attributes['title'])
            ->assertSee($attributes['description'])
            ->assertSee($attributes['notes']);
    }

    /** @test */
    public function an_unauthorized_user_cannot_delete_a_project()
    {
        $this->signIn();

        $project = factory(\App\Project::class)->create();
        
        $this->delete($project->path())->assertStatus(403);

        Auth::logout();

        $this->delete($project->path())->assertRedirect('/login');
    }

    /** @test */
    public function a_manager_can_delete_a_project()
    {
        $this->withoutExceptionHandling();

        $user = factory(\App\User::class)->create();

        $permission = factory(\App\Permission::class)->create(['name' => 'delete-project']);
        $role = factory(\App\Role::class)->create(['name' => 'manager']);

        $role->givePermissionTo($permission);

        $user->assignRole('manager');

        $this->be($user);

        $project = factory(\App\Project::class)->create();

        $this->assertDatabaseHas('projects', ['id' => $project->id, 'deleted_at' => null]);
        
        $this->delete($project->path());

        $this->assertNotNull($project->fresh()->deleted_at);
    }

 
    /** @test */
    public function a_user_can_update_a_project()
    {
        $this->withoutExceptionHandling();
        
        $this->signIn();
        
        
        $project = factory(\App\Project::class)->create(['owner_id' => auth()->id()]);


        $this->patch($project->path(), $atributes = [
            'title' => 'changed',
            'description' => 'changed',
            'notes' => 'Changed notes'
            ])
            ->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', $atributes);
    }

    /** @test */
    public function a_user_can_update_a_project_general_notes()
    {
        $this->withoutExceptionHandling();
            
        $this->signIn();
            
            
        $project = factory(\App\Project::class)->create(['owner_id' => auth()->id()]);
    
            
    
        $this->patch($project->path(), $atributes = [
                'notes' => 'Changed notes'
                ]);
    
        $this->assertDatabaseHas('projects', $atributes);
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
    public function an_authenticted_user_can_view_others_project()
    {
        $this->signIn();
        
        $project = factory(\App\Project::class)->create();

        $this->get($project->path())->assertStatus(200);
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
