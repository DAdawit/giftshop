<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    use HttpResponses;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return RoleResource::collection(
            Role::latest()->paginate(20)
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
        $request->validated($request->all());

        $role = Role::create([
            'name'=>$request["name"],
        ]);
        return new RoleResource($role);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        return new RoleResource($role);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $role->update($request->all());
        return new RoleResource($role);    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        return $role->delete();
    }
}
