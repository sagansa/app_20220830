<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.employees.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('employees.index') }}" class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <x-shows.dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.employees.inputs.identity_no')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $employee->identity_no ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.employees.inputs.fullname')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $employee->fullname ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.employees.inputs.nickname')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $employee->nickname ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.employees.inputs.no_telp')</x-shows.dt
                        >
                        <x-shows.dd>{{ $employee->no_telp ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.employees.inputs.birth_place')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $employee->birth_place ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.employees.inputs.birth_date')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $employee->birth_date ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.employees.inputs.fathers_name')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $employee->fathers_name ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.employees.inputs.mothers_name')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $employee->mothers_name ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.employees.inputs.parents_no_telp')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $employee->parents_no_telp ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.employees.inputs.address')</x-shows.dt
                        >
                        <x-shows.dd>{{ $employee->address ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.employees.inputs.codepos')</x-shows.dt
                        >
                        <x-shows.dd>{{ $employee->codepos ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.employees.inputs.gps_location')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $employee->gps_location ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.employees.inputs.siblings_name')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $employee->siblings_name ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.employees.inputs.siblings_no_telp')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $employee->siblings_no_telp ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.employees.inputs.bpjs')</x-shows.dt
                        >
                        <x-shows.dd>{{ $employee->bpjs ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.employees.inputs.bank_account_no')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $employee->bank_account_no ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.employees.inputs.marital_status')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $employee->marital_status ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.employees.inputs.bank_id')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ optional($employee->bank)->name ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.employees.inputs.accepted_work_date')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $employee->accepted_work_date ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.employees.inputs.ttd')</x-shows.dt
                        >
                        <x-shows.dd>{{ $employee->ttd ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.employees.inputs.religion')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $employee->religion ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.employees.inputs.gender')</x-shows.dt
                        >
                        <x-shows.dd>{{ $employee->gender ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.employees.inputs.driver_license')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $employee->driver_license ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.employees.inputs.level_of_education')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $employee->level_of_education ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.employees.inputs.major')</x-shows.dt
                        >
                        <x-shows.dd>{{ $employee->major ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.employees.inputs.image_identity_id')</x-shows.dt
                        >
                        @if ($employee->image_identity_id != null)
                        <x-partials.thumbnail src="" size="150" />
                        @else
                        <a
                            href="{{ \Storage::url($employee->image_identity_id) }}"
                        >
                            <x-partials.thumbnail
                                src="{{ $employee->image_identity_id ? \Storage::url($employee->image_identity_id) : '' }}"
                                size="150"
                            />
                        </a>
                        @endif
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.employees.inputs.image_selfie')</x-shows.dt
                        >
                        @if ($employee->image_selfie != null)
                        <x-partials.thumbnail src="" size="150" />
                        @else
                        <a href="{{ \Storage::url($employee->image_selfie) }}">
                            <x-partials.thumbnail
                                src="{{ $employee->image_selfie ? \Storage::url($employee->image_selfie) : '' }}"
                                size="150"
                            />
                        </a>
                        @endif
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.employees.inputs.employee_status_id')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ optional($employee->employeeStatus)->name ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.employees.inputs.notes')</x-shows.dt
                        >
                        <x-shows.dd>{{ $employee->notes ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.employees.inputs.province_id')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ optional($employee->province)->name ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.employees.inputs.regency_id')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ optional($employee->regency)->name ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.employees.inputs.district_id')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ optional($employee->district)->name ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Created Date</x-shows.dt>
                        <x-shows.dd
                            >{{ $employee->created_at ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Updated Date</x-shows.dt>
                        <x-shows.dd
                            >{{ $employee->updated_at ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                </x-shows.dl>

                <div class="mt-10">
                    <a href="{{ route('employees.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>
                </div>
            </x-partials.card>

            @can('view-any', App\Models\Saving::class)
            <x-partials.card class="mt-5">
                <x-slot name="title"> Savings </x-slot>

                <livewire:employee-savings :employee="$employee" />
            </x-partials.card>
            @endcan @can('view-any', App\Models\ContractEmployee::class)
            <x-partials.card class="mt-5">
                <x-slot name="title"> Contract Employees </x-slot>

                <livewire:employee-contract-employees :employee="$employee" />
            </x-partials.card>
            @endcan @can('view-any', App\Models\WorkingExperience::class)
            <x-partials.card class="mt-5">
                <x-slot name="title"> Working Experiences </x-slot>

                <livewire:employee-working-experiences :employee="$employee" />
            </x-partials.card>
            @endcan
        </div>
    </div>
</x-admin-layout>
