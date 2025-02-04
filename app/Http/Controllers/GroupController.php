<?php

namespace App\Http\Controllers;

use App\Enum\UserRoleEnum;
use App\Http\Requests\GroupUserRequest;
use App\Models\Group;
use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Models\GroupUser;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class GroupController extends Controller implements HasMiddleware
{
    /**
     * Apply subscribe middleware to Group join and store methods (not routes
     * in this case because resource controller makes it hard to single out create route).
     * Users can join two groups for free. We check the Group join and create methods
     * to see if they've hit the free limit and they're not a subscriber and now need
     * provide their payment info and become a Stripe customer with a Stripe subscription
     * to join more groups.
     * There is a bunch of duplicative between the create and join flows
     * but because the routes Stripe Checkout needs to receive and send the user on to
     * after they successfully fill out its secure payment form is different for these two things,
     * the request object doesn't exist after going through Stripe Checkout, the group data is
     * received via POST and there are different values, this works
     */
    public static function middleware(): array
    {
        return [
            new Middleware('subscribeCreateGroup', only: ['store']),
            new Middleware('subscribeJoinGroup', only: ['join'])
        ];
    }

    /**
     * Display the page to search groups (mobile only)
     */
    public function searchForm()
    {
        return view('groups.search-form');
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

        $noOfGroups = GroupUser::where('user_id', auth()->user()->id)->count();

        // increase quality of subscription if more than two free and subscriber
        $subscription = Auth::user()->subscription(config('services.stripe.prod_id'));
        if ($subscription && $noOfGroups >= Group::NUMBER_FREE_GROUPS) {
            $subscription->updateQuantity($subscription->quantity + 1);
        }

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
        Gate::authorize('edit', $group);

        return view('groups.edit', ['group' => $group]);
    }

    /**
     * Update a group in storage.
     */
    public function update(UpdateGroupRequest $request, Group $group): RedirectResponse
    {
        Gate::authorize('update', $group);

        $validated = $request->validated();
        $group->update($validated);

        return redirect(route('groups.show', ['group' => $group]));
    }

    /**
     * Remove a group from storage.
     */
    public function destroy(Group $group): RedirectResponse
    {
        // cascading delete for group and related models/records
        $group->events()->delete();
        $group->admins()->sync([]); // delete many-to-many relationship
        $group->delete();

        return redirect(route('dashboard'));
    }

    /**
     * Receive a search term, query groups table and return groups that match
     */
    public function search(Request $request): View
    {
        $name = $request->get('name');

        // location search input on top nav and welcome page have different id's
        // bc jQuery autocompletes would interfere with each other on one page
        if($request->get('location_id')) {
            $location_id = $request->get('location_id');
            $location_name = $request->get('location_name');
        } else {
            $location_id = $request->get('location_id_navigation');
            $location_name = $request->get('location_name_navigation');
        }

        // query builder if search by topic and/or location
        $groupQuery = Group::query();

        $groupQuery->when($name, function($query) use ($name) {
            $query->where('name','like','%'.$name.'%');
        });

        $groupQuery->when($location_id, function($query) use ($location_id) {
            $query->where('location_id', $location_id);
        });

        if($name == null && $location_id == null) {
            $groups = null;
        } else {
            $groups = $groupQuery->get();
        }

        // return page title if search by topic and/or location
        if(($name) && (!$location_name)) {
            $search_terms = $name;
        } elseif ((!$name) && ($location_name)) {
            $search_terms = $location_name;
        } elseif ((!$name) && (!$location_name)) {
            $search_terms = 'no search terms';
        } else {
            $search_terms = $name . ' and ' . $location_name;
        }

        return view('groups.index', ['groups' => $groups, 'search_terms' => $search_terms]);
    }

    /**
     * Add a user to a group and increment subscription quantity if they are in > free amount
     */
    public function join(Request $request): RedirectResponse
    {
        $group_id = $request->input('group_id');

        Auth::user()->groups()->attach($group_id, ['role' => UserRoleEnum::MEMBER]);

        $noOfGroups = GroupUser::where('user_id', auth()->user()->id)->count();

        // increase quality of subscription if more than two free and subscriber
        $subscription = Auth::user()->subscription(config('services.stripe.prod_id'));
        if ($subscription && $noOfGroups >= Group::NUMBER_FREE_GROUPS) {
            $subscription->updateQuantity($subscription->quantity + 1);
        }

        return redirect(route('groups.show', ['group' => $group_id]));
    }

    /**
     * A user leaves a group
     */
    public function leave(Request $request): RedirectResponse
    {
        $group_id = $request->get('group_id');

        Auth::User()->groups()->detach($group_id);

        $subscription = Auth::user()->subscription(config('services.stripe.prod_id'));
        if ($subscription->quantity > 0) {
            $subscription->updateQuantity($subscription->quantity - 1);
        }

        return redirect(route('dashboard'));
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
