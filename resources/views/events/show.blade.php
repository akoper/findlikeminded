<x-app-layout>

    <div class="flex mb-5">
        <div class="flex-1  text-2xl font-bold">{{ $event->name }}</div>
        <div class="flex-none w-32">
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
        <span class="font-bold">Location:</span> {{ $event->location ?? '' }}
    </div>

    <div class="mb-5">
        <span class="font-bold">Address:</span> {{ $event->address ?? '' }}
    </div>

    <div class="mb-5">
        <span class="font-bold">Start Date:</span> {{ date('D, F j, Y', strtotime($event->start_date)) ?? '' }}
    </div>

    <div class="mb-5">
        <span class="font-bold">Start Time:</span> {{ date('g:ia', strtotime($event->start_time)) ?? '' }}
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


</x-app-layout>
