<div>
    <div>
        @role('super-admin')
            @can('create', App\Models\Presence::class)
                <button class="button" wire:click="newPresence">
                    <i class="mr-1 icon ion-md-add text-primary"></i>
                    @lang('crud.common.attach')
                </button>
            @endcan
        @endrole
    </div>

    <x-modal wire:model="showingModal">
        <div class="px-6 py-4">
            <div class="text-lg font-bold">{{ $modalTitle }}</div>

            <div class="mt-5">
                <div>
                    <x-input.select name="presence_id" label="Presence" wire:model="presence_id">
                        <option value="null" disabled>-- select --</option>
                        @foreach ($presencesForSelect as $value => $label)
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
                        Employee
                    </x-tables.th-left>
                    <x-tables.th-left>
                        Amount
                    </x-tables.th-left>
                    <th></th>
                </tr>
            </x-slot>
            <x-slot name="body">
                @foreach ($closingStorePresences as $presence)
                    <tr class="hover:bg-gray-100">
                        <x-tables.td-left>
                            {{ optional($presence->created_by)->name ?? '-' }}
                        </x-tables.td-left>
                        <x-tables.td-left>
                            {{ $presence->amount ?? '-' }}
                        </x-tables.td-left>
                        <td class="px-4 py-3 text-right" style="width: 70px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @if ($closingStore->transfer_status != '2' || $closingStore->closing_status != '2')
                                    @can('delete-any', App\Models\Presence::class)
                                        <button class="button button-danger"
                                            onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                                            wire:click="detach({{ $presence->id }})">
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
                    <x-tables.th-total colspan="1">Totals</x-tables.th-total>
                    <x-tables.td-total>@currency($this->presence->totals)</x-tables.td-total>
                </tr>
                <tr>
                    <td colspan="3">
                        <div class="px-4 mt-10">
                            {{ $closingStorePresences->render() }}
                        </div>
                    </td>
                </tr>
            </x-slot>
        </x-table>
    </x-tables.card-overflow>
</div>
