<div>
    <script src="{{ asset('js/sites/multiselect.js') }}"></script>
    <div class="ml-2 mb-5">
        <div class="text-sm breadcrumbs">
            <ul>
                <li><a href="{{ route('home') }}"><i class="bx bxs-cog mr-2"></i> {{ __('breadcrumbs.admin.admin') }}
                    </a></li>
                <li><a href="{{ route('admin-user-list') }}"><i
                            class="bx bxs-user-account mr-2"></i> {{ __('breadcrumbs.admin.users.list') }}</a></li>
                <li><a href="{{ route('admin-user-edit', [$userId]) }}"><i
                            class="bx bxs-edit-alt mr-2"></i> {{ __('breadcrumbs.admin.users.edit') }}</a></li>
            </ul>
        </div>
    </div>

    <div class="card bg-base-100 col-span-1 lg:col-span-2 shadow-xl">
        <div class="card-body">
            <form onsubmit="event.preventDefault()">
                <div class="grid md:grid-cols-2 gap-4 mt-4">
                    <div class="form-control w-full">
                        <label class="label" for="first_name">
                            <span class="label-text">{{ __('pages/admin/users/all.first_name') }}</span>
                        </label>
                        <input id="first_name" type="text"
                               class="input input-bordered w-full" wire:model="first_name" required/>
                    </div>
                    <div class="form-control w-full">
                        <label class="label" for="last_name">
                            <span class="label-text">{{ __('pages/admin/users/all.last_name') }}</span>
                        </label>
                        <input id="last_name" type="text"
                               class="input input-bordered w-full" wire:model="last_name" required/>
                    </div>

                    <div class="form-control w-full">
                        <label class="label" for="username">
                            <span class="label-text">{{ __('pages/admin/users/all.username') }}</span>
                        </label>
                        <input id="username" type="text"
                               class="input input-bordered w-full" wire:model="username" required/>
                    </div>

                    <div class="form-control w-full">
                        <label class="label" for="email">
                            <span class="label-text">{{ __('pages/admin/users/all.email') }}</span>
                        </label>
                        <input id="email" type="text"
                               class="input input-bordered w-full" wire:model="email" required/>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-4 mt-4">
                    <div class="form-control w-full">
                        <label class="label" for="password">
                            <span class="label-text">{{ __('messages.password') }}</span>
                        </label>
                        <input id="password" type="password"
                               class="input input-bordered w-full" wire:model="password"/>
                    </div>
                    <div class="form-control w-full" wire:ignore>
                        <label class="label" for="roles">
                            <span class="label-text">{{ __('pages/admin/users/all.roles') }}</span>
                        </label>
                        <select x-data="multiselect" id="roles" class="select select-bordered" wire:model="roles" multiple>
                            @foreach(\Spatie\Permission\Models\Role::all() as $role)
                                <option value="{{ $role->id }}" @if($user->hasRole($role->name)) selected @endif>{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="form-control w-full">
                        <label class="label" for="change_password">
                            <span class="label-text">{{ __('pages/admin/users/all.change_password') }}</span>
                        </label>
                        <select id="change_password" class="select select-bordered" wire:model="change_password">
                            <option value="1">
                                {{ __('messages.yes') }}
                            </option>
                            <option value="0">
                                {{ __('messages.no') }}
                            </option>
                        </select>
                    </div>

                    <div class="form-control w-full">
                        <label class="label" for="activate_two_factor">
                            <span
                                class="label-text">{{ __('pages/admin/users/all.activate_two_factor') }}</span>
                        </label>
                        <select id="activate_two_factor" class="select select-bordered" wire:model="activate_two_factor">
                            <option value="1">
                                {{ __('messages.yes') }}
                            </option>
                            <option value="0" selected>
                                {{ __('messages.no') }}
                            </option>
                        </select>
                    </div>
                </div>


                <div class="col-span-1 mt-6 space-x-2 space-y-2">

                    <a href="{{ route('admin-user-list') }}"
                       class="btn btn-error">
                        {{ __('messages.back') }}
                    </a>
                    <button type="submit" wire:click="updateUser"
                            class="btn btn-primary">
                        {{ __('pages/admin/users/user-edit.update') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
