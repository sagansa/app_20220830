<div>
    <x-tables.card>
        <x-table>
            <x-slot name="head">
                <tr>
                    <x-tables.th-left>
                        @lang('crud.store_asset_movement_assets.inputs.image')
                    </x-tables.th-left>
                    <x-tables.th-left>
                        @lang('crud.store_asset_movement_assets.inputs.qr_code')
                    </x-tables.th-left>
                    <x-tables.th-left>
                        @lang('crud.store_asset_movement_assets.inputs.product_id')
                    </x-tables.th-left>
                    <x-tables.th-left>
                        @lang('crud.store_asset_movement_assets.inputs.good_cond_qty')
                    </x-tables.th-left>
                    <x-tables.th-left>
                        @lang('crud.store_asset_movement_assets.inputs.bad_cond_qty')
                    </x-tables.th-left>
                    <th></th>
                </tr>
            </x-slot>
            <x-slot name="body">
                @foreach ($movementAssets as $movementAsset)
                    <tr class="hover:bg-gray-100">
                        <x-tables.td-left>
                            @if ($movementAsset->image == null)
                                <x-partials.thumbnail src="" />
                            @else
                                <a href="{{ Storage::url($movementAsset->image) }}">
                                    <x-partials.thumbnail
                                        src="{{ $movementAsset->image ? Storage::url($movementAsset->image) : '' }}" />
                                </a>
                            @endif
                        </x-tables.td-left>
                        <x-tables.td-left>
                            @if ($movementAsset->qr_code == null)
                                <x-partials.thumbnail src="" />
                            @else
                                <a href="{{ \Storage::url('images/movement-assets' . '/' . $movementAsset->qr_code) }}">
                                    <x-partials.thumbnail
                                        src="{{ $movementAsset->qr_code ? Storage::url('images/movement-assets' . '/' . $movementAsset->qr_code) : '' }}" />
                                </a>
                            @endif
                        </x-tables.td-left>
                        <x-tables.td-left>
                            {{ optional($movementAsset->product)->name ?? '-' }}
                        </x-tables.td-left>
                        <x-tables.td-left>
                            {{ $movementAsset->good_cond_qty ?? '-' }} {{ $movementAsset->product->unit->unit }}
                        </x-tables.td-left>
                        <x-tables.td-left>
                            {{ $movementAsset->bad_cond_qty ?? '-' }} {{ $movementAsset->product->unit->unit }}
                        </x-tables.td-left>
                        <td class="px-4 py-3 text-right" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @can('update', $movementAsset)
                                    <button type="button" class="button"
                                        wire:click="editMovementAsset({{ $movementAsset->id }})">
                                        <i class="icon ion-md-create"></i>
                                    </button>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-slot>
            <x-slot name="foot"></x-slot>
        </x-table>
    </x-tables.card>

</div>
