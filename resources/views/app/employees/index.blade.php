<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.employees.index_title')
        </h2>
        <p class="mt-2 text-xs text-gray-700">---</p>
    </x-slot>

    <div class="mb-5 mt-4">
        <div class="flex flex-wrap justify-between mt-1">
            <div class="mt-1 md:w-1/3">
                <form>
                    <div class="flex items-center w-full">
                        <x-inputs.text
                            name="search"
                            value="{{ $search ?? '' }}"
                            placeholder="{{ __('crud.common.search') }}"
                            autocomplete="off"
                        ></x-inputs.text>

                        <div class="ml-1">
                            <x-jet-button>
                                <i class="icon ion-md-search"></i>
                            </x-jet-button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="mt-1 md:w-1/3 text-right">
                @can('create', App\Models\Employee::class)
                <a href="{{ route('employees.create') }}"
                    ><x-jet-button>
                        <i class="mr-1 icon ion-md-add"></i>
                        @lang('crud.common.create')</x-jet-button
                    >
                </a>
                @endcan
            </div>
        </div>
    </div>

    <x-tables.card>
        <x-table>
            <x-slot name="head">
                <x-tables.th-left
                    >@lang('crud.employees.inputs.fullname')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.employees.inputs.no_telp')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.employees.inputs.bank_account_no')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.employees.inputs.bank_id')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.employees.inputs.accepted_work_date')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.employees.inputs.image_selfie')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.employees.inputs.employee_status_id')</x-tables.th-left
                >
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($employees as $employee)
                <tr class="hover:bg-gray-50">
                    <x-tables.td-left-hide
                        >{{ $employee->fullname ?? '-' }}</x-tables.td-left-hide
                    >
                    <x-tables.td-right-hide
                        >{{ $employee->no_telp ?? '-' }}</x-tables.td-right-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $employee->bank_account_no ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ optional($employee->bank)->name ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $employee->accepted_work_date ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide>
                        @if ($employee->image_selfie == null)
                        <x-partials.thumbnail src="" />
                        @else
                        <a href="{{ \Storage::url($employee->image_selfie) }}">
                            <x-partials.thumbnail
                                src="{{ $employee->image_selfie ? \Storage::url($employee->image_selfie) : '' }}"
                            />
                        </a>
                        @endif
                    </x-tables.td-left-hide>

                    <x-tables.td-left-hide
                        >{{ optional($employee->employeeStatus)->name ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <td class="px-4 py-3 text-center" style="width: 134px;">
                        <div
                            role="group"
                            aria-label="Row Actions"
                            class="relative inline-flex align-middle"
                        >
                            @if($employee->status != '2')
                            <a
                                href="{{ route('employees.edit', $employee) }}"
                                class="mr-1"
                            >
                                <x-buttons.edit></x-buttons.edit>
                            </a>
                            @elseif($employee->status == '2')
                            <a
                                href="{{ route('employees.show', $employee) }}"
                                class="mr-1"
                            >
                                <x-buttons.show></x-buttons.show>
                            </a>
                            @endif @can('delete', $employee)
                            <form
                                action="{{ route('employees.destroy', $employee) }}"
                                method="POST"
                                onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')"
                            >
                                @csrf @method('DELETE')
                                <x-buttons.delete></x-buttons.delete>
                            </form>
                            @endcan
                        </div>
                    </td>
                </tr>
                @empty
                <x-tables.no-items-found colspan="8"> </x-tables.no-items-found>
                @endforelse
            </x-slot>
            <x-slot name="foot"> </x-slot>
        </x-table>
    </x-tables.card>
    <div class="mt-10 px-4">{!! $employees->render() !!}</div>
</x-admin-layout>
