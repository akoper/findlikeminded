<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Group;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EventController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of all events.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new event.
     */
    public function create(): View
    {
        $group_id = request()->get('group_id');

        $this->authorize('createEvent', Group::find($group_id));

        return view('events.create', ['group_id' => $group_id]);
    }

    /**
     * Store a newly created event in storage.
     */
    public function store(StoreEventRequest $request): RedirectResponse
    {
        $group_id = request()->get('group_id');

        $this->authorize('createEvent', Group::find($group_id));

        $validated = $request->validated();
        $event = new Event();
        $event->fill($validated);
        $event->creator_id = auth()->user()->id;
        $event->save();

        Auth::user()->events()->attach($event);

        return redirect( route('events.show', ['event' => $event]) );
    }

    /**
     * Display the event.
     */
    public function show(Event $event): View
    {
        /** @var User $user */
        $user = auth()->user();
        $this->authorize('view', $event);

        $inEvent = $user->events()->where('event_id', $event->id)->exists();

        return view('events.show', ['event' => $event, 'inEvent' => $inEvent]);
    }

    /**
     * Show the form for editing the event.
     */
    public function edit(Event $event): View
    {
        Gate::authorize('edit', $event);

        return view('events.edit', ['event' => $event]);
    }

    /**
     * Update the event in storage.
     */
    public function update(UpdateEventRequest $request, Event $event): View
    {
        Gate::authorize('update', $event);

        $validated = $request->validated();
        $event->update($validated);

        return view('events.show', ['event' => $event]);
    }

    /**
     * Remove the event from storage.
     */
    public function destroy(Event $event): RedirectResponse
    {
        Gate::authorize('delete', $event);

        $group = Group::find($event->group_id);
        $event->delete();

        return redirect(route('groups.show', ['group' => $group]));;
    }

    /**
     * A user joins the event.
     */
    public function join(Request $request): RedirectResponse
    {
        $event_id = $request->input('event_id');
        $event = Event::find($event_id);

        $this->authorize('join', $event);

        Auth::user()->events()->attach($event_id);

        return redirect(route('dashboard'));
    }

    /**
     * A user leaves the event.
     */
    public function leave(Request $request): RedirectResponse
    {
        $event_id = $request->input('event_id');
        $event = Event::find($event_id);

        $this->authorize('join', $event);

        Auth::User()->events()->detach($event_id);

        return redirect(route('dashboard'));
    }
}
