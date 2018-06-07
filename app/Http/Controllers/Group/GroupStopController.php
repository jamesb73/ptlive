<?php

namespace App\Http\Controllers\Group;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Group\GroupStopResource;
use App\Http\Requests\Group\GroupStopStore;
use App\Group;
use App\GroupStop;

class GroupStopController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:see,group');
        $this->middleware('can:update,group', ['only' => ['store', 'update', 'delete']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Group $group)
    {
        return GroupStopResource::collection( $group->stops);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Group $group, GroupStopStore $request)
    {
        return new GroupStopResource(
            $group->stops()->create(
                $request->only(['lat', 'lng', 'name', 'description'])
            )
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group, GroupStop $stop)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Group $group, GroupStop $stop, Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group, GroupStop $stop)
    {
        //
    }
}
