<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Unit Price
        </h2>
        <p class="mt-2 text-xs text-gray-700"> --- </p>
    </x-slot>

    <x-modal wire:model="showingModal">
        <div class="px-6 py-4">
            <div class="text-lg font-bold">{{ $modalTitle }}</div>

            <div class="mt-1 sm:space-y-5">

                {{-- <x-input.select name="detailInvoice.detail_request_id" label="Detail Request"
                    wire:model="detailInvoice.detail_request_id">
                    <option value="null" disabled>-- select --</option>
                    @foreach ($detailRequestsForSelect as $label => $value)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </x-input.select> --}}

                <x-input.number name="detailInvoice.quantity_product" label="Quantity Product"
                    wire:model="detailInvoice.quantity_product"></x-input.number>

                <x-input.number name="detailInvoice.quantity_invoice" label="Quantity Invoice"
                    wire:model="detailInvoice.quantity_invoice"></x-input.number>

                <x-input.select name="detailInvoice.unit_invoice_id" label="Unit Invoice"
                    wire:model="detailInvoice.unit_invoice_id">
                    <option value="null" disabled>-- select --</option>
                    @foreach ($unitsForSelect as $label => $value)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </x-input.select>

                <x-input.currency name="detailInvoice.subtotal_invoice" label="Subtotal Invoice"
                    wire:model="detailInvoice.subtotal_invoice"></x-input.currency>

                @role('super-admin|manager')
                    <x-input.select name="detailInvoice.status" label="Status" wire:model="detailInvoice.status">
                        <option value="1" {{ $selected == '1' ? 'selected' : '' }}>process</option>
                        <option value="2" {{ $selected == '2' ? 'selected' : '' }}>done</option>
                        <option value="3" {{ $selected == '3' ? 'selected' : '' }}>no need</option>
                    </x-input.select>
                @endrole

            </div>
        </div>

        <div class="flex justify-between px-6 py-4 bg-gray-50">
            <x-buttons.secondary wire:click="$toggle('showingModal')">Cancel</x-buttons.secondary>
            <x-jet-button wire:click="save">Save</x-jet-button>
        </div>
    </x-modal>

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
            <div class="flex flex-wrap justify-between mt-1">
                <div class="mt-1 md:w-1/3">

                </div>
            </div>
        </x-slot>
    </x-tables.topbar>

    <x-tables.card>
        <x-table>
            <x-slot name="head">
                <tr>
                    <x-tables.th-left>
                        Product
                    </x-tables.th-left>
                    <x-tables.th-left-hide>
                        Store
                    </x-tables.th-left-hide>
                    <x-tables.th-left-hide>
                        Supplier
                    </x-tables.th-left-hide>
                    <x-tables.th-left-hide>
                        Created By
                    </x-tables.th-left-hide>
                    <x-tables.th-left-hide>
                        Date
                    </x-tables.th-left-hide>
                    <x-tables.th-left-hide>
                        Qty Product
                    </x-tables.th-left-hide>
                    <x-tables.th-left-hide>
                        Unit Price
                    </x-tables.th-left-hide>
                    <x-tables.th-left-hide>
                        @lang('crud.invoice_purchase_detail_invoices.inputs.subtotal_invoice')
                    </x-tables.th-left-hide>
                    <th></th>
                </tr>
            </x-slot>
            <x-slot name="body">
                @foreach ($detailInvoices as $detailInvoice)
                    <tr class="hover:bg-gray-100">
                        <x-tables.td-left-hide>
                            {{ optional($detailInvoice->detailRequest)->product->name ?? '-' }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            {{ optional($detailInvoice->invoicePurchase)->store->nickname ?? '-' }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            {{ optional($detailInvoice->invoicePurchase)->supplier->name ?? '-' }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            {{ $detailInvoice->invoicePurchase->created_by->name }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            {{ $detailInvoice->invoicePurchase->date->toFormattedDate() }}
                        </x-tables.td-left-hide>
                        <x-tables.td-right-hide>
                            {{ $detailInvoice->quantity_product ?? '-' }}
                            {{ $detailInvoice->detailRequest->product->unit->unit }}
                        </x-tables.td-right-hide>
                        <x-tables.td-right-hide>
                            @if ($detailInvoice->quantity_product != null)
                                @currency($detailInvoice->subtotal_invoice / $detailInvoice->quantity_product)
                            @else
                                -
                            @endif
                        </x-tables.td-right-hide>
                        <x-tables.td-right-hide>
                            @currency($detailInvoice->subtotal_invoice)
                        </x-tables.td-right-hide>
                        <td class="px-4 py-3 text-right" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @can('update', $detailInvoice)
                                    {{-- <button type="button" class="button"
                                        wire:click="editDetailInvoice({{ $detailInvoice->id }})">
                                        <i class="icon ion-md-create"></i>
                                    </button> --}}
                                    <button type="button" class="w-4 mr-2 transform hover:text-yellow-500 hover:scale-110"
                                        wire:click="editDetailInvoice({{ $detailInvoice->id }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </button>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-slot>
            <x-slot name="foot">
                <tr>
                    <td colspan="7">
                        <div class="px-4 mt-10">
                            {{ $detailInvoices->render() }}
                        </div>
                    </td>
                </tr>
            </x-slot>
        </x-table>
    </x-tables.card>
</div>
