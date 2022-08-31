@php $editing = isset($role) @endphp

<div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
    <x-input.text name="name" label="Name" value="{{ old('name', $editing ? $role->name : '') }}"></x-input.text>

    <div class="px-4 my-4">
        <h4 class="text-lg font-bold text-gray-700">
            Assign @lang('crud.permissions.name')
        </h4>

        <ul role="list" class="grid grid-cols-1 gap-x-3 sm:grid-cols-3 sm:gap-x-2 lg:grid-cols-5 xl:gap-x-2">
            @foreach ($permissions as $permission)
                <div>
                    <x-inputs.checkbox id="permission{{ $permission->id }}" name="permissions[]"
                        label="{{ ucfirst($permission->name) }}" value="{{ $permission->id }}" :checked="isset($role) ? $role->hasPermissionTo($permission) : false"
                        :add-hidden-value="false"></x-inputs.checkbox>
                </div>
            @endforeach

        </ul>
    </div>
</div>
