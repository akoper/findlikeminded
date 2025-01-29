<x-app-layout>

    <p class="mb-5 text-2xl font-bold">Edit Event</p>

    <form method="POST" action="{{ route('events.update', $event) }}">
        @csrf
        @method('patch')
        <input type="hidden" name="group_id" value="{{ old('group_id', $event->group_id) }}" id="group_id" />
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2 dark:text-gray-100" for="name">Name *</label>
            <input
                class="required shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline"
                name="name" id="name" type="text" value="{{ old('name', $event->name) }}">
            @error('name')
                <div class="alert text-red-600 alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2 dark:text-gray-100" for="description">Description</label>
            <textarea class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border focus:ring-blue-500 focus:border-blue-500 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
            id="description" name="description" rows="7">{{ old('description', $event->description) }}</textarea>
            @error('description')
                <div class="alert text-red-600 alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2 dark:text-gray-100" for="location">Location *</label>
            <input
                class="required shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                name="location" id="location" type="text" value="{{ old('location', $event->location ) }}">
            @error('location')
                <div class="alert text-red-600 alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="location">Address *</label>
            <input
                class="required shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                name="address" id="address" type="text" value="{{ old('address', $event->address) }}">
            @error('address')
                <div class="alert text-red-600 alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="location">Start Date *</label>
            <input
                class="required shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                name="start_date" id="start_date" type="date" value="{{ old('start_date', $event->start_date->format('Y-m-d')) }}">
            @error('start_date')
                <div class="alert text-red-600 alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="location">Start Time *</label>
            <input
                class="required shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                name="start_time" id="start_time" type="time" value="{{ old('start_time', $event->start_time->format('H:i')) }}">
            @error('start_time')
                <div class="alert text-red-600 alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="location">End Date</label>
            <input
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                name="end_date" id="end_date" type="date" value="{{ old('end_date', isset($event->end_date) ? $event->end_date->format('Y-m-d') : null ) }}">
            @error('end_date')
                <div class="alert text-red-600 alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="location">End Time</label>
            <input
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                name="end_time" id="end_time" type="time" value="{{ old('end_time', isset($event->end_time) ? $event->end_time->format('H:i') : null) }}">
            @error('end_time')
                <div class="alert text-red-600 alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="flex items-center justify-between">
            <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Update
            </button>
        </div>

    </form>

</x-app-layout>
