<div>
    <script src="{{ asset('js/sites/multiselect.js') }}"></script>
    <div class="ml-2 mb-5">
        <div class="text-sm breadcrumbs">
            <ul>
                <li><a href="{{ route('home') }}"><i class="bx bxs-cog mr-2"></i> {{ __('navigation/messages.admin') }}
                    </a></li>
                <li><a href="{{ route('admin-role-list') }}"><i
                            class="bx bxs-user-badge mr-2"></i> {{ __('messages.roles') }}</a></li>
                <li><a href="{{ route('admin-role-edit', [$roleId]) }}"><i
                            class="bx bxs-edit-alt mr-2"></i> {{ __('navigation/breadcrumbs.admin.roles.edit') }}</a></li>
            </ul>
        </div>
    </div>

    <div class="card bg-base-100 col-span-1 lg:col-span-2 shadow-xl">
        <div class="card-body">
            <x-form wire:submit="updateRole">
                <div class="grid md:grid-cols-2 gap-4 mt-4">
                    <div class="form-control w-full">
                        <x-input label="{{ __('messages.name') }}"
                                 class="input input-bordered w-full" wire:model="name" required/>
                    </div>
                    <div class="form-control w-full">
                        <x-input label="{{ __('pages/admin/roles/messages.guard_name') }}"
                                 class="input input-bordered w-full" wire:model="guard_name" value="web" required/>
                    </div>
                </div>

                <div class="form-control w-full mt-4" wire:ignore>
                    <label class="label" for="permissions">
                        <span class="label-text">{{ __('messages.permissions') }}</span>
                    </label>
                    <select x-data="multiselect" id="permissions" class="select select-bordered"
                            wire:model="permissions" multiple>
                        @foreach(\Spatie\Permission\Models\Permission::all() as $permission)
                            <option value="{{ $permission->id }}" @if($role->hasPermissionTo($permission->name)) selected @endif>{{ $permission->name }}</option>
                        @endforeach
                    </select>
                </div>


                <div class="col-span-1 mt-6 space-x-2 space-y-2">

                    <a href="{{ route('admin-user-list') }}"
                       class="btn btn-error">
                        {{ __('messages.back') }}
                    </a>
                    <x-button type="submit"
                            class="btn btn-primary" spinner="updateRole">
                        {{ __('pages/admin/roles/role-edit.buttons.update_role') }}
                    </x-button>
                </div>
            </x-form>
        </div>
    </div>
</div>