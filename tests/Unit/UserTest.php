<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function a_user_has_projects()
    {
        $user = factory('App\User')->create();

        $this->assertInstanceOf(Collection::class, $user->projects);
    }

    /** @test */
    public function a_user_can_determine_their_avatar_path()
    {
        $user = factory('App\User')->create();

        $this->assertEquals('avatars/default_avatar.jpg', $user->avatar());

        $user->avatar_path =  'avatars/me.jpg';

        $this->assertEquals('avatars/me.jpg', $user->avatar());
    }
}
