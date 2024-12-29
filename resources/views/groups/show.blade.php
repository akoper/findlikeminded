<x-app-layout>

    <div class="flex mb-5">
        <div class="flex-1  text-2xl font-bold">{{ $group->name }}</div>
        <div class="flex-none w-32">
            <form action="/groups/join" method="post">
                @csrf
                <div class="">
                    <input type="hidden" name="group_id" value="{{ $group->id }}" id="group_id" />

                    <button class="px-6 py-2 text-sm bg-green-600 hover:bg-green-400 text-white font-bold lg:mt-0 rounded-lg">Join Group</button>
                </div>
            </form>
        </div>
    </div>

    <div class="mb-5">
        <span class="font-bold">Description:</span> {{ $group->description ?? ''}}
    </div>

    <div class="mb-5">
        <span class="font-bold">Location:</span> {{ $group->location ?? '' }}
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
{{--            @foreach($group->events as $event)--}}
{{--                <li><a class="text-blue-600 underline" href="/events/{{ $event->id }}">{{ $event->name }}</a></li>--}}
{{--            @endforeach--}}
        </ul>
    </div>

</x-app-layout>
