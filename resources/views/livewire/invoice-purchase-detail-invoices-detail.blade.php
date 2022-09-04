<div>
    <div>
        @can('create', App\Models\DetailInvoice::class)
        <button class="button" wire:click="newDetailInvoice">
            <i class="mr-1 icon ion-md-add text-primary"></i>
            @lang('crud.common.new')
        </button>
        @endcan @can('delete-any', App\Models\DetailInvoice::class)
        <button
            class="button button-danger"
             {{ empty($selected) ? 'disabled' : '' }} 
            onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
            wire:click="destroySelected"
        >
            <i class="mr-1 icon ion-md-trash text-primary"></i>
            @lang('crud.common.delete_selected')
        </button>
        @endcan
    </div>

    <x-modal wire:model="showingModal">
        <div class="px-6 py-4">
            <div class="text-lg font-bold">{{ $modalTitle }}</div>

            <div class="mt-5">
                <div>
                    <x-input.select
                        name="detailInvoice.detail_request_id"
                        label="Detail Request"
                        wire:model="detailInvoice.detail_request_id"
                    >
                        <option value="null" disabled>-- select --</option>
                        @foreach($detailRequestsForSelect as $value => $label)
                        <option value="{{ $value }}"  >{{ $label }}</option>
                        @endforeach
                    </x-input.select>

                    <x-input.number
                        name="detailInvoice.quantity_product"
                        label="Quantity Product"
                        wire:model="detailInvoice.quantity_product"
                        max="255"
                        step="0.01"
                        placeholder="Quantity Product"
                    ></x-input.number>

                    <x-input.number
                        name="detailInvoice.quantity_invoice"
                        label="Quantity Invoice"
                        wire:model="detailInvoice.quantity_invoice"
                        max="255"
                        step="0.01"
                        placeholder="Quantity Invoice"
                    ></x-input.number>

                    <x-input.select
                        name="detailInvoice.unit_invoice_id"
                        label="Unit Invoice"
                        wire:model="detailInvoice.unit_invoice_id"
                    >
                        <option value="null" disabled>-- select --</option>
                        @foreach($unitsForSelect as $value => $label)
                        <option value="{{ $value }}"  >{{ $label }}</option>
                        @endforeach
                    </x-input.select>

                    <x-input.number
                        name="detailInvoice.subtotal_invoice"
                        label="Subtotal Invoice"
                        wire:model="detailInvoice.subtotal_invoice"
                    ></x-input.number>

                    <x-input.select
                        name="detailInvoice.status"
                        label="Status"
                        wire:model="detailInvoice.status"
                    >
                        <option value="1" {{ $selected == '1' ? 'selected' : '' }} >process</option>
                        <option value="2" {{ $selected == '2' ? 'selected' : '' }} >done</option>
                        <option value="3" {{ $selected == '3' ? 'selected' : '' }} >no need</option>
                    </x-input.select>
                </div>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 flex justify-between">
            <button
                type="button"
                class="button"
                wire:click="$toggle('showingModal')"
            >
                <i class="mr-1 icon ion-md-close"></i>
                @lang('crud.common.cancel')
            </button>

            <button
                type="button"
                class="button button-primary"
                wire:click="save"
            >
                <i class="mr-1 icon ion-md-save"></i>
                @lang('crud.common.save')
            </button>
        </div>
    </x-modal>

    <div class="block w-full overflow-auto scrolling-touch mt-4">
        <table class="w-full max-w-full mb-4 bg-transparent">
            <thead class="text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left w-1">
                        <input
                            type="checkbox"
                            wire:model="allSelected"
                            wire:click="toggleFullSelection"
                            title="{{ trans('crud.common.select_all') }}"
                        />
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.invoice_purchase_detail_invoices.inputs.detail_request_id')
                    </th>
                    <th class="px-4 py-3 text-right">
                        @lang('crud.invoice_purchase_detail_invoices.inputs.quantity_product')
                    </th>
                    <th class="px-4 py-3 text-right">
                        @lang('crud.invoice_purchase_detail_invoices.inputs.quantity_invoice')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.invoice_purchase_detail_invoices.inputs.unit_invoice_id')
                    </th>
                    <th class="px-4 py-3 text-right">
                        @lang('crud.invoice_purchase_detail_invoices.inputs.subtotal_invoice')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.invoice_purchase_detail_invoices.inputs.status')
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @foreach ($detailInvoices as $detailInvoice)
                <tr class="hover:bg-gray-100">
                    <td class="px-4 py-3 text-left">
                        <input
                            type="checkbox"
                            value="{{ $detailInvoice->id }}"
                            wire:model="selected"
                        />
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ optional($detailInvoice->detailRequest)->notes ?? '-'
                        }}
                    </td>
                    <td class="px-4 py-3 text-right">
                        {{ $detailInvoice->quantity_product ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right">
                        {{ $detailInvoice->quantity_invoice ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ optional($detailInvoice->unit_invoice)->name ?? '-'
                        }}
                    </td>
                    <td class="px-4 py-3 text-right">
                        {{ $detailInvoice->subtotal_invoice ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $detailInvoice->status ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right" style="width: 134px;">
                        <div
                            role="group"
                            aria-label="Row Actions"
                            class="relative inline-flex align-middle"
                        >
                            @can('update', $detailInvoice)
                            <button
                                type="button"
                                class="button"
                                wire:click="editDetailInvoice({{ $detailInvoice->id }})"
                            >
                                <i class="icon ion-md-create"></i>
                            </button>
                            @endcan
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="7">
                        <div class="mt-10 px-4">
                            {{ $detailInvoices->render() }}
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
