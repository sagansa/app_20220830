<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.sales_order_onlines.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('sales-order-onlines.index') }}" class="mr-4"><i
                            class="mr-1 icon ion-md-arrow-back"></i></a>
                </x-slot>

                <x-shows.dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.sales_order_onlines.inputs.image')</x-shows.dt>
                        @if ($salesOrderOnline->image != null)
                            <x-partials.thumbnail src="" size="150" />
                        @else
                            <a href="{{ \Storage::url($salesOrderOnline->image) }}">
                                <x-partials.thumbnail
                                    src="{{ $salesOrderOnline->image ? \Storage::url($salesOrderOnline->image) : '' }}"
                                    size="150" />
                            </a>
                        @endif
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.sales_order_onlines.inputs.store_id')</x-shows.dt>
                        <x-shows.dd>{{ optional($salesOrderOnline->store)->name ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.sales_order_onlines.inputs.online_shop_provider_id')</x-shows.dt>
                        <x-shows.dd>
                            {{ optional($salesOrderOnline->onlineShopProvider)->name ?? '-' }}
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.sales_order_onlines.inputs.delivery_service_id')</x-shows.dt>
                        <x-shows.dd>
                            {{ optional($salesOrderOnline->deliveryService)->name ?? '-' }}
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.sales_order_onlines.inputs.customer_id')</x-shows.dt>
                        <x-shows.dd>{{ optional($salesOrderOnline->customer)->name ?? '-' }}
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.sales_order_onlines.inputs.delivery_address_id')</x-shows.dt>
                        <x-shows.dd>
                            {{ optional($salesOrderOnline->deliveryAddress)->name ?? '-' }}
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.sales_order_onlines.inputs.receipt_no')</x-shows.dt>
                        <x-shows.dd>{{ $salesOrderOnline->receipt_no ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.sales_order_onlines.inputs.date')</x-shows.dt>
                        <x-shows.dd>{{ $salesOrderOnline->date->toFormattedDate() ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.sales_order_onlines.inputs.status')</x-shows.dt>
                        <x-shows.dd>
                            <x-spans.status-valid class="{{ $salesOrderOnline->status_badge }}">
                                {{ $salesOrderOnline->status_name }}</x-spans.status-valid>
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Created By</x-shows.dt>
                        <x-shows.dd>
                            {{ optional($salesOrderOnline->created_by)->name ?? '-' }}
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Updated By</x-shows.dt>
                        <x-shows.dd>
                            {{ optional($salesOrderOnline->approved_by)->name ?? '-' }}
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.sales_order_onlines.inputs.notes')</x-shows.dt>
                        <x-shows.dd>{{ $salesOrderOnline->notes ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.sales_order_onlines.inputs.image_sent')</x-shows.dt>
                        @if ($salesOrderOnline->image_sent != null)
                            <x-partials.thumbnail src="" size="150" />
                        @else
                            <a href="{{ \Storage::url($salesOrderOnline->image_sent) }}">
                                <x-partials.thumbnail
                                    src="{{ $salesOrderOnline->image_sent ? \Storage::url($salesOrderOnline->image_sent) : '' }}"
                                    size="150" />
                            </a>
                        @endif
                    </x-shows.sub-dl>
                </x-shows.dl>

                <div class="mt-10">
                    <a href="{{ route('sales-order-onlines.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>
                </div>
            </x-partials.card>

            @can('view-any', App\Models\product_sales_order_online::class)
                <x-partials.card class="mt-5">
                    <x-slot name="title"> Products </x-slot>

                    <livewire:sales-order-online-products-detail :salesOrderOnline="$salesOrderOnline" />
                </x-partials.card>
            @endcan
        </div>
    </div>
</x-admin-layout>
