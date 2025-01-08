<x-app-layout>

    @isset($user_name)
        <p class="mb-5 text-2xl font-bold">{{ $user_name }}'s Groups</p>
    @else
        <p class="mb-5 text-2xl font-bold">Search Results for {{ $name }}</p>
    @endif

        <table class="border table-auto border-collapse min-w-full">
            <thead>
                <tr>
                    <th class="border p-2" scope="col">Name</th>
                    <th class="border p-2 hidden sm:table-cell" scope="col">Description</th>
                    <th class="border p-2 hidden sm:table-cell" scope="col">Location</th>
                </tr>
            </thead>
            <tbody>
            @foreach($groups as $group)
                <tr>
                    <td class="border p-2"><a class="text-blue-600 underline" href="/groups/{{ $group->id }}">{{ $group->name }}</a></td>
                    <td class="border p-2 hidden sm:table-cell">{{ $group->description ?? ''}}</td>
                    <td class="border p-2 hidden sm:table-cell">{{ $group->location->city ?? '' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>

</x-app-layout>
