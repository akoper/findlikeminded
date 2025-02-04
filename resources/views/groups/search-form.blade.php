<x-app-layout>

    <p class="mb-5 text-2xl font-bold">Search Groups</p>

    <form action="/groups/search" method="post">
        @csrf
        <div class="mb-3 sm:mb-0 pt-0">
            <input type="text" name="name" id="name" placeholder="Topic"
                   class="w-full px-3 py-4 sm:w-44 md:w-44 lg:w-56 lg:max-w-80  placeholder-blueGray-300 text-blueGray-600 relative bg-white bg-white rounded text-base border-0 shadow outline-none focus:outline-none focus:ring "/>

            <input type="hidden" name="location_id" id="location_id" value={{ old('location_id') }}>
            <input type="text" name="location_name" id="location_name" placeholder="City" autocomplete="off"
                   class="w-full px-3 py-4 mt-2 sm:mt-0 sm:w-44 md:w-44 lg:w-56 lg:max-w-80  placeholder-blueGray-300 text-blueGray-600 relative bg-white bg-white rounded text-base border-0 shadow outline-none focus:outline-none focus:ring "/>

            <button class="py-2 mt-4 mb-8 w-36 inline-block text-white bg-orange-500 hover:bg-orange-600 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm focus:outline-none text-center">
                Search Groups</button>
        </div>
    </form>

</x-app-layout>
