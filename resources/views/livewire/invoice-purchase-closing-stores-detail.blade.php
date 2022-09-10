<div>
    <div>
        @can('create', App\Models\ClosingStore::class)
            <button class="button" wire:click="newClosingStore">
                <i class="mr-1 icon ion-md-add text-primary"></i>
                @lang('crud.common.attach')
            </button>
        @endcan
    </div>

    <x-modal wire:model="showingModal">
        <div class="px-6 py-4">
            <div class="text-lg font-bold">{{ $modalTitle }}</div>

            <div class="mt-5">
                <div>
                    <x-input.select name="closing_store_id" label="Closing Store" wire:model="closing_store_id">
                        <option value="null" disabled>-- select --</option>
                        @foreach ($closingStoresForSelect as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-input.select>
                </div>
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
                    <x-tables.th-left>
                        @lang('crud.invoice_purchase_closing_stores.inputs.closing_store_id')
                    </x-tables.th-left>
                    <th></th>
                </tr>
            </x-slot>
            <x-slot name="body">
                @foreach ($invoicePurchaseClosingStores as $closingStore)
                    <tr class="hover:bg-gray-100">
                        <x-tables.td-left>
                            {{ $closingStore->date ?? '-' }}
                        </x-tables.td-left>
                        <td class="px-4 py-3 text-right" style="width: 70px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @can('delete-any', App\Models\ClosingStore::class)
                                    <button class="button button-danger"
                                        onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                                        wire:click="detach({{ $closingStore->id }})">
                                        <i class="mr-1 icon ion-md-trash text-primary"></i>
                                        @lang('crud.common.detach')
                                    </button>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-slot>
            <x-slot name="foot">
                <tr>
                    <td colspan="2">
                        <div class="px-4 mt-10">
                            {{ $invoicePurchaseClosingStores->render() }}
                        </div>
                    </td>
                </tr>
            </x-slot>
        </x-table>
    </x-tables.card-overflow>
</div>
