<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use JWTAuth;
use \App\User;

class LoginTest extends TestCase
{
    use DatabaseTransactions;

    public function test_a_user_can_log_in()
    {
        $user = factory( User::class)->create();

        $this->postJson('/api/login', [
        	'email' => $user->email,
        	'password' => 'secret'
        ])
        ->assertSuccessful()
        ->assertJsonFragment(['token']);
    }

    public function test_a_user_cannot_login_with_incorrect_email_or_password()
    {
        $user = factory( User::class)->create();

        $this->postJson('/api/login', [
        	'email' => 'wrongEmail@ptlive.com',
        	'password' => 'secret'
        ])
        ->assertStatus(401);

        $this->postJson('/api/login', [
        	'email' => $user->email,
        	'password' => 'wrongpassword'
        ])
        ->assertStatus(401);
    }

    public function test_a_user_cannot_login_without_providing_email_or_password()
    {
        $user = factory( User::class)->create();

        $this->postJson('/api/login', [
        	'email' => '',
        	'password' => 'secret'
        ])
        ->assertStatus(422);

        $this->postJson('/api/login', [
        	'email' => $user->email,
        	'password' => ''
        ])
        ->assertStatus(422);
    }

    public function test_a_user_can_logout()
    {
        $user  = factory( User::class)->create();
        $token = JWTAuth::fromUser( $user);

        $this->postJson("/api/logout?token={$token}")
        ->assertSuccessful();
    }
}
