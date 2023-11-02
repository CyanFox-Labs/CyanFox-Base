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
            <x-form wire:submit="updateUser">
                <div class="grid md:grid-cols-2 gap-4 mt-4">
                    <div class="form-control w-full">
                        <x-input label="{{ __('pages/admin/users/all.first_name') }}"
                                 class="input input-bordered w-full" wire:model="first_name" required/>
                    </div>
                    <div class="form-control w-full">
                        <x-input label="{{ __('pages/admin/users/all.last_name') }}"
                                 class="input input-bordered w-full" wire:model="last_name" required/>
                    </div>

                    <div class="form-control w-full">
                        <x-input label="{{ __('pages/admin/users/all.username') }}"
                                 class="input input-bordered w-full" wire:model="username" required/>
                    </div>

                    <div class="form-control w-full">
                        <x-input label="{{ __('pages/admin/users/all.email') }}"
                                 class="input input-bordered w-full" wire:model="email" required/>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-4 mt-4">
                    <div class="form-control w-full">
                        <div class="form-control w-full">
                            <x-input label="{{ __('messages.password') }}" type="password"
                                     class="input input-bordered w-full" wire:model="password"/>
                        </div>
                    </div>
                    <div class="form-control w-full" wire:ignore>
                        <label class="label pt-0" for="roles">
                            <span class="label-text font-semibold">{{ __('pages/admin/users/all.roles') }}</span>
                        </label>
                        <select x-data="multiselect" id="roles" class="select select-bordered" wire:model="roles"
                                multiple>
                            @foreach(\Spatie\Permission\Models\Role::all() as $role)
                                <option value="{{ $role->id }}"
                                        @if($user->hasRole($role->name)) selected @endif>{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="form-control w-full">
                        <label class="label pt-0" for="change_password">
                            <span
                                class="label-text font-semibold">{{ __('pages/admin/users/all.change_password') }}</span>
                        </label>
                        <select id="change_password" class="select select-bordered" wire:model="change_password">
                            <option value="1" @if($user->change_password == 1) selected @endif>
                                {{ __('messages.yes') }}
                            </option>
                            <option value="0" @if($user->change_password == 0) selected @endif>
                                {{ __('messages.no') }}
                            </option>
                        </select>
                    </div>

                    <div class="form-control w-full">
                        <label class="label pt-0" for="activate_two_factor">
                            <span
                                class="label-text font-semibold">{{ __('pages/admin/users/all.activate_two_factor') }}</span>
                        </label>
                        <select id="activate_two_factor" class="select select-bordered"
                                wire:model="activate_two_factor">
                            <option value="1" @if($user->activate_two_factor == 1) selected @endif>
                                {{ __('messages.yes') }}
                            </option>
                            <option value="0" @if($user->activate_two_factor == 0) selected @endif>
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
                    <x-button type="submit"
                              class="btn btn-primary" spinner="updateUser">
                        {{ __('pages/admin/users/user-edit.update') }}
                    </x-button>
                </div>
            </x-form>
        </div>
    </div>
</div>
