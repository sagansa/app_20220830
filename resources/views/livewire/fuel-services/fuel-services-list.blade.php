<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.fuel_services.index_title')
        </h2>
        <p class="mt-2 text-xs text-gray-700">laporan bahan bakar atau service kendaraan</p>
    </x-slot>

    <x-tables.topbar>
        <x-slot name="search">
            <x-buttons.link wire:click="$toggle('showFilters')">
                @if ($showFilters)
                    Hide
                @endif Advanced Search...
            </x-buttons.link>
            @if ($showFilters)
                <x-filters.group>
                    <x-filters.label>Payment Type</x-filters.label>
                    <x-filters.select wire:model="filters.payment_type_id">
                        @foreach ($paymentTypes as $label => $value)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-filters.select>
                </x-filters.group>

                <x-filters.group>
                    <x-filters.label>Status</x-filters.label>
                    <x-filters.select wire:model="filters.fuel_service">
                        @foreach (App\Models\FuelService::FUELSERVICES as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-filters.select>
                </x-filters.group>

                <x-filters.group>
                    <x-filters.label>Status</x-filters.label>
                    <x-filters.select wire:model="filters.status">
                        @foreach (App\Models\FuelService::STATUSES as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-filters.select>
                </x-filters.group>

                <x-buttons.link wire:click="resetFilters">Reset Filter
                </x-buttons.link>
            @endif
        </x-slot>
        <x-slot name="action">
            <div class="flex flex-wrap justify-between mt-1">
                <div class="mt-1 md:w-1/3">
                    @role('super-admin')
                        <x-buttons.green wire:click="markAllAsSudahDibayar">sudah dibayar</x-buttons.green>
                        <x-buttons.gray wire:click="markAllAsSiapDibayar">siap dibayar</x-buttons.gray>
                        <x-buttons.red wire:click="markAllAsTidakValid">perbaiki</x-buttons.red>
                    @endrole
                </div>
                <div class="mt-1 text-right md:w-1/3">
                    @can('create', App\Models\FuelService::class)
                        <a href="{{ route('fuel-services.create') }}">
                            <x-jet-button>
                                <i class="mr-1 icon ion-md-add"></i>
                                @lang('crud.common.create')
                            </x-jet-button>
                        </a>
                    @endcan
                </div>
            </div>
        </x-slot>
    </x-tables.topbar>

    <x-tables.card>
        <x-table>
            <x-slot name="head">
                <x-tables.th-left-hide>@lang('crud.fuel_services.inputs.image')</x-tables.th-left-hide>
                <x-tables.th-left-hide>date</x-tables.th-left-hide>
                <x-tables.th-left>@lang('crud.fuel_services.inputs.vehicle_id')</x-tables.th-left>
                <x-tables.th-left-hide>@lang('crud.fuel_services.inputs.fuel_service')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.fuel_services.inputs.payment_type_id')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.fuel_services.inputs.km')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.fuel_services.inputs.liter')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.fuel_services.inputs.amount')</x-tables.th-left-hide>

                @role('super-admin')
                    <x-tables.th-left-hide>per liter</x-tables.th-left-hide>
                    <x-tables.th-left-hide>created by</x-tables.th-left-hide>
                @endrole
                <x-tables.th-left-hide>Payment</x-tables.th-left-hide>
                <x-tables.th-left-hide>Status</x-tables.th-left-hide>
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($fuelServices as $fuelService)
                    <tr class="hover:bg-gray-50">
                        <x-tables.td-left-main>
                            <x-slot name="main">
                                @if ($fuelService->image == null)
                                    <x-partials.thumbnail src="" />
                                @else
                                    <a href="{{ \Storage::url($fuelService->image) }}">
                                        <x-partials.thumbnail
                                            src="{{ $fuelService->image ? \Storage::url($fuelService->image) : '' }}" />
                                    </a>
                                @endif
                            </x-slot>
                            <x-slot name="sub">
                                <p> {{ $fuelService->vehicle->no_register }}</p>
                                <p>
                                    @if ($fuelService->fuel_service == 1)
                                        fuel
                                    @else
                                        service
                                    @endif
                                    {{ optional($fuelService->paymentType)->name ?? '-' }}
                                </p>
                                <p>@number($fuelService->liter) - @currency($fuelService->amount)</p>
                                <p>
                                    @if ($fuelService->payment_type_id == 2)
                                        @foreach ($fuelService->closingStores as $closingStore)
                                            {{ optional($closingStore)->store->nickname ?? '-' }} |
                                            {{ optional($closingStore)->shiftStore->name ?? '-' }} |
                                            {{ optional($closingStore->date)->toFormattedDate() ?? '-' }}
                                        @endforeach
                                    @elseif($fuelService->payment_type_id == 1)
                                        @foreach ($fuelService->paymentReceipts as $paymentReceipt)
                                            {{ $paymentReceipt->created_at->toFormattedDate() }}
                                        @endforeach
                                    @endif
                                </p>
                                <p>
                                    <x-spans.status-valid class="{{ $fuelService->status_badge }}">
                                        {{ $fuelService->status_name }}
                                    </x-spans.status-valid>
                                </p>
                            </x-slot>

                        </x-tables.td-left-main>

                        <x-tables.td-left-hide>
                            @if ($fuelService == null)
                                -
                            @else
                                {{ optional($fuelService->date)->toFormattedDate() ?? '-' }}
                            @endif
                        </x-tables.td-left-hide>

                        <x-tables.td-left-hide>
                            {{ $fuelService->vehicle->no_register }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            @if ($fuelService->fuel_service == 1)
                                fuel
                            @else
                                service
                            @endif
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ optional($fuelService->paymentType)->name ?? '-' }}
                        </x-tables.td-left-hide>
                        <x-tables.td-right-hide>@number($fuelService->km)</x-tables.td-right-hide>
                        <x-tables.td-right-hide>@number($fuelService->liter)</x-tables.td-right-hide>
                        <x-tables.td-right-hide>@currency($fuelService->amount)</x-tables.td-right-hide>
                        @role('super-admin')
                            <x-tables.td-right-hide>
                                @if ($fuelService->fuel_service == 1)
                                    @currency($fuelService->amount / $fuelService->liter)
                                @endif
                            </x-tables.td-right-hide>
                            <x-tables.td-right-hide>
                                {{ $fuelService->created_by->name }}
                            </x-tables.td-right-hide>
                        @endrole
                        <x-tables.td-left-hide>
                            @if ($fuelService->payment_type_id == 2)
                                @foreach ($fuelService->closingStores as $closingStore)
                                    {{ optional($closingStore)->store->nickname ?? '-' }} |
                                    {{ optional($closingStore)->shiftStore->name ?? '-' }} |
                                    {{ optional($closingStore->date)->toFormattedDate() ?? '-' }}
                                @endforeach
                            @elseif($fuelService->payment_type_id == 1)
                                @foreach ($fuelService->paymentReceipts as $paymentReceipt)
                                    {{ $paymentReceipt->created_at->toFormattedDate() }}
                                @endforeach
                            @endif
                        </x-tables.td-left-hide>
                        <x-tables.td-right-hide>
                            <x-spans.status-valid class="{{ $fuelService->status_badge }}">
                                {{ $fuelService->status_name }}
                            </x-spans.status-valid>
                        </x-tables.td-right-hide>
                        <td class="px-4 py-3 text-center" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @if ($fuelService->status != '2')
                                    <a href="{{ route('fuel-services.edit', $fuelService) }}" class="mr-1">
                                        <x-buttons.edit></x-buttons.edit>
                                    </a>
                                @elseif($fuelService->status == '2')
                                    <a href="{{ route('fuel-services.show', $fuelService) }}" class="mr-1">
                                        <x-buttons.show></x-buttons.show>
                                    </a>
                                @endif
                                @can('delete', $fuelService)
                                    <form action="{{ route('fuel-services.destroy', $fuelService) }}" method="POST"
                                        onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                        @csrf @method('DELETE')
                                        <x-buttons.delete></x-buttons.delete>
                                    </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <x-tables.no-items-found colspan="10"> </x-tables.no-items-found>
                @endforelse
            </x-slot>
            <x-slot name="foot"> </x-slot>
        </x-table>
    </x-tables.card>
    <div class="px-4 mt-10">{!! $fuelServices->render() !!}</div>
</div>
