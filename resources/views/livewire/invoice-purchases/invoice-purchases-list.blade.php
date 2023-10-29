<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.invoice_purchases.index_title')
        </h2>
        <p class="mt-2 text-xs text-gray-700">seluruh pembelian yang dilakukan masing-masing warung, wajib harus ada
            kuitansi yang valid, serta untuk bahan baku utama dilanjutkan dengan membuat production</p>
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
                    <x-filters.label>Supplier</x-filters.label>
                    <x-filters.select wire:model="filters.supplier_id">
                        @foreach ($suppliers as $label => $value)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-filters.select>
                </x-filters.group>
                <x-filters.group>
                    <x-filters.label>Payment Type</x-filters.label>
                    <x-filters.select wire:model="filters.payment_type_id">
                        @foreach ($paymentTypes as $label => $value)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-filters.select>
                </x-filters.group>
                <x-filters.group>
                    <x-filters.label>Payment Status</x-filters.label>
                    <x-filters.select wire:model="filters.payment_status">
                        @foreach (App\Models\InvoicePurchase::PAYMENT_STATUSES as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-filters.select>
                </x-filters.group>
                <x-filters.group>
                    <x-filters.label>Order Status</x-filters.label>
                    <x-filters.select wire:model="filters.order_status">
                        @foreach (App\Models\InvoicePurchase::ORDER_STATUSES as $value => $label)
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
                        <x-buttons.green wire:click.prevent="markAllAsSudahDibayar">Sudah Dibayar</x-buttons.green>
                        <x-buttons.yellow wire:click.prevent="markAllAsBelumDibayar">Belum Dibayar</x-buttons.yellow>
                        <x-buttons.red wire:click.prevent='markAllAsTidakValid'>Tidak Valid</x-buttons.red>
                    @endrole
                </div>
                <div class="mt-1 text-right md:w-1/3">
                    @can('create', App\Models\InvoicePurchase::class)
                        <a href="{{ route('invoice-purchases.create') }}">
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
                <x-tables.th-left-hide>@lang('crud.invoice_purchases.inputs.image')</x-tables.th-left-hide>
                <x-tables.th-left wire:click="sortByColumn('date')">
                    <x-spans.sort>@lang('crud.invoice_purchases.inputs.store_id') - @lang('crud.invoice_purchases.inputs.date')</x-spans.sort>
                    @if ($sortColumn == 'date')
                        @include('svg.sort-' . $sortDirection)
                    @else
                        @include('svg.sort')
                    @endif
                </x-tables.th-left>
                {{-- <x-tables.th-left-hide>@lang('crud.invoice_purchases.inputs.store_id')</x-tables.th-left-hide> --}}
                <x-tables.th-left-hide>@lang('crud.invoice_purchases.inputs.supplier_id')</x-tables.th-left-hide>
                {{-- <x-tables.th-left-hide>@lang('crud.invoice_purchases.inputs.payment_type_id')</x-tables.th-left-hide> --}}

                <x-tables.th-left-hide>Detail Product</x-tables.th-left-hide>

                <x-tables.th-left-hide>Total</x-tables.th-left-hide>

                @role('super-admin')
                    <x-tables.th-left-hide>Report Payment</x-tables.th-left-hide>
                @endrole
                <x-tables.th-left-hide>@lang('crud.invoice_purchases.inputs.payment_status')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.invoice_purchases.inputs.order_status')</x-tables.th-left-hide>
                @role('super-admin|supervisor|manager')
                    <x-tables.th-left-hide>@lang('crud.invoice_purchases.inputs.created_by_id')</x-tables.th-left-hide>
                    <x-tables.th-left-hide>created date</x-tables.th-left-hide>
                @endrole
                {{-- @role('super-admin|staff|manager')
                    <x-tables.th-left-hide>@lang('crud.invoice_purchases.inputs.approved_by_id')</x-tables.th-left-hide>
                @endrole --}}
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($invoicePurchases as $invoicePurchase)
                    <tr class="hover:bg-gray-50">
                        @role('super-admin')
                            <x-tables.td-checkbox id="{{ $invoicePurchase->id }}"></x-tables.td-checkbox>
                        @endrole
                        <x-tables.td-left-main>
                            <x-slot name="main">

                                @if ($invoicePurchase->image == null)
                                    <x-partials.thumbnail src="" />
                                @else
                                    <a href="{{ \Storage::url($invoicePurchase->image) }}">
                                        <x-partials.thumbnail
                                            src="{{ $invoicePurchase->image ? \Storage::url($invoicePurchase->image) : '' }}" />
                                    </a>
                                @endif

                            </x-slot>
                            <x-slot name="sub">

                                <p>{{ optional($invoicePurchase->store)->nickname ?? '-' }}</p>
                                <p>{{ optional($invoicePurchase->supplier)->name ?? '-' }}</p>
                                <p>
                                    @if ($invoicePurchase->payment_type_id == '1')
                                        {{ optional($invoicePurchase->supplier)->bank->name ?? '-' }} -
                                        {{ optional($invoicePurchase->supplier)->bank_account_no ?? '-' }} -
                                        {{ optional($invoicePurchase->supplier)->bank_account_name ?? '-' }}
                                    @endif
                                </p>
                                {{-- <p>{{ optional($invoicePurchase->paymentType)->name ?? '-' }}</p> --}}
                                <p>{{ $invoicePurchase->date->toFormattedDate() ?? '-' }}</p>
                                <p>
                                    <x-spans.status-valid class="{{ $invoicePurchase->payment_status_badge }}">
                                        {{ $invoicePurchase->payment_status_name }}
                                    </x-spans.status-valid>
                                    <x-spans.status-valid class="{{ $invoicePurchase->order_status_badge }}">
                                        {{ $invoicePurchase->order_status_name }}</x-spans.status-valid>
                                </p>
                            </x-slot>
                        </x-tables.td-left-main>

                        <x-tables.td-left-hide>
                            <p>
                                @role('staff')
                                    @if ($invoicePurchase->payment_status != 2 || $invoicePurchase->order_status != 2)
                                        <x-buttons.notes wire:click="edit({{ $invoicePurchase->id }})">
                                        </x-buttons.notes>
                                    @endif
                                @endrole
                                @role('supervisor|manager|super-admin')
                                    <x-buttons.notes wire:click="edit({{ $invoicePurchase->id }})">
                                    </x-buttons.notes>
                                @endrole
                            </p>
                            <p> {{ optional($invoicePurchase->store)->nickname ?? '-' }}
                            </p>
                            <p> {{ $invoicePurchase->date->toFormattedDate() ?? '-' }}</p>
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            <p>{{ optional($invoicePurchase->supplier)->name ?? '-' }}</p>
                            @if ($invoicePurchase->payment_type_id == '1')
                                <p>{{ optional($invoicePurchase->supplier)->bank->name ?? '-' }} -
                                    {{ optional($invoicePurchase->supplier)->bank_account_no ?? '-' }}</p>
                                <p>{{ optional($invoicePurchase->supplier)->bank_account_name ?? '-' }}</p>
                            @endif
                        </x-tables.td-left-hide>

                        <x-tables.td-left-hide>
                            @foreach ($invoicePurchase->detailInvoices as $detailInvoice)
                                @if ($detailInvoice == null)
                                    -
                                @else
                                    <p>
                                        {{ $detailInvoice->detailRequest->product->name }} -
                                        {{ $detailInvoice->quantity_product }}
                                        {{ $detailInvoice->detailRequest->product->unit->unit }} -
                                        @role('super-admin')
                                            @currency($detailInvoice->subtotal_invoice / $detailInvoice->quantity_product) -
                                        @endrole
                                        <x-spans.status-valid
                                            class="{{ $detailInvoice->detailRequest->approval_status_badge }}">
                                            {{ $detailInvoice->detailRequest->approval_status_name }}
                                        </x-spans.status-valid>
                                    </p>
                                @endif
                            @endforeach
                        </x-tables.td-left-hide>

                        @role('staff|supervisor|manager')
                            <x-tables.td-left-hide>
                                <p>totals: @currency($invoicePurchase->detail_invoices_sum_subtotal_invoice - $invoicePurchase->discounts + $invoicePurchase->taxes)
                                </p>
                            </x-tables.td-left-hide>
                        @endrole
                        @role('super-admin')
                            <x-tables.td-left-hide>
                                <p>discounts: @currency($invoicePurchase->discounts)</p>
                                <p>taxes: @currency($invoicePurchase->taxes)</p>
                                <p>subtotals @currency($invoicePurchase->detail_invoices_sum_subtotal_invoice)</p>
                                <p>totals: @currency($invoicePurchase->detail_invoices_sum_subtotal_invoice - $invoicePurchase->discounts + $invoicePurchase->taxes)
                                </p>
                            </x-tables.td-left-hide>
                        @endrole
                        <x-tables.td-left-hide>
                            @foreach ($invoicePurchase->paymentReceipts as $paymentReceipt)
                                @if ($paymentReceipt->id != null)
                                    sudah
                                @endif
                            @endforeach

                            @foreach ($invoicePurchase->closingStores as $closingStore)
                                @if ($closingStore->id != null)
                                    sudah
                                @endif
                            @endforeach
                        </x-tables.td-left-hide>

                        <x-tables.td-left-hide>
                            <x-spans.status-valid class="{{ $invoicePurchase->payment_status_badge }}">
                                {{ $invoicePurchase->payment_status_name }}
                            </x-spans.status-valid>
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            <x-spans.status-valid class="{{ $invoicePurchase->order_status_badge }}">
                                {{ $invoicePurchase->order_status_name }}</x-spans.status-valid>
                        </x-tables.td-left-hide>
                        @role('super-admin|supervisor|manager')
                            <x-tables.td-left-hide>{{ optional($invoicePurchase->created_by)->name ?? '-' }}
                            </x-tables.td-left-hide>
                            <x-tables.td-left-hide>{{ $invoicePurchase->created_at ?? '-' }}
                            </x-tables.td-left-hide>
                        @endrole
                        {{-- @role('super-admin|staff|manager')
                            <x-tables.td-left-hide>{{ optional($invoicePurchase->approved_by)->name ?? '-' }}
                            </x-tables.td-left-hide>
                        @endrole --}}
                        <td class="px-4 py-3 text-center" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @if ($invoicePurchase->payment_status != '2' || $invoicePurchase->order_status != '2')
                                    <a href="{{ route('invoice-purchases.edit', $invoicePurchase) }}" class="mr-1">
                                        <x-buttons.edit></x-buttons.edit>
                                    </a>
                                @endif
                                <a href="{{ route('invoice-purchases.show', $invoicePurchase) }}" class="mr-1">
                                    <x-buttons.show></x-buttons.show>
                                </a>
                                @can('delete', $invoicePurchase)
                                    <form action="{{ route('invoice-purchases.destroy', $invoicePurchase) }}"
                                        method="POST" onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                        @csrf @method('DELETE')
                                        <x-buttons.delete></x-buttons.delete>
                                    </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <x-tables.no-items-found colspan="10">
                    </x-tables.no-items-found>
                @endforelse
            </x-slot>
            <x-slot name="foot"> </x-slot>
        </x-table>
    </x-tables.card>
    <div class="px-4 mt-10">{{ $invoicePurchases->render() }}</div>

    <!-- Save Invoice Purchase Modal -->
    <div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" wire:ignore.self>
        <form wire:submit.prevent="save">
            <x-modals.dialog wire:model.defer="showEditModal">
                <x-slot name="title">Invoice Purhase</x-slot>

                <x-slot name="content">
                    @role('super-admin')
                        <x-inputs.group for="payment_status" label="Payment Status">
                            <x-inputs.select name="payment_status" label="Payment Status"
                                wire:model.defer="editing.payment_status" id="status">
                                <option value="2">valid</option>
                                <option value="3">perbaiki</option>
                            </x-inputs.select>
                        </x-inputs.group>
                    @endrole
                    <x-inputs.group for="notes" label="Notes">
                        <x-inputs.textarea name="notes" label="notes" wire:model.defer="editing.notes"
                            id="notes" />
                    </x-inputs.group>
                </x-slot>

                <x-slot name="footer">
                    <x-buttons.secondary wire:click="$set('showEditModal', false)">Cancel</x-buttons.secondary>
                    <x-jet-button type="submit">Save</x-jet-button>
                </x-slot>
            </x-modals.dialog>
        </form>
    </div>
</div>
