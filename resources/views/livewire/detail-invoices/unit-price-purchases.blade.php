<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Unit Price Purchase
        </h2>
        <p class="mt-2 text-xs text-gray-700">---</p>
    </x-slot>

    <x-tables.topbar>
        <x-slot name="search">
            <x-buttons.link wire:click="$toggle('showFilters')">
                @if ($showFilters)
                    Hide
                @endif Advanced Search...
            </x-buttons.link>
            @if ($showFilters)
                {{-- <x-filters.group>
                    <x-filters.label>Store</x-filters.label>
                    <x-filters.select wire:model="filters.store_id">
                        @foreach ($stores as $label => $value)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-filters.select>
                </x-filters.group>
                <x-filters.group>
                    <x-filters.label>Supplier</x-filters.label>
                    <x-filters.select wire:model="filters.supplier_id">
                        @foreach ($suppliers as $label => $value)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-filters.select>
                </x-filters.group> --}}
                <x-filters.group>
                    <x-filters.label>Product</x-filters.label>
                    <x-filters.select wire:model="filters.product_id">
                        @foreach ($products as $label => $value)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-filters.select>
                </x-filters.group>

                <x-buttons.link wire:click="resetFilters">Reset Filter
                </x-buttons.link>
            @endif
        </x-slot>
        <x-slot name="action">
        </x-slot>
    </x-tables.topbar>
    <x-tables.card>
        <x-table>
            <x-slot name="head">
                <tr>
                    <x-tables.th-left>
                        Store Purchase Order
                    </x-tables.th-left>
                    <x-tables.th-left>
                        Supplier
                    </x-tables.th-left>
                    <x-tables.th-left>
                        Product
                    </x-tables.th-left>

                    <x-tables.th-left>
                        Quantity Product
                    </x-tables.th-left>
                    <x-tables.th-left>
                        Unit Price
                    </x-tables.th-left>
                    <x-tables.th-left>
                        Subtotal Invoice
                    </x-tables.th-left>



                </tr>
            </x-slot>
            <x-slot name="body">
                @foreach ($detailInvoices as $detailInvoice)
                    <tr class="hover:bg-gray-100">
                        <x-tables.td-left-hide>
                            {{ $detailInvoice->invoicePurchase->store->nickname }} -
                            {{ $detailInvoice->invoicePurchase->date->toFormattedDate() }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            {{ $detailInvoice->invoicePurchase->supplier->name }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            {{ optional($detailInvoice->detailRequest)->product->name ?? '-' }}
                        </x-tables.td-left-hide>
                        <x-tables.td-right-hide>
                            {{ $detailInvoice->quantity_product ?? '-' }}
                            {{ optional($detailInvoice->detailRequest)->product->unit->unit ?? '-' }}
                        </x-tables.td-right-hide>
                        <x-tables.td-right-hide>

                            @currency($detailInvoice->subtotal_invoice / $detailInvoice->quantity_product)

                        </x-tables.td-right-hide>
                        <x-tables.td-right-hide>
                            @currency($detailInvoice->subtotal_invoice)
                        </x-tables.td-right-hide>


                    </tr>
                @endforeach
            </x-slot>
            <x-slot name="foot">
                <tr>
                    <td colspan="7">
                        <div class="px-4 my-2">
                            {{ $detailInvoices->render() }}
                        </div>
                    </td>
                </tr>
            </x-slot>
        </x-table>
    </x-tables.card>
</div>
