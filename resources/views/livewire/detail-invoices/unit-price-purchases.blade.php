<div>
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

    <x-tables.card-overflow>
        <x-table>
            <x-slot name="head">
                <tr>
                    <x-tables.th-left>
                        Product
                    </x-tables.th-left>
                    <x-tables.th-left>
                        Store
                    </x-tables.th-left>
                    <x-tables.th-left>
                        Created By
                    </x-tables.th-left>
                    <x-tables.th-left>
                        Date
                    </x-tables.th-left>
                    <x-tables.th-left>
                        Quantity Invoice
                    </x-tables.th-left>
                    <x-tables.th-left>
                        Quantity Product
                    </x-tables.th-left>
                    <x-tables.th-left>
                        Unit Price
                    </x-tables.th-left>
                    <x-tables.th-left>
                        @lang('crud.invoice_purchase_detail_invoices.inputs.subtotal_invoice')
                    </x-tables.th-left>
                    <th></th>
                </tr>
            </x-slot>
            <x-slot name="body">
                @foreach ($detailInvoices as $detailInvoice)
                    <tr class="hover:bg-gray-100">
                        <x-tables.td-left>
                            {{ optional($detailInvoice->detailRequest)->product->name ?? '-' }}
                        </x-tables.td-left>
                        <x-tables.td-left>
                            {{ optional($detailInvoice->invoicePurchase)->store->nickname ?? '-' }}
                        </x-tables.td-left>
                        <x-tables.td-left>
                            {{ $detailInvoice->invoicePurchase->created_by->name }}
                        </x-tables.td-left>
                        <x-tables.td-left>
                            {{ $detailInvoice->invoicePurchase->date->toFormattedDate() }}
                        </x-tables.td-left>
                        <x-tables.td-right>
                            {{ $detailInvoice->quantity_product ?? '-' }}
                            {{ $detailInvoice->detailRequest->product->unit->unit }}
                        </x-tables.td-right>
                        <x-tables.td-right>
                            {{ $detailInvoice->quantity_invoice ?? '-' }}
                            {{ $detailInvoice->detailRequest->product->unit->unit ?? '-' }}
                        </x-tables.td-right>
                        <x-tables.td-right>
                            @if ($detailInvoice->quantity_product != null)
                                @currency($detailInvoice->subtotal_invoice / $detailInvoice->quantity_product)
                            @else
                                -
                            @endif
                        </x-tables.td-right>
                        <x-tables.td-right>
                            @currency($detailInvoice->subtotal_invoice)
                        </x-tables.td-right>
                        <td class="px-4 py-3 text-right" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @can('update', $detailInvoice)
                                    <button type="button" class="button"
                                        wire:click="editDetailInvoice({{ $detailInvoice->id }})">
                                        <i class="icon ion-md-create"></i>
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
    </x-tables.card-overflow>
</div>
