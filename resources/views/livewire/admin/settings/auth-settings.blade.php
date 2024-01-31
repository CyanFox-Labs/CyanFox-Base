<div>
    <x-form wire:submit="updateAuthSettings">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-[repeat(auto-fit,minmax(0,1fr))] gap-4 mb-5">
            <x-select label="{{ __('pages/admin/settings/auth_settings.enable_auth') }}"
                      hint="{{ __('pages/admin/settings/auth_settings.enable_auth_hint') }}"
                      wire:model="enableAuth"
                      class="select select-bordered"
                      :options="$options"></x-select>

            <x-select label="{{ __('pages/admin/settings/auth_settings.enable_captcha') }}"
                      wire:model="enableCaptcha"
                      class="select select-bordered"
                      :options="$options"></x-select>

            <x-select label="{{ __('pages/admin/settings/auth_settings.enable_forgot_password') }}"
                      wire:model="enableForgotPassword"
                      class="select select-bordered"
                      :options="$options"></x-select>

            <x-select label="{{ __('pages/admin/settings/auth_settings.enable_registration') }}"
                      wire:model="enableRegistration"
                      class="select select-bordered"
                      :options="$options"></x-select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
            <x-select label="{{ __('pages/admin/settings/auth_settings.enable_oauth') }}"
                      wire:model="enableOAuth"
                      class="select select-bordered"
                      :options="$options"></x-select>

            <x-select label="{{ __('pages/admin/settings/auth_settings.enable_local_login') }}"
                      wire:model="enableLocalLogin"
                      class="select select-bordered"
                      :options="$options"></x-select>
        </div>


        <div role="tablist" class="tabs tabs-bordered my-4">
            <a role="tab" class="tab @if($tab == 'google') tab-active @endif"
               wire:click="$set('tab', 'google')"><i class="icon-chrome pr-2"></i>
                <span class="md:block hidden">{{ __('pages/admin/settings/auth_settings.tabs.google') }}</span>
            </a>

            <a role="tab" class="tab @if($tab == 'github') tab-active @endif"
               wire:click="$set('tab', 'github')"><i class="icon-github pr-2"></i>
                <span class="md:block hidden">{{ __('pages/admin/settings/auth_settings.tabs.github') }}</span>
            </a>

            <a role="tab" class="tab @if($tab == 'gitlab') tab-active @endif"
               wire:click="$set('tab', 'gitlab')"><i class="icon-gitlab pr-2"></i>
                <span class="md:block hidden">{{ __('pages/admin/settings/auth_settings.tabs.gitlab') }}</span>
            </a>
        </div>

        @if($tab == 'google')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                <x-select label="{{ __('pages/admin/settings/auth_settings.oauth.google.enable_google_oauth') }}"
                          wire:model="enableGoogleOAuth"
                          class="select select-bordered"
                          :options="$options"></x-select>

                <x-input label="{{ __('pages/admin/settings/auth_settings.oauth.google.google_client_id') }}"
                         class="input-bordered" wire:model="googleClientId"/>

                <x-input label="{{ __('pages/admin/settings/auth_settings.oauth.google.google_client_secret') }}"
                         class="input-bordered" type="password" wire:model="googleClientSecret"/>

                <x-input label="{{ __('pages/admin/settings/auth_settings.oauth.google.google_redirect_url') }}"
                         class="input-bordered" wire:model="googleRedirectUrl"/>
            </div>
        @endif

        @if($tab == 'github')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                <x-select label="{{ __('pages/admin/settings/auth_settings.oauth.github.enable_github_oauth') }}"
                          wire:model="enableGithubOAuth"
                          class="select select-bordered"
                          :options="$options"></x-select>

                <x-input label="{{ __('pages/admin/settings/auth_settings.oauth.github.github_client_id') }}"
                         class="input-bordered" wire:model="githubClientId"/>

                <x-input label="{{ __('pages/admin/settings/auth_settings.oauth.github.github_client_secret') }}"
                         class="input-bordered" type="password" wire:model="githubClientSecret"/>

                <x-input label="{{ __('pages/admin/settings/auth_settings.oauth.github.github_redirect_url') }}"
                         class="input-bordered" wire:model="githubRedirectUrl"/>
            </div>
        @endif

        @if($tab == 'gitlab')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                <x-select label="{{ __('pages/admin/settings/auth_settings.oauth.gitlab.enable_gitlab_oauth') }}"
                          wire:model="enableGitlabOAuth"
                          class="select select-bordered"
                          :options="$options"></x-select>

                <x-input label="{{ __('pages/admin/settings/auth_settings.oauth.gitlab.gitlab_client_id') }}"
                         class="input-bordered" wire:model="gitlabClientId"/>

                <x-input label="{{ __('pages/admin/settings/auth_settings.oauth.gitlab.gitlab_client_secret') }}"
                         class="input-bordered" type="password" wire:model="gitlabClientSecret"/>

                <x-input label="{{ __('pages/admin/settings/auth_settings.oauth.gitlab.gitlab_redirect_url') }}"
                         class="input-bordered" wire:model="gitlabRedirectUrl"/>
            </div>
        @endif

        <div class="mt-2 flex justify-start gap-3">
            <x-button class="btn btn-success"
                      type="submit" spinner="updateAuthSettings">
                {{ __('messages.buttons.update') }}
            </x-button>
        </div>
    </x-form>
</div>
