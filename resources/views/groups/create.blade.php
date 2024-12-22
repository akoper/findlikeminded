<x-app-layout>
  <div class="w-full max-w-xs">
    <form method="POST" action="/group" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
    @csrf
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="title">Title</label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="title" type="text">
      </div>
      <div class="mb-6">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="description">Description</label>
      <textarea id="description" rows="7" class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="location">Location</label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="location" type="text">
      </div>
      <div class="flex items-center justify-between">
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
          Create
        </button>
      </div>
    </form>
  </div>
</x-app-layout>