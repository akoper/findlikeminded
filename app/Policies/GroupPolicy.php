<?php

namespace App\Policies;

use App\Models\Group;
use App\Models\User;
use App\Models\GroupUser;
use Illuminate\Auth\Access\Response;


class GroupPolicy
{
    /**
     * Determine whether the user can view any groups.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the group.
     */
    public function view(User $user, Group $group): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create groups.
     */
    public function create(User $user): bool
    {
        return false;
    }

    public function createEvent(User $user, Group $group): Response
    {
        return GroupUser::where('user_id', $user->id)
            ->where('group_id', $group->id)
            ->exists()
            ? Response::allow()
            : Response::deny("You are not a member of the group so you can't create an event");
    }

    /**
     * Determine whether the user can see the form to edit group
     */
    public function edit(User $user, Group $group): bool
    {
        return $user->id === $group->admins->id;
    }

    /**
     * Determine whether the user can update the group.
     */
    public function update(User $user, Group $group): bool
    {
        return $user->id === $group->admins()->id;
    }

    /**
     * Determine whether the user can delete the group.
     */
    public function delete(User $user, Group $group): bool
    {
        return $user->id === $group->admins->id;
    }

    /**
     * Determine whether the user can restore the group.
     */
    public function restore(User $user, Group $group): bool
    {
        return $user->id === $group->admins->id;
    }

    /**
     * Determine whether the user can permanently delete the group.
     */
    public function forceDelete(User $user, Group $group): bool
    {
        return $user->id === $group->admins->id;
    }
}
