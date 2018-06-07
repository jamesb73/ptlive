<?php

namespace App\Policies;

use App\User;
use App\Group;
use Illuminate\Auth\Access\HandlesAuthorization;

class GroupPolicy
{
    use HandlesAuthorization;

    public function update( User $user, Group $group)
    {
        return $group->users()->wherePivot( 'is_admin', 1)->find( $user->id);
    }

    public function see( User $user, Group $group)
    {
        return $user->groups()->find( $group->id);
    }
}
