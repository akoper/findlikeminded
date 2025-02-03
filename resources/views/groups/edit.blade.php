<x-app-layout>

    <p class="mb-5 text-2xl font-bold">Edit Group</p>

    <form method="POST" action="{{ route('groups.update', $group) }}">
        @csrf
        @method('patch')
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2 dark:text-gray-100" for="name">Name *</label>
            <input
                class="required shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                name="name" id="name" type="text" value="{{ old('name', $group->name) }}">
            @error('name')
                <div class="alert text-red-600 alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2 dark:text-gray-100" for="description">Description</label>
            <textarea class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border focus:ring-blue-500 focus:border-blue-500 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
            id="description" name="description" rows="7">{{ old('description', $group->description) }}</textarea>
            @error('description')
                <div class="alert text-red-600 alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <input type="hidden" name="location_id" id="location_id" value="{{ old('location_id', $group->location_id) }}">
            <label class="block text-gray-700 text-sm font-bold mb-2 dark:text-gray-100"  *</label>
            <input
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                name="location_name" id="location_name" type="text" autocomplete="off" value="{{ old('location_name' , $group->location->city) }}">
            @error('location_name')
                <div class="alert text-red-600 alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="flex items-center justify-between">
            <button type="submit"
                    class="bg-blue-700 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Update
            </button>
        </div>

    </form>

</x-app-layout>
