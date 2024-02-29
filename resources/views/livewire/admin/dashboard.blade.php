<div>

    <div class="grid md:grid-cols-2 gap-4">
        <x-alert class="alert-success flex justify-center">
            {{ __('admin/dashboard.version.current_template_version', ['version' => $currentTemplateVersion]) }}
        </x-alert>
        <x-alert class="alert-success flex justify-center">
            {{ __('admin/dashboard.version.current_project_version', ['version' => $currentProjectVersion]) }}
        </x-alert>
    </div>

    @if(!$isDevVersion)
        @if($showUpdateNotification)
            @if(!$isTemplateUpToDate)
                <x-alert class="alert-error flex justify-center mt-4">
                    {{ __('admin/dashboard.version.new_template_version_available', ['old_version' => $currentTemplateVersion, 'new_version' => $remoteTemplateVersion]) }}
                </x-alert>
            @else
                <x-alert class="alert-success flex justify-center mt-4">
                    {{ __('admin/dashboard.version.no_new_template_version_available') }}
                </x-alert>
            @endif

            @if(!$isProjectUpToDate)
                <x-alert class="alert-error flex justify-center mt-4">
                    {{ __('admin/dashboard.version.new_project_version_available', ['old_version' => $currentProjectVersion, 'new_version' => $remoteProjectVersion]) }}
                </x-alert>
            @else
                <x-alert class="alert-success flex justify-center mt-4">
                    {{ __('admin/dashboard.version.no_new_project_version_available') }}
                </x-alert>
            @endif
        @endif

        <div class="grid grid-cols-1">
            <x-button class="btn btn-primary mt-4" wire:click="checkForUpdates" spinner>
                {{ __('admin/dashboard.version.buttons.check_for_updates') }}
            </x-button>
        </div>
    @else
        <x-alert class="alert-warning flex justify-center mt-4">
            {{ __('admin/dashboard.version.dev_version') }}
        </x-alert>
    @endif

    <div class="grid md:grid-cols-3 sm:grid-cols-2 gap-4 mt-4">

        <div class="card bg-base-100 shadow-xl">
            <div class="card-body flex justify-center align-middle text-center">
                <a href="{{ route('admin.users') }}"><i class="icon-users text-9xl"></i></a>
                <a href="{{ route('admin.users') }}">{{ __('admin/dashboard.navigation.users') }}</a>
            </div>
        </div>

        <div class="card bg-base-100 shadow-xl">
            <div class="card-body flex justify-center align-middle text-center">
                <a href="{{ route('admin.groups') }}"><i class="icon-shield text-9xl"></i></a>
                <a href="{{ route('admin.groups') }}">{{ __('admin/dashboard.navigation.groups') }}</a>
            </div>
        </div>

        <div class="card bg-base-100 shadow-xl">
            <div class="card-body flex justify-center align-middle text-center">
                <a href="{{ route('admin.settings') }}"><i class="icon-settings-2 text-9xl"></i></a>
                <a href="{{ route('admin.settings') }}">{{ __('admin/dashboard.navigation.settings') }}</a>
            </div>
        </div>

        <div class="card bg-base-100 shadow-xl">
            <div class="card-body flex justify-center align-middle text-center">
                <a href="{{ route('admin.modules') }}"><i class="icon-blocks text-9xl"></i></a>
                <a href="{{ route('admin.modules') }}">{{ __('admin/dashboard.navigation.modules') }}</a>
            </div>
        </div>

        <div class="card bg-base-100 shadow-xl">
            <div class="card-body flex justify-center align-middle text-center">
                <a href="{{ route('admin.activity') }}"><i class="icon-eye text-9xl"></i></a>
                <a href="{{ route('admin.activity') }}">{{ __('admin/dashboard.navigation.activity') }}</a>
            </div>
        </div>

        <div class="card bg-base-100 shadow-xl">
            <div class="card-body flex justify-center align-middle text-center">
                <a href="/pulse"><i class="icon-heart-pulse text-9xl"></i></a>
                <a href="/pulse">{{ __('admin/dashboard.navigation.pulse') }}</a>
            </div>
        </div>

        @forelse (app('integrate.views')->getAll() as $moduleComponent)
            @if($moduleComponent['section'] == 'dashboard' && $moduleComponent['location'] == 'admin.dashboard')
                @component($moduleComponent['component'])
                @endcomponent
            @endif
        @empty
        @endforelse
    </div>
</div>
