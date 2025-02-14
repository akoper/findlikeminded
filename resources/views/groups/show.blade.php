<x-app-layout>

    <div class="flex mb-5">
        <div class="flex-1 text-2xl font-bold">{{ $group->name }}</div>
        <div class="flex-none sm:w-32">
            @if($inGroup)
                <form action="/groups/leave" method="post">
                    @csrf
                    <div class="">
                        <input type="hidden" name="group_id" value="{{ $group->id }}" id="group_id" />
                        <button class="px-3 py-2 text-sm bg-gray-500 hover:bg-gray-800 text-white font-bold lg:mt-0 rounded-lg">Leave Group</button>
                    </div>
                </form>
            @else
                <form action="/groups/join" method="post">
                    @csrf
                    <div class="">
                        <input type="hidden" name="group_id" value="{{ $group->id }}" id="group_id" />
                        <button class="px-6 py-2 text-sm bg-green-700 hover:bg-green-800 text-white font-bold lg:mt-0 rounded-lg">Join Group</button>
                    </div>
                </form>
            @endif
        </div>
    </div>

    <div class="mb-5">
        <span class="font-bold">Description:</span> {{ $group->description ?? ''}}
    </div>

    <div class="mb-5">
        <span class="font-bold">Location:</span> {{ $group->location->city ?? '' }}
    </div>

    <div class="mb-5">
        <span class="font-bold">Members:</span>
        <ul>
            @foreach($group->users as $user)
                <li class="list">{{ $user->name }}</li>
            @endforeach
        </ul>
    </div>

    <div class="mb-5">
        <span class="font-bold">Upcoming Events:</span>
        <ul>
            @foreach($group->events as $event)
                <li class="list"><a class="text-blue-600 underline" href="/events/{{ $event->id }}">{{ $event->name }}</a>
                    {{ $event->start_date->format('D, M j, Y') }} at {{ $event->start_time->format('g:ia') }}
                </li>
            @endforeach
        </ul>
    </div>

    <a href="{{ route('events.create', ['group_id' => $group->id]) }}" class="py-2 my-2 w-40 inline-block text-white bg-orange-500 hover:bg-orange-600 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm   focus:outline-none text-center">Create Event</a>

    <div class="my-5">
        <span class="font-bold">Administrator(s):</span>
        <ul>
            @foreach($group->admins as $admin)
                <li class="list">{{ $admin->name }}</li>
            @endforeach
        </ul>
    </div>

    <a class="text-blue-600 underline my-2" href="/email-form?type=group-admin&group_id={{ $group->id }}">Send email to group admin(s)</a>

@if($isAdmin == true)
    <div class="font-bold mt-8">Group Administrator Tools</div>

        <a class="text-blue-600 underline my-6 inline-block" href="/email-form?type=admin-group&group_id={{ $group->id }}">Send email to group members</a>

        <form action="/groups/add-admin" method="post">
            @csrf
            <div class="">
                <div class="mb-2">
                    <label class="block text-gray-700 text-sm font-bold mb-2 dark:text-gray-100" for="location">Search for and add a user as an administrator to group (there can be many) *</label>
                    <input type="hidden" name="group_id" id="group_id" value="{{ $group->id }}">
                    <input type="hidden" name="user_id" id="user_id" value="{{ old('user_id') }}">
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        name="user_name" id="user_name" type="text" autocomplete="off" value="{{ old('user_name') }}">
                    @error('user_name')
                    <div class="alert text-red-600 alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="px-6 py-2 lg:mt-0 text-sm bg-blue-700 hover:bg-blue-800 text-white font-bold rounded-lg">Add Co-Admin</button>
            </div>
        </form>

        <a href="{{ route('groups.edit', $group) }}" class="py-2 my-10 w-36 inline-block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm focus:outline-none text-center">Edit Group</a>

        <form method="POST" action="{{ route('groups.destroy', $group) }}">
            @csrf
            @method('delete')
            <button type="submit" class="text-blue-600 underline my-4" :href="route('groups.destroy', $event)"
                    onclick="event.preventDefault(); this.closest('form').submit();">
                {{ __('Delete Group') }}
            </button>
        </form>
    @endif

</x-app-layout>
