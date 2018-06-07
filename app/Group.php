<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';
    protected $guarded = [];

    public function users()
    {
    	return $this->belongsToMany( User::class, 'groups_users')->withPivot('is_admin');
    }

    public function stops()
    {
        return $this->hasMany( GroupStop::class);
    }

    public function inviteCode()
    {
    	return $this->hasOne( GroupInviteCode::class)->withDefault( function() {
            return GroupInviteCode::create([
                'group_id' => $this->id,
                'code' => GroupInviteCode::randomCode()
            ]);
        });
    }
}
