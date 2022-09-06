<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Request Purchase Approvals
        </h2>
        <p class="mt-2 text-xs text-gray-700">persetujuan pembelian barang sebelum dilakukan pembelian</p>
    </x-slot>

    <x-tables.topbar>
        <x-slot name="search">
            <x-buttons.link wire:click="$toggle('showFilters')">
                @if ($showFilters)
                    Hide
                @endif Advanced Search...
            </x-buttons.link>

            @if ($showFilters)

                <x-filters.group>
                    <x-filters.label>Status</x-filters.label>
                    <x-filters.select wire:model="filters.status">
                        @foreach (App\Models\DetailRequest::STATUSES as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-filters.select>
                </x-filters.group>

                <x-buttons.link wire:click="resetFilters">Reset Filter
                </x-buttons.link>

            @endif
        </x-slot>
        <x-slot name="action">
        </x-slot>
    </x-tables.topbar>

    <x-tables.card>
        <x-table>
            <x-slot name="head">
                <tr>
                    <x-tables.th-left>
                        Store
                    </x-tables.th-left>
                    <x-tables.th-left>
                        Date
                    </x-tables.th-left>
                    <x-tables.th-left>
                        Product
                    </x-tables.th-left>
                    <x-tables.th-left>
                        Quantity Plan
                    </x-tables.th-left>
                    <x-tables.th-left>
                        Quantity Real
                    </x-tables.th-left>
                    <x-tables.th-left>
                        Diajukan Oleh
                    </x-tables.th-left>
                    <x-tables.th-left>
                        Status
                    </x-tables.th-left>

                </tr>
            </x-slot>
            <x-slot name="body">
                @foreach ($detailRequests as $detailRequest)
                    <tr class="hover:bg-gray-100">
                        <x-tables.td-left-hide>
                            {{ $detailRequest->requestPurchase->store->nickname }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>

                            {{ $detailRequest->requestPurchase->date->toFormattedDate() }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            {{ optional($detailRequest->product)->name ?? '-' }}
                        </x-tables.td-left-hide>

                        <x-tables.td-left-hide>
                            {{ $detailRequest->quantity_plan ?? '-' }}
                            {{ $detailRequest->product->unit->unit }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            {{ optional($detailRequest->detailInvoice)->quantity_product ?? '-' }}
                            @if ($detailRequest->detailInvoice->quantity_product != null)
                                {{ optional($detailRequest->product)->unit->unit ?? '-' }}
                            @endif
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            {{ $detailRequest->requestPurchase->user->name }}
                        </x-tables.td-left-hide>

                        <x-tables.td-left-hide>
                            <select
                                class="block w-full py-2 pl-3 pr-10 mt-1 text-xs border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                wire:change="changeStatus({{ $detailRequest }}, $event.target.value)">
                                <option value="1" {{ $detailRequest->status == '1' ? 'selected' : '' }}>
                                    Process</option>
                                <option value="2" {{ $detailRequest->status == '2' ? 'selected' : '' }}>
                                    Done</option>
                                <option value="3" {{ $detailRequest->status == '3' ? 'selected' : '' }}>
                                    Reject</option>
                                <option value="4" {{ $detailRequest->status == '4' ? 'selected' : '' }}>
                                    Approved</option>
                                <option value="5" {{ $detailRequest->status == '5' ? 'selected' : '' }}>
                                    Not Valid</option>
                            </select>
                        </x-tables.td-left-hide>
                    </tr>
                @endforeach
            </x-slot>
            <x-slot name="foot">
                <tr>
                    <td colspan="7">
                        <div class="px-4 my-2">
                            {{ $detailRequests->render() }}
                        </div>
                    </td>
                </tr>
            </x-slot>
        </x-table>
    </x-tables.card>
</div>
