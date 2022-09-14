<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Check Productions
        </h2>
        <p class="mt-2 text-xs text-gray-700">cek produksi bahan baku utama</p>
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
                        @foreach (App\Models\DetailInvoice::STATUSES as $value => $label)
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
                        From Product
                    </x-tables.th-left>
                    <x-tables.th-left>
                        Quantity Product
                    </x-tables.th-left>

                    <x-tables.th-left>
                        Store Production
                    </x-tables.th-left>
                    <x-tables.th-left>
                        Created Date
                    </x-tables.th-left>
                    <x-tables.th-left>
                        Status
                    </x-tables.th-left>

                </tr>
            </x-slot>
            <x-slot name="body">
                @foreach ($detailInvoices as $detailInvoice)
                    <tr class="hover:bg-gray-100">
                        <x-tables.td-left-hide>
                            {{ $detailInvoice->invoicePurchase->store->nickname }}
                        </x-tables.td-left-hide>

                        <x-tables.td-left-hide>
                            {{ $detailInvoice->invoicePurchase->date->toFormattedDate() }}
                        </x-tables.td-left-hide>

                        <x-tables.td-left-hide>
                            {{ optional($detailInvoice->detailRequest->product)->name ?? '-' }}
                        </x-tables.td-left-hide>

                        <x-tables.td-left-hide>
                            {{ $detailInvoice->quantity_product ?? '-' }}

                            {{ $detailInvoice->detailRequest->product->unit->unit }}
                        </x-tables.td-left-hide>

                        <x-tables.td-left-hide>
                            @foreach ($detailInvoice->productionMainFroms as $productionMainFrom)
                                <p>{{ $productionMainFrom->production->store->nickname }} -
                                    {{ $productionMainFrom->production->date->toFormattedDate() }}</p>
                            @endforeach

                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            {{ $detailInvoice->created_at }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>

                            <select
                                class="block w-full py-2 pl-3 pr-10 my-1 text-xs border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                wire:change="changeStatus({{ $detailInvoice }}, $event.target.value)">
                                <option value="1" {{ $detailInvoice->status == '1' ? 'selected' : '' }}>
                                    Process</option>
                                <option value="2" {{ $detailInvoice->status == '2' ? 'selected' : '' }}>
                                    Done</option>
                                <option value="3" {{ $detailInvoice->status == '3' ? 'selected' : '' }}>
                                    No Need</option>
                            </select>
                        </x-tables.td-left-hide>
                    </tr>
                @endforeach
            </x-slot>
            <x-slot name="foot">
                <tr>
                    <td colspan="7">
                        <div class="px-4 my-2">
                            {{ $detailInvoices->render() }}
                        </div>
                    </td>
                </tr>
            </x-slot>
        </x-table>
    </x-tables.card>

</div>
