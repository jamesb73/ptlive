<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use \App\Group;
use \App\User;

class RegisterTest extends TestCase
{
	use DatabaseTransactions;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_a_guest_can_register_with_group_code()
    {
    	$group = factory( Group::class)->states('private')->create();

    	$response = $this->postJSON('/api/register', [
    		'name'  => 'Test User',
    		'email' => 'test@ptlive.test',
    		'group_code' => $group->inviteCode->code,
    		'password' => 'secret123',
    		'password_confirmation' => 'secret123'
    	])
    	->assertSuccessful()
    	->assertJsonFragment(['token'])
    	->json();

    	$this->assertDatabaseHas('users', [
    		'id' => $response['data']['user']['id'],
    		'name' => $response['data']['user']['name'],
    		'email' => $response['data']['user']['email'],
    	]);

    	$this->assertDatabaseHas('groups_users', [
    		'user_id' => $response['data']['user']['id'],
    		'group_id' => $group->id,
    		'is_admin' => 0,
    	]);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_a_guest_cannot_register_without_group_code()
    {
    	$response = $this->postJSON('/api/register', [
    		'name'  => 'Test User',
    		'email' => 'test@ptlive.test',
    		'group_code' => '',
    		'password' => 'secret123',
    		'password_confirmation' => 'secret123'
    	])
    	->assertStatus(422);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_a_guest_cannot_register_with_incorrect_group_code()
    {
    	$group = factory( Group::class)->states('private')->create();

    	$response = $this->postJSON('/api/register', [
    		'name'  => 'Test User',
    		'email' => 'test@ptlive.test',
    		'group_code' => 'incorrect',
    		'password' => 'secret123',
    		'password_confirmation' => 'secret123'
    	])
    	->assertStatus(422);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_a_guest_cannot_register_without_matching_password()
    {
    	$group = factory( Group::class)->states('private')->create();

    	$response = $this->postJSON('/api/register', [
    		'name'  => 'Test User',
    		'email' => 'test@ptlive.test',
    		'group_code' => $group->inviteCode->code,
    		'password' => 'secret123',
    		'password_confirmation' => 'secret1'
    	])
    	->assertStatus(422);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_a_guest_cannot_register_without_unique_email()
    {
    	$user  = factory( User::class)->create();
    	$group = factory( Group::class)->states('private')->create();

    	$response = $this->postJSON('/api/register', [
    		'name'  => 'Test User',
    		'email' => $user->email,
    		'group_code' => $group->inviteCode->code,
    		'password' => 'secret123',
    		'password_confirmation' => 'secret123'
    	])
    	->assertStatus(422);
    }
}
