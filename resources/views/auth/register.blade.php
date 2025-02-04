<x-guest-layout>
    <p class="mb-5 text-2xl font-bold dark:text-gray-100">Register</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex flex-col items-center justify-center mt-4">

            <x-primary-button class="px-12 py-3 rounded-lg drop-shadow-md">
                {{ __('Register with email') }}
            </x-primary-button>

            <a class="underline mt-6 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>


        </div>
    </form>

    <div class="flex items-center justify-center mt-10">
        <a href="{{ route('google.redirect') }}" class="drop-shadow">
            <img src="{{ asset('images/login_Google.png') }}" alt="Login with your Google account button" style="width:250px">
        </a>
    </div>

    <p class="mt-4">If you create your FindLikeMinded account with your Google account,
        if you log in to FindLikeMinded with your email address and password (you can also login
        with you Google account), your FindLikeMinded
        password will be your Google password.</p>

{{--    <div class="flex items-center justify-center mt-6">--}}
{{--        <a href="{{ route('login.facebook') }}" class="drop-shadow">--}}
{{--            <img src="{{ asset('images/login_Facebook.png') }}" class="drop-shadow" alt="Login with your Facebook account button" style="width:250px">--}}
{{--        </a>--}}
{{--    </div>--}}

</x-guest-layout>
