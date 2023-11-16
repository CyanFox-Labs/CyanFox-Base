<div>
    <script src="{{ asset('js/sites/multiselect.js') }}"></script>
    <div class="ml-2 mb-5">
        <div class="text-sm breadcrumbs">
            <ul>
                <li><a href="{{ route('home') }}"><i class="bx bxs-cog mr-2"></i> {{ __('navigation/messages.admin') }}
                    </a></li>
                <li><a href="{{ route('admin-user-list') }}"><i
                            class="bx bxs-user-account mr-2"></i> {{ __('messages.users') }}</a></li>
                <li><a href="{{ route('admin-user-create') }}"><i
                            class="bx bxs-plus-circle mr-2"></i> {{ __('navigation/breadcrumbs.admin.users.create') }}</a></li>
            </ul>
        </div>
    </div>

    <div class="card bg-base-100 col-span-1 lg:col-span-2 shadow-xl">
        <div class="card-body">
            <x-form wire:submit="createUser">
                <div class="grid md:grid-cols-2 gap-4 mt-4">
                    <div class="form-control w-full">
                        <x-input label="{{ __('messages.first_name') }}"
                                 class="input input-bordered w-full" wire:model="first_name" required/>
                    </div>
                    <div class="form-control w-full">
                        <x-input label="{{ __('messages.last_name') }}"
                                 class="input input-bordered w-full" wire:model="last_name" required/>
                    </div>

                    <div class="form-control w-full">
                        <x-input label="{{ __('messages.username') }}"
                                 class="input input-bordered w-full" wire:model="username" required/>
                    </div>

                    <div class="form-control w-full">
                        <x-input label="{{ __('messages.email') }}"
                                 class="input input-bordered w-full" wire:model="email" required/>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-4 mt-4">
                    <div class="form-control w-full">
                        <x-input label="{{ __('messages.password') }}" type="password"
                                 class="input input-bordered w-full" wire:model="password" required/>
                    </div>
                    <div class="form-control w-full" wire:ignore>
                        <label class="label pt-0" for="roles">
                            <span class="label-text font-semibold">{{ __('messages.roles') }}</span>
                        </label>
                        <select x-data="multiselect" id="roles" class="select select-bordered" wire:model="roles"
                                multiple>
                            @foreach(\Spatie\Permission\Models\Role::all() as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-control w-full">
                        <div class="form-control w-full">
                            <x-checkbox label="{{ __('pages/admin/users/messages.must_change_password') }}" wire:model="change_password" />
                            <div class="mt-3"></div>
                            <x-checkbox label="{{ __('pages/admin/users/messages.must_activate_two_factor') }}" wire:model="activate_two_factor" />
                        </div>
                    </div>
                </div>


                <div class="col-span-1 mt-6 space-x-2 space-y-2">

                    <a href="{{ route('admin-user-list') }}"
                       class="btn btn-error">
                        {{ __('messages.back') }}
                    </a>
                    <x-button type="submit"
                              class="btn btn-primary" spinner="createUser">
                        {{ __('pages/admin/users/user-create.buttons.create_user') }}
                    </x-button>
                </div>
            </x-form>
        </div>
    </div>
</div>
