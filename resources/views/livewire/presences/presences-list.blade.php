<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.presences.index_title')
        </h2>
        <p class="mt-2 text-xs text-gray-700">Data gaji harian pegawai</p>
    </x-slot>

    <x-tables.topbar>
        <x-slot name="search">
            <x-buttons.link wire:click="$toggle('showFilters')">
                @if ($showFilters)
                    Hide
                @endif Advanced Search...
            </x-buttons.link>
            @if ($showFilters)
                @role('super-admin')
                    <x-filters.group>
                        <x-filters.label>User</x-filters.label>
                        <x-filters.select wire:model="filters.created_by_id">
                            @foreach ($users as $label => $value)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </x-filters.select>
                    </x-filters.group>
                @endrole
                <x-filters.group>
                    <x-filters.label>Payment Type</x-filters.label>
                    <x-filters.select wire:model="filters.payment_type_id">
                        @foreach ($paymentTypes as $label => $value)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-filters.select>
                </x-filters.group>

                <x-filters.group>
                    <x-filters.label>Status</x-filters.label>
                    <x-filters.select wire:model="filters.status">
                        @foreach (App\Models\Presence::STATUSES as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-filters.select>
                </x-filters.group>

                <x-buttons.link wire:click="resetFilters">Reset Filter
                </x-buttons.link>
            @endif
        </x-slot>
        <x-slot name="action">
            <div class="flex flex-wrap justify-between mt-1">
                <div class="mt-1 md:w-1/3">
                    @role('super-admin')
                        <x-buttons.yellow wire:click="markAllAsBelumDibayar">belum dibayar</x-buttons.yellow>
                        <x-buttons.green wire:click="markAllAsSudahDibayar">sudah dibayar</x-buttons.green>
                        <x-buttons.gray wire:click="markAllAsSiapDibayar">siap dibayar</x-buttons.gray>
                        <x-buttons.red wire:click="markAllAsTidakValid">tidak valid</x-buttons.red>
                    @endrole
                </div>
                <div class="mt-1 text-right md:w-1/3">
                    @can('create', App\Models\Presence::class)
                        <a href="{{ route('presences.create') }}">
                            <x-jet-button>
                                <i class="mr-1 icon ion-md-add"></i>
                                @lang('crud.common.create')
                            </x-jet-button>
                        </a>
                    @endcan
                </div>
            </div>
        </x-slot>
    </x-tables.topbar>

    <x-tables.card>
        <x-table>
            <x-slot name="head">
                @role('super-admin')
                    <th></th>
                @endrole
                <x-tables.th-left>Store</x-tables.th-left>
                <x-tables.th-left>Shift</x-tables.th-left>
                <x-tables.th-left-hide>Date</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.presences.inputs.amount')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.presences.inputs.payment_type_id')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.presences.inputs.status')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.presences.inputs.created_by_id')</x-tables.th-left-hide>
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($presences as $presence)
                    <tr class="hover:bg-gray-50">
                        @role('super-admin|manager')
                            <x-tables.td-checkbox id="{{ $presence->id }}"></x-tables.td-checkbox>
                        @endrole
                        <x-tables.td-left-main>

                            <x-slot name="main">
                                @foreach ($presence->closingStores as $closingStore)
                                    {{ optional($closingStore)->store->nickname ?? '-' }}
                                @endforeach
                            </x-slot>
                            <x-slot name="sub">
                                <p>
                                    @foreach ($presence->closingStores as $closingStore)
                                        {{ optional($closingStore)->date->toFormattedDate() ?? '-' }}
                                    @endforeach
                                    - @currency($presence->amount)
                                </p>
                                <p>{{ optional($presence->paymentType)->name ?? '-' }}
                                    @if ($presence->status == 1)
                                        <x-spans.yellow>belum dibayar</x-spans.yellow>
                                    @elseif ($presence->status == 2)
                                        <x-spans.green>sudah dibayar</x-spans.green>
                                    @elseif ($presence->status == 3)
                                        <x-spans.gray>siap dibayar</x-spans.gray>
                                    @elseif ($presence->status == 4)
                                        <x-spans.red>tidak valid</x-spans.red>
                                    @endif
                                </p>
                            </x-slot>

                        </x-tables.td-left-main>
                        <x-tables.td-left-hide>
                            @foreach ($presence->closingStores as $closingStore)
                                {{ optional($closingStore)->shiftStore->name ?? '-' }}
                            @endforeach
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            @foreach ($presence->closingStores as $closingStore)
                                {{ optional($closingStore)->date->toFormattedDate() ?? '-' }}
                            @endforeach
                        </x-tables.td-left-hide>
                        <x-tables.td-right-hide>@currency($presence->amount)</x-tables.td-right-hide>
                        <x-tables.td-left-hide>{{ optional($presence->paymentType)->name ?? '-' }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            @if ($presence->status == 1)
                                <x-spans.yellow>belum dibayar</x-spans.yellow>
                            @elseif ($presence->status == 2)
                                <x-spans.green>sudah dibayar</x-spans.green>
                            @elseif ($presence->status == 3)
                                <x-spans.gray>siap dibayar</x-spans.gray>
                            @elseif ($presence->status == 4)
                                <x-spans.red>tidak valid</x-spans.red>
                            @endif
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ optional($presence->created_by)->name ?? '-' }}
                        </x-tables.td-left-hide>
                        <td class="px-4 py-3 text-center" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @if ($presence->status != '2')
                                    <a href="{{ route('presences.edit', $presence) }}" class="mr-1">
                                        <x-buttons.edit></x-buttons.edit>
                                    </a>
                                @elseif($presence->status == '2')
                                    <a href="{{ route('presences.show', $presence) }}" class="mr-1">
                                        <x-buttons.show></x-buttons.show>
                                    </a>
                                @endif
                                @can('delete', $presence)
                                    <form action="{{ route('presences.destroy', $presence) }}" method="POST"
                                        onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                        @csrf @method('DELETE')
                                        <x-buttons.delete></x-buttons.delete>
                                    </form>
                                @endcan
                            </div>
                        </td>
                    </tr>

                @empty
                    <x-tables.no-items-found colspan="9"> </x-tables.no-items-found>
                @endforelse
            </x-slot>
            <x-slot name="foot">
                <tr>
                    <td colspan="9">
                        <div class="px-4 my-2">{!! $presences->render() !!}</div>
                    </td>
                </tr>
            </x-slot>
        </x-table>
    </x-tables.card>

</div>
