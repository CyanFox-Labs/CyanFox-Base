<link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
<div x-data="{ sidebarOpen: false, pinned: $persist(false) }" class="relative">
    <!-- Navbar -->
    <nav class="bg-base-200 flex items-center justify-between p-3">
        <div class="dropdown dropdown-bottom dropdown-end ml-auto flex items-center">
            <span role="button" tabindex="0" class="mr-2">{{ auth()->user()->username }}</span>
            <img tabindex="0" role="button"
                 src="https://source.boringavatars.com/beam/120/{{ auth()->user()->username }}" alt="Profile"
                 class="w-9 h-9 mr-6">
            <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                <li><a href="{{ route('home') }}"><i class='icon-home'></i> {{ __('navigation/messages.home') }}</a></li>
                <li><a href="{{ route('profile') }}"><i class='icon-user'></i> {{ __('navigation/messages.profile') }}
                    </a>
                </li>
                <div class="divider"></div>
                <li><a href="{{ route('logout') }}"><i class='icon-log-out'></i> {{ __('navigation/messages.logout') }}</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Sidebar -->
    <div x-bind:class="{'expanded': sidebarOpen || pinned, 'pinned': pinned}" @mouseover="sidebarOpen = true"
         @mouseleave="sidebarOpen = false" @touchstart="sidebarOpen = !sidebarOpen; pinned = false"
         class="flex flex-col items-center w-40 fixed top-0 left-0 h-full sidebar overflow-hidden bg-base-200 shadow-lg transform transition-transform"
         x-transition:enter="transition-transform transition-width ease-out duration-300"
         x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
         x-transition:leave="transition-transform transition-width ease-in duration-300"
         x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full">
        <!-- Brand-Image with Text -->
        <div class="flex items-center justify-center w-full h-16 mt-2">
            <img src="{{ asset('img/Logo.png') }}" alt="Logo" class="w-8 h-8">
            <span class="ml-2 text-sm font-bold text-hidden">{{ env('APP_NAME') }}</span>
        </div>

        <div class="w-full px-2 mt-4">
            <div class="flex flex-col items-center w-full mt-3 mb-3">
                <a class="flex items-center w-full h-12 px-3.5 mt-2 rounded hover:bg-base-300 {{ request()->routeIs('admin') ? 'bg-base-300' : '' }}"
                   href="{{ route('admin') }}">
                    <i class="icon-layout-dashboard"></i>
                    <span class="ml-2 text-sm font-medium text-hidden">{{ __('messages.dashboard') }}</span>
                </a>
                <a class="flex items-center w-full h-12 px-3.5 mt-2 rounded hover:bg-base-300 {{ request()->routeIs('admin-user*') ? 'bg-base-300' : '' }}"
                   href="{{ route('admin-user-list') }}">
                    <i class="icon-users"></i>
                    <span class="ml-2 text-sm font-medium text-hidden">{{ __('messages.users') }}</span>
                </a>
                <a class="flex items-center w-full h-12 px-3.5 mt-2 rounded hover:bg-base-300 {{ request()->routeIs('admin-role*') ? 'bg-base-300' : '' }}"
                   href="{{ route('admin-role-list') }}">
                    <i class="icon-shield"></i>
                    <span class="ml-2 text-sm font-medium text-hidden">{{ __('messages.roles') }}</span>
                </a>
                <a class="flex items-center w-full h-12 px-3.5 mt-2 rounded hover:bg-base-300 {{ request()->routeIs('admin-activity-log*') ? 'bg-base-300' : '' }}"
                   href="{{ route('admin-activity-log') }}">
                    <i class="icon-eye"></i>
                    <span class="ml-2 text-sm font-medium text-hidden">{{ __('messages.activity_log') }}</span>
                </a>
            </div>
            <div class="relative flex items-center">
                <div class="flex-grow border-t-2 rounded-2xl border-gray-500"></div>
            </div>

            <div class="flex flex-col items-center w-full mt-2">
                <a class="flex items-center w-full h-12 px-3.5 mt-2 rounded hover:bg-base-300 {{ request()->routeIs('home') ? 'bg-base-300' : '' }}"
                   href="{{ route('home') }}">
                    <i class="icon-home"></i>
                    <span class="ml-2 text-sm font-medium text-hidden">{{ __('navigation/messages.home') }}</span>
                </a>
                <a class="flex items-center w-full h-12 px-3.5 mt-2 rounded hover:bg-base-300 {{ request()->routeIs('profile') ? 'bg-base-300' : '' }}"
                   href="{{ route('profile') }}">
                    <i class="icon-user"></i>
                    <span class="ml-2 text-sm font-medium text-hidden">{{ __('navigation/messages.profile') }}</span>
                </a>
                <a class="relative flex items-center w-full h-12 px-3.5 mt-2 rounded hover:bg-base-300 {{ request()->routeIs('logout') ? 'bg-base-300' : '' }}"
                   href="{{ route('logout') }}">
                    <i class="icon-log-out"></i>
                    <span class="ml-2 text-sm font-medium text-hidden">{{ __('navigation/messages.logout') }}</span>
                </a>
            </div>
        </div>
        <a @click="pinned = !pinned" id="pinBtn" role="button"
           class="flex items-center justify-center w-full h-16 mt-auto rounded hover:bg-base-300 sm:inline-flex hidden"
           :class="[pinned ? 'bg-base-300' : '']">
            <i :class="[pinned ? 'icon-pin bx-rotate-90' : 'icon-pin']"></i>
            <span class="ml-2 text-sm font-medium text-hidden">{{ __('navigation/sidebar/messages.pin') }}</span>
        </a>
    </div>
    <!-- Content -->
    <div :class="{'ml-14': !pinned, 'ml-52': pinned}"
         class="content transition-all duration-200 ease-in-out pt-7 px-2 md:px-5 pb-4">


