<div>

    <div class="grid md:grid-cols-2 gap-4">
        <x-alert class="alert-success flex justify-center">
            {{ __('pages/admin/admin.current_template_version') }} {{ $currentTemplateVersion }}
        </x-alert>
        <x-alert class="alert-success flex justify-center">
            {{ __('pages/admin/admin.current_project_version') }} {{ $currentProjectVersion }}
        </x-alert>
    </div>

    @if(!$isDevVersion)
        @if(!$isTemplateUpToDate)
            <x-alert class="alert-error flex justify-center mt-4">
                {{ __('pages/admin/admin.new_template_version') }} ({{ $currentTemplateVersion }}
                => {{ $remoteTemplateVersion }})
            </x-alert>
        @endif

        @if(!$isProjectUpToDate)
            <x-alert class="alert-error flex justify-center mt-4">
                {{ __('pages/admin/admin.new_project_version') }} ({{ $currentProjectVersion }}
                => {{ $remoteProjectVersion }})
            </x-alert>
        @endif
    @else
        <x-alert class="alert-warning flex justify-center mt-4">
            {{ __('pages/admin/admin.dev_version') }}
        </x-alert>
    @endif

    <div class="grid md:grid-cols-2 gap-4 mt-4">
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body flex justify-center align-middle text-center">
                <a href="{{ route('admin-user-list') }}"><i class="bx bxs-user-account text-9xl"></i></a>
                <a href="{{ route('admin-user-list') }}">{{ __('messages.users') }}</a>
            </div>
        </div>
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body flex justify-center align-middle text-center">
                <a href="{{ route('admin-role-list') }}"><i class="bx bxs-user-badge text-9xl"></i></a>
                <a href="{{ route('admin-role-list') }}">{{ __('messages.roles') }}</a>
            </div>
        </div>
    </div>
</div>
