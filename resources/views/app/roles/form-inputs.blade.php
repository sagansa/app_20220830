@php $editing = isset($role) @endphp

<div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
    <x-input.text name="name" label="Name" value="{{ old('name', $editing ? $role->name : '') }}"></x-input.text>

    <div class="px-4 my-4">
        <h4 class="text-lg font-bold text-gray-700">
            Assign @lang('crud.permissions.name')
        </h4>

        <ul role="list" class="grid grid-cols-2 gap-x-4 sm:grid-cols-3 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8">
            @foreach ($permissions as $permission)
                <div>
                    <x-inputs.checkbox id="permission{{ $permission->id }}" name="permissions[]"
                        label="{{ ucfirst($permission->name) }}" value="{{ $permission->id }}" :checked="isset($role) ? $role->hasPermissionTo($permission) : false"
                        :add-hidden-value="false"></x-inputs.checkbox>
                </div>
                {{-- <li class="relative">
                <div
                    class="block w-full overflow-hidden bg-gray-100 rounded-lg group aspect-w-10 aspect-h-7 focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 focus-within:ring-offset-gray-100">
                    <img src="https://images.unsplash.com/photo-1582053433976-25c00369fc93?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=512&q=80"
                        alt="" class="object-cover pointer-events-none group-hover:opacity-75">
                    <button type="button" class="absolute inset-0 focus:outline-none">
                        <span class="sr-only">View details for IMG_4985.HEIC</span>
                    </button>
                </div>
                <p class="block mt-2 text-sm font-medium text-gray-900 truncate pointer-events-none">IMG_4985.HEIC</p>
                <p class="block text-sm font-medium text-gray-500 pointer-events-none">3.9 MB</p>
            </li> --}}
            @endforeach
            <!-- More files... -->
        </ul>

        {{-- <div class="py-2">
            @foreach ($permissions as $permission)
                <div>
                    <x-inputs.checkbox id="permission{{ $permission->id }}" name="permissions[]"
                        label="{{ ucfirst($permission->name) }}" value="{{ $permission->id }}" :checked="isset($role) ? $role->hasPermissionTo($permission) : false"
                        :add-hidden-value="false"></x-inputs.checkbox>
                </div>
            @endforeach
        </div> --}}
    </div>
</div>
