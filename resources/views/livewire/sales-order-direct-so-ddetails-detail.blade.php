<div>
    <div>
        @can('create', App\Models\SoDdetail::class)
        <button class="button" wire:click="newSoDdetail">
            <i class="mr-1 icon ion-md-add text-primary"></i>
            @lang('crud.common.new')
        </button>
        @endcan @can('delete-any', App\Models\SoDdetail::class)
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
                        name="soDdetail.e_product_id"
                        label="E Product"
                        wire:model="soDdetail.e_product_id"
                    >
                        <option value="null" disabled>-- select --</option>
                        @foreach($eProductsForSelect as $value => $label)
                        <option value="{{ $value }}"  >{{ $label }}</option>
                        @endforeach
                    </x-input.select>

                    <x-input.number
                        name="soDdetail.quantity"
                        label="Quantity"
                        wire:model="soDdetail.quantity"
                    ></x-input.number>

                    <x-input.number
                        name="soDdetail.price"
                        label="Price"
                        wire:model="soDdetail.price"
                    ></x-input.number>
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
                        @lang('crud.sales_order_direct_details.inputs.e_product_id')
                    </th>
                    <th class="px-4 py-3 text-right">
                        @lang('crud.sales_order_direct_details.inputs.quantity')
                    </th>
                    <th class="px-4 py-3 text-right">
                        @lang('crud.sales_order_direct_details.inputs.price')
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @foreach ($soDdetails as $soDdetail)
                <tr class="hover:bg-gray-100">
                    <td class="px-4 py-3 text-left">
                        <input
                            type="checkbox"
                            value="{{ $soDdetail->id }}"
                            wire:model="selected"
                        />
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ optional($soDdetail->eProduct)->image ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right">
                        {{ $soDdetail->quantity ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right">
                        {{ $soDdetail->price ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right" style="width: 134px;">
                        <div
                            role="group"
                            aria-label="Row Actions"
                            class="relative inline-flex align-middle"
                        >
                            @can('update', $soDdetail)
                            <button
                                type="button"
                                class="button"
                                wire:click="editSoDdetail({{ $soDdetail->id }})"
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
                    <td colspan="4">
                        <div class="mt-10 px-4">
                            {{ $soDdetails->render() }}
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
