<x-app-layout>

    <p class="mb-5 text-2xl font-bold">Send Email</p>

    <p class="mb-5">This will send an email to recipients that will come from a do-not-reply FindLikeMinded email address.  Perhaps include your email address
        if you want recipients to communicate with you about the topic.</p>

    <form method="POST" action="/send">
        @csrf

        <input type="hidden" name="type" id="type" value={{ $type, old('type') }}>
        <input type="hidden" name="group_id" id="group_id" value={{ $group_id, old('group_id') }}>
        <input type="hidden" name="event_id" id="event_id" value={{ $event_id, old('event_id') }}>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2 dark:text-gray-100" for="subject">Subject *</label>
            <input
                class="required shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                name="subject" id="subject" type="text" value={{ old('subject') }}>
            @error('subject')
            <div class="alert text-red-600 alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2 dark:text-gray-100" for="message">Message *</label>
            <textarea class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border focus:ring-blue-500 focus:border-blue-500 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                      id="message" name="message" rows="7">{{ old('message') }}</textarea>
            @error('message')
            <div class="alert text-red-600 alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="flex items-center justify-between">
            <button type="submit"
                    class="bg-blue-700 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Send
            </button>
        </div>

    </form>

</x-app-layout>
