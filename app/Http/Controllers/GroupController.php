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
     * Display all the groups
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new group.
     */
    public function create(): View
    {
        return view('groups.create');
    }

    /**
     * Store a newly created group in storage.
     */
    public function store(StoreGroupRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $group = new Group();
        $group->fill($validated);
        $group->creator_id = auth()->user()->id;
        $group->save();

        $gu = new GroupUser();
        $gu->group_id = $group->id;
        $gu->user_id = auth()->user()->id;
        $gu->role = 'admin';
        $gu->save();

        return redirect( route('group.show', ['group' => $group]) );
    }

    /**
     * Display a group.
     */
    public function show(Group $group): View
    {
        $inGroup = User::find(auth()->user()->id)->groups()->where('group_id', $group->id)->exists();

        return view('groups.show', ['group' => $group, 'inGroup' => $inGroup]);
    }

    /**
     * Show the form for editing a group.
     */
    public function edit(Group $group)
    {
        //
    }

    /**
     * Update a group in storage.
     */
    public function update(UpdateGroupRequest $request, Group $group)
    {
        //
    }

    /**
     * Remove a group from storage.
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
        // TODO: figure out how to handle location in search vs just topic
        $groups = Group::where('name', 'like', '%' . $name . '%')
//            ->where ('location_id', $location_id)
            ->get();

        return view('groups.index', ['groups' => $groups, 'name' => $name]);
    }

    public function join(Request $request): RedirectResponse
    {
        $gu = new GroupUser();
        $gu->group_id = $request->input('group_id');
        $gu->user_id = auth()->user()->id;
        $gu->role = 'member';
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
