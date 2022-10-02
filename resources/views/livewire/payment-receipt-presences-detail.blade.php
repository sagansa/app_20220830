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

            <div class="mt-1 sm:space-y-5">

                <x-input.select name="presence_id" label="Presence" wire:model="presence_id">
                    <option value="null" disabled>-- select --</option>
                    @foreach ($presencesForSelect as $value => $label)
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
                        date
                    </x-tables.th-left>
                    <x-tables.th-left>
                        @lang('crud.payment_receipt_presences.inputs.presence_id')
                    </x-tables.th-left>
                    <x-tables.th-left>
                        payment type
                    </x-tables.th-left>
                    <x-tables.th-left>
                        store
                    </x-tables.th-left>
                    <x-tables.th-left>
                        amount
                    </x-tables.th-left>
                    <x-tables.th-left>
                        status
                    </x-tables.th-left>
                    <th></th>
                </tr>
            </x-slot>
            <x-slot name="body">
                @foreach ($paymentReceiptPresences as $presence)
                    <tr class="hover:bg-gray-100">
                        <x-tables.td-left>
                            {{ $presence->closingStore->date->toFormattedDate() }}
                        </x-tables.td-left>
                        <x-tables.td-left>
                            {{ $presence->created_by->name ?? '-' }}
                        </x-tables.td-left>
                        <x-tables.td-left>
                            {{ $presence->paymentType->name }}
                        </x-tables.td-left>
                        <x-tables.td-left>
                            {{ $presence->closingStore->store->nickname }}
                        </x-tables.td-left>
                        <x-tables.td-right>
                            @currency($presence->amount)
                        </x-tables.td-right>
                        <x-tables.td-right>
                            <select
                                class="block w-full py-2 pl-3 pr-10 mt-1 text-xs border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                wire:change="changeStatus({{ $presence }}, $event.target.value)">
                                <option value="1" {{ $presence->status == '1' ? 'selected' : '' }}>
                                    belum dibayar</option>
                                <option value="2" {{ $presence->status == '2' ? 'selected' : '' }}>
                                    sudah dibayar</option>
                                <option value="3" {{ $presence->status == '3' ? 'selected' : '' }}>
                                    siap valid</option>
                                <option value="4" {{ $presence->status == '4' ? 'selected' : '' }}>
                                    tidak valid</option>
                            </select>
                        </x-tables.td-right>
                        <td class="px-4 py-3 text-right" style="width: 70px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @role('super-admin|manager')
                                    @can('delete-any', App\Models\Presence::class)
                                        <button class="button button-danger"
                                            onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                                            wire:click="detach({{ $presence->id }})">
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
                <tr>
                    <td colspan="2">
                        <div class="px-4 mt-10">
                            {{ $paymentReceiptPresences->render() }}
                        </div>
                    </td>
                </tr>
            </x-slot>
        </x-table>
    </x-tables.card-overflow>
</div>
