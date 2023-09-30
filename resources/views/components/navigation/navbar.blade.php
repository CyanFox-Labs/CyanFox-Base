<div class="navbar bg-base-100">

    <!-- Mobile Nav -->
    <div class="navbar-start">
        <div class="dropdown">
            <i role="button" tabindex="0" class='btn btn-ghost bx bx-menu text-2xl lg:hidden'></i>
            <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                <li><a>Item 1</a></li>
                <li>
                    <a>Parent</a>
                    <ul class="p-2">
                        <li><a>Submenu 1</a></li>
                        <li><a>Submenu 2</a></li>
                    </ul>
                </li>
                <li><a>Item 3</a></li>
            </ul>
        </div>
        <a class="btn btn-ghost normal-case text-xl">{{ env('APP_NAME') }}</a>
    </div>


    <!-- Desktop Nav -->
    <div class="navbar-center hidden lg:flex">
        <ul class="menu menu-horizontal px-1">
            <li><a>Item 1</a></li>
            <li tabindex="0">
                <details>
                    <summary>Parent</summary>
                    <ul class="p-2">
                        <li><a>Submenu 1</a></li>
                        <li><a>Submenu 2</a></li>
                    </ul>
                </details>
            </li>
            <li><a>Item 3</a></li>
        </ul>
    </div>
    <div class="navbar-end">
        <div class="dropdown dropdown-end">
            <img tabindex="0" role="button"
                 src="https://source.boringavatars.com/beam/120/{{ auth()->user()->username }}" alt="Profile"
                 class="w-9 h-9">
            <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                <li><a href="{{ route('profile') }}"><i class='bx bxs-user-circle'></i> {{ __('navigation.profile') }}</a></li>
                @hasrole('Super Admin')
                <li><a href="{{ route('admin') }}"><i class='bx bxs-cog'></i> {{ __('navigation.admin') }}</a></li>
                <div class="divider"></div>
                @endhasrole
                <li><a href="{{ route('logout') }}"><i class='bx bxs-log-out'></i> {{ __('navigation.logout') }}</a></li>
            </ul>
        </div>
    </div>
</div>
