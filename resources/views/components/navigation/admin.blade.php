<link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
<div x-data="{ sidebarOpen: false, pinned: $persist(false) }" class="relative">

    <!-- Mobile Navbar -->
    <div class="navbar bg-base-200 md:hidden">
        <div class="navbar-start">
            <div class="dropdown">
                <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
                    <i class="icon-menu font-semibold text-xl"></i>
                </div>
                <ul tabindex="0"
                    class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                    <li>
                        <a class="flex items-center w-full h-12 px-3.5 mt-2 rounded hover:bg-base-300 {{ request()->routeIs('admin.dashboard') ? 'bg-base-300' : '' }}"
                           href="{{ route('admin.dashboard') }}" wire:navigate>
                            <i class="icon-layout-dashboard"></i>
                            <span
                                class="ml-2 text-sm font-medium">{{ __('navigation/navigation.admin.dashboard') }}</span>
                        </a>

                        <a class="flex items-center w-full h-12 px-3.5 mt-2 rounded hover:bg-base-300 {{ request()->routeIs('admin.notifications*') ? 'bg-base-300' : '' }}"
                           href="{{ route('admin.notifications') }}" wire:navigate>
                            <i class="icon-bell"></i>
                            <span
                                class="ml-2 text-sm font-medium">{{ __('navigation/navigation.admin.notifications') }}</span>
                        </a>

                        <a class="flex items-center w-full h-12 px-3.5 mt-2 rounded hover:bg-base-300 {{ request()->routeIs('admin.users*') ? 'bg-base-300' : '' }}"
                           href="{{ route('admin.users') }}" wire:navigate>
                            <i class="icon-users"></i>
                            <span class="ml-2 text-sm font-medium">{{ __('navigation/navigation.admin.users') }}</span>
                        </a>

                        <a class="flex items-center w-full h-12 px-3.5 mt-2 rounded hover:bg-base-300 {{ request()->routeIs('admin.groups*') ? 'bg-base-300' : '' }}"
                           href="{{ route('admin.groups') }}" wire:navigate>
                            <i class="icon-shield"></i>
                            <span class="ml-2 text-sm font-medium">{{ __('navigation/navigation.admin.groups') }}</span>
                        </a>

                        <a class="flex items-center w-full h-12 px-3.5 mt-2 rounded hover:bg-base-300 {{ request()->routeIs('admin.settings') ? 'bg-base-300' : '' }}"
                           href="{{ route('admin.settings') }}" wire:navigate>
                            <i class="icon-settings-2"></i>
                            <span
                                class="ml-2 text-sm font-medium">{{ __('navigation/navigation.admin.settings') }}</span>
                        </a>

                        <a class="flex items-center w-full h-12 px-3.5 mt-2 rounded hover:bg-base-300 {{ request()->routeIs('admin.modules') ? 'bg-base-300' : '' }}"
                           href="{{ route('admin.modules') }}" wire:navigate>
                            <i class="icon-blocks"></i>
                            <span
                                class="ml-2 text-sm font-medium">{{ __('navigation/navigation.admin.modules') }}</span>
                        </a>

                        <a class="flex items-center w-full h-12 px-3.5 mt-2 rounded hover:bg-base-300 {{ request()->routeIs('admin.activity') ? 'bg-base-300' : '' }}"
                           href="{{ route('admin.activity') }}" wire:navigate>
                            <i class="icon-eye"></i>
                            <span
                                class="ml-2 text-sm font-medium">{{ __('navigation/navigation.admin.activity') }}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="navbar-center">
            <img src="{{ asset('img/Logo.svg') }}" alt="Logo" class="w-16 h-16">
        </div>
        <div class="navbar-end">

            <div class="mr-3">
                <i class="icon-search font-semibold text-xl cursor-pointer"
                   @click.stop="$dispatch('mary-search-open')"></i>
            </div>

            <a class="btn btn-ghost btn-circle" href="{{ route('account.notifications') }}" wire:navigate>
                <i class="icon-bell font-semibold text-xl"></i>
            </a>

            <div class="ml-2 dropdown dropdown-bottom dropdown-end">
                <img tabindex="0" role="button"
                     src="{{ auth()->user()->getAvatarURL() }}" alt="Profile"
                     class="w-9 h-9 rounded-3xl mr-6">
                <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                    <li><a href="{{ route('account.profile') }}" wire:navigate><i
                                class='icon-user'></i> {{ __('navigation/navigation.profile') }}</a>
                    </li>

                    <li><a href="{{ route('home') }}" wire:navigate><i
                                class='icon-home'></i> {{ __('navigation/navigation.home') }}</a></li>
                    <div class="divider"></div>

                    <li><a href="{{ route('auth.logout') }}" wire:navigate><i
                                class='icon-log-out'></i> {{ __('navigation/navigation.logout') }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="bg-base-200 flex items-center justify-between p-3 md:flex hidden">
        <div class="ml-auto flex items-center">
            <div class="mr-4">
                <i class="icon-search font-semibold text-xl cursor-pointer"
                   @click.stop="$dispatch('mary-search-open')"></i>
            </div>
            <div class="mr-4">
                <a href="{{ route('account.notifications') }}" wire:navigate><i
                        class="icon-bell font-semibold text-xl cursor-pointer"></i></a>
            </div>
            <div class="mr-4">
                <a href="{{ route('home') }}" wire:navigate><i class="icon-home font-semibold text-xl"></i></a>
            </div>

            <div class="dropdown dropdown-bottom dropdown-end ml-auto flex items-center">
                <img tabindex="0" role="button"
                     src="{{ auth()->user()->getAvatarURL() }}" alt="Profile"
                     class="w-9 h-9 rounded-3xl mr-6">
                <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                    <li><a href="{{ route('account.profile') }}" wire:navigate><i
                                class='icon-user'></i> {{ __('navigation/navigation.profile') }}</a>
                    </li>

                    <li><a href="{{ route('home') }}" wire:navigate><i
                                class='icon-home'></i> {{ __('navigation/navigation.home') }}</a></li>
                    <div class="divider"></div>

                    <li><a href="{{ route('auth.logout') }}" wire:navigate><i
                                class='icon-log-out'></i> {{ __('navigation/navigation.logout') }}</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div x-bind:class="{'expanded': sidebarOpen || pinned, 'pinned': pinned}" @mouseover="sidebarOpen = true"
         @mouseleave="sidebarOpen = false" @touchstart="sidebarOpen = !sidebarOpen; pinned = false"
         class="flex flex-col items-center w-40 fixed top-0 left-0 h-full sidebar overflow-x-hidden overflow-y-auto bg-base-200 transform transition-transform md:flex hidden"
         x-transition:enter="transition-transform transition-width ease-out duration-300"
         x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
         x-transition:leave="transition-transform transition-width ease-in duration-300"
         x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full">

        <div class="flex items-center justify-center w-full h-16 mt-2">
            <img src="{{ asset('img/Logo.svg') }}" alt="Logo" class="w-16 h-16">
            <span class="ml-1 font-bold text-hidden">{{ setting('app_name') }}</span>
        </div>

        <div class="w-full px-2 mt-4">
            <div class="flex flex-col items-center w-full mt-3 mb-3">
                <a class="flex items-center w-full h-12 px-3.5 mt-2 rounded hover:bg-base-300 {{ request()->routeIs('admin.dashboard') ? 'bg-base-300' : '' }}"
                   href="{{ route('admin.dashboard') }}" wire:navigate>
                    <i class="icon-layout-dashboard"></i>
                    <span
                        class="ml-2 text-sm font-medium text-hidden">{{ __('navigation/navigation.admin.dashboard') }}</span>
                </a>

                <a class="flex items-center w-full h-12 px-3.5 mt-2 rounded hover:bg-base-300 {{ request()->routeIs('admin.notifications*') ? 'bg-base-300' : '' }}"
                   href="{{ route('admin.notifications') }}" wire:navigate>
                    <i class="icon-bell"></i>
                    <span
                        class="ml-2 text-sm font-medium text-hidden">{{ __('navigation/navigation.admin.notifications') }}</span>
                </a>

                <a class="flex items-center w-full h-12 px-3.5 mt-2 rounded hover:bg-base-300 {{ request()->routeIs('admin.users*') ? 'bg-base-300' : '' }}"
                   href="{{ route('admin.users') }}" wire:navigate>
                    <i class="icon-users"></i>
                    <span
                        class="ml-2 text-sm font-medium text-hidden">{{ __('navigation/navigation.admin.users') }}</span>
                </a>

                <a class="flex items-center w-full h-12 px-3.5 mt-2 rounded hover:bg-base-300 {{ request()->routeIs('admin.groups*') ? 'bg-base-300' : '' }}"
                   href="{{ route('admin.groups') }}" wire:navigate>
                    <i class="icon-shield"></i>
                    <span
                        class="ml-2 text-sm font-medium text-hidden">{{ __('navigation/navigation.admin.groups') }}</span>
                </a>

                <a class="flex items-center w-full h-12 px-3.5 mt-2 rounded hover:bg-base-300 {{ request()->routeIs('admin.settings') ? 'bg-base-300' : '' }}"
                   href="{{ route('admin.settings') }}" wire:navigate>
                    <i class="icon-settings-2"></i>
                    <span
                        class="ml-2 text-sm font-medium text-hidden">{{ __('navigation/navigation.admin.settings') }}</span>
                </a>

                <a class="flex items-center w-full h-12 px-3.5 mt-2 rounded hover:bg-base-300 {{ request()->routeIs('admin.modules') ? 'bg-base-300' : '' }}"
                   href="{{ route('admin.modules') }}" wire:navigate>
                    <i class="icon-blocks"></i>
                    <span
                        class="ml-2 text-sm font-medium text-hidden">{{ __('navigation/navigation.admin.modules') }}</span>
                </a>

                <a class="flex items-center w-full h-12 px-3.5 mt-2 rounded hover:bg-base-300 {{ request()->routeIs('admin.activity') ? 'bg-base-300' : '' }}"
                   href="{{ route('admin.activity') }}" wire:navigate>
                    <i class="icon-eye"></i>
                    <span
                        class="ml-2 text-sm font-medium text-hidden">{{ __('navigation/navigation.admin.activity') }}</span>
                </a>
            </div>

            <div class="divider divider-neutral"></div>

            <div class="flex flex-col items-center w-full my-2">
                <a class="flex items-center w-full h-12 px-3.5 mt-2 rounded hover:bg-base-300 {{ request()->routeIs('account.profile') ? 'bg-base-300' : '' }}"
                   href="{{ route('account.profile') }}" wire:navigate>
                    <i class="icon-user"></i>
                    <span class="ml-2 text-sm font-medium text-hidden">{{ __('navigation/navigation.profile') }}</span>
                </a>
                <a class="flex items-center w-full h-12 px-3.5 mt-2 rounded hover:bg-base-300"
                   href="{{ route('home') }}" wire:navigate>
                    <i class="icon-home"></i>
                    <span class="ml-2 text-sm font-medium text-hidden">{{ __('navigation/navigation.home') }}</span>
                </a>
                <a class="relative flex items-center w-full h-12 px-3.5 mt-2 rounded hover:bg-base-300 {{ request()->routeIs('logout') ? 'bg-base-300' : '' }}"
                   href="{{ route('auth.logout') }}" wire:navigate>
                    <i class="icon-log-out"></i>
                    <span class="ml-2 text-sm font-medium text-hidden">{{ __('navigation/navigation.logout') }}</span>
                </a>
            </div>
        </div>
        <a @click="pinned = !pinned" id="pinBtn" role="button"
           class="flex items-center justify-center w-full h-16 mt-auto rounded hover:bg-base-300 sm:inline-flex hidden"
           :class="[pinned ? 'bg-base-300' : '']">
            <i :class="[pinned ? 'icon-pin transform rotate-90 transition-transform duration-300' :
            'icon-pin transform rotate-0 transition-transform duration-300']"></i>
        </a>
    </div>

    <!-- Content -->
    <div :class="{'md:ml-14': !pinned, 'md:ml-52': pinned}"
         class="content transition-all duration-200 ease-in-out pt-7 px-2 md:px-5 pb-4">

        {{ $content }}

    </div>
</div>
