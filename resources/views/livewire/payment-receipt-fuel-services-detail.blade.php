<div>
    <div>
        @role('super-admin|manager')
            @can('create', App\Models\FuelService::class)
                <button class="button" wire:click="newFuelService">
                    <i class="mr-1 icon ion-md-add text-primary"></i>
                    @lang('crud.common.attach')
                </button>
            @endcan
        @endrole
    </div>

    <x-modal wire:model="showingModal">
        <div class="px-6 py-4">
            <div class="text-lg font-bold">{{ $modalTitle }}</div>

            <div class="mt-5">
                <div>
                    <x-input.select name="fuel_service_id" label="Fuel Service" wire:model="fuel_service_id">
                        <option value="null" disabled>-- select --</option>
                        @foreach ($fuelServicesForSelect as $label => $value)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-input.select>
                </div>
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
                        No Register
                    </x-tables.th-left>
                    <x-tables.th-left>
                        fuel / Service
                    </x-tables.th-left>

                    <x-tables.th-left>
                        amount
                    </x-tables.th-left>
                    <x-tables.th-left>
                        created by
                    </x-tables.th-left>
                    <x-tables.th-left>
                        status
                    </x-tables.th-left>
                    <th></th>
                </tr>
            </x-slot>
            <x-slot name="body">
                @foreach ($paymentReceiptFuelServices as $fuelService)
                    <tr class="hover:bg-gray-100">
                        <x-tables.td-left>
                            {{ $fuelService->vehicle->no_register ?? '-' }}
                        </x-tables.td-left>
                        <x-tables.td-left>

                            @if ($fuelService->fuel_service == 1)
                                fuel
                            @elseif ($fuelService->fuel_service == 2)
                                service
                            @endif

                        </x-tables.td-left>

                        <x-tables.td-right>
                            @currency($fuelService->amount)
                        </x-tables.td-right>
                        <x-tables.td-right>
                            {{ $fuelService->created_by->name }}
                        </x-tables.td-right>
                        <x-tables.td-right>
                            <select
                                class="block w-full py-2 pl-3 pr-10 mt-1 text-xs border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                wire:change="changeStatus({{ $fuelService }}, $event.target.value)">
                                <option value="1" {{ $fuelService->status == '1' ? 'selected' : '' }}>
                                    belum dibayar</option>
                                <option value="2" {{ $fuelService->status == '2' ? 'selected' : '' }}>
                                    sudah dibayar</option>
                                <option value="3" {{ $fuelService->status == '3' ? 'selected' : '' }}>
                                    siap dibayar</option>
                                <option value="4" {{ $fuelService->status == '4' ? 'selected' : '' }}>
                                    tidak valid</option>
                            </select>
                        </x-tables.td-right>
                        <td class="px-4 py-3 text-right" style="width: 70px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @role('super-admin|manager')
                                    @can('delete-any', App\Models\FuelService::class)
                                        <button class="button button-danger"
                                            onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                                            wire:click="detach({{ $fuelService->id }})">
                                            <i class="icon ion-md-trash text-primary"></i>
                                        </button>
                                    @endcan
                                @endrole
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-slot>
            <x-slot name="foot">
                @role('super-admin|manager')
                    <tr>
                        <x-tables.th-total colspan="2">Total Payment</x-tables.th-total>
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
                <tr>
                    <td colspan="2">
                        <div class="px-4 mt-10">
                            {{ $paymentReceiptFuelServices->render() }}
                        </div>
                    </td>
                </tr>
            </x-slot>
        </x-table>
    </x-tables.card-overflow>
</div>
