<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 pt-8 sm:pt-0 sm:px-6 lg:px-8">
        <div class="flex flex-row justify-around sm:h-16 md:justify-between">
                <!-- Logo -->
                <div class="shrink-0 flex items-center justify-center sm:align-middle">
                    @guest
                        <a href="{{ url('/') }}" class="inline-block text-4xl font-extrabold sm:text-2xl lg:text-4xl dark:text-gray-100 ">FindLikeMinded</a>
                    @endguest
                    @auth
                        <a href="{{ route('dashboard') }}" class="inline-block text-4xl font-extrabold sm:text-2xl lg:text-4xl dark:text-gray-100 ">FindLikeMinded</a>
                    @endauth

                </div>

            {{-- #####################    create group button     ################  --}}
                <div class="flex items-center">
                    <div class="hidden sm:block">
                        <a href="{{ url('/groups/create') }}"
                           class="w-full py-2 mt-3 sm:w-28 sm:mt-0 md:mx-2 md:px-2 lg:w-36 xl:mx-14 xl:w-40 block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm focus:outline-none text-center">Create Group</a>
                    </div>
                </div>

            {{-- #####################    search groups form and button     ################  --}}
            <div class="hidden sm:block text-center sm:flex items-center w-full mt-3 sm:mt-0">
                <form action="/groups/search" method="post">
                    @csrf
                    <div>
                        <input type="text" name="name" id="name" placeholder="Topic"
                               class="w-full mb-1 sm:w-16 sm:mb-0 md:w-36 placeholder-blueGray-300 text-blueGray-600 relative bg-white bg-white rounded text-base border-0 shadow outline-none focus:outline-none focus:ring"/>
                        <input type="hidden" name="location_id_navigation" id="location_id_navigation" value={{ old('location_id_navigation') }}>
                        <input type="text" name="location_name_navigation" id="location_name_navigation" placeholder="City" autocomplete="off"
                               class="w-full sm:w-20 md:w-40 lg:w-40 placeholder-blueGray-300 text-blueGray-600 relative bg-white bg-white rounded text-base border-0 shadow outline-none focus:outline-none focus:ring"/>
                        <button class="w-full py-2 mt-2 sm:w-16 sm:mt-0 md:px-3 lg:w-32 lg:ml-2 xl:w-40 inline-block text:px-6 text-sm bg-red-600 hover:bg-red-400 text-white font-bold rounded-lg">Search</button>
                    </div>
                </form>
            </div>

            @guest
                <div class="-mx-3 flex justify-center align-middle items-center">

                    <a href="{{ route('register') }}"
                       class="rounded-md mt-4 sm:mt-0 px-3 py-2 text-black ring-1 ring-transparent text-color-blue transition hover:text-blue/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                        Register</a>
                </div>
            @endguest

            @auth
            {{-- #####################    dropdown for desktop screen     ################  --}}
            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-2 md:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('dashboard')">
                            {{ __('Dashboard') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="url(env('STRIPE_CUSTOMER_BILLING_PORTAL_URL'))">
                            {{ __('Billing (in Stripe)') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('contact-us')">
                            {{ __('Contact Us') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- #####################    dropdown for mobile screen     ################  --}}
            <!-- Hamburger -->
            <div class="-me-2 flex justify-end mt-2 sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            @endauth
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">

        <div class="pt-2 pb-1 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->

        <div class="space-y-1">
            <x-responsive-nav-link :href="route('groups.search-form')">
                {{ __('Search Groups') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('groups.create')">
                {{ __('Create Group') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('profile.edit')">
                {{ __('Profile') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="url(env('STRIPE_CUSTOMER_BILLING_PORTAL_URL'))">
                {{ __('Billing (in Stripe)') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('contact-us')">
                {{ __('Contact Us') }}
            </x-responsive-nav-link>

            <!-- Authentication -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                    this.closest('form').submit();">
                    {{ __('Log Out') }}
                </x-responsive-nav-link>
            </form>
        </div>

    </div>
</nav>
