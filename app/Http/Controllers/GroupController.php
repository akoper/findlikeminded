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
     * Display all the groups a user is in
     */
    public function index(): View
    {   // query from many-to-many relationship tables - think this works 12/29
        $groups = User::find(auth()->user()->id)
            ->groups()
            ->sortBy('start_date')
            ->get();

        $user_name = Auth::user()->name;

        return view('groups.index', ['groups' => $groups, 'user_name' => $user_name]);
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

        return redirect('/dashboard');
    }

    /**
     * Display a group.
     */
    public function show(Group $group): View
    {
        // boolean: is this user in this group? for join or leave button
        $inGroup = User::find(auth()->user()->id)->groups()->where('group_id', $group->id)->exists();

//        // get admins from many-to-many relationship
//        $admins = User::find(auth()->user()->id)->groups()->get();
//
//        // boolean: is this user an admin of this group? to show group admin features
//        $isAdmin = AdminGroup::where([
//            'group_id' => $group->id,
//            'user_id' => auth()->user()->id
//        ])->exists();
        // $isAdmin = AdminGroup::where('user_id', auth()->user()->id)->where('group_id', $group->id)->exists();
        // $exists = User::where('email', 'example@email.com')->where('username', 'johndoe')->exists();

//        dd($isAdmin);
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

    /**
     * this is a little temp method to help with development and testing
     * Display a listing of all the groups.
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
