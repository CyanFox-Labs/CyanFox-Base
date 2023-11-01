<div>
    <div class="ml-2 mb-5">
        <div class="text-sm breadcrumbs">
            <ul>
                <li><a href="{{ route('home') }}"><i class="bx bxs-home mr-2"></i> {{ __('breadcrumbs.home') }}</a></li>
                <li><img src="https://source.boringavatars.com/beam/120/{{ auth()->user()->username }}"
                         alt="Profile" class="h-7 w-7 rounded-3xl mr-2"> {{ __('breadcrumbs.profile') }}
                </li>
            </ul>
        </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <div class="col-span-1 space-y-4">
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <div class="flex">
                        <img src="https://source.boringavatars.com/beam/120/{{ auth()->user()->username }}"
                             alt="Profile" class="h-16 w-16 rounded-3xl mr-4">
                        <div>
                            <p class="font-bold">{{ auth()->user()->username }}</p>
                            <p>{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</p>
                            <div class="divider"></div>
                            <p>{{ auth()->user()->getRoleNames()->implode(', ') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <span class="font-bold text-xl">{{ __('pages/profile.language_theme') }}</span>
                    <div class="divider"></div>
                    <div class="form-control w-full">
                        <label class="label" for="language">
                            <span class="label-text font-bold">{{ __('pages/profile.select_language') }}</span>
                        </label>
                        <select class="select select-bordered" id="language"
                                wire:blur="changeLanguage($event.target.value)">
                            <option value="de"
                                    @if(auth()->user()->language == 'de') selected @endif>{{ __('messages.languageType.de') }}</option>
                            <option value="en"
                                    @if(auth()->user()->language == 'en') selected @endif>{{ __('messages.languageType.en') }}</option>
                        </select>
                    </div>
                    <div class="form-control w-full">
                        <label class="label" for="theme">
                            <span class="label-text font-bold">{{ __('pages/profile.select_theme') }}</span>
                        </label>
                        <select class="select select-bordered" id="theme" wire:blur="changeTheme($event.target.value)">
                            <option value="light"
                                    @if(auth()->user()->theme == 'light') selected @endif>{{ __('pages/profile.themeType.light') }}</option>
                            <option value="dark"
                                    @if(auth()->user()->theme == 'dark') selected @endif>{{ __('pages/profile.themeType.dark') }}</option>
                            <option value="cupcake"
                                    @if(auth()->user()->theme == 'cupcake') selected @endif>{{ __('pages/profile.themeType.cupcake') }}</option>
                            <option value="bumblebee"
                                    @if(auth()->user()->theme == 'bumblebee') selected @endif>{{ __('pages/profile.themeType.bumblebee') }}</option>
                            <option value="emerald"
                                    @if(auth()->user()->theme == 'emerald') selected @endif>{{ __('pages/profile.themeType.emerald') }}</option>
                            <option value="corporate"
                                    @if(auth()->user()->theme == 'corporate') selected @endif>{{ __('pages/profile.themeType.corporate') }}</option>
                            <option value="synthwave"
                                    @if(auth()->user()->theme == 'synthwave') selected @endif>{{ __('pages/profile.themeType.synthwave') }}</option>
                            <option value="retro"
                                    @if(auth()->user()->theme == 'retro') selected @endif>{{ __('pages/profile.themeType.retro') }}</option>
                            <option value="cyberpunk"
                                    @if(auth()->user()->theme == 'cyberpunk') selected @endif>{{ __('pages/profile.themeType.cyberpunk') }}</option>
                            <option value="valentine"
                                    @if(auth()->user()->theme == 'valentine') selected @endif>{{ __('pages/profile.themeType.valentine') }}</option>
                            <option value="halloween"
                                    @if(auth()->user()->theme == 'halloween') selected @endif>{{ __('pages/profile.themeType.halloween') }}</option>
                            <option value="garden"
                                    @if(auth()->user()->theme == 'garden') selected @endif>{{ __('pages/profile.themeType.garden') }}</option>
                            <option value="forest"
                                    @if(auth()->user()->theme == 'forest') selected @endif>{{ __('pages/profile.themeType.forest') }}</option>
                            <option value="aqua"
                                    @if(auth()->user()->theme == 'aqua') selected @endif>{{ __('pages/profile.themeType.aqua') }}</option>
                            <option value="lofi"
                                    @if(auth()->user()->theme == 'lofi') selected @endif>{{ __('pages/profile.themeType.lofi') }}</option>
                            <option value="pastel"
                                    @if(auth()->user()->theme == 'pastel') selected @endif>{{ __('pages/profile.themeType.pastel') }}</option>
                            <option value="fantasy"
                                    @if(auth()->user()->theme == 'fantasy') selected @endif>{{ __('pages/profile.themeType.fantasy') }}</option>
                            <option value="wireframe"
                                    @if(auth()->user()->theme == 'wireframe') selected @endif>{{ __('pages/profile.themeType.wireframe') }}</option>
                            <option value="black"
                                    @if(auth()->user()->theme == 'black') selected @endif>{{ __('pages/profile.themeType.black') }}</option>
                            <option value="luxury"
                                    @if(auth()->user()->theme == 'luxury') selected @endif>{{ __('pages/profile.themeType.luxury') }}</option>
                            <option value="dracula"
                                    @if(auth()->user()->theme == 'dracula') selected @endif>{{ __('pages/profile.themeType.dracula') }}</option>
                            <option value="cmyk"
                                    @if(auth()->user()->theme == 'cmyk') selected @endif>{{ __('pages/profile.themeType.cmyk') }}</option>
                            <option value="autumn"
                                    @if(auth()->user()->theme == 'autumn') selected @endif>{{ __('pages/profile.themeType.autumn') }}</option>
                            <option value="business"
                                    @if(auth()->user()->theme == 'business') selected @endif>{{ __('pages/profile.themeType.business') }}</option>
                            <option value="acid"
                                    @if(auth()->user()->theme == 'acid') selected @endif>{{ __('pages/profile.themeType.acid') }}</option>
                            <option value="lemonade"
                                    @if(auth()->user()->theme == 'lemonade') selected @endif>{{ __('pages/profile.themeType.lemonade') }}</option>
                            <option value="night"
                                    @if(auth()->user()->theme == 'night') selected @endif>{{ __('pages/profile.themeType.night') }}</option>
                            <option value="coffee"
                                    @if(auth()->user()->theme == 'coffee') selected @endif>{{ __('pages/profile.themeType.coffee') }}</option>
                            <option value="winter"
                                    @if(auth()->user()->theme == 'winter') selected @endif>{{ __('pages/profile.themeType.winter') }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <span class="font-bold text-xl">{{ __('pages/profile.sessions') }}</span>
                    <div class="divider"></div>
                    <div class="grid grid-cols-4 items-center gap-x-4 overflow-x-auto">
                        @foreach ($sessionData as $session)
                            <div class="col-span-3 flex items-center space-x-2 space-y-3">
                                <div class="text-4xl">
                                    @if($session['deviceType'] == 'Desktop')
                                        <i class="bx bx-desktop"></i>
                                    @elseif($session['deviceType'] == 'Phone')
                                        <i class="bx bx-mobile-alt"></i>
                                    @elseif($session['deviceType'] == 'Tablet')
                                        <i class="bx bx-tab"></i>
                                    @else
                                        <i class="bx bx-devices"></i>
                                    @endif
                                </div>
                                <div>
                                    <div class="font-bold">{{ $session['ip'] }}</div>
                                    <div>{{ $session['platform'] }}</div>
                                </div>
                            </div>
                            <div class="col-span-1 text-end">
                                @if ($session['isCurrentSession'])
                                    <button class="btn btn-outline btn-ghost"
                                            wire:click="$dispatch('openModal', { component: 'components.modals.profile.logout' })">
                                        {{ __('pages/profile.current_session') }}
                                    </button>
                                @else
                                    <button class="btn btn-outline btn-error"
                                            wire:click="$dispatch('openModal', { component: 'components.modals.profile.logout-session', arguments: { sessionId: '{{ $session['id'] }}' }})">
                                        {{ __('pages/profile.revoke_session') }}
                                    </button>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <div class="divider"></div>
                    <button class="btn btn-error btn-outline"
                            wire:click="$dispatch('openModal', { component: 'components.modals.profile.logout-all-sessions' })">
                        {{ __('pages/profile.logout_sessions') }}
                    </button>
                </div>
            </div>
        </div>
        <div class="col-span-2 space-y-4">
            <div class="card bg-base-100 col-span-1 lg:col-span-2 shadow-xl">
                <div class="card-body">
                    <x-form class="grid grid-cols-2 gap-4" wire:submit="updateProfile">
                        <div>
                            <div class="form-control w-full">
                                <x-input label="{{ __('pages/profile.first_name') }}"
                                         class="input input-bordered w-full" wire:model="first_name"/>
                            </div>
                        </div>
                        <div>
                            <div class="form-control w-full">
                                <x-input label="{{ __('pages/profile.last_name') }}"
                                         class="input input-bordered w-full" wire:model="last_name"/>
                            </div>
                        </div>
                        <div>
                            <div class="form-control w-full">
                                <x-input label="{{ __('pages/profile.username') }}"
                                         class="input input-bordered w-full" wire:model="username"/>
                            </div>
                        </div>
                        <div>
                            <div class="form-control w-full">
                                <x-input label="{{ __('pages/profile.email') }}"
                                         class="input input-bordered w-full" wire:model="email"/>
                            </div>
                        </div>
                        <div class="col-span-1 mt-6">
                            <x-button type="submit"
                                      class="btn btn-primary" spinner="updateProfile">
                                {{ __('messages.update') }}
                            </x-button>
                        </div>
                    </x-form>
                </div>
            </div>
            <div class="col-span-2 space-y-4">
                <div class="card bg-base-100 col-span-1 lg:col-span-2 shadow-xl">
                    <div class="card-body">
                        <x-form wire:submit="updatePassword">
                            <div class="w-full">
                                <div class="form-control w-full">
                                    <x-input label="{{ __('pages/profile.current_password') }}"
                                             type="password"
                                             class="input input-bordered w-full" wire:model="current_password"/>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mt-4">
                                <div>
                                    <div class="form-control w-full">
                                        <x-input label="{{ __('pages/profile.new_password') }}"
                                                 type="password"
                                                 class="input input-bordered w-full" wire:model="new_password"/>
                                    </div>
                                </div>
                                <div>
                                    <div class="form-control w-full">
                                        <x-input label="{{ __('pages/profile.confirm_password') }}"
                                                 type="password"
                                                 class="input input-bordered w-full" wire:model="confirm_password"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-1 mt-6 flex gap-2">
                                <x-button type="submit"
                                          class="btn btn-primary" spinner="updatePassword">
                                    {{ __('messages.update') }}
                                </x-button>

                                @if(auth()->user()->two_factor_enabled)
                                    <button type="button"
                                            class="btn btn-error"
                                            wire:click="$dispatch('openModal', { component: 'components.modals.profile.disable-two-factor' })">
                                        {{ __('pages/profile.disable_2fa') }}
                                    </button>
                                    <button type="button"
                                            class="btn btn-accent"
                                            wire:click="$dispatch('openModal', { component: 'components.modals.profile.recovery-codes' })">
                                        {{ __('pages/profile.show_recovery_codes') }}
                                    </button>
                                @else
                                    <button type="button"
                                            class="btn btn-accent"
                                            wire:click="$dispatch('openModal', { component: 'components.modals.profile.activate-two-factor' })">
                                        {{ __('pages/profile.enable_2fa') }}
                                    </button>
                                @endif
                            </div>
                        </x-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

