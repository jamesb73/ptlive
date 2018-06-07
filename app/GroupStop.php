<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupStop extends Model
{
    protected $table = 'groups_stops';
    protected $guarded = [];

    public function group()
    {
    	return $this->belongsTo( Group::class);
    }
}
