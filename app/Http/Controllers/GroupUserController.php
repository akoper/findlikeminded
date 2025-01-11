<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupUserRequest;
use App\Http\Requests\StoreGroupRequest;
use App\Models\GroupUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class GroupUserController extends Controller
{
    /**
     * Add a user as an admin to a group
     */
    public function addAdmin(GroupUserRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $gu = GroupUser::updateOrCreate([
            'group_id' => $validated['group_id'],
            'user_id' => $validated['user_id'],
            'role' => 'admin'
        ]);

        return back();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Add a user as an admin to a group -
     */
    public function store(StoreGroupRequest $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
