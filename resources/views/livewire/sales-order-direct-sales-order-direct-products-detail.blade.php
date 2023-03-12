<div>
    <div>
        @role('super-admin|manager')
            @if ($salesOrderDirect->payment_status != 2 || $salesOrderDirect->delivery_status != 5)
                @can('create', App\Models\SalesOrderDirectProduct::class)
                    <button class="button" wire:click="newSalesOrderDirectProduct">
                        <i class="mr-1 icon ion-md-add text-primary"></i>
                        @lang('crud.common.new')
                    </button>
                    @endcan @can('delete-any', App\Models\SalesOrderDirectProduct::class)
                    <button class="button button-danger" {{ empty($selected) ? 'disabled' : '' }}
                        onclick="confirm('Are you sure?') || event.stopImmediatePropagation()" wire:click="destroySelected">
                        <i class="mr-1 icon ion-md-trash text-primary"></i>
                        @lang('crud.common.delete_selected')
                    </button>
                @endcan
            @endif
            @elserole('customer')
            @if ($salesOrderDirect->payment_status != 2)
                @can('create', App\Models\SalesOrderDirectProduct::class)
                    <button class="button" wire:click="newSalesOrderDirectProduct">
                        <i class="mr-1 icon ion-md-add text-primary"></i>
                        @lang('crud.common.new')
                    </button>
                    @endcan @can('delete-any', App\Models\SalesOrderDirectProduct::class)
                    <button class="button button-danger" {{ empty($selected) ? 'disabled' : '' }}
                        onclick="confirm('Are you sure?') || event.stopImmediatePropagation()" wire:click="destroySelected">
                        <i class="mr-1 icon ion-md-trash text-primary"></i>
                        @lang('crud.common.delete_selected')
                    </button>
                @endcan
            @endif
        @endrole
    </div>

    <x-modal wire:model="showingModal">
        <div class="px-6 py-4">
            <div class="text-lg font-bold">{{ $modalTitle }}</div>

            <div class="mt-1 sm:space-y-5">

                <x-input.select name="salesOrderDirectProduct.e_product_id" label="E Product"
                    wire:model="salesOrderDirectProduct.e_product_id">
                    <option value="null" disabled>-- select --</option>
                    @foreach ($eProductsForSelect as $label => $value)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </x-input.select>

                <x-input.number name="salesOrderDirectProduct.quantity" label="Quantity"
                    wire:model="salesOrderDirectProduct.quantity"></x-input.number>

                <x-input.number name="salesOrderDirectProduct.price" label="Price"
                    wire:model="salesOrderDirectProduct.price"></x-input.number>

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
                    @role('super-admin|manager|customer')
                        @if ($salesOrderDirect->payment_status != 2 || $salesOrderDirect->delivery_status != 5)
                            <x-tables.th-left>
                                <input type="checkbox" wire:model="allSelected" wire:click="toggleFullSelection"
                                    title="{{ trans('crud.common.select_all') }}" />
                            </x-tables.th-left>
                        @endif
                        @elserole('customer')
                        @if ($salesOrderDirect->payment_status != 2)
                            <x-tables.th-left>
                                <input type="checkbox" wire:model="allSelected" wire:click="toggleFullSelection"
                                    title="{{ trans('crud.common.select_all') }}" />
                            </x-tables.th-left>
                        @endif
                    @endrole
                    <x-tables.th-left>
                        {{-- @lang('crud.sales_order_direct_sales_order_direct_products.inputs.e_product_id') --}} Product
                    </x-tables.th-left>
                    <x-tables.th-left>
                        @lang('crud.sales_order_direct_sales_order_direct_products.inputs.quantity')
                    </x-tables.th-left>
                    @role('super-admin|manaager|customer')
                        <x-tables.th-left>
                            @lang('crud.sales_order_direct_sales_order_direct_products.inputs.price')
                        </x-tables.th-left>
                        <x-tables.th-left>
                            @lang('crud.sales_order_direct_sales_order_direct_products.inputs.amount')
                        </x-tables.th-left>
                        <th></th>
                    @endrole
                </tr>
            </x-slot>
            <x-slot name="body">
                @foreach ($salesOrderDirectProducts as $salesOrderDirectProduct)
                    <tr class="hover:bg-gray-100">
                        @role('super-admin|manager|customer')
                            @if ($salesOrderDirect->payment_status != 2 || $salesOrderDirect->delivery_status != 5)
                                <x-tables.td-left>
                                    <input type="checkbox" value="{{ $salesOrderDirectProduct->id }}"
                                        wire:model="selected" />
                                </x-tables.td-left>
                            @endif
                            @elserole('customer')
                            @if ($salesOrderDirect->payment_status != 2)
                                <x-tables.td-left>
                                    <input type="checkbox" value="{{ $salesOrderDirectProduct->id }}"
                                        wire:model="selected" />
                                </x-tables.td-left>
                            @endif
                        @endrole
                        <x-tables.td-left>
                            {{ optional($salesOrderDirectProduct->eProduct)->product->name ?? '-' }}
                        </x-tables.td-left>
                        <x-tables.td-right>
                            {{ $salesOrderDirectProduct->quantity ?? '-' }}
                            {{ $salesOrderDirectProduct->eProduct->product->unit->unit }}
                        </x-tables.td-right>
                        @role('super-admin|manager|customer')
                            <x-tables.td-right>
                                @currency($salesOrderDirectProduct->price)
                            </x-tables.td-right>
                            <x-tables.td-right>
                                @currency($salesOrderDirectProduct->quantity * $salesOrderDirectProduct->price)
                            </x-tables.td-right>
                        @endrole
                        @role('super-admin|manager')
                            @if ($salesOrderDirect->payment_status != 2 || $salesOrderDirect->delivery_status != 5)
                                <td class="px-4 py-3 text-right" style="width: 134px;">
                                    <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                        @can('update', $salesOrderDirectProduct)
                                            <button type="button" class="button"
                                                wire:click="editSalesOrderDirectProduct({{ $salesOrderDirectProduct->id }})">
                                                <i class="icon ion-md-create"></i>
                                            </button>
                                        @endcan
                                    </div>
                                </td>
                            @endif @elserole('customer')
                            @if ($salesOrderDirect->payment_status != 2)
                                <td class="px-4 py-3 text-right" style="width: 134px;">
                                    <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                        @can('update', $salesOrderDirectProduct)
                                            <button type="button" class="button"
                                                wire:click="editSalesOrderDirectProduct({{ $salesOrderDirectProduct->id }})">
                                                <i class="icon ion-md-create"></i>
                                            </button>
                                        @endcan
                                    </div>
                                </td>
                            @endif
                        @endrole
                    </tr>
                @endforeach
            </x-slot>
            <x-slot name="foot">
                @role('super-admin|manager|customer')
                    <tr>
                        <x-tables.th-total colspan="3">Subtotals</x-tables.th-total>
                        <x-tables.td-total>@currency($salesOrderDirectProducts->sum('amount'))</x-tables.td-total>
                    </tr>
                    <tr>
                        <x-tables.th-total colspan="3">Shipping Cost</x-tables.th-total>
                        @role('super-admin|manager')
                            @if ($salesOrderDirect->payment_status != 2 || $salesOrderDirect->delivery_status != 5)
                                <x-input.wire-currency name="shipping_cost" wiresubmit="updateOrder"
                                    wiremodel="state.shipping_cost"></x-input.wire-currency>
                            @else
                                <x-tables.td-total> @currency($this->salesOrderDirect->shipping_cost)</x-tables.td-total>
                            @endif
                            @elserole('customer|storage-staff')
                            <x-tables.td-total> @currency($this->salesOrderDirect->shipping_cost)</x-tables.td-total>
                        @endrole
                    </tr>
                    <tr>
                        <x-tables.th-total colspan="3">Totals</x-tables.th-total>
                        <x-tables.td-total> @currency($this->salesOrderDirect->totals)</x-tables.td-total>
                    </tr>
                @endrole
                <tr>
                    <td colspan="3">
                        <div class="px-4 mt-10">
                            {{ $salesOrderDirectProducts->render() }}
                        </div>
                    </td>
                </tr>
            </x-slot>
        </x-table>
    </x-tables.card-overflow>
</div>
