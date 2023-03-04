<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.sales_order_directs.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a
                        href="{{ route('sales-order-directs.index') }}"
                        class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <x-shows.dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.sales_order_directs.inputs.order_by_id')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ optional($salesOrderDirect->order_by)->name ??
                            '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.sales_order_directs.inputs.delivery_date')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $salesOrderDirect->delivery_date ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.sales_order_directs.inputs.delivery_service_id')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{
                            optional($salesOrderDirect->deliveryService)->name
                            ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.sales_order_directs.inputs.transfer_to_account_id')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{
                            optional($salesOrderDirect->transferToAccount)->name
                            ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.sales_order_directs.inputs.payment_status')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $salesOrderDirect->payment_status ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.sales_order_directs.inputs.store_id')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ optional($salesOrderDirect->store)->name ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.sales_order_directs.inputs.submitted_by_id')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ optional($salesOrderDirect->submitted_by)->name
                            ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.sales_order_directs.inputs.received_by')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $salesOrderDirect->received_by ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.sales_order_directs.inputs.sign')</x-shows.dt
                        >
                        @if ($salesOrderDirect->sign != null)
                        <x-partials.thumbnail src="" size="150" />
                        @else
                        <a href="{{ \Storage::url($salesOrderDirect->sign) }}">
                            <x-partials.thumbnail
                                src="{{ $salesOrderDirect->sign ? \Storage::url($salesOrderDirect->sign) : '' }}"
                                size="150"
                            />
                        </a>
                        @endif
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.sales_order_directs.inputs.image_transfer')</x-shows.dt
                        >
                        @if ($salesOrderDirect->image_transfer != null)
                        <x-partials.thumbnail src="" size="150" />
                        @else
                        <a
                            href="{{ \Storage::url($salesOrderDirect->image_transfer) }}"
                        >
                            <x-partials.thumbnail
                                src="{{ $salesOrderDirect->image_transfer ? \Storage::url($salesOrderDirect->image_transfer) : '' }}"
                                size="150"
                            />
                        </a>
                        @endif
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.sales_order_directs.inputs.image_receipt')</x-shows.dt
                        >
                        @if ($salesOrderDirect->image_receipt != null)
                        <x-partials.thumbnail src="" size="150" />
                        @else
                        <a
                            href="{{ \Storage::url($salesOrderDirect->image_receipt) }}"
                        >
                            <x-partials.thumbnail
                                src="{{ $salesOrderDirect->image_receipt ? \Storage::url($salesOrderDirect->image_receipt) : '' }}"
                                size="150"
                            />
                        </a>
                        @endif
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.sales_order_directs.inputs.delivery_status')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $salesOrderDirect->delivery_status ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.sales_order_directs.inputs.shipping_cost')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $salesOrderDirect->shipping_cost ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Created Date</x-shows.dt>
                        <x-shows.dd
                            >{{ $salesOrderDirect->created_at ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Updated Date</x-shows.dt>
                        <x-shows.dd
                            >{{ $salesOrderDirect->updated_at ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                </x-shows.dl>

                <div class="mt-10">
                    <a
                        href="{{ route('sales-order-directs.index') }}"
                        class="button"
                    >
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>
                </div>
            </x-partials.card>

            @can('view-any', App\Models\SoDdetail::class)
            <x-partials.card class="mt-5">
                <x-slot name="title"> So Ddetails </x-slot>

                <livewire:sales-order-direct-so-ddetails-detail
                    :salesOrderDirect="$salesOrderDirect"
                />
            </x-partials.card>
            @endcan
        </div>
    </div>
</x-admin-layout>
