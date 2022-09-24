<div>
    <div>
        @role('super-admin|manager')
            @can('create', App\Models\InvoicePurchase::class)
                <button class="button" wire:click="newInvoicePurchase">
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

                <x-input.select name="invoice_purchase_id" label="Invoice Purchase" wire:model="invoice_purchase_id">
                    <option value="null" disabled>-- select --</option>
                    @foreach ($invoicePurchasesForSelect as $label => $value)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </x-input.select>

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
                        Date
                    </x-tables.th-left>
                    <x-tables.th-left>
                        Supplier
                    </x-tables.th-left>
                    <x-tables.th-left>
                        Store
                    </x-tables.th-left>
                    <x-tables.th-left>
                        Discounts - Taxes
                    </x-tables.th-left>
                    <x-tables.th-left>
                        Detail Order
                    </x-tables.th-left>
                    <x-tables.th-left>
                        Totals
                    </x-tables.th-left>
                    @role('super-admin|manager')
                        <x-tables.th-left>
                            Payment Status
                        </x-tables.th-left>
                    @endrole
                    <th></th>
                </tr>
            </x-slot>
            <x-slot name="body">
                @foreach ($paymentReceiptInvoicePurchases as $invoicePurchase)
                    <tr class="hover:bg-gray-100">
                        <x-tables.td-left>
                            {{ $invoicePurchase->date->toFormattedDate() ?? '-' }}
                        </x-tables.td-left>
                        <x-tables.td-left>
                            <p class="text-right sm:text-left">
                                {{ optional($invoicePurchase->supplier)->bank_account_name ?? '-' }}
                            </p>
                            <p class="text-right sm:text-left">{{ optional($invoicePurchase->supplier)->name ?? '-' }}
                            </p>
                            <p class="text-right sm:text-left">
                                {{ optional($invoicePurchase->supplier)->bank->name ?? '-' }}</p>
                            <p class="text-right sm:text-left">
                                {{ optional($invoicePurchase->supplier)->bank_account_no ?? '-' }}
                            </p>
                        </x-tables.td-left>
                        <x-tables.td-left>
                            {{ $invoicePurchase->store->nickname ?? '-' }}
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
                            @currency($invoicePurchase->detailInvoices->sum('subtotal_invoice') - $invoicePurchase->discounts + $invoicePurchase->taxes)
                        </x-tables.td-right>
                        @role('super-admin|manager')
                            <x-tables.td-left>
                                <select
                                    class="block w-full py-2 pl-3 pr-10 mt-1 text-xs border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                    wire:change="changePaymentStatus({{ $invoicePurchase }}, $event.target.value)">
                                    <option value="1" {{ $invoicePurchase->payment_status == '1' ? 'selected' : '' }}>
                                        Belum Dibayar</option>
                                    <option value="2" {{ $invoicePurchase->payment_status == '2' ? 'selected' : '' }}>
                                        Sudah Dibayar</option>
                                </select>
                            </x-tables.td-left>
                        @endrole
                        <td class="px-4 py-3 text-right" style="width: 70px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @role('super-admin|manager')
                                    @can('delete-any', App\Models\InvoicePurchase::class)
                                        <button class="button button-danger"
                                            onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                                            wire:click="detach({{ $invoicePurchase->id }})">
                                            <i class="icon ion-md-trash text-primary"></i>

                                        </button>
                                    @endcan
                                @endrole
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-slot>
            <x-slot name="foot">
                @role('super-admin|manager')
                    <tr>
                        <x-tables.th-total colspan="5">Total Invoice</x-tables.th-total>
                        <x-tables.td-total>{{ $this->totals }}
                        </x-tables.td-total>
                    </tr>
                    <tr>
                        <x-tables.th-total colspan="5">Amount</x-tables.th-total>
                        @role('supervisor|manager|staff')
                            <x-tables.td-total>@currency($this->purchaseReceipt->nominal_transfer)</x-tables.td-total>
                        @endrole
                        @role('super-admin')
                            <x-input.wire-currency name="amount" wiresubmit="updatePaymentReceipt" wiremodel="state.amount">
                            </x-input.wire-currency>
                        @endrole
                    </tr>
                    <tr>
                        <x-tables.th-total colspan="5">Difference</x-tables.th-total>
                        <x-tables.td-total>
                            @if ($this->difference < 0)
                                <x-spans.text-red>@currency($this->difference) </x-spans.text-red>
                            @else
                                <x-spans.text-green>@currency($this->difference) </x-spans.text-green>
                            @endif
                        </x-tables.td-total>
                    </tr>
                @endrole
                <tr>
                    <td colspan="2">
                        <div class="px-4 mt-10">
                            {{ $paymentReceiptInvoicePurchases->render() }}
                        </div>
                    </td>
                </tr>
            </x-slot>
        </x-table>
    </x-tables.card-overflow>
</div>
