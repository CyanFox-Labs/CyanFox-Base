<link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
<!-- Navbar -->
<nav class="bg-gray-900 flex items-center justify-between p-3">
    <div class="dropdown dropdown-bottom dropdown-end ml-auto flex items-center">
        <span role="button" tabindex="0" class="mr-2 text-white">{{ auth()->user()->username }}</span>
        <img tabindex="0" role="button"
             src="https://source.boringavatars.com/beam/120/{{ auth()->user()->username }}" alt="Profile"
             class="w-9 h-9 mr-6">
        <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
            <li><a href="{{ route('profile') }}"><i class='bx bxs-user-circle'></i> Profile</a></li>
            @hasrole('Super Admin')
            <li><a href="{{ route('admin') }}"><i class='bx bxs-cog'></i> Admin</a></li>
            <div class="divider"></div>
            @endhasrole
            <li><a href="{{ route('logout') }}"><i class='bx bxs-log-out'></i> Logout</a></li>
        </ul>
    </div>
</nav>
<div x-data="{ sidebarOpen: false, pinned: $persist(false) }" class="relative">
    <!-- Sidebar -->
    <div :class="{'expanded': sidebarOpen || pinned}" @mouseover="sidebarOpen = true" @mouseleave="sidebarOpen = false"
         class="flex flex-col items-center w-40 fixed top-0 left-0 h-full sidebar overflow-hidden text-gray-400 bg-gray-900 shadow-lg transform transition-transform"
         x-transition:enter="transition-transform transition-width ease-out duration-300"
         x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
         x-transition:leave="transition-transform transition-width ease-in duration-300"
         x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full">
        <!-- Brand-Image with Text -->
        <div class="flex items-center justify-center w-full h-16 mt-2">
            <img src="{{ asset('img/Logo.png') }}" alt="Logo" class="w-8 h-8">
            <span class="ml-2 text-sm font-bold text-white text-hidden">{{ env('APP_NAME') }}</span>
        </div>

        <div class="w-full px-2 mt-4">
            <div class="flex flex-col items-center w-full mt-3">
                <a class="flex items-center w-full h-12 px-3 mt-2 rounded hover:bg-gray-700 hover:text-gray-300"
                   href="{{ route('home') }}">
                    <i class="bx bxs-home"></i>
                    <span class="ml-2 text-sm font-medium text-hidden">Home</span>
                </a>
            </div>
            <div class="flex flex-col items-center w-full mt-2">
                <a class="flex items-center w-full h-12 px-3 mt-2 rounded hover:bg-gray-700 hover:text-gray-300"
                   href="#">
                    <i class="bx bxs-user"></i>
                    <span class="ml-2 text-sm font-medium text-hidden">Profile</span>
                </a>
                <a class="relative flex items-center w-full h-12 px-3 mt-2 rounded hover:bg-gray-700 hover:text-gray-300"
                   href="#">
                    <i class="bx bxs-log-out"></i>
                    <span class="ml-2 text-sm font-medium text-hidden">Logout</span>
                </a>
            </div>
        </div>
        <a @click="pinned = !pinned"
           class="flex items-center justify-center w-full h-16 mt-auto rounded hover:bg-gray-700 hover:text-gray-300">
            <i :class="[pinned ? 'bx bxs-pin bx-rotate-90' : 'bx bxs-pin']"></i>
            <span class="ml-2 text-sm font-medium text-hidden">Pin</span>
        </a>
    </div>
</div>

