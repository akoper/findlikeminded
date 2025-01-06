<x-app-layout>

    <div class="flex mb-5">
        <div class="flex-1  text-2xl font-bold">{{ $group->name }}</div>
        <div class="flex-none w-32">
            @if($inGroup)
                <form action="/groups/leave" method="post">
                    @csrf
                    <div class="">
                        <input type="hidden" name="group_id" value="{{ $group->id }}" id="group_id" />
                        <button class="px-3 py-2 text-sm bg-gray-500 hover:bg-gray-300 text-white font-bold lg:mt-0 rounded-lg">Leave Group</button>
                    </div>
                </form>
            @else
                <form action="/groups/join" method="post">
                    @csrf
                    <div class="">
                        <input type="hidden" name="group_id" value="{{ $group->id }}" id="group_id" />
                        <button class="px-6 py-2 text-sm bg-green-600 hover:bg-green-400 text-white font-bold lg:mt-0 rounded-lg">Join Group</button>
                    </div>
                </form>
            @endif
        </div>
    </div>

    <div class="mb-5">
        <span class="font-bold">Description:</span> {{ $group->description ?? ''}}
    </div>

    <div class="mb-5">
        <span class="font-bold">Location:</span> {{ $group->location->CITY ?? '' }}
    </div>

    <div class="mb-5">
        <span class="font-bold">Members:</span>
        <ul>
            @foreach($group->users as $user)
                <li>{{ $user->name }}</li>
            @endforeach
        </ul>
    </div>

    <div class="mb-5">
        <span class="font-bold">Events:</span>
        <ul>
            @foreach($group->events as $event)
                <li><a class="text-blue-600 underline" href="/events/{{ $event->id }}">{{ $event->name }}</a></li>
            @endforeach
        </ul>
    </div>

    <a href="{{ route('events.create', ['group_id' => $group->id]) }}" class="py-2 w-40 inline-block text-white bg-orange-600 hover:bg-orange-300 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm   focus:outline-none text-center">Create Event</a>

</x-app-layout>
