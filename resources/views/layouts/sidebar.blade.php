<nav x-data="{ open: false }"
    :class="{ 'w-[250px] h-screen': open, 'w-[80px] h-[64px]': !open }"
    class="absolute sm:w-[336px] sm:h-screen shadow-gray-600 bg-white dark:bg-gray-800 transition-all duration-300 ease-in-out border-gray-100 dark:border-gray-700 pl-6 sidebar">
    <!-- Primary Navigation Menu -->
    <div class="flex flex-col h-full">
        <div class="flex items-center justify-between p-4">
            <!-- Logo (visible only when expanded) -->
            <div class="shrink-0 sm:flex items-center hidden" :class="{ 'block': open, 'hidden': !open }">
                <a href="{{ route('dashboard') }}">
                    <x-application-logo class="h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                </a>
            </div>
            <!-- Navigation Links -->
            <div class="hidden sm:space-x-8 sm:-my-px sm:ms-10 sm:flex">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-nav-link>
            </div>

            <!-- Hamburger -->
            <button @click="open = ! open"
                class="sm:hidden inline-flex items-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 transition duration-150 ease-in-out">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{ 'hidden': open, 'inline-flex': !open }"
                        class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{ 'hidden': !open, 'inline-flex': open }"
                        class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Sidebar Links (shown/hidden based on `open`) -->
        <div class="flex-1 pt-4 space-y-4">
            <a href="{{ route('dashboard') }}"
                :class="{ 'block': open, 'hidden': !open }"
                class="block text-gray-800 dark:text-gray-200 px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-900 rounded-md transition duration-150 ease-in-out">
                Dashboard
            </a>
            <!-- Add more links here -->
        </div>
    </div>
</nav>
