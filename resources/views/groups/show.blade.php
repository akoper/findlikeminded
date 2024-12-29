<x-app-layout>

    <p class="mb-5 text-2xl font-bold">{{ $group->title }}</p>

    <div class="mb-5">
        <span class="font-bold">Description:</span> {{ $group->description ?? ''}}
    </div>

    <div class="mb-5">
        <span class="font-bold">Location:</span> {{ $group->location ?? '' }}
    </div>

    <div class="mb-5">
        <span class="font-bold">Members:</span>
        <ul>
{{--            @foreach($group->members as $member)--}}
{{--                <li>{{ $member->name }}</li>--}}
{{--            @endforeach--}}
        </ul>
    </div>

    <div class="mb-5">
        <span class="font-bold">Events:</span>
        <ul>
{{--            @foreach($group->events as $event)--}}
{{--                <li><a class="text-blue-600 underline" href="/events/{{ $event->id }}">{{ $event->title }}</a></li>--}}
{{--            @endforeach--}}
        </ul>
    </div>

</x-app-layout>
