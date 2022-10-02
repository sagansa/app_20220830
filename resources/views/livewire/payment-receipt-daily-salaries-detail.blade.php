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
                    <option value="null" disabled>-- select --</option>
                    @foreach ($dailySalariesForSelect as $label => $value)
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
                            {{ $dailySalary->date ?? '-' }}
                        </x-tables.td-left>
                        <x-tables.td-left>
                            {{ $dailySalary->created_by->name ?? '-' }}
                        </x-tables.td-left>

                        <x-tables.td-left>
                            {{-- {{ $dailySalary->store_id }} --}}
                        </x-tables.td-left>
                        <x-tables.td-right>
                            @currency($dailySalary->amount)
                        </x-tables.td-right>
                        @role('super-admin|manager')
                            <x-tables.td-left>
                                <select
                                    class="block w-full py-2 pl-3 pr-10 mt-1 text-xs border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                    wire:change="changeStatus({{ $dailySalary }}, $event.target.value)">
                                    <option value="1" {{ $dailySalary->status == '1' ? 'selected' : '' }}>
                                        Belum Dibayar</option>
                                    <option value="2" {{ $dailySalary->status == '2' ? 'selected' : '' }}>
                                        Sudah Dibayar</option>
                                </select>
                            </x-tables.td-left>
                        @endrole
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
                @role('super-admin|manager')
                    <tr>
                        <x-tables.th-total colspan="3">Total Payment</x-tables.th-total>
                        <x-tables.td-total>@currency($this->totals)
                        </x-tables.td-total>
                    </tr>
                    <tr>
                        <x-tables.th-total colspan="3">Amount</x-tables.th-total>
                        @role('supervisor|manager|staff')
                            <x-tables.td-total>@currency($this->paymentReceipt->amount)</x-tables.td-total>
                        @endrole
                        @role('super-admin')
                            <x-input.wire-currency name="amount" wiresubmit="updatePaymentReceipt" wiremodel="state.amount">
                            </x-input.wire-currency>
                        @endrole
                    </tr>
                    <tr>
                        <x-tables.th-total colspan="3">Difference</x-tables.th-total>
                        <x-tables.td-total>
                            @if ($this->difference < 0)
                                <x-spans.text-red>@currency($this->difference) </x-spans.text-red>
                            @else
                                <x-spans.text-green>@currency($this->difference) </x-spans.text-green>
                            @endif
                        </x-tables.td-total>
                    </tr>
                @endrole
            </x-slot>
        </x-table>
    </x-tables.card-overflow>
</div>
