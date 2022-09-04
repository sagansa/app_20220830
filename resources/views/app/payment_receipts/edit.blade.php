@if ($paymentReceipt->status != 2)
    <x-admin-layout>
        <x-slot name="header">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                @lang('crud.payment_receipts.edit_title')
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <x-partials.card>
                    <x-slot name="title">
                        <a href="{{ route('payment-receipts.index') }}" class="mr-4"><i
                                class="mr-1 icon ion-md-arrow-back"></i></a>
                    </x-slot>

                    <x-form method="PUT" action="{{ route('payment-receipts.update', $paymentReceipt) }}" has-files
                        class="mt-4">
                        @include('app.payment_receipts.form-inputs')

                        <div class="mt-10">
                            <a href="{{ route('payment-receipts.index') }}" class="button">
                                <i class="mr-1 icon ion-md-return-left text-primary"></i>
                                @lang('crud.common.back')
                            </a>

                            <x-jet-button class="float-right">
                                <i class="mr-1 icon ion-md-save"></i>
                                @lang('crud.common.update')
                            </x-jet-button>
                        </div>
                    </x-form>
                </x-partials.card>

                @if ($paymentReceipt->payment_for == 1)
                    @can('view-any', App\Models\FuelService::class)
                        <x-partials.card class="mt-5">
                            <x-slot name="title"> Fuel Services </x-slot>

                            <livewire:payment-receipt-fuel-services-detail :paymentReceipt="$paymentReceipt" />
                        </x-partials.card>
                    @endcan
                @elseif ($paymentReceipt->payment_for == 2)
                    @can('view-any', App\Models\Presence::class)
                        <x-partials.card class="mt-5">
                            <x-slot name="title"> Presences </x-slot>

                            <livewire:payment-receipt-presences-detail :paymentReceipt="$paymentReceipt" />
                        </x-partials.card>
                    @endcan
                @elseif ($paymentReceipt->payment_for == 3)
                    @can('view-any', App\Models\InvoicePurchase::class)
                        <x-partials.card class="mt-5">
                            <x-slot name="title"> Invoice Purchases </x-slot>

                            <livewire:payment-receipt-invoice-purchases-detail :paymentReceipt="$paymentReceipt" />
                        </x-partials.card>
                    @endcan
                @endif
            </div>
        </div>
    </x-admin-layout>
@else
    <x-admin-layout>
        <a href="{{ route('payment-receipts.index') }}" class="button">
            <i class="mr-1 icon ion-md-return-left text-primary"></i>
            FORBIDDEN ACCESS @lang('crud.common.back')
        </a>
    </x-admin-layout>
@endif
