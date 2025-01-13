<x-app-layout>

    <p class="mb-5 text-2xl font-bold">{{ Auth::user()->name }}'s Dashboard</p>

    <p class="mb-4 mt-10 text-xl font-bold">Your Upcoming Events</p>
    <table class="border table-auto border-collapse min-w-full">
        <thead>
        <tr>
            <th class="border p-2" scope="col">Name</th>
            <th class="border p-2 hidden sm:table-cell" scope="col">Date</th>
            <th class="border p-2 hidden sm:table-cell" scope="col">Group</th>
            <th class="border p-2 hidden sm:table-cell" scope="col">Location</th>
        </tr>
        </thead>
        <tbody>
        @if ($user->events->count() === 0)
            <tr>
                <td class="border p-2 italic text-center" colspan="3">no events</td>
            </tr>
        @else
            @foreach($user->events as $event)
                <tr>
                    <td class="border p-2"><a class="text-blue-600 underline" href="/events/{{ $event->id }}">{{ $event->name }}</a></td>
                    <td class="border p-2 hidden sm:table-cell">{{ $event->start_date->format('D, M j, Y') ?? ''}}</td>
                    <td class="border p-2 hidden sm:table-cell"><a class="text-blue-600 underline" href="/groups/{{ $event->group->id }}">{{ $event->group->name }}</a></td>
                    <td class="border p-2 hidden sm:table-cell">{{ $event->location ?? '' }}</td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>

    <p class="mb-4 mt-10 text-xl font-bold">Your Groups</p>
    <table class="border table-auto border-collapse min-w-full">
        <thead>
        <tr>
            <th class="border p-2" scope="col">Name</th>
            <th class="border p-2 hidden sm:table-cell" scope="col">Description</th>
            <th class="border p-2 hidden sm:table-cell" scope="col">Location</th>
        </tr>
        </thead>
        <tbody>
        @if ($user->groups->count() === 0)
            <tr>
                <td class="border p-2 italic text-center" colspan="3">no groups</td>
            </tr>
        @else
            @foreach($user->groups as $group)
                <tr>
                    <td class="border p-2"><a class="text-blue-600 underline" href="/groups/{{ $group->id }}">{{ $group->name }}</a></td>
                    <td class="border p-2 hidden sm:table-cell">{{ $group->description ?? ''}}</td>
                    <td class="border p-2 hidden sm:table-cell">{{ $group->location->city ?? '' }}</td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>

    </div>

</x-app-layout>
