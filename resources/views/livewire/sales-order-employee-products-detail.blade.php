<div>
    <div>
        @if ($salesOrderEmployee->status != 2)
            @can('create', App\Models\Product::class)
                <button class="button" wire:click="newProduct">
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
                <x-input.select name="product_id" label="Product" wire:model="product_id">
                    <option value="null" disabled>-- select --</option>
                    @foreach ($productsForSelect as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </x-input.select>

                <x-input.number name="quantity" label="Quantity" wire:model="quantity"></x-input.number>

                <x-input.number name="unit_price" label="Unit Price" wire:model="unit_price"></x-input.number>
            </div>

        </div>

        <div class="flex justify-between px-6 py-4 bg-gray-50">
            <x-buttons.secondary wire:click="$toggle('showingModal')"> @lang('crud.common.cancel')</x-buttons.secondary>
            <x-jet-button wire:click="save"> @lang('crud.common.save')</x-jet-button>
        </div>
    </x-modal>

    <x-tables.card-overflow>
        <x-table>
            <x-slot name="head">
                <tr>
                    <x-tables.th-left>
                        @lang('crud.sales_order_employee_products.inputs.product_id')
                    </x-tables.th-left>
                    <x-tables.th-left>
                        @lang('crud.sales_order_employee_products.inputs.quantity')
                    </x-tables.th-left>
                    <x-tables.th-left>
                        @lang('crud.sales_order_employee_products.inputs.unit_price')
                    </x-tables.th-left>
                    <th></th>
                </tr>
            </x-slot>
            <x-slot name="body">
                @foreach ($salesOrderEmployeeProducts as $product)
                    <tr class="hover:bg-gray-100">
                        <x-tables.td-left>
                            {{ $product->name ?? '-' }}
                        </x-tables.td-left>
                        <x-tables.td-left>
                            {{ $product->pivot->quantity ?? '-' }} {{ $product->unit->unit }}
                        </x-tables.td-left>
                        <x-tables.td-left>
                            @currency($product->pivot->unit_price)
                        </x-tables.td-left>
                        <td class="px-4 py-3 text-right" style="width: 70px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @if ($salesOrderEmployee->status != 2)
                                    @can('delete-any', App\Models\Product::class)
                                        <button class="button button-danger"
                                            onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                                            wire:click="detach({{ $product->id }})">
                                            <i class="icon ion-md-trash text-primary"></i>

                                        </button>
                                    @endcan
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-slot>
            <x-slot name="foot">
                <tr>
                    <td colspan="4">
                        <div class="px-4 mt-10">
                            {{ $salesOrderEmployeeProducts->render() }}
                        </div>
                    </td>
                </tr>
            </x-slot>
        </x-table>
    </x-tables.card-overflow>
</div>
