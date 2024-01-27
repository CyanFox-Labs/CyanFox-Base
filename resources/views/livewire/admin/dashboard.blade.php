<div>

    <div class="grid md:grid-cols-2 gap-4">
        <x-alert class="alert-success flex justify-center">
            {{ __('pages/admin/dashboard.current_template_version') }} {{ $currentTemplateVersion }}
        </x-alert>
        <x-alert class="alert-success flex justify-center">
            {{ __('pages/admin/dashboard.current_project_version') }} {{ $currentProjectVersion }}
        </x-alert>
    </div>

    @if(!$isDevVersion)
        @if($showUpdateNotification)
            @if(!$isTemplateUpToDate)
                <x-alert class="alert-error flex justify-center mt-4">
                    {{ __('pages/admin/dashboard.new_template_version_available') }} ({{ $currentTemplateVersion }}
                    => {{ $remoteTemplateVersion }})
                </x-alert>
            @else
                <x-alert class="alert-success flex justify-center mt-4">
                    {{ __('pages/admin/dashboard.no_new_template_version_available') }}
                </x-alert>
            @endif

            @if(!$isProjectUpToDate)
                <x-alert class="alert-error flex justify-center mt-4">
                    {{ __('pages/admin/dashboard.new_project_version_available') }} ({{ $currentProjectVersion }}
                    => {{ $remoteProjectVersion }})
                </x-alert>
            @else
                <x-alert class="alert-success flex justify-center mt-4">
                    {{ __('pages/admin/dashboard.no_new_project_version_available') }}
                </x-alert>
            @endif
        @endif

        <div class="grid grid-cols-1">
            <x-button class="btn btn-primary mt-4" wire:click="checkForUpdates" spinner>
                {{ __('pages/admin/dashboard.buttons.check_for_updates') }}
            </x-button>
        </div>
    @else
        <x-alert class="alert-warning flex justify-center mt-4">
            {{ __('pages/admin/dashboard.dev_version') }}
        </x-alert>
    @endif

    <div class="grid md:grid-cols-3 sm:grid-cols-2 gap-4 mt-4">

        <div class="card bg-base-100 shadow-xl">
            <div class="card-body flex justify-center align-middle text-center">
                <a href="{{ route('admin.dashboard') }}"><i class="icon-bell text-9xl"></i></a>
                <a href="{{ route('admin.dashboard') }}">{{ __('navigation/navigation.admin.notifications') }}</a>
            </div>
        </div>

        <div class="card bg-base-100 shadow-xl">
            <div class="card-body flex justify-center align-middle text-center">
                <a href="{{ route('admin.users') }}"><i class="icon-users text-9xl"></i></a>
                <a href="{{ route('admin.users') }}">{{ __('navigation/navigation.admin.users') }}</a>
            </div>
        </div>

        <div class="card bg-base-100 shadow-xl">
            <div class="card-body flex justify-center align-middle text-center">
                <a href="{{ route('admin.dashboard') }}"><i class="icon-shield text-9xl"></i></a>
                <a href="{{ route('admin.dashboard') }}">{{ __('navigation/navigation.admin.groups') }}</a>
            </div>
        </div>

        <div class="card bg-base-100 shadow-xl">
            <div class="card-body flex justify-center align-middle text-center">
                <a href="{{ route('admin.dashboard') }}"><i class="icon-settings-2 text-9xl"></i></a>
                <a href="{{ route('admin.dashboard') }}">{{ __('navigation/navigation.admin.settings') }}</a>
            </div>
        </div>

        <div class="card bg-base-100 shadow-xl">
            <div class="card-body flex justify-center align-middle text-center">
                <a href="{{ route('admin.dashboard') }}"><i class="icon-terminal text-9xl"></i></a>
                <a href="{{ route('admin.dashboard') }}">{{ __('navigation/navigation.admin.actions') }}</a>
            </div>
        </div>

        <div class="card bg-base-100 shadow-xl">
            <div class="card-body flex justify-center align-middle text-center">
                <a href="{{ route('admin.dashboard') }}"><i class="icon-eye text-9xl"></i></a>
                <a href="{{ route('admin.dashboard') }}">{{ __('navigation/navigation.admin.activity') }}</a>
            </div>
        </div>

    </div>
</div>
