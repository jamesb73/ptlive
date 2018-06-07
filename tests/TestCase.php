<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use \App\Group;
use JWTAuth;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $user;

    public function apiSignIn()
    {
        $this->user = factory(\App\User::class)->create();

        return JWTAuth::fromUser( $this->user);
    }

    protected function createAndSyncGroup($type, $admin = true)
	{
		$group = factory( Group::class)->states($type)->create();

    	$this->user->groups()->sync([
    		$group->id => [ 'is_admin' => $admin]
    	]);

    	return $group;
	}
}
