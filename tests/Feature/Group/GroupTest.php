<?php

namespace Tests\Feature\Group;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Group;

class GroupTest extends TestCase
{
	use DatabaseTransactions;

    public function test_a_user_can_see_groups_they_are_a_user_on()
    {
    	$token = $this->apiSignIn();
    	$group = $this->createAndSyncGroup('private');

		$this->getJson("/api/groups?token={$token}")
		->assertSuccessful()
		->assertJsonStructure(['data']);
    }

    public function test_a_user_can_see_single_group_they_are_a_user_on()
    {
    	$token = $this->apiSignIn();
    	$group = $group = $this->createAndSyncGroup('private');

		$this->getJson("/api/groups/{$group->id}?token={$token}")
		->assertSuccessful()
		->assertJsonStructure(['data']);
    }

    public function test_a_user_cannnot_see_single_group_they_are_not_a_user_on()
    {
    	$token = $this->apiSignIn();
    	$group = factory( Group::class)->states('private')->create();

		$this->getJson("/api/groups/{$group->id}?token={$token}")
		->assertStatus(403);
    }

    public function test_a_group_admin_user_can_update_group_name()
    {
    	$token = $this->apiSignIn();
    	$group = $group = $this->createAndSyncGroup('private');

		$this->putJson("/api/groups/{$group->id}?token={$token}", ['name' => 'test update'])
		->assertSuccessful()
		->assertJsonStructure(['data']);

		$this->assertDatabaseHas('groups', [
			'id' => $group->id,
			'name' => 'test update'
		]);
    }

    public function test_a_group_admin_user_cannot_update_group_without_name_value()
    {
    	$token = $this->apiSignIn();
    	$group = $group = $this->createAndSyncGroup('private');

		$this->putJson("/api/groups/{$group->id}?token={$token}")
		->assertStatus(422);
    }

    public function test_a_group_non_admin_user_cannot_update_group_name()
    {
    	$token = $this->apiSignIn();
    	$group = $this->createAndSyncGroup('private', false);

		$this->putJson("/api/groups/{$group->id}?token={$token}", ['name' => 'test update'])
		->assertStatus(403);
    }
}
