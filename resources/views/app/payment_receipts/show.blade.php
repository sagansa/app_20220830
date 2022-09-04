<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.payment_receipts.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('payment-receipts.index') }}" class="mr-4"><i
                            class="mr-1 icon ion-md-arrow-back"></i></a>
                </x-slot>

                <x-shows.dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.payment_receipts.inputs.image')</x-shows.dt>
                        @if ($paymentReceipt->image != null)
                            <x-partials.thumbnail src="" size="150" />
                        @else
                            <a href="{{ \Storage::url($paymentReceipt->image) }}">
                                <x-partials.thumbnail
                                    src="{{ $paymentReceipt->image ? \Storage::url($paymentReceipt->image) : '' }}"
                                    size="150" />
                            </a>
                        @endif
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.payment_receipts.inputs.amount')</x-shows.dt>
                        <x-shows.dd>{{ $paymentReceipt->amount ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.payment_receipts.inputs.payment_for')</x-shows.dt>
                        <x-shows.dd>{{ $paymentReceipt->payment_for ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Created Date</x-shows.dt>
                        <x-shows.dd>{{ $paymentReceipt->created_at ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Updated Date</x-shows.dt>
                        <x-shows.dd>{{ $paymentReceipt->updated_at ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                </x-shows.dl>

                <div class="mt-10">
                    <a href="{{ route('payment-receipts.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>
                </div>
            </x-partials.card>

            @if ($paymentReceipt->payment_for == 1)
                @can('view-any', App\Models\fuel_service_payment_receipt::class)
                    <x-partials.card class="mt-5">
                        <x-slot name="title"> Fuel Services </x-slot>

                        <livewire:payment-receipt-fuel-services-detail :paymentReceipt="$paymentReceipt" />
                    </x-partials.card>
                @endcan
            @elseif ($paymentReceipt->payment_for == 2)
                @can('view-any', App\Models\payment_receipt_presence::class)
                    <x-partials.card class="mt-5">
                        <x-slot name="title"> Presences </x-slot>

                        <livewire:payment-receipt-presences-detail :paymentReceipt="$paymentReceipt" />
                    </x-partials.card>
                @endcan
            @elseif ($paymentReceipt->payment_for == 3)
                @can('view-any', App\Models\invoice_purchase_payment_receipt::class)
                    <x-partials.card class="mt-5">
                        <x-slot name="title"> Invoice Purchases </x-slot>

                        <livewire:payment-receipt-invoice-purchases-detail :paymentReceipt="$paymentReceipt" />
                    </x-partials.card>
                @endcan
            @endif



        </div>
    </div>
</x-admin-layout>
