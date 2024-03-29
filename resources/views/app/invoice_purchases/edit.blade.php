@if ($invoicePurchase->status != 2)
    <x-admin-layout>
        <x-slot name="header">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                @lang('crud.invoice_purchases.edit_title')
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <x-partials.card>
                    <x-slot name="title">
                        <a href="{{ route('invoice-purchases.index') }}" class="mr-4"><i
                                class="mr-1 icon ion-md-arrow-back"></i></a>
                    </x-slot>

                    <x-form method="PUT" action="{{ route('invoice-purchases.update', $invoicePurchase) }}" has-files
                        class="mt-4">
                        @include('app.invoice_purchases.form-inputs')

                        <div class="mt-10">
                            <a href="{{ route('invoice-purchases.index') }}" class="button">
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

                @can('view-any', App\Models\DetailInvoice::class)
                    <x-partials.card class="mt-5">
                        <x-slot name="title"> Detail Invoices </x-slot>
                        {{-- @if ($invoicePurchase->payment_type_id == 2) --}}
                        {{-- <livewire:detail-invoices.detail-invoice-cash :invoicePurchase="$invoicePurchase" /> --}}
                        {{-- @elseif ($invoicePurchase->payment_type_id == 1) --}}
                        <livewire:invoice-purchase-detail-invoices-detail :invoicePurchase="$invoicePurchase" />
                        {{-- <livewire:detail-invoices.detail-invoice-transfer :invoicePurchase="$invoicePurchase" /> --}}
                        {{-- @endif --}}
                    </x-partials.card>
                @endcan

                @if ($invoicePurchase->payment_type_id == 2)
                    @can('view-any', App\Models\ClosingStore::class)
                        <x-partials.card class="mt-5">
                            <x-slot name="title"> Closing Stores </x-slot>

                            <livewire:invoice-purchase-closing-stores-detail :invoicePurchase="$invoicePurchase" />
                        </x-partials.card>
                    @endcan
                @endif

            </div>
        </div>
    </x-admin-layout>
@else
    <x-admin-layout>
        <a href="{{ route('invoice-purchases.index') }}" class="button">
            <i class="mr-1 icon ion-md-return-left text-primary"></i>
            FORBIDDEN ACCESS @lang('crud.common.back')
        </a>
    </x-admin-layout>
@endif
