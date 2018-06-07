<?php

namespace App\Http\Controllers\Group;

use Illuminate\Http\Request;
use App\Http\Resources\Group\GroupResource;
use App\Http\Requests\Group\GroupUpdate;
use App\Http\Controllers\Controller;
use App\Group;

class GroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:see,group', ['only' => ['show']]);
        $this->middleware('can:update,group', ['only' => ['update', 'destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return GroupResource::collection(
            auth()->user()->groups->load( $this->loadRelationships())
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request)
    {
        // create a group & invite code
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show( Group $group)
    {
        return new GroupResource(
            $group->load( $this->loadRelationships())
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update( GroupUpdate $request, Group $group)
    {
        $group->update(
            $request->only('name')
        );

        return new GroupResource(
            $group->load( $this->loadRelationships())
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( Group $group)
    {
        //
    }

    public function loadRelationships()
    {
        return ['users', 'stops'];
    }
}
