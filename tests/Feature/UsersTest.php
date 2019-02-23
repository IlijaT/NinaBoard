<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class UsersTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function guest_cannot_see_users()
    {
        $users = factory(\App\User::class, 1)->create();

        $this->get('/users')->assertRedirect('/login');
       
    }

    /** @test */
    public function logged_in_user_cannot_see_users()
    {
        $this->signIn();

        $users = factory(\App\User::class, 3)->create();

        $this->get('/users')->assertRedirect('/projects');
        
    }

    /** @test */
    public function manager_can_see_users()
    {
        $user = factory(\App\User::class)->create();

        $permission = factory(\App\Permission::class)->create(['name' => 'delete-project']);
        $role = factory(\App\Role::class)->create(['name' => 'manager']);

        $role->givePermissionTo($permission);

        $user->assignRole('manager');

        $this->be($user);

        $worker = factory(\App\User::class, 1)->create();

        $this->get('/users')->assertSee($worker->first()->name);
        
    }

    /** @test */
    public function a_user_can_see_his_profile()
    {
        $this->withoutExceptionHandling();
        
        $user = factory(\App\User::class)->create();

        $this->signIn($user);

        $this->get("/users/{$user->id}")->assertSee($user->first()->name);
        
    }

    /** @test */
    public function manager_can_register_new_user()
    {
        $this->withoutExceptionHandling();
        
        $manager = factory(\App\User::class)->create();

        $permission = factory(\App\Permission::class)->create(['name' => 'delete-project']);
        $role = factory(\App\Role::class)->create(['name' => 'manager']);

        $role->givePermissionTo($permission);

        $manager->assignRole('manager');

        $this->be($manager);

        $attributes = [
            'name' => 'John Doe',
            'email' => 'john@gmail.com',
            'email_verified_at' => now(),
            'password'          => 'secret', // secret
            'password_confirmation' => 'secret',
            'remember_token'    => str_random(10),
        ];

        $this->post('/users', $attributes)->assertRedirect('/users');

        $this->assertDatabaseHas('users', ['name' => 'John Doe']);
        
    }
}
