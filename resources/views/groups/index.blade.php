<x-app-layout>

    <h3 class="my-3 font-bold">Groups</h3>

        <table class="border table-auto border-collapse min-w-full">
            <thead>
                <tr>
                    <th class="border p-2" scope="col">Title</th>
                    <th class="border p-2" scope="col">Description</th>
                    <th class="border p-2 w-28" scope="col">Location</th>
                </tr>
            </thead>
            <tbody>
            @foreach($groups as $group)
                <tr>
                    <td class="border p-2">{{ $group->title }}</td>
                    <td class="border p-2">{{ $group->description ?? ''}}</td>
                    <td class="border p-2">{{ $group->location ?? '' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>

</x-app-layout>