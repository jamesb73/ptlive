<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupInviteCode extends Model
{
    protected $table = 'groups_invite_codes';
    protected $guarded = [];

    public function group()
    {
    	return $this->belongsTo( Group::class);
    }

    public static function randomCode()
    {
        $str = "";
        $characters = array_merge(range('A','Z'), range('0','9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < 8; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $str;
    }
}
