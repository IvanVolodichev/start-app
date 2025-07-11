<nav x-data="{ open: false, eventsOpen: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                
                <!-- Navigation Links -->

                @if(Auth::user()->is_admin)

                    <!-- Logo -->

                    <div class="shrink-0 flex items-center">
                        <a href="{{ route('dashboard') }}">
                            <x-application-logo class="block h-10 w-auto fill-current text-gray-800" />
                        </a>
                    </div>

                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Панель управления') }}
                        </x-nav-link>
                        <x-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.*')">
                            {{ __('Жалобы') }}
                        </x-nav-link>
                        <x-nav-link :href="route('feedbacks.index')" :active="request()->routeIs('feedbacks.*')">
                            {{ __('Обращения') }}
                        </x-nav-link>
                    </div>
                @else

                    <!-- Logo -->

                    <div class="shrink-0 flex items-center">
                        <a href="{{ route('main') }}">
                            <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                        </a>
                    </div>

                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <x-nav-link :href="route('main')" :active="request()->routeIs('main')">
                            {{ __('Главная') }}
                        </x-nav-link>
                    </div>

                    <!-- Events Dropdown -->
                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button @click="eventsOpen = ! eventsOpen" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    <div>{{ __('События') }}</div>
                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('events.index')">
                                    {{ __('Все события') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('events.create')">
                                    {{ __('Создать событие') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('events.my', ['filter' => 'my'])">
                                    {{ __('Мои события') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('events.participated', ['filter' => 'participating'])">
                                    {{ __('Участвую') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>

                @endif
                
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                        <!-- Аватар пользователя -->

                        <div class="mr-2">{{ Auth::user()->name }}</div>

                        <div class="shrink-0 mr-1">
                            @if(Auth::user()->avatar)
                                <img src="{{ Auth::user()->avatar }}" 
                                    class="h-8 w-8 rounded-full object-cover border-2 border-gray-200">
                            @endif
                        </div>


                        <div class="ms-1">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>
                </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Настройки профиля') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Выход') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @if(Auth::user()->is_admin)
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Панель управления') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.*')">
                    {{ __('Жалобы') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('feedbacks.index')" :active="request()->routeIs('feedbacks.*')">
                    {{ __('Обращения') }}
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('main')" :active="request()->routeIs('main')">
                    {{ __('Главная') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('events.index')" :active="request()->routeIs('events.index')">
                    {{ __('Все события') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('events.create')" :active="request()->routeIs('events.create')">
                    {{ __('Создать событие') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('events.index', ['filter' => 'my'])" :active="request()->routeIs('events.index') && request()->get('filter') === 'my'">
                    {{ __('Мои события') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('events.index', ['filter' => 'participating'])" :active="request()->routeIs('events.index') && request()->get('filter') === 'participating'">
                    {{ __('Участвую') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Настройки профиля') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Выход') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
