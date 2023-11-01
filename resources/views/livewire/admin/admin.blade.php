<div>

    <div class="grid md:grid-cols-2 gap-4 ">
        <x-alert class="alert-success flex justify-center">
                {{ __('pages/admin/admin.template_version') }} {{ $currentTemplateVersion }}
        </x-alert>
        <x-alert class="alert-success flex justify-center">
            {{ __('pages/admin/admin.project_version') }} {{ $currentProjectVersion }}
        </x-alert>
    </div>

    @if(!$isTemplateUpToDate)
        <x-alert class="alert-error flex justify-center mt-4">
            {{ __('pages/admin/admin.new_project_version') }} ({{ $currentTemplateVersion }} => {{ $remoteTemplateVersion }})
        </x-alert>
    @endif

    @if(!$isProjectUpToDate)
        <x-alert class="alert-error flex justify-center mt-4">
            {{ __('pages/admin/admin.new_template_version') }} ({{ $currentProjectVersion }} => {{ $remoteProjectVersion }})
        </x-alert>
    @endif

    <div class="grid md:grid-cols-2 gap-4 mt-4">
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <div class="overflow-x-auto">
                    <livewire:components.tables.admin.role-list/>
                </div>
            </div>
        </div>
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <div class="overflow-x-auto">
                    <livewire:components.tables.admin.user-list/>
                </div>
            </div>
        </div>
    </div>
</div>
