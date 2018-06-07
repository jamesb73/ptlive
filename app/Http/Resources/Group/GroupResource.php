<?php

namespace App\Http\Resources\Group;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User\UserResource;

class GroupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'is_admin' => $this->whenLoaded('pivot', function(){
                return $this->pivot->is_admin;
            }),
            'users' => UserResource::collection( $this->whenLoaded('users')),
            'stops' => GroupStopResource::collection( $this->whenLoaded('stops'))
        ];
    }
}
