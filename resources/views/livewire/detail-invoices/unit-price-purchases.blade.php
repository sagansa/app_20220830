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
                <x-filters.group>
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
                </x-filters.group>
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
                    <x-tables.th-left-hide>
                        Store
                    </x-tables.th-left-hide>

                    <x-tables.th-left-hide>
                        Supplier
                    </x-tables.th-left-hide>
                    <x-tables.th-left>
                        Product
                    </x-tables.th-left>

                    <x-tables.th-left-hide>
                        Quantity Product
                    </x-tables.th-left-hide>
                    <x-tables.th-left-hide>
                        Subtotal Invoice
                    </x-tables.th-left-hide>
                    <x-tables.th-left>
                        Unit Price
                    </x-tables.th-left>
                    <x-tables.th-left>
                        Status
                    </x-tables.th-left>
                </tr>
            </x-slot>
            <x-slot name="body">
                @foreach ($detailInvoices as $detailInvoice)
                    <tr class="hover:bg-gray-100">
                        <x-tables.td-left-main>
                            <x-slot name="main"> {{ $detailInvoice->invoicePurchase->store->nickname }} -
                                {{ $detailInvoice->invoicePurchase->date->toFormattedDate() }}</x-slot>
                            <x-slot name="sub">
                                <p> {{ $detailInvoice->invoicePurchase->supplier->name }}</p>
                                <p> {{ optional($detailInvoice->detailRequest)->product->name ?? '-' }}</p>
                            </x-slot>
                        </x-tables.td-left-main>

                        <x-tables.td-left-hide>
                            {{ $detailInvoice->invoicePurchase->supplier->name }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            {{ optional($detailInvoice->detailRequest)->product->name ?? '-' }}
                        </x-tables.td-left-hide>
                        <x-tables.td-right-hide>
                            @currency($detailInvoice->subtotal_invoice / $detailInvoice->quantity_product)
                        </x-tables.td-right-hide>
                        <x-tables.td-right-hide>
                            {{ $detailInvoice->quantity_product ?? '-' }}
                            {{ optional($detailInvoice->detailRequest)->product->unit->unit ?? '-' }}
                        </x-tables.td-right-hide>

                        <td class="px-4 py-3 text-xs text-right" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @currency($detailInvoice->subtotal_invoice / $detailInvoice->quantity_product)
                            </div>
                        </td>

                        <x-tables.td-left-hide>
                            <select
                                class="block w-full py-2 pl-3 pr-10 mt-1 text-xs border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                wire:change="changeStatus({{ $detailInvoice }}, $event.target.value)">
                                <option value="1" {{ $detailInvoice->status == '1' ? 'selected' : '' }}>
                                    Process</option>
                                <option value="2" {{ $detailInvoice->status == '2' ? 'selected' : '' }}>
                                    Done</option>
                                <option value="3" {{ $detailInvoice->status == '3' ? 'selected' : '' }}>
                                    No Need</option>
                            </select>
                        </x-tables.td-left-hide>

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
