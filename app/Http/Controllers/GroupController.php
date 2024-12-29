<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups = Group::where('owner_id', auth()->user()->id)->get();

//        $groups = Group::whereHas('user', function($q) use($userIds) {
//            $q->whereIn('id', $userIds);
//        })->get();

        return view('groups.index', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('groups.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGroupRequest $request)
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
    public function show(Group $group)
    {
//        dd($group);
        return view('groups.show', ['group' => $group]);
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
    public function destroy(Group $group)
    {
        //
    }

    /**
     * Display a listing of the resource.
     */
    public function search(Request $request)
    {
        $name = $request->input('name');

        $groups = Group::where('title', 'like', "%{$name}%")->get();

        return view('groups.index', compact('groups'));
    }
}
