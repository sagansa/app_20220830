<div>
    <div>
        @can('create', App\Models\ProductionTo::class)
            <button class="button" wire:click="newProductionTo">
                <i class="mr-1 icon ion-md-add text-primary"></i>
                @lang('crud.common.new')
            </button>
            @endcan @can('delete-any', App\Models\ProductionTo::class)
            <button class="button button-danger" {{ empty($selected) ? 'disabled' : '' }}
                onclick="confirm('Are you sure?') || event.stopImmediatePropagation()" wire:click="destroySelected">
                <i class="mr-1 icon ion-md-trash text-primary"></i>
                @lang('crud.common.delete_selected')
            </button>
        @endcan
    </div>

    <x-modal wire:model="showingModal">
        <div class="px-6 py-4">
            <div class="text-lg font-bold">{{ $modalTitle }}</div>

            <div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">

                <x-input.select name="productionTo.product_id" label="Product" wire:model="productionTo.product_id">
                    <option value="null" disabled>-- select --</option>
                    @foreach ($productsForSelect as $label => $value)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </x-input.select>

                <x-input.number name="productionTo.quantity" label="Quantity" wire:model="productionTo.quantity">
                </x-input.number>

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
                        @lang('crud.production_production_tos.inputs.product_id')
                    </x-tables.th-left>
                    <x-tables.th-left>
                        @lang('crud.production_production_tos.inputs.quantity')
                    </x-tables.th-left>
                    <th></th>
                </tr>
            </x-slot>
            <x-slot name="body">
                @foreach ($productionTos as $productionTo)
                    <tr class="hover:bg-gray-100">
                        <x-tables.td-left>
                            <input type="checkbox" value="{{ $productionTo->id }}" wire:model="selected" />
                        </x-tables.td-left>
                        <x-tables.td-left>
                            {{ optional($productionTo->product)->name ?? '-' }}
                        </x-tables.td-left>
                        <x-tables.td-left>
                            {{ $productionTo->quantity ?? '-' }} {{ $productionTo->product->unit->unit }}
                        </x-tables.td-left>
                        <td class="px-4 py-3 text-right" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @can('update', $productionTo)
                                    <button type="button" class="button"
                                        wire:click="editProductionTo({{ $productionTo->id }})">
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
                    <td colspan="3">
                        <div class="px-4 mt-10">
                            {{ $productionTos->render() }}
                        </div>
                    </td>
                </tr>
            </x-slot>
        </x-table>
    </x-tables.card-overflow>
</div>
