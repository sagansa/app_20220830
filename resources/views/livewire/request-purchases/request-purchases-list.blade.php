<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.request_purchases.index_title')
        </h2>
        <p class="mt-2 text-xs text-gray-700">permintaan bahan baku</p>
    </x-slot>

    <x-tables.topbar>
        <x-slot name="search">
            <x-buttons.link wire:click.prevent="$toggle('showFilters')">
                @if ($showFilters)
                    Hide
                @endif Advanced Search...
            </x-buttons.link>
            @if ($showFilters)
                <x-filters.group>
                    <x-filters.label>Store</x-filters.label>
                    <x-filters.select wire:model="filters.store_id">
                        @foreach ($stores as $label => $value)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-filters.select>
                </x-filters.group>

                <x-filters.group>
                    <x-filters.label>Status</x-filters.label>
                    <x-filters.select wire:model="filters.status">
                        @foreach (App\Models\RequestPurchase::STATUSES as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-filters.select>
                </x-filters.group>

                <x-buttons.link wire:click.prevent="resetFilters">Reset Filter
                </x-buttons.link>
            @endif
        </x-slot>
        <x-slot name="action">
            <div class="flex flex-wrap justify-between mt-1">
                <div class="mt-1 md:w-1/3">
                    @role('super-admin')
                        <x-buttons.yellow wire:click.prevent="markAllAsProcess">Process</x-buttons.yellow>
                        <x-buttons.green wire:click.prevent="markAllAsDone">Done</x-buttons.green>
                    @endrole
                </div>
                <div class="mt-1 text-right md:w-1/3">
                    @can('create', App\Models\RequestPurchase::class)
                        <a href="{{ route('request-purchases.create') }}">
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
                <x-tables.th-left>@lang('crud.request_purchases.inputs.store_id')</x-tables.th-left>
                <x-tables.th-left-hide>@lang('crud.request_purchases.inputs.date')</x-tables.th-left-hide>
                @role('super-admin')
                    <x-tables.th-left-hide>@lang('crud.request_purchases.inputs.user_id')</x-tables.th-left-hide>
                @endrole
                <x-tables.th-left-hide>Detail Request</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.request_purchases.inputs.status')</x-tables.th-left-hide>
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($requestPurchases as $requestPurchase)
                    <tr class="hover:bg-gray-50">
                        @role('super-admin')
                            <x-tables.td-checkbox id="{{ $requestPurchase->id }}"></x-tables.td-checkbox>
                        @endrole
                        <x-tables.td-left-main>
                            <x-slot name="main">{{ optional($requestPurchase->store)->nickname ?? '-' }}</x-slot>
                            <x-slot name="sub">{{ $requestPurchase->date->toFormattedDate() ?? '-' }}
                                @foreach ($requestPurchase->detailRequests as $detailRequest)
                                    <p>
                                        {{ $detailRequest->product->name }} - {{ $detailRequest->quantity_plan }}
                                        {{ $detailRequest->product->unit->unit }} -
                                        @if ($detailRequest->status == 1)
                                            <x-spans.yellow>process</x-spans.yellow>
                                        @elseif($detailRequest->status == 2)
                                            <x-spans.green>done</x-spans.green>
                                        @elseif($detailRequest->status == 3)
                                            <x-spans.red>reject</x-spans.red>
                                        @elseif($detailRequest->status == 4)
                                            <x-spans.gray>approved</x-spans.gray>
                                        @elseif($detailRequest->status == 5)
                                            <x-spans.red>not valid</x-spans.red>
                                        @endif
                                    </p>
                                @endforeach
                            </x-slot>
                        </x-tables.td-left-main>
                        <x-tables.td-left-hide>{{ $requestPurchase->date->toFormattedDate() ?? '-' }}
                        </x-tables.td-left-hide>
                        @role('super-admin')
                            <x-tables.td-left-hide>{{ optional($requestPurchase->user)->name ?? '-' }}
                            </x-tables.td-left-hide>
                        @endrole
                        <x-tables.td-left-hide>
                            @foreach ($requestPurchase->detailRequests as $detailRequest)
                                <p> {{ $detailRequest->product->name }} - {{ $detailRequest->quantity_plan }}
                                    {{ $detailRequest->product->unit->unit }} -
                                    @if ($detailRequest->status == 1)
                                        <x-spans.yellow>process</x-spans.yellow>
                                    @elseif($detailRequest->status == 2)
                                        <x-spans.green>done</x-spans.green>
                                    @elseif($detailRequest->status == 3)
                                        <x-spans.red>reject</x-spans.red>
                                    @elseif($detailRequest->status == 4)
                                        <x-spans.gray>approved</x-spans.gray>
                                    @elseif($detailRequest->status == 5)
                                        <x-spans.red>not valid</x-spans.red>
                                    @endif
                                </p>
                            @endforeach
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            @if ($requestPurchase->status == 1)
                                <x-spans.yellow>process</x-spans.yellow>
                            @else
                                <x-spans.green>done</x-spans.green>
                            @endif
                        </x-tables.td-left-hide>
                        <td class="px-4 py-3 text-center" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @if ($requestPurchase->status != '2')
                                    <a href="{{ route('request-purchases.edit', $requestPurchase) }}" class="mr-1">
                                        <x-buttons.edit></x-buttons.edit>
                                    </a>
                                    @can('delete', $requestPurchase)
                                        <form action="{{ route('request-purchases.destroy', $requestPurchase) }}"
                                            method="POST"
                                            onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                            @csrf @method('DELETE')
                                            <x-buttons.delete></x-buttons.delete>
                                        </form>
                                    @endcan
                                @elseif($requestPurchase->status == '2')
                                    <a href="{{ route('request-purchases.show', $requestPurchase) }}" class="mr-1">
                                        <x-buttons.show></x-buttons.show>
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <x-tables.no-items-found colspan="5"> </x-tables.no-items-found>
                @endforelse
            </x-slot>
            <x-slot name="foot">
                <tr>
                    <td colspan="7">
                        <div class="px-4 my-2">
                            {{ $requestPurchases->render() }}
                        </div>
                    </td>
                </tr>
            </x-slot>
        </x-table>
    </x-tables.card>
</div>
