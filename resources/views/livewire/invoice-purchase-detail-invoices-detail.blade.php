<div>
    <div>
        @if ($invoicePurchase->payment_status != 2 || $invoicePurchase->order_status != 2)
            @can('create', App\Models\DetailInvoice::class)
                <button class="button" wire:click="newDetailInvoice">
                    <i class="mr-1 icon ion-md-add text-primary"></i>
                    @lang('crud.common.new')
                </button>
                @endcan @can('delete-any', App\Models\DetailInvoice::class)
                <button class="button button-danger" {{ empty($selected) ? 'disabled' : '' }}
                    onclick="confirm('Are you sure?') || event.stopImmediatePropagation()" wire:click="destroySelected">
                    <i class="mr-1 icon ion-md-trash text-primary"></i>
                    @lang('crud.common.delete_selected')
                </button>
            @endcan
        @endif
    </div>

    <x-modal wire:model="showingModal">
        <div class="px-6 py-4">
            <div class="text-lg font-bold">{{ $modalTitle }}</div>

            <div class="mt-1 sm:space-y-5">

                <x-input.select name="detailInvoice.detail_request_id" label="Detail Request"
                    wire:model="detailInvoice.detail_request_id">
                    <option value="null" disabled>-- select --</option>
                    @foreach ($detailRequestsForSelect as $label => $value)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </x-input.select>

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

                @role('staff|supervisor')
                    <x-input.select name="detailInvoice.status" label="Status" wire:model="detailInvoice.status">
                        @if ($detailInvoice->product_id == null)
                            <option value="" {{ $selected == '1' ? 'selected' : '' }}></option>
                        @elseif ($detailInvoice->invoicePurchase->product->material_group_id == 3)
                            <option value="1" {{ $selected == '1' ? 'selected' : '' }}>process</option>
                        @elseif ($detailInvoice->invoicePurchase > product->material_group_id != 3)
                            <option value="3" {{ $selected == '3' ? 'selected' : '' }}>no need</option>
                        @endif
                    </x-input.select>
                @endrole
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
                        <input type="checkbox" wire:model="allSelected" wire:click="toggleFullSelection"
                            title="{{ trans('crud.common.select_all') }}" />
                    </x-tables.th-left>
                    <x-tables.th-left>
                        @lang('crud.invoice_purchase_detail_invoices.inputs.detail_request_id')
                    </x-tables.th-left>
                    <x-tables.th-left>
                        Quantity
                    </x-tables.th-left>
                    <x-tables.th-left>
                        Unit Price
                    </x-tables.th-left>
                    {{-- <x-tables.th-left>
                        @lang('crud.invoice_purchase_detail_invoices.inputs.quantity_product')
                    </x-tables.th-left> --}}
                    {{-- <x-tables.th-left>
                        @lang('crud.invoice_purchase_detail_invoices.inputs.quantity_invoice')
                    </x-tables.th-left> --}}
                    {{-- <x-tables.th-left>
                        @lang('crud.invoice_purchase_detail_invoices.inputs.unit_invoice_id')
                    </x-tables.th-left> --}}
                    <x-tables.th-left>
                        @lang('crud.invoice_purchase_detail_invoices.inputs.subtotal_invoice')
                    </x-tables.th-left>
                    {{-- <x-tables.th-left>
                        @lang('crud.invoice_purchase_detail_invoices.inputs.status')
                    </x-tables.th-left> --}}
                    <th></th>
                </tr>
            </x-slot>
            <x-slot name="body">
                @foreach ($detailInvoices as $detailInvoice)
                    <tr class="hover:bg-gray-100">
                        <x-tables.td-left>
                            <input type="checkbox" value="{{ $detailInvoice->id }}" wire:model="selected" />
                        </x-tables.td-left>
                        <x-tables.td-left>
                            @if ($detailInvoice->detailRequest->product->payment_type_id != $this->invoicePurchase->payment_type_id)
                                <x-spans.text-red>{{ optional($detailInvoice->detailRequest)->product->name ?? '-' }}
                                </x-spans.text-red>
                            @elseif ($detailInvoice->detailRequest->product->payment_type_id == $this->invoicePurchase->payment_type_id)
                                <x-spans.text-black>{{ optional($detailInvoice->detailRequest)->product->name ?? '-' }}
                                </x-spans.text-black>
                            @endif


                        </x-tables.td-left>
                        <x-tables.td-right>
                            <p>Prod: {{ $detailInvoice->quantity_product ?? '-' }}
                                {{ $detailInvoice->detailRequest->product->unit->unit }}</p>
                            <p>Inv: {{ $detailInvoice->quantity_invoice ?? '-' }}
                                {{ $detailInvoice->unit->unit ?? '-' }}</p>
                        </x-tables.td-right>

                        <x-tables.td-right>
                            @currency($detailInvoice->subtotal_invoice - $detailInvoice->quantity_product)
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
                    <x-tables.th-total colspan="4">Subtotals</x-tables.th-total>
                    <x-tables.td-total> @currency($detailInvoices->sum('subtotal_invoice'))</x-tables.td-total>
                </tr>
                <tr>
                    <x-tables.th-total colspan="4">Discounts</x-tables.th-total>
                    @if ($invoicePurchase->payment_status != 2 || $invoicePurchase->order_status != 2)
                        <x-input.wire-currency name="discounts" wiresubmit="updateInvoicePurchase"
                            wiremodel="state.discounts"></x-input.wire-currency>
                    @else
                        <x-tables.td-total>@currency($this->invoicePurchase->discounts)</x-tables.td-total>
                    @endif
                </tr>
                <tr>
                    <x-tables.th-total colspan="4">Taxes</x-tables.th-total>
                    @if ($invoicePurchase->payment_status != 2 || $invoicePurchase->order_status != 2)
                        <x-input.wire-currency name="taxes" wiresubmit="updatePurchaseOrder" wiremodel="state.taxes">
                        </x-input.wire-currency>
                    @else
                        <x-tables.td-total>@currency($this->invoicePurchase->taxes)</x-tables.td-total>
                    @endif
                </tr>
                <tr>
                    <x-tables.th-total colspan="4">Totals</x-tables.th-total>
                    <x-tables.td-total>@currency($this->invoicePurchase->totals)</x-tables.td-total>
                </tr>
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
