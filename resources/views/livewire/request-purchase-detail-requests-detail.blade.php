<div>
    <div>
        @if ($requestPurchase->status != 2)
            @can('create', App\Models\DetailRequest::class)
                <button class="button" wire:click="newDetailRequest">
                    <i class="mr-1 icon ion-md-add text-primary"></i>
                    @lang('crud.common.new')
                </button>
            @endcan
            @can('delete-any', App\Models\DetailRequest::class)
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

                {{-- <x-input.select name="detailRequest.product_id" label="Product" wire:model="detailRequest.product_id">
                    <option value="null" disabled>-- select --</option>
                    @foreach ($productsForSelect as $label => $value)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </x-input.select> --}}

                <div class="mb-4">
                    <label class="block mb-2 text-sm font-medium text-gray-700" for="name">
                        Product
                    </label>
                    <x-virtual-select id="product" wire:model="detailRequest.product_id" options="products"
                        multiple="false" />
                    {{-- @error('productCategories')
                        <div class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </div>
                    @enderror --}}
                </div>

                {{-- <x-inputs.select-dropdown name="product" wire="detailRequest.product_id"
                    options="products"></x-inputs.select-dropdown> --}}

                <x-input.number name="detailRequest.quantity_plan" label="Quantity Plan"
                    wire:model="detailRequest.quantity_plan"></x-input.number>
                {{-- @role('super-admin|manager')
                    <x-input.select name="detailRequest.status" label="Status" wire:model="detailRequest.status">
                        <option value="1" {{ $selected == '1' ? 'selected' : '' }}>process</option>
                        <option value="2" {{ $selected == '2' ? 'selected' : '' }}>done</option>
                        <option value="3" {{ $selected == '3' ? 'selected' : '' }}>reject</option>
                        <option value="4" {{ $selected == '4' ? 'selected' : '' }}>approved</option>
                        <option value="5" {{ $selected == '5' ? 'selected' : '' }}>not valid</option>
                        <option value="5" {{ $selected == '5' ? 'selected' : '' }}>not used</option>
                    </x-input.select>
                @endrole --}}
                {{-- @role('supervisor|staff') --}}
                {{-- <x-input.hidden name="detailRequest.status" wire:model="detailRequest.status">
                </x-input.hidden> --}}
                {{-- @endrole --}}
                @if ($this->detailRequest->product->payment_type_id = '1')
                    <x-input.select name="detailRequest.status" label="Status" wire:model="detailRequest.status">
                        <option value="4" {{ $selected == '4' ? 'selected' : '' }}>approved</option>
                    </x-input.select>
                @elseif ($this->detailRequest->product->payment_type_id = '2')
                    <x-input.select name="detailRequest.status" label="Status" wire:model="detailRequest.status">
                        <option value="1" {{ $selected == '1' ? 'selected' : '' }}>process</option>
                    </x-input.select>
                @endif
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
                        @role('super-admin')
                            <input type="checkbox" wire:model="allSelected" wire:click="toggleFullSelection"
                                title="{{ trans('crud.common.select_all') }}" />
                        @endrole
                    </x-tables.th-left>
                    <x-tables.th-left>
                        @lang('crud.request_purchase_detail_requests.inputs.product_id')
                    </x-tables.th-left>
                    <x-tables.th-left>
                        @lang('crud.request_purchase_detail_requests.inputs.quantity_plan')
                    </x-tables.th-left>
                    <x-tables.th-left>
                        @lang('crud.request_purchase_detail_requests.inputs.status')
                    </x-tables.th-left>
                    <th></th>
                </tr>
            </x-slot>
            <x-slot name="body">
                @foreach ($detailRequests as $detailRequest)
                    <tr class="hover:bg-gray-100">
                        <x-tables.td-left>
                            @if ($detailRequest->status == 1 || $detailRequest->status == 5)
                                <input type="checkbox" value="{{ $detailRequest->id }}" wire:model="selected" />
                            @endif
                        </x-tables.td-left>
                        <x-tables.td-left>
                            {{ optional($detailRequest->product)->name ?? '-' }}
                        </x-tables.td-left>
                        <x-tables.td-left>
                            {{ $detailRequest->quantity_plan ?? '-' }} {{ $detailRequest->product->unit->unit }}
                        </x-tables.td-left>
                        <x-tables.td-left>
                            @if ($detailRequest->status == 1)
                                <x-spans.yellow>process</x-spans.yellow>
                            @elseif ($detailRequest->status == 2)
                                <x-spans.green>done</x-spans.green>
                            @elseif ($detailRequest->status == 3)
                                <x-spans.red>reject</x-spans.red>
                            @elseif ($detailRequest->status == 4)
                                <x-spans.green>approved</x-spans.green>
                            @elseif ($detailRequest->status == 5)
                                <x-spans.red>not valid</x-spans.red>
                            @elseif ($detailRequest->status == 6)
                                <x-spans.gray>not used</x-spans.gray>
                            @endif
                        </x-tables.td-left>
                        <x-tables.td-left>
                            {{ $detailRequest->notes ?? '-' }}
                        </x-tables.td-left>
                        <td class="px-4 py-3 text-right" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @can('update', $detailRequest)
                                    @if ($detailRequest->status == 1 || $detailRequest->status == 5)
                                        <button type="button" class="button"
                                            wire:click="editDetailRequest({{ $detailRequest->id }})">
                                            <i class="icon ion-md-create"></i>
                                        </button>
                                    @endif
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-slot>
            <x-slot name="foot">
                <tr>
                    <td colspan="5">
                        <div class="px-4 mt-10">
                            {{ $detailRequests->render() }}
                        </div>
                    </td>
                </tr>
            </x-slot>
        </x-table>
    </x-tables.card-overflow>
</div>
