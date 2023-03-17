<div>
    <x-slot name="header">
        @role('customer')
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                YOUR ORDER
            </h2>
            <p class="mt-2 text-xs text-gray-700">Terima kasih sudah mempercayakan kepada kami selama ini</p>
        @endrole

        @role('super-admin|manager|storage-staff')
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                @lang('crud.sales_order_directs.index_title')
            </h2>
            <p class="mt-2 text-xs text-gray-700">Penjualan melalui langsung ke pembeli</p>
        @endrole
    </x-slot>


    <x-tables.topbar>

        <x-slot name="search">
            @role('super-admin|manager|storage-staff')
                <x-buttons.link wire:click.prevent="$toggle('showFilters')">
                    @if ($showFilters)
                        Hide
                    @endif Advanced Search...
                </x-buttons.link>
            @endrole
            @if ($showFilters)
                @role('super-admin|manager')
                    <x-filters.group>
                        <x-filters.label>Payment Status</x-filters.label>
                        <x-filters.select wire:model="filters.payment_status">
                            @foreach (App\Models\SalesOrderDirect::PAYMENT_STATUSES as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </x-filters.select>
                    </x-filters.group>
                @endrole
                @role('super-admin|manager|storage-staff')
                    <x-filters.group>
                        <x-filters.label>Delivery Status</x-filters.label>
                        <x-filters.select wire:model="filters.delivery_status">
                            @foreach (App\Models\SalesOrderDirect::DELIVERY_STATUSES as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </x-filters.select>
                    </x-filters.group>

                    <x-buttons.link wire:click.prevent="resetFilters">Reset Filter
                    </x-buttons.link>
                @endrole
            @endif

        </x-slot>
        <x-slot name="action">
            <div class="flex flex-wrap justify-between mt-1">
                <div class="mt-1 md:w-1/2">
                    @role('super-admin|manager')
                        <x-buttons.green wire:click.prevent="markAllAsValid">Valid</x-buttons.green>
                        <x-buttons.red wire:click.prevent="markAllAsPerbaiki">Perbaiki</x-buttons.red>
                    @endrole
                </div>
                <div class="mt-1 text-right md:w-1/2">
                    @role('customer')
                        @can('create', App\Models\SalesOrderDirect::class)
                            <a href="{{ route('sales-order-directs.create') }}">
                                <x-jet-button>
                                    <i class="mr-1 icon ion-md-add"></i>
                                    Order
                                </x-jet-button>
                            </a>
                        @endcan

                        @can('create', App\Models\DeliveryLocation::class)
                            <a href="{{ route('delivery-locations.create') }}">
                                <x-jet-button class="mt-1">
                                    <i class="mr-1 icon ion-md-add"></i>
                                    Delivery Location
                                </x-jet-button>
                            </a>
                        @endcan
                    @endrole
                </div>
            </div>
        </x-slot>
    </x-tables.topbar>

    <x-tables.card>
        <x-table>
            <x-slot name="head">
                @role('super-admin|manager')
                    <th></th>
                @endrole
                <x-tables.th-left-hide>@lang('crud.sales_order_directs.inputs.image_transfer')</x-tables.th-left-hide>
                @role('super-admin|storage-staff|manager')
                    <x-tables.th-left-hide>@lang('crud.sales_order_directs.inputs.order_by_id')</x-tables.th-left-hide>
                @endrole
                <x-tables.th-left>@lang('crud.sales_order_directs.inputs.delivery_date')</x-tables.th-left>
                <x-tables.th-left-hide>@lang('crud.sales_order_directs.inputs.delivery_service_id')</x-tables.th-left-hide>
                {{-- <x-tables.th-left-hide>DETAIL ORDER</x-tables.th-left-hide> --}}
                @role('super-admin|customer|manager')
                    <x-tables.th-left-hide>@lang('crud.sales_order_directs.inputs.transfer_to_account_id')</x-tables.th-left-hide>
                    <x-tables.th-left-hide>@lang('crud.sales_order_directs.inputs.payment_status')</x-tables.th-left-hide>
                @endrole
                @role('super-admin|storage-staff|manager')
                    <x-tables.th-left-hide>@lang('crud.sales_order_directs.inputs.store_id')</x-tables.th-left-hide>
                    @elserole('super-admin|manger')
                    <x-tables.th-left-hide>@lang('crud.sales_order_directs.inputs.submitted_by_id')</x-tables.th-left-hide>
                @endrole
                <x-tables.th-left-hide>@lang('crud.sales_order_directs.inputs.received_by')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.sales_order_directs.inputs.delivery_status')</x-tables.th-left-hide>
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse ($salesOrderDirects as $salesOrderDirect)
                    <tr class="hover:bg-gray-50">
                        @role('super-admin|manager')
                            <x-tables.td-checkbox id="{{ $salesOrderDirect->id }}"></x-tables.td-checkbox>
                        @endrole
                        <x-tables.td-left-main>
                            <x-slot name="main">
                                <div class="relative z-0 flex -space-x-2 overflow-hidden">
                                    @role('super-admin|manager|customer')
                                        <div class="mr-3">
                                            @if ($salesOrderDirect->image_transfer == null)
                                                <x-partials.thumbnail src="" />
                                            @else
                                                <a href="{{ \Storage::url($salesOrderDirect->image_transfer) }}">
                                                    <x-partials.thumbnail
                                                        src="{{ $salesOrderDirect->image_transfer ? \Storage::url($salesOrderDirect->image_transfer) : '' }}" />
                                                </a>
                                            @endif
                                        </div>
                                    @endrole
                                    <div>
                                        @if ($salesOrderDirect->image_receipt == null)
                                            <x-partials.thumbnail src="" />
                                        @else
                                            <a href="{{ \Storage::url($salesOrderDirect->image_receipt) }}">
                                                <x-partials.thumbnail
                                                    src="{{ $salesOrderDirect->image_receipt ? \Storage::url($salesOrderDirect->image_receipt) : '' }}" />
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </x-slot>
                            <x-slot name="sub">
                                @role('super-admin|manager|storage-staff')
                                    {{ optional($salesOrderDirect->order_by)->name ?? '-' }}
                                @endrole

                                <div> {{ $salesOrderDirect->delivery_date->toFormattedDate() ?? '-' }} </div>
                                <div> {{ optional($salesOrderDirect->deliveryService)->name ?? '-' }} </div>
                                @role('super-admin|customer|manager')
                                    <div> {{ optional($salesOrderDirect->transferToAccount)->bank->name ?? '-' }}</div>
                                @endrole
                                <x-spans.status-valid class="{{ $salesOrderDirect->payment_status_badge }}">
                                    {{ $salesOrderDirect->payment_status_name }}
                                </x-spans.status-valid>
                                <x-spans.status-valid class="{{ $salesOrderDirect->delivery_status_badge }}">
                                    {{ $salesOrderDirect->delivery_status_name }}
                                </x-spans.status-valid>
                            </x-slot>
                        </x-tables.td-left-main>
                        @role('super-admin|storage-staff|manager')
                            <x-tables.td-left-hide>{{ optional($salesOrderDirect->order_by)->name ?? '-' }}
                            </x-tables.td-left-hide>
                        @endrole
                        <x-tables.td-left-hide>{{ $salesOrderDirect->delivery_date->toFormattedDate() ?? '-' }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            {{ optional($salesOrderDirect->deliveryService)->name ?? '-' }}
                        </x-tables.td-left-hide>
                        {{-- <x-tables.td-left-hide>
                            @forelse ($salesOrderDirect->salesOrderDirectProducts as $salesOrderDirectProduct)
                                {{ $salesOrderDirectProduct->eProduct->product->name }} -
                                {{ $salesOrderDirectProduct->quantity }}
                                {{ $salesOrderDirectProduct->eProduct->product->unit->unit }} -
                                @currency($salesOrderDirectProduct->price)
                            @empty
                                -
                            @endforelse
                        </x-tables.td-left-hide> --}}
                        @role('super-admin|customer|manager')
                            <x-tables.td-left-hide>
                                {{ optional($salesOrderDirect->transferToAccount)->bank->name ?? '-' }}
                            </x-tables.td-left-hide>
                            <x-tables.td-left-hide>
                                <x-spans.status-valid class="{{ $salesOrderDirect->payment_status_badge }}">
                                    {{ $salesOrderDirect->payment_status_name }}
                                </x-spans.status-valid>
                            </x-tables.td-left-hide>
                        @endrole
                        @role('super-admin|storage-staff|manager')
                            <x-tables.td-left-hide>{{ optional($salesOrderDirect->store)->nickname ?? '-' }}
                            </x-tables.td-left-hide>
                            @elserole('super-admin|manager')
                            <x-tables.td-left-hide>
                                {{ optional($salesOrderDirect->submitted_by)->name ?? '-' }}
                            </x-tables.td-left-hide>
                        @endrole
                        <x-tables.td-left-hide>{{ $salesOrderDirect->received_by ?? '-' }}</x-tables.td-left-hide>

                        <x-tables.td-left-hide>
                            <x-spans.status-valid class="{{ $salesOrderDirect->delivery_status_badge }}">
                                {{ $salesOrderDirect->delivery_status_name }}
                            </x-spans.status-valid>
                        </x-tables.td-left-hide>
                        <td class="px-4 py-3 text-center" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @role('customer')
                                    @if ($salesOrderDirect->payment_status == '1')
                                        <a href="{{ route('sales-order-directs.edit', $salesOrderDirect) }}"
                                            class="mr-1">
                                            <x-buttons.edit></x-buttons.edit>
                                        </a>
                                    @elseif($salesOrderDirect->status != '1')
                                        <a href="{{ route('sales-order-directs.show', $salesOrderDirect) }}"
                                            class="mr-1">
                                            <x-buttons.show></x-buttons.show>
                                        </a>
                                    @endif
                                @endrole

                                @role('super-admin|manager|storage-staff')
                                    @if ($salesOrderDirect->payment_status != '2' || $salesOrderDirect->delivery_status != '5')
                                        <a href="{{ route('sales-order-directs.edit', $salesOrderDirect) }}"
                                            class="mr-1">
                                            <x-buttons.edit></x-buttons.edit>
                                        </a>
                                    @elseif($salesOrderDirect->status == '2' || $salesOrderDirect->delivery_status == '5')
                                        <a href="{{ route('sales-order-directs.show', $salesOrderDirect) }}"
                                            class="mr-1">
                                            <x-buttons.show></x-buttons.show>
                                        </a>
                                    @endif
                                @endrole

                                @can('delete', $salesOrderDirect)
                                    <form action="{{ route('sales-order-directs.destroy', $salesOrderDirect) }}"
                                        method="POST" onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                        @csrf @method('DELETE')
                                        <x-buttons.delete></x-buttons.delete>
                                    </form>
                                @endcan
                            </div>
                    </tr>
                @empty
                @endforelse
            </x-slot>
            <x-slot name="foot"></x-slot>
        </x-table>
    </x-tables.card>
</div>
