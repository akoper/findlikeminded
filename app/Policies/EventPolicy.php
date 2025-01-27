<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\EventUser;
use App\Models\GroupUser;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EventPolicy
{
    /**
     * Determine whether the user can view any events.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the event.
     */
    public function view(User $user, Event $event): Response
    {
        return GroupUser::where('user_id', $user->id)
                ->where('group_id', $event->group_id)
                ->exists()
            ? Response::allow()
            : Response::deny("You are not a member of the group {$event->group->name} so you can't see their event");
    }

    /**
     * Determine whether the user can create events.
     */
    public function create(User $user): bool
    {
        return false;
    }


    /**
     * Determine whether the user can see the form to edit event
     */
    public function edit(User $user, Event $event): Response
    {
        return $user->id === $event->creator_id
            ? Response::allow()
            : Response::deny("You are not the creator of this event so you can't edit this event");
    }

    /**
     * Determine whether the user can update the event.
     */
    public function update(User $user, Event $event): Response
    {
        return $user->id === $event->creator_id
            ? Response::allow()
            : Response::deny("You are not the creator of this event so you can't edit this event");
    }

    /**
     * Determine whether the user can delete the event.
     */
    public function delete(User $user, Event $event): Response
    {
        return $user->id === $event->creator_id
            ? Response::allow()
            : Response::deny("You are not the creator of this event so you can't delete this event");
    }

    /**
     * Determine whether the user can restore the event.
     */
    public function restore(User $user, Event $event): bool
    {
        return $user->id === $event->creator_id;
    }

    /**
     * Determine whether the user can permanently delete the event.
     */
    public function forceDelete(User $user, Event $event): bool
    {
        return $user->id === $event->creator_id;
    }

    /**
     * Determine whether the user can join this event.
     */
    public function join(User $user, Event $event): Response
    {
        return GroupUser::where('user_id', $user->id)
            ->where('group_id', $event->group_id)
            ->exists()
            ? Response::allow()
            : Response::deny("You are not a member of the group {$event->group->name} so you can't join this event");
    }

    /**
     * Determine whether the user can leave this event.
     */
    public function leave(User $user, Event $event): Response
    {
        return GroupUser::where('user_id', $user->id)
            ->where('group_id', $event->group_id)
            ->exists()
            ? Response::allow()
            : Response::deny("You are not a member of this event so you can't leave this event");
    }
}
