<x-app-layout>

    <div class="flex mb-5">
        <div class="flex-1  text-2xl font-bold">{{ $event->name }}</div>
{{--        <div class="flex-none w-32">--}}
{{--            @if($inGroup)--}}
{{--                <form action="/groups/leave" method="post">--}}
{{--                    @csrf--}}
{{--                    <div class="">--}}
{{--                        <input type="hidden" name="group_id" value="{{ $event->id }}" id="group_id" />--}}
{{--                        <button class="px-3 py-2 text-sm bg-gray-500 hover:bg-gray-300 text-white font-bold lg:mt-0 rounded-lg">Leave Group</button>--}}
{{--                    </div>--}}
{{--                </form>--}}
{{--            @else--}}
{{--                <form action="/groups/join" method="post">--}}
{{--                    @csrf--}}
{{--                    <div class="">--}}
{{--                        <input type="hidden" name="group_id" value="{{ $event->id }}" id="group_id" />--}}
{{--                        <button class="px-6 py-2 text-sm bg-green-600 hover:bg-green-400 text-white font-bold lg:mt-0 rounded-lg">Join Group</button>--}}
{{--                    </div>--}}
{{--                </form>--}}
{{--            @endif--}}
{{--        </div>--}}
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
        <span class="font-bold">End Date:</span> {{ date('D, F j, Y', strtotime($event->end_date)) ?? '' }}
    </div>

    <div class="mb-5">
        <span class="font-bold">End Time:</span> {{ date('g:ia', strtotime($event->end_time)) ?? '' }}
    </div>


</x-app-layout>
