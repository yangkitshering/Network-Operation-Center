<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                    <span class="pl-3 cd-headline">NOC</span>
                </div>
            </div>

            <!-- Navigation Links -->

            <div class="space-x-8 sm:-my-px sm:ml-12 sm:flex">
                @if(Auth::user()->hasRole('user') && Auth::user()->is_dcfocal == 0)
                <x-nav-link :href="route('registration')" :active="request()->routeIs('registration')">
                    {{ __('Make Access Request') }}
                </x-nav-link>
                @endif

                <!-- Dropdown for pendings -->
                {{-- @if (Auth::user()->hasRole('admin'))
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <x-dropdown>
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div :active="request()->routeIs('registration')">Pending Request</div>
                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            @if(Auth::user()->hasRole('admin'))
                            <x-dropdown-link :href="route('pendingList')">
                                {{ __('Access Request') }}
                            </x-dropdown-link>
                            @endif

                            <x-dropdown-link :href="route('user-pending')">
                                {{ __('Registration Request') }}
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                </div>
                @endif --}}
                @if (Auth::user()->hasRole('admin'))
                <x-nav-link :href="route('user-pending')" :active="request()->routeIs('/user_pending')">
                    {{ __('Registration Requests') }}
                </x-nav-link>
                <x-nav-link :href="route('pendingList')" :active="request()->routeIs('/pendingList')">
                    {{ __('Access Request') }}
                </x-nav-link>

                <x-nav-link :href="route('approvedList')" :active="request()->routeIs('/approvedList')">
                    {{ __('Approved/Rejected Request') }}
                </x-nav-link>

                <x-nav-link :href="route('showTickets')" :active="request()->routeIs('/showTickets')">
                    {{ __('Tickets') }}
                </x-nav-link>
                @endif
                @if (Auth::user()->hasRole('user') && Auth::user()->is_dcfocal == 0)
                <x-nav-link :href="route('user_request')" :active="request()->routeIs('/user_request')">
                    {{ __('View Access Request') }}
                </x-nav-link>
                <x-nav-link :href="route('ticket')" :active="request()->routeIs('/ticket')">
                    {{ __('Raise Ticket') }}
                </x-nav-link>
                @endif

                @if (Auth::user()->hasRole('user') && Auth::user()->is_dcfocal == 1)
                <x-nav-link :href="route('approvedList')" :active="request()->routeIs('/approvedList')">
                    {{ __('Pending Exit Access Request') }}
                </x-nav-link>
                @endif
                
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown allign="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        {{-- @if(Auth::user()->hasRole('admin'))
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        @endif --}}
                        @if(Auth::user()->is_dcfocal == 0)
                        <x-dropdown-link :href="route('manage-user')">
                            {{ __('User Management') }}
                        </x-dropdown-link>
                        @endif
                        @if(Auth::user()->hasRole('admin'))
                        <x-dropdown-link :href="route('manage-setting')">
                            {{ __('App Settings') }}
                        </x-dropdown-link>
                        @endif
                        
                        <x-dropdown-link :href="route('change-pwd')">
                            {{ __('Change Password') }}
                        </x-dropdown-link>
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            {{-- <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div> --}}
        </div>
    </div>
</nav>