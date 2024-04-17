<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.payment_receipts.index_title')
        </h2>
        <p class="mt-2 text-xs text-gray-700">bukti transfer kepada pemasok</p>
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
                    <x-filters.label>Payment For</x-filters.label>
                    <x-filters.select wire:model="filters.payment_for">
                        @foreach (App\Models\PaymentReceipt::PAYMENT_FORES as $value => $label)
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
                <div class="mt-1 md:w-1/2">

                </div>
                <div class="mt-1 text-right md:w-1/2">
                    @role('super-admin|manager')
                        <a href="{{ route('payment-receipts.create') }}">
                            <x-jet-button>
                                <i class="mr-1 icon ion-md-add"></i>
                                @lang('crud.common.create')
                            </x-jet-button>
                        </a>
                    @endrole
                </div>
            </div>
        </x-slot>
    </x-tables.topbar>

    <x-tables.card>
        <x-table>
            <x-slot name="head">
                <x-tables.th-left>@lang('crud.payment_receipts.inputs.image')</x-tables.th-left>
                <x-tables.th-left-hide>@lang('crud.payment_receipts.inputs.amount')</x-tables.th-left-hide>
                <x-tables.th-left-hide>Detail</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.payment_receipts.inputs.payment_for')</x-tables.th-left-hide>
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($paymentReceipts as $paymentReceipt)
                    <tr class="hover:bg-gray-50">
                        <x-tables.td-left-main>
                            <x-slot name="main">
                                <div class="relative z-0 flex -space-x-2 overflow-hidden">
                                    <div class="mr-3">
                                        @if ($paymentReceipt->image == null)
                                            <x-partials.thumbnail src="" />
                                        @else
                                            <a href="{{ \Storage::url($paymentReceipt->image) }}">
                                                <x-partials.thumbnail
                                                    src="{{ $paymentReceipt->image ? \Storage::url($paymentReceipt->image) : '' }}" />
                                            </a>
                                        @endif
                                    </div>

                                    <div>
                                        @if ($paymentReceipt->image_adjust == null)
                                            <x-partials.thumbnail src="" />
                                        @else
                                            <a href="{{ \Storage::url($paymentReceipt->image_adjust) }}">
                                                <x-partials.thumbnail
                                                    src="{{ $paymentReceipt->image_adjust ? \Storage::url($paymentReceipt->image_adjust) : '' }}" />
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </x-slot>
                            <x-slot name="sub">
                                <p>{{ $paymentReceipt->created_at ?? '-' }}</p>
                                <p>@currency($paymentReceipt->amount)</p>
                                <p>
                                    @if ($paymentReceipt->payment_for == 1)
                                        <p>fuel service</p>
                                    @elseif ($paymentReceipt->payment_for == 2)
                                        <p>dailySalary</p>
                                    @elseif ($paymentReceipt->payment_for == 3)
                                        <p>invoice purchase</p>
                                    @endif
                                </p>
                                <p>
                                    @foreach ($paymentReceipt->dailySalaries as $dailySalary)
                                        <p>{{ $dailySalary->created_by->name }} | {{ $dailySalary->date }}
                                            @currency($dailySalary->amount)</p>
                                    @endforeach
                                    @foreach ($paymentReceipt->fuelServices as $fuelService)
                                        <p>{{ $fuelService->vehicle->no_register }} | @currency($fuelService->amount)</p>
                                    @endforeach

                                    @foreach ($paymentReceipt->invoicePurchases as $invoicePurchase)
                                        <p>
                                            {{ $invoicePurchase->supplier->name }} |
                                            @currency($invoicePurchase->detailInvoices->sum('subtotal_invoice') - $invoicePurchase->discounts + $invoicePurchase->taxes)</p>
                                    @endforeach
                                </p>
                            </x-slot>
                        </x-tables.td-left-main>

                        <x-tables.td-right-hide>@currency($paymentReceipt->amount)</x-tables.td-right-hide>

                        <x-tables.td-left-hide>
                            @foreach ($paymentReceipt->dailySalaries as $dailySalary)
                                <p>{{ $dailySalary->created_by->name }} |
                                    {{ $dailySalary->date->toFormattedDate() }} |
                                    @currency($dailySalary->amount)</p>
                            @endforeach

                            @foreach ($paymentReceipt->fuelServices as $fuelService)
                                <p>{{ $fuelService->vehicle->no_register }} |
                                    {{ $fuelService->created_at->toFormattedDate() }} | @currency($fuelService->amount)</p>
                            @endforeach

                            @foreach ($paymentReceipt->invoicePurchases as $invoicePurchase)
                                <p>{{ $invoicePurchase->store->nickname }} | {{ $invoicePurchase->supplier->name }} |
                                    {{ $invoicePurchase->date->toFormattedDate() }} |
                                    @currency($invoicePurchase->detailInvoices->sum('subtotal_invoice') - $invoicePurchase->discounts + $invoicePurchase->taxes)</p>
                            @endforeach

                        </x-tables.td-left-hide>

                        <x-tables.td-left-hide>
                            @if ($paymentReceipt->payment_for == 1)
                                <p>fuel service</p>
                            @elseif ($paymentReceipt->payment_for == 2)
                                <p>Daily Salary</p>
                            @elseif ($paymentReceipt->payment_for == 3)
                                <p>invoice purchase</p>
                            @endif
                        </x-tables.td-left-hide>

                        <td class="px-4 py-3 text-center" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @if ($paymentReceipt->status != '2')
                                    <a href="{{ route('payment-receipts.edit', $paymentReceipt) }}" class="mr-1">
                                        <x-buttons.edit></x-buttons.edit>
                                    </a>
                                @elseif($paymentReceipt->status == '2')
                                    <a href="{{ route('payment-receipts.show', $paymentReceipt) }}" class="mr-1">
                                        <x-buttons.show></x-buttons.show>
                                    </a>
                                @endif
                                @can('delete', $paymentReceipt)
                                    <form action="{{ route('payment-receipts.destroy', $paymentReceipt) }}" method="POST"
                                        onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                        @csrf @method('DELETE')
                                        <x-buttons.delete></x-buttons.delete>
                                    </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <x-tables.no-items-found colspan="6"> </x-tables.no-items-found>
                @endforelse
            </x-slot>
            <x-slot name="foot"> </x-slot>
        </x-table>
    </x-tables.card>
    <div class="px-4 mt-10">{!! $paymentReceipts->render() !!}</div>
</div>
