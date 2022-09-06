<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.payment_receipts.index_title')
        </h2>
        <p class="mt-2 text-xs text-gray-700">bukti transfer</p>
    </x-slot>

    <div class="mt-4 mb-5">
        <div class="flex flex-wrap justify-between mt-1">
            <div class="mt-1 md:w-1/3">
                <form>
                    <div class="flex items-center w-full">
                        <x-inputs.text name="search" value="{{ $search ?? '' }}"
                            placeholder="{{ __('crud.common.search') }}" autocomplete="off"></x-inputs.text>

                        <div class="ml-1">
                            <x-jet-button>
                                <i class="icon ion-md-search"></i>
                            </x-jet-button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="mt-1 text-right md:w-1/3">
                @can('create', App\Models\PaymentReceipt::class)
                    <a href="{{ route('payment-receipts.create') }}">
                        <x-jet-button>
                            <i class="mr-1 icon ion-md-add"></i>
                            @lang('crud.common.create')
                        </x-jet-button>
                    </a>
                @endcan
            </div>
        </div>
    </div>

    <x-tables.card>
        <x-table>
            <x-slot name="head">
                <x-tables.th-left-hide>@lang('crud.payment_receipts.inputs.image')</x-tables.th-left-hide>

                <x-tables.th-left>Store</x-tables.th-left>
                <x-tables.th-left>Supplier</x-tables.th-left>
                <x-tables.th-left>Date</x-tables.th-left>
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
                                @if ($paymentReceipt->image == null)
                                    <x-partials.thumbnail src="" />
                                @else
                                    <a href="{{ \Storage::url($paymentReceipt->image) }}">
                                        <x-partials.thumbnail
                                            src="{{ $paymentReceipt->image ? \Storage::url($paymentReceipt->image) : '' }}" />
                                    </a>
                                @endif
                            </x-slot>
                            <x-slot name="sub">
                                <p>{{ $paymentReceipt->created_at ?? '-' }}</p>
                                <p>@currency($paymentReceipt->amount)</p>
                                <p>
                                    @if ($paymentReceipt->payment_for == 1)
                                        <p>fuel service</p>
                                    @elseif ($paymentReceipt->payment_for == 2)
                                        <p>presence</p>
                                    @elseif ($paymentReceipt->payment_for == 3)
                                        <p>invoice purchase</p>
                                    @endif
                                </p>
                            </x-slot>
                        </x-tables.td-left-main>
                        <x-tables.td-left-hide>
                            @foreach ($paymentReceipt->invoicePurchases as $invoicePurchase)
                                <p>{{ $invoicePurchase->store->nickname }}</p>
                            @endforeach
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            @foreach ($paymentReceipt->invoicePurchases as $invoicePurchase)
                                <p>{{ $invoicePurchase->supplier->name }}</p>
                            @endforeach
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            @foreach ($paymentReceipt->invoicePurchases as $invoicePurchase)
                                <p>{{ $invoicePurchase->date->toFormattedDate() }}</p>
                            @endforeach
                        </x-tables.td-left-hide>

                        <x-tables.td-right-hide>@currency($paymentReceipt->amount)</x-tables.td-right-hide>

                        <x-tables.td-left-hide>
                            @foreach ($paymentReceipt->presences as $presence)
                                <p>{{ $presence->created_by->name }} - @currency($presence->amount) -
                                    {{ $presence->closingStore->date->toFormattedDate() }}</p>
                            @endforeach
                            @foreach ($paymentReceipt->fuelServices as $fuelService)
                                <p>{{ $fuelService->vehicle->no_register }} - {{ $fuelService->amount }}</p>
                            @endforeach

                            @foreach ($paymentReceipt->invoicePurchases as $invoicePurchase)
                                <p>{{ $invoicePurchase->store->nickname }} - {{ $invoicePurchase->supplier->name }} -
                                    {{ $invoicePurchase->date->toFormattedDate() }} -
                                    {{ $invoicePurchase->detailInvoices->sum('subtotal_invoice') }}</p>
                            @endforeach

                        </x-tables.td-left-hide>

                        <x-tables.td-left-hide>
                            @if ($paymentReceipt->payment_for == 1)
                                <p>fuel service</p>
                            @elseif ($paymentReceipt->payment_for == 2)
                                <p>presence</p>
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
                                @endif @can('delete', $paymentReceipt)
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
</x-admin-layout>
