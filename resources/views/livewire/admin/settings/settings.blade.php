<div>

    <span class="font-bold text-xl">{{ __('pages/admin/settings/settings.title') }}</span>
    <div class="divider"></div>

    <div role="tablist" class="tabs tabs-boxed my-4">
        <a role="tab" class="tab @if($tab == 'system') tab-active @endif"
           wire:click="$set('tab', 'system')"><i class="icon-wrench pr-2"></i>
            <span class="md:block hidden">{{ __('pages/admin/settings/settings.tabs.system') }}</span>
        </a>

        <a role="tab" class="tab @if($tab == 'auth') tab-active @endif"
           wire:click="$set('tab', 'auth')"><i class="icon-key-round pr-2"></i>
            <span class="md:block hidden">{{ __('pages/admin/settings/settings.tabs.auth') }}</span>
        </a>

        <a role="tab" class="tab @if($tab == 'emails') tab-active @endif"
           wire:click="$set('tab', 'emails')"><i class="icon-mail pr-2"></i>
            <span class="md:block hidden">{{ __('pages/admin/settings/settings.tabs.emails') }}</span>
        </a>

        <a role="tab" class="tab @if($tab == 'profile') tab-active @endif"
           wire:click="$set('tab', 'profile')"><i class="icon-user pr-2"></i>
            <span class="md:block hidden">{{ __('pages/admin/settings/settings.tabs.profile') }}</span>
        </a>

        <a role="tab" class="tab @if($tab == 'security') tab-active @endif"
           wire:click="$set('tab', 'security')"><i class="icon-lock-keyhole pr-2"></i>
            <span class="md:block hidden">{{ __('pages/admin/settings/settings.tabs.security') }}</span>
        </a>
    </div>

    @if($tab == 'system')
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <livewire:admin.settings.system-settings/>
            </div>
        </div>
    @endif

    @if($tab == 'auth')
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <livewire:admin.settings.auth-settings/>
            </div>
        </div>
    @endif

    @if($tab == 'emails')
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <livewire:admin.settings.email-settings/>
            </div>
        </div>
    @endif

    @if($tab == 'profile')
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <livewire:admin.settings.profile-settings/>
            </div>
        </div>
    @endif

    @if($tab == 'security')
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <livewire:admin.settings.security-settings/>
            </div>
        </div>
    @endif
</div>
