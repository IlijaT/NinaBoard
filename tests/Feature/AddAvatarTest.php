<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;

class AddAvatarTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_authenticated_users_can_add_avatar()
    {
        $this->json('POST', '/users/1/avatar')->assertStatus(401);
    }

    /** @test */
    public function a_valid_avatar_must_be_provided()
    {
        $this->signIn();

        $this->json(
            'POST',
            '/users/'. auth()->id() .'/avatar',
            ['avatar' => 'not-an-image']
        )->assertStatus(422);
    }

    /** @test */
    public function an_user_may_add_an_avatar_to_their_profile()
    {
        $this->signIn();

        Storage::fake('public');

        $file = UploadedFile::fake()->image('avatar.jpg');

        $this->json(
            'POST',
            '/users/'. auth()->id() .'/avatar',
            ['avatar' => $file]
        );

        Storage::disk('public')->assertExists('avatars/'.$file->hashName());
    }
}
