<div>
    <div>
        @can('create', App\Models\DailySalary::class)
            <button class="button" wire:click="newDailySalary">
                <i class="mr-1 icon ion-md-add text-primary"></i>
                @lang('crud.common.attach')
            </button>
        @endcan
    </div>

    <x-modal wire:model="showingModal">
        <div class="px-6 py-4">
            <div class="text-lg font-bold">{{ $modalTitle }}</div>

            <div class="mt-1 sm:space-y-5">
                <x-input.select name="daily_salary_id" label="Daily Salary" wire:model="daily_salary_id">
                    <option value="null" disabled>Please select the Daily Salary</option>
                    @foreach ($dailySalariesForSelect as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </x-input.select>
            </div>

        </div>

        <div class="flex justify-between px-6 py-4 bg-gray-50">
            <x-buttons.secondary wire:click="$toggle('showingModal')">Cancel</x-buttons.secondary>
            <x-jet-button wire:click="save">Save</x-jet-button>
        </div>
    </x-modal>

    <x-tables.card-overflow>
        <x-table>
            <x-slot name="head">
                <tr>
                    <x-tables.th-left>
                        date
                    </x-tables.th-left>
                    <x-tables.th-left>
                        @lang('crud.payment_receipt_daily_salaries.inputs.daily_salary_id')
                    </x-tables.th-left>
                    <x-tables.th-left>
                        payment type
                    </x-tables.th-left>
                    <x-tables.th-left>
                        store
                    </x-tables.th-left>
                    <x-tables.th-left>
                        amount
                    </x-tables.th-left>
                    <x-tables.th-left>
                        status
                    </x-tables.th-left>
                    <th></th>
                </tr>
            </x-slot>
            <x-slot name="body">
                @foreach ($paymentReceiptDailySalaries as $dailySalary)
                    <tr class="hover:bg-gray-100">
                        <x-tables.td-left>
                            {{ $dailySalary->date->toFormattedDate() ?? '-' }}
                        </x-tables.td-left>
                        <x-tables.td-left>
                            {{ $dailySalary->created_by->name ?? '-' }}
                        </x-tables.td-left>
                        <x-tables.td-left>
                            {{ $dailySalary->paymentType->name }}
                        </x-tables.td-left>
                        <x-tables.td-left>
                            {{ $dailySalary->closingStore->store->nickname }}
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
                                        <i class="mr-1 icon ion-md-trash text-primary"></i>
                                        @lang('crud.common.detach')
                                    </button>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-slot>
            <x-slot name="foot">
                <tr>
                    <td colspan="2">
                        <div class="px-4 mt-10">
                            {{ $paymentReceiptDailySalaries->render() }}
                        </div>
                    </td>
                </tr>
            </x-slot>
        </x-table>
    </x-tables.card-overflow>
</div>
