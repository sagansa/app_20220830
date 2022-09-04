<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.invoice_purchases.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a
                        href="{{ route('invoice-purchases.index') }}"
                        class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <x-shows.dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.invoice_purchases.inputs.image')</x-shows.dt
                        >
                        @if ($invoicePurchase->image != null)
                        <x-partials.thumbnail src="" size="150" />
                        @else
                        <a href="{{ \Storage::url($invoicePurchase->image) }}">
                            <x-partials.thumbnail
                                src="{{ $invoicePurchase->image ? \Storage::url($invoicePurchase->image) : '' }}"
                                size="150"
                            />
                        </a>
                        @endif
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.invoice_purchases.inputs.payment_type_id')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ optional($invoicePurchase->paymentType)->name ??
                            '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.invoice_purchases.inputs.store_id')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ optional($invoicePurchase->store)->name ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.invoice_purchases.inputs.supplier_id')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ optional($invoicePurchase->supplier)->name ??
                            '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.invoice_purchases.inputs.date')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $invoicePurchase->date ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.invoice_purchases.inputs.payment_status')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $invoicePurchase->payment_status ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.invoice_purchases.inputs.order_status')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $invoicePurchase->order_status ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.invoice_purchases.inputs.created_by_id')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ optional($invoicePurchase->created_by)->name ??
                            '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.invoice_purchases.inputs.approved_id')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ optional($invoicePurchase->approved_by)->name ??
                            '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Created Date</x-shows.dt>
                        <x-shows.dd
                            >{{ $invoicePurchase->created_at ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Updated Date</x-shows.dt>
                        <x-shows.dd
                            >{{ $invoicePurchase->updated_at ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                </x-shows.dl>

                <div class="mt-10">
                    <a
                        href="{{ route('invoice-purchases.index') }}"
                        class="button"
                    >
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>
                </div>
            </x-partials.card>

            @can('view-any', App\Models\DetailInvoice::class)
            <x-partials.card class="mt-5">
                <x-slot name="title"> Detail Invoices </x-slot>

                <livewire:invoice-purchase-detail-invoices-detail
                    :invoicePurchase="$invoicePurchase"
                />
            </x-partials.card>
            @endcan
        </div>
    </div>
</x-admin-layout>
