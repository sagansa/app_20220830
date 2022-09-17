<div>
    <div>
        @role('super-admin')
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

            <div class="mt-1 sm:space-y-5">

                <x-input.select name="fuel_service_id" label="Fuel Service" wire:model="fuel_service_id">
                    <option value="null" disabled>-- select --</option>
                    @foreach ($fuelServicesForSelect as $label => $value)
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
                        No Register
                    </x-tables.th-left>
                    <x-tables.th-left>
                        Amount
                    </x-tables.th-left>
                    <th></th>
                </tr>
            </x-slot>
            <x-slot name="body">
                @foreach ($closingStoreFuelServices as $fuelService)
                    <tr class="hover:bg-gray-100">
                        <x-tables.td-left>
                            {{ $fuelService->vehicle->no_register }}
                        </x-tables.td-left>
                        <x-tables.td-left>
                            @currency($fuelService->amount)
                        </x-tables.td-left>
                        <td class="px-4 py-3 text-right" style="width: 70px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @if ($closingStore->transfer_status != '2' || $closingStore->closing_status != '2')
                                    @can('delete-any', App\Models\FuelService::class)
                                        <button class="button button-danger"
                                            onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                                            wire:click="detach({{ $fuelService->id }})">
                                            <i class="icon ion-md-trash text-primary"></i>
                                        </button>
                                    @endcan
                                @endif

                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-slot>
            <x-slot name="foot">
                <tr>
                    <x-tables.th-total colspan="1">Totals</x-tables.th-total>
                    <x-tables.td-total>@currency($this->fuelService->totals)</x-tables.td-total>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class="px-4 my-2">
                            {{ $closingStoreFuelServices->render() }}
                        </div>
                    </td>
                </tr>
            </x-slot>
        </x-table>
    </x-tables.card-overflow>
</div>
