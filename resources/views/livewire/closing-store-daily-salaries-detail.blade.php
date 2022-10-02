<div>
    <div>
        @role('super-admin')
            @can('create', App\Models\DailySalary::class)
                <button class="button" wire:click="newDailySalary">
                    <i class="mr-1 icon ion-md-add text-primary"></i>
                    @lang('crud.common.attach')
                </button>
            @endcan
        @endrole
    </div>

    <x-modal wire:model="showingModal">
        <div class="px-6 py-4">
            <div class="text-lg font-bold">{{ $modalTitle }}</div>

            <div class="mt-1 sm:space-y-5">

                <x-input.select name="daily_salary_id" label="Daily Salary" wire:model="daily_salary_id">
                    <option value="null" disabled>-- select --</option>
                    @foreach ($dailySalariesForSelect as $label => $value)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </x-input.select>

            </div>
        </div>

        <div class="flex justify-between px-6 py-4 bg-gray-50">
            <x-buttons.secondary wire:click="$toggle('showingModal')">@lang('crud.common.cancel')</x-buttons.secondary>
            <x-jet-button wire:click="save">@lang('crud.common.save')</x-jet-button>
        </div>
    </x-modal>

    <x-tables.card-overflow>
        <x-table>
            <x-slot name="head">
                <tr>
                    <x-tables.th-left>
                        name
                    </x-tables.th-left>
                    <x-tables.th-left>
                        date
                    </x-tables.th-left>
                    <x-tables.th-left>
                        amount
                    </x-tables.th-left>
                    <th></th>
                </tr>
            </x-slot>
            <x-slot name="body">
                @foreach ($closingStoreDailySalaries as $dailySalary)
                    <tr class="hover:bg-gray-100">

                        <x-tables.td-left>
                            {{ $dailySalary->created_by->name ?? '-' }}
                        </x-tables.td-left>
                        <x-tables.td-left>
                            {{ $dailySalary->date->toFormattedDate() ?? '-' }}
                        </x-tables.td-left>
                        <x-tables.td-right>
                            @currency($dailySalary->amount)
                        </x-tables.td-right>
                        <td class="px-4 py-3 text-right" style="width: 70px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @can('delete-any', App\Models\DailySalary::class)
                                    <button class="button button-danger"
                                        onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                                        wire:click="detach({{ $dailySalary->id }})">
                                        <i class="icon ion-md-trash text-primary"></i>

                                    </button>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-slot>
            <x-slot name="foot">
                <tr>
                    <x-tables.th-total colspan="2">Totals</x-tables.th-total>
                    <x-tables.td-total>@currency($this->dailySalary->totals)</x-tables.td-total>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class="px-4 mt-10">
                            {{ $closingStoreDailySalaries->render() }}
                        </div>
                    </td>
                </tr>
            </x-slot>
        </x-table>
    </x-tables.card-overflow>
</div>
