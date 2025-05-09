<nav x-data="{ open: false }" class="bg-white border-b border-gray-100" style="background-color: #eef20a">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16 relative">
            <!-- Left Section: Dashboard Link -->
            <div class="absolute left-0 flex items-center space-x-8">
                @if(auth()->check() && auth()->user()->role != 'Beekeeping association' && auth()->user()->role != 'Administrator')
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                @endif

                @if(Auth::check())
                    @if(Auth::user()->role === 'Beekeeping association')
                        <x-nav-link :href="route('association.indexAssociation')" :active="request()->routeIs('association.indexAssociation')">
                            {{ __('Association') }}
                        </x-nav-link>
                    @endif

                    @if(Auth::user()->role === 'Administrator')
                        <x-nav-link :href="route('administrator.indexAdministrator')" :active="request()->routeIs('administrator.indexAdministrator')">
                            {{ __('Administrator') }}
                        </x-nav-link>
                    @endif
                @endif
            </div>

            <!-- Center Section: Logo -->
            <div class="flex-1 flex justify-center">
                <a href="{{ route('dashboard') }}">
                    <img src="{{ asset('storage/honey_product_traceability_navbar.png') }}" alt="Logo" class="h-12 w-auto">
                </a>
            </div>

            <!-- Right Section: Profile Dropdown -->
            @if (Auth::check())
                <div class="absolute right-0 flex items-center space-x-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                        this.closest('form').submit();">
                                    {{ __('Logout') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            @endif
        </div>
    </div>
</nav>
