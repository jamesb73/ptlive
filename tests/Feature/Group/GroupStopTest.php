<?php

namespace Tests\Feature\Group;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GroupStopTest extends TestCase
{
	use DatabaseTransactions;

	/**
     * A basic test example.
     *
     * @return void
     */
    public function test_a_group_user_see_the_group_stops()
    {
        $token = $this->apiSignIn();
    	$group = $this->createAndSyncGroup('private', false);
    	$stop  = factory( \App\GroupStop::class)->create([
    		'group_id' => $group->id
    	]);

    	$response = $this->getJSON("api/groups/{$group->id}/stops?token={$token}")
    	->assertSuccessful()
    	->assertJsonStructure(['data'])
    	->json();

    	$this->assertEquals( count( $response['data']), 1);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_user_cannot_see_the_stops_for_group_they_are_not_a_user_of()
    {
        $token = $this->apiSignIn();
    	$group = factory( \App\Group::class)->create();

    	$this->getJSON("api/groups/{$group->id}/stops?token={$token}")
    	->assertStatus(403);
    }

     /**
     * A basic test example.
     *
     * @return void
     */
    public function test_a_group_user_cannot_create_a_stop()
    {
        $token = $this->apiSignIn();
    	$group = $this->createAndSyncGroup('private', false);

    	$this->postJSON("api/groups/{$group->id}/stops?token={$token}", [
    		'lat' => "51.39358266870915",
    		'lng' => "-0.3036689758300781",
    		'name' => "Corrie Hall",
    		'description' => "Corrie Hall in Surbiton"
    	])
    	->assertStatus( 403);
    }

     /**
     * A basic test example.
     *
     * @return void
     */
    public function test_a_user_cannot_create_a_stop_for_group_they_are_not_a_user_of()
    {
        $token = $this->apiSignIn();
    	$group = factory( \App\Group::class)->create();

    	$this->postJSON("api/groups/{$group->id}/stops?token={$token}", [
    		'lat' => "51.39358266870915",
    		'lng' => "-0.3036689758300781",
    		'name' => "Corrie Hall",
    		'description' => "Corrie Hall in Surbiton"
    	])
    	->assertStatus( 403);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_a_group_admin_can_create_a_stop()
    {
        $token = $this->apiSignIn();
    	$group = $this->createAndSyncGroup('private');

    	$this->postJSON("api/groups/{$group->id}/stops?token={$token}", [
    		'lat' => "51.39358266870915",
    		'lng' => "-0.3036689758300781",
    		'name' => "Corrie Hall",
    		'description' => "Corrie Hall in Surbiton"
    	])
    	->assertSuccessful()
    	->assertJsonStructure(['data']);

    	$this->assertDatabaseHas('groups_stops', [
    		'group_id' => $group->id,
    		'lat' => "51.39358266870915",
    		'lng' => "-0.3036689758300781",
    		'name' => "Corrie Hall",
    		'description' => "Corrie Hall in Surbiton"
    	]);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_a_group_admin_cannot_create_a_stop_without_required_data()
    {
        $token = $this->apiSignIn();
    	$group = $this->createAndSyncGroup('private', true);

    	$this->postJSON("api/groups/{$group->id}/stops?token={$token}", [
    		'lat' => "",
    		'lng' => "-0.3036689758300781",
    		'name' => "Corrie Hall",
    		'description' => "Corrie Hall in Surbiton"
    	])
    	->assertStatus( 422);

    	$this->postJSON("api/groups/{$group->id}/stops?token={$token}", [
    		'lat' => "51.39358266870915",
    		'lng' => "",
    		'name' => "Corrie Hall",
    		'description' => "Corrie Hall in Surbiton"
    	])
    	->assertStatus( 422);

    	$this->postJSON("api/groups/{$group->id}/stops?token={$token}", [
    		'lat' => "51.39358266870915",
    		'lng' => "-0.3036689758300781",
    		'name' => "",
    		'description' => "Corrie Hall in Surbiton"
    	])
    	->assertStatus( 422);

    	$this->postJSON("api/groups/{$group->id}/stops?token={$token}", [
    		'lat' => "51.39358266870915",
    		'lng' => "-0.3036689758300781",
    		'name' => "Corrie Hall",
    		'description' => ""
    	])
    	->assertStatus( 422);
    }
}
