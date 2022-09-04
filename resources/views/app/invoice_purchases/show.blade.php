<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.invoice_purchases.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('invoice-purchases.index') }}" class="mr-4"><i
                            class="mr-1 icon ion-md-arrow-back"></i></a>
                </x-slot>

                <x-shows.dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.invoice_purchases.inputs.image')</x-shows.dt>
                        @if ($invoicePurchase->image != null)
                            <x-partials.thumbnail src="" size="150" />
                        @else
                            <a href="{{ \Storage::url($invoicePurchase->image) }}">
                                <x-partials.thumbnail
                                    src="{{ $invoicePurchase->image ? \Storage::url($invoicePurchase->image) : '' }}"
                                    size="150" />
                            </a>
                        @endif
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.invoice_purchases.inputs.payment_type_id')</x-shows.dt>
                        <x-shows.dd>
                            {{ optional($invoicePurchase->paymentType)->name ?? '-' }}
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.invoice_purchases.inputs.store_id')</x-shows.dt>
                        <x-shows.dd>{{ optional($invoicePurchase->store)->nickname ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.invoice_purchases.inputs.supplier_id')</x-shows.dt>
                        <x-shows.dd>
                            @if ($invoicePurchase->payment_type_id == 1)
                                <p class="text-right sm:text-left">
                                    {{ optional($invoicePurchase->supplier)->bank_account_name ?? '-' }}
                                </p>
                                <p class="text-right sm:text-left">
                                    {{ optional($invoicePurchase->supplier)->name ?? '-' }}
                                </p>
                                <p class="text-right sm:text-left">
                                    {{ optional($invoicePurchase->supplier)->bank->name ?? '-' }}</p>
                                <p class="text-right sm:text-left">
                                    {{ optional($invoicePurchase->supplier)->bank_account_no ?? '-' }}
                                </p>
                            @elseif ($invoicePurchase->payment_type_id == 2)
                                {{ optional($invoicePurchase->supplier)->name ?? '-' }}
                            @endif
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.invoice_purchases.inputs.date')</x-shows.dt>
                        <x-shows.dd>{{ $invoicePurchase->date->toFormattedDate() ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.invoice_purchases.inputs.payment_status')</x-shows.dt>
                        <x-shows.dd>
                            @if ($invoicePurchase->payment_status == '1')
                                <x-spans.yellow>belum dibayar</x-spans.yellow>
                            @elseif ($invoicePurchase->payment_status == '2')
                                <x-spans.green>sudah dibayar</x-spans.green>
                            @elseif ($invoicePurchase->payment_status == '3')
                                <x-spans.red>diperbaiki</x-spans.red>
                            @elseif ($invoicePurchase->payment_status == '4')
                                <x-spans.gray>periksa ulang</x-spans.gray>
                            @endif
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.invoice_purchases.inputs.order_status')</x-shows.dt>
                        <x-shows.dd>
                            @if ($invoicePurchase->order_status == '1')
                                <x-spans.yellow>belum diterima</x-spans.yellow>
                            @elseif ($invoicePurchase->order_status == '2')
                                <x-spans.green>sudah diterima</x-spans.green>
                            @else
                                <x-spans.red>dikembalikan</x-spans.red>
                            @endif
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.invoice_purchases.inputs.notes')</x-shows.dt>
                        <x-shows.dd>{{ $invoicePurchase->notes ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Created Date</x-shows.dt>
                        <x-shows.dd>{{ $invoicePurchase->created_at ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Updated Date</x-shows.dt>
                        <x-shows.dd>{{ $invoicePurchase->updated_at ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                </x-shows.dl>

                <div class="mt-10">
                    <a href="{{ route('invoice-purchases.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>
                </div>
            </x-partials.card>

            @can('view-any', App\Models\DetailInvoice::class)
                <x-partials.card class="mt-5">
                    <x-slot name="title"> Detail Invoices </x-slot>

                    <livewire:invoice-purchase-detail-invoices-detail :invoicePurchase="$invoicePurchase" />
                </x-partials.card>
            @endcan
        </div>
    </div>
</x-admin-layout>
