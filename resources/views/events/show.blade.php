<x-app-layout>

    <div class="flex mb-5">
        <div class="flex-1  text-2xl font-bold">{{ $event->name }}</div>
        <div class="flex-none sm:w-32">
            @if($inEvent)
                <form action="/events/leave" method="post">
                    @csrf
                    <div class="">
                        <input type="hidden" name="event_id" value="{{ $event->id }}" id="event_id" />
                        <button class="px-3 py-2 text-sm bg-gray-500 hover:bg-gray-300 text-white font-bold lg:mt-0 rounded-lg">Leave Event</button>
                    </div>
                </form>
            @else
                <form action="/events/join" method="post">
                    @csrf
                    <div class="">
                        <input type="hidden" name="event_id" value="{{ $event->id }}" id="event_id" />
                        <button class="px-6 py-2 text-sm bg-green-600 hover:bg-green-400 text-white font-bold lg:mt-0 rounded-lg">Join Event</button>
                    </div>
                </form>
            @endif
        </div>
    </div>

    <div class="mb-5">
        <span class="font-bold">Description:</span> {{ $event->description ?? ''}}
    </div>

    <div class="mb-5">
        <span class="font-bold">Group:</span>
        <a href="{{ url('groups/' . $event->group->id) }}" class="text-blue-600 underline mb-4">{{ $event->group->name }}</a>
    </div>

    <div class="mb-5">
        <span class="font-bold">Location:</span> {{ $event->location ?? '' }}
    </div>

    <div class="mb-5">
        <span class="font-bold">Address:</span> {{ $event->address ?? '' }}
    </div>

    <div class="mb-5">
        <span class="font-bold">Start Date:</span> {{ date('D, F j, Y', strtotime($event->start_date)) }}
    </div>

    <div class="mb-5">
        <span class="font-bold">Start Time:</span> {{ date('g:ia', strtotime($event->start_time)) }}
    </div>

    <div class="mb-5">
        <span class="font-bold">End Date:</span> {{ !empty($event->end_date) ? date('D, F j, Y', strtotime($event->end_date)) : '' }}
    </div>

    <div class="mb-5">
        <span class="font-bold">End Time:</span> {{ !empty($event->end_time) ? date('g:ia', strtotime($event->end_time)) : '' }}
    </div>

    <div class="mb-5">
        <span class="font-bold">Attendees:</span>
        <ul>
            @foreach($event->users as $user)
                <li class="list">{{ $user->name }}</li>
            @endforeach
        </ul>
    </div>

    @if($event->creator_id == Auth::user()->id)
        <div class="font-bold mt-8 mb-4">Event Organizer Tools</div>

        <a href="{{ route('events.edit', $event) }}" class="text-blue-600 underline block mb-4">{{ __('Edit Event') }}</a>

        <form method="POST" action="{{ route('events.destroy', $event) }}">
            @csrf
            @method('delete')
            <button type="submit" class="text-blue-600 underline" :href="route('events.destroy', $event)"
                    onclick="event.preventDefault(); this.closest('form').submit();">
                {{ __('Delete Event') }}
            </button>
        </form>

    {{-- ##### below the code to have a confirm dialog pop-up first if a user goes to delete an event #### --}}
{{--        <a class="text-blue-600 underline block" id="opener" href="#">Delete Event</a>--}}

{{--        <div id="dialog" title="Delete Event">--}}
{{--            <form method="POST" action="{{ route('events.destroy', $event) }}">--}}
{{--                @csrf--}}
{{--                @method('delete')--}}
{{--                <button type="submit" :href="route('events.destroy', $event)" onclick="event.preventDefault(); this.closest('form').submit();">--}}
{{--                    {{ __('Delete') }}--}}
{{--                </button>--}}
{{--            </form>--}}
{{--        </div>--}}

    @endif

    <p></p>

</x-app-layout>
