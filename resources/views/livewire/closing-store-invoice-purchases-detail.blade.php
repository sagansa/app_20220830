<div>
    <div>
        @if ($closingStore->transfer_status != 2 || $closingStore->closing_status != 2)
            @can('create', App\Models\InvoicePurchase::class)
                <button class="button" wire:click="newInvoicePurchase">
                    <i class="mr-1 icon ion-md-add text-primary"></i>
                    @lang('crud.common.attach')
                </button>
            @endcan
        @endif
    </div>

    <x-modal wire:model="showingModal">
        <div class="px-6 py-4">
            <div class="text-lg font-bold">{{ $modalTitle }}</div>

            <div class="mt-1 sm:space-y-5">

                <x-input.select name="invoice_purchase_id" label="Invoice Purchase" wire:model="invoice_purchase_id">
                    <option value="null" disabled>-- select --</option>
                    @foreach ($invoicePurchasesForSelect as $value => $label)
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
                    {{-- <th class="px-4 py-3 text-left">
                        @lang('crud.closing_store_invoice_purchases.inputs.invoice_purchase_id')
                    </th> --}}
                    <x-tables.th-left>
                        Store
                    </x-tables.th-left>
                    <x-tables.th-left>
                        Date
                    </x-tables.th-left>
                    <x-tables.th-left>
                        Supplier
                    </x-tables.th-left>
                    <x-tables.th-left>
                        Discounts - Taxes
                    </x-tables.th-left>
                    <x-tables.th-left>
                        Detail Order
                    </x-tables.th-left>
                    <x-tables.th-left>
                        Subtotal
                    </x-tables.th-left>
                    <th></th>
                </tr>
            </x-slot>
            <x-slot name="body">
                @foreach ($closingStoreInvoicePurchases as $invoicePurchase)
                    <tr class="hover:bg-gray-100">
                        <x-tables.td-left>
                            {{ $invoicePurchase->store->nickname ?? '-' }}
                        </x-tables.td-left>
                        <x-tables.td-left>
                            {{ $invoicePurchase->date->toFormattedDate() ?? '-' }}
                        </x-tables.td-left>
                        <x-tables.td-left>
                            {{ $invoicePurchase->supplier->name ?? '-' }}
                        </x-tables.td-left>
                        <x-tables.td-right>
                            <p>discounts: @currency($invoicePurchase->discounts)</p>
                            <p>taxes: @currency($invoicePurchase->taxes)</p>
                        </x-tables.td-right>
                        <x-tables.td-right>
                            @foreach ($invoicePurchase->detailInvoices as $detailInvoice)
                                <p>{{ $detailInvoice->detailRequest->product->name }}</p>
                            @endforeach
                        </x-tables.td-right>
                        <x-tables.td-right>
                            @foreach ($invoicePurchase->detailInvoices as $detailInvoice)
                                <p>@currency($detailInvoice->subtotal_invoice)</p>
                            @endforeach
                        </x-tables.td-right>
                        <td class="px-4 py-3 text-right" style="width: 70px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @if ($closingStore->transfer_status != '2' || $closingStore->closing_status != '2')
                                    {{-- @can('delete-any', App\Models\InvoicePurchase::class) --}}
                                    <button class="button button-danger"
                                        onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                                        wire:click="detach({{ $invoicePurchase->id }})">
                                        <i class="mr-1 icon ion-md-trash text-primary"></i>
                                    </button>
                                    {{-- @endcan --}}
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-slot>
            <x-slot name="foot">
                <tr>
                    <th scope="row" colspan="5"
                        class="pt-1 pl-6 pr-3 text-xs font-semibold text-right text-gray-900 sm:table-cell md:pl-0">
                        Totals</th>

                    <td class="relative py-2 pl-3 pr-4 text-xs font-semibold text-right text-gray-500 sm:pr-6">
                        @currency($this->totals)
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class="px-4 mt-10">
                            {{ $closingStoreInvoicePurchases->render() }}
                        </div>
                    </td>
                </tr>
            </x-slot>
        </x-table>
    </x-tables.card-overflow>
</div>
