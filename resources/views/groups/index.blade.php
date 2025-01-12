<x-app-layout>

        <p class="mb-5 text-2xl font-bold">Search Results for {{ $name }}</p>

        <table class="border table-auto border-collapse min-w-full">
            <thead>
                <tr>
                    <th class="border p-2" scope="col">Name</th>
                    <th class="border p-2 hidden sm:table-cell" scope="col">Description</th>
                    <th class="border p-2 hidden sm:table-cell" scope="col">Location</th>
                </tr>
            </thead>
            <tbody>
            @if (empty($groups))
                <tr>
                    <td class="border p-2"><i>no groups</i></td>
                    <td class="border p-2 hidden sm:table-cell"></td>
                    <td class="border p-2 hidden sm:table-cell"></td>
                </tr>
            @else
                @foreach($groups as $group)
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
