<?php

namespace App\Http\Controllers;

use App\Enum\UserRoleEnum;
use App\Http\Requests\GroupUserRequest;
use App\Models\Group;
use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
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

        Auth::user()->groups()->attach($group, ['role'=>UserRoleEnum::ADMIN]);

        return redirect( route('groups.show', ['group' => $group]) );
    }

    /**
     * Display a group.
     */
    public function show(Group $group): View
    {
        $inGroup = User::find(auth()->user()->id)->groups()->where('group_id', $group->id)->exists();
        $isAdmin = User::find(auth()->user()->id)->groups()
            ->where('group_id', $group->id)
            ->where('role', UserRoleEnum::ADMIN)
            ->exists();

        return view('groups.show', ['group' => $group, 'inGroup' => $inGroup, 'isAdmin' => $isAdmin]);
    }

    /**
     * Show the form for editing a group.
     */
    public function edit(Group $group): View
    {
//        Gate::authorize('edit', $group);

        return view('groups.edit', ['group' => $group]);
    }

    /**
     * Update a group in storage.
     */
    public function update(UpdateGroupRequest $request, Group $group): RedirectResponse
    {
//        Gate::authorize('update', $group);

        $validated = $request->validated();
        $group->update($validated);

        return redirect(route('groups.show', ['group' => $group]));;}

    /**
     * Remove a group from storage.
     */
    public function destroy(Group $group): RedirectResponse
    {
        // cascading delete for groups and related models/records
        $group->events()->delete();
        $group->admins()->sync([]); //many-to-many relationship
        $group->delete();

        return redirect(route('dashboard'));
    }

    /**
     * Receive a search term, query groups table and return groups that match
     */
    public function search(Request $request): View
    {
        $name = $request->input('name');
        // $location_id = $request->input('location_id');
        // TODO: figure out how to handle location in search vs just topic

        if($name === null) {
            $groups = null;
        } else {
            $groups = Group::where('name', 'like', '%' . $name . '%')->get();
            // ->where ('location_id', $location_id)
        }

        return view('groups.index', ['groups' => $groups, 'name' => $name]);
    }

    /**
     * A user joins the group
     */
    public function join(Request $request): RedirectResponse
    {
        $group_id = $request->input('group_id');

        Auth::user()->groups()->attach($group_id, ['role'=>UserRoleEnum::MEMBER]);

        return redirect(route('groups.show', ['group' => $group_id]));;
    }

    /**
     * A user leaves the group
     */
    public function leave(Request $request): RedirectResponse
    {
        $group_id = $request->input('group_id');

        Auth::User()->groups()->detach($group_id);

        return redirect(route('groups.show', ['group' => $group_id]));;
    }

    /**
     * Add a user as an admin to a group
     */
    public function addAdmin(GroupUserRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $group_id = $validated['group_id'];
        $user_id = $validated['user_id'];

        User::find($user_id)->groups()->syncWithoutDetaching([$group_id => ['role'=>UserRoleEnum::ADMIN]]);

        return back();
    }
}
