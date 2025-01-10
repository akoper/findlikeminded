<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Models\GroupUser;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {   // query from many-to-many relationship tables - think this works 12/29
        $groups = User::find(auth()->user()->id)->groups()->get();

        $user_name = Auth::user()->name;

        return view('groups.index', ['groups' => $groups, 'user_name' => $user_name]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('groups.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGroupRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $group = new Group();
        $group->fill($validated);
        $group->owner_id = auth()->user()->id;
        $group->save();

        return redirect('/dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group): View
    {
        // boolean: is this user in this group?
        $inGroup = User::find(auth()->user()->id)->groups()->where('group_id', $group->id)->exists();

        return view('groups.show', ['group' => $group, 'inGroup' => $inGroup]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $group)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGroupRequest $request, Group $group)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group): RedirectResponse
    {
        $group->delete();
        return back();
    }

    /**
     * Receive a search term, query groups table and return groups that match
     */
    public function search(Request $request): View
    {
        $name = $request->input('name');
//        $location_id = $request->input('location_id');
        // TODO: figure out how to handle location in search vs just name
        $groups = Group::where('name', 'like', '%' . $name . '%')
//            ->where ('location_id', $location_id)
            ->get();

        return view('groups.index', ['groups' => $groups, 'name' => $name]);
    }

    /**
     * this is a little temp method to help with development and testing
     * Display a listing of the resource.
     */
    public function all(): View
    {
        $groups = Group::all();

        return view('groups.index', compact('groups'));
    }

    public function join(Request $request): RedirectResponse
    {
        $gu = new GroupUser();
        $gu->group_id = $request->input('group_id');
        $gu->user_id = auth()->user()->id;
        $gu->save();

        return redirect('/dashboard');
    }

    public function leave(Request $request): RedirectResponse
    {
        $group_id = $request->input('group_id');
        $user_id = auth()->user()->id;

        $deleted = GroupUser::where('group_id', $group_id)->where('user_id', $user_id)->delete();

        return redirect('/dashboard');
    }

}
