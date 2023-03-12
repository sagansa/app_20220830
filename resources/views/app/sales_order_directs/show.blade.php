<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.sales_order_directs.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('sales-order-directs.index') }}" class="mr-4"><i
                            class="mr-1 icon ion-md-arrow-back"></i></a>
                </x-slot>

                <x-shows.dl>
                    @role('super-admin|manager|storage-staff')
                        <x-shows.sub-dl>
                            <x-shows.dt>@lang('crud.sales_order_directs.inputs.order_by_id')</x-shows.dt>
                            <x-shows.dd>{{ optional($salesOrderDirect->order_by)->name ?? '-' }}
                            </x-shows.dd>
                        </x-shows.sub-dl>
                    @endrole
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.sales_order_directs.inputs.delivery_date')</x-shows.dt>
                        <x-shows.dd>{{ $salesOrderDirect->delivery_date->toFormattedDate() ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.sales_order_directs.inputs.delivery_service_id')</x-shows.dt>
                        <x-shows.dd>
                            {{ optional($salesOrderDirect->deliveryService)->name ?? '-' }}
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.sales_order_directs.inputs.delivery_location_id')</x-shows.dt>
                        <x-shows.dd>
                            {{ optional($salesOrderDirect->deliveryLocation)->label ?? '-' }}
                            <div> {{ optional($salesOrderDirect->deliveryLocation)->contact_name ?? '-' }} -
                                {{ optional($salesOrderDirect->deliveryLocation)->contact_number ?? '-' }}</div>
                            <div>{{ optional($salesOrderDirect->deliveryLocation)->address ?? '-' }}</div>
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    @role('super-admin|manager|customer')
                        <x-shows.sub-dl>
                            <x-shows.dt>@lang('crud.sales_order_directs.inputs.transfer_to_account_id')</x-shows.dt>
                            <x-shows.dd>
                                {{ optional($salesOrderDirect->transferToAccount)->bank->name ?? '-' }} -
                                {{ optional($salesOrderDirect->transferToAccount)->number ?? '-' }} -
                                {{ optional($salesOrderDirect->transferToAccount)->name ?? '-' }}
                            </x-shows.dd>
                        </x-shows.sub-dl>
                        <x-shows.sub-dl>
                            <x-shows.dt>@lang('crud.sales_order_directs.inputs.payment_status')</x-shows.dt>
                            <x-shows.dd>
                                <x-spans.status-valid class="{{ $salesOrderDirect->payment_status_badge }}">
                                    {{ $salesOrderDirect->payment_status_name }}
                                </x-spans.status-valid>
                            </x-shows.dd>
                        </x-shows.sub-dl>
                        <x-shows.sub-dl>
                            <x-shows.dt>@lang('crud.sales_order_directs.inputs.image_transfer')</x-shows.dt>
                            @if ($salesOrderDirect->image_transfer != null)
                                <x-partials.thumbnail src="" size="150" />
                            @else
                                <a href="{{ \Storage::url($salesOrderDirect->image_transfer) }}">
                                    <x-partials.thumbnail
                                        src="{{ $salesOrderDirect->image_transfer ? \Storage::url($salesOrderDirect->image_transfer) : '' }}"
                                        size="150" />
                                </a>
                            @endif
                        </x-shows.sub-dl>
                    @endrole

                    @role('super-admin|manager|storage-staff')
                        <x-shows.sub-dl>
                            <x-shows.dt>@lang('crud.sales_order_directs.inputs.store_id')</x-shows.dt>
                            <x-shows.dd>{{ optional($salesOrderDirect->store)->nickname ?? '-' }}</x-shows.dd>
                        </x-shows.sub-dl>
                        <x-shows.sub-dl>
                            <x-shows.dt>@lang('crud.sales_order_directs.inputs.submitted_by_id')</x-shows.dt>
                            <x-shows.dd>
                                {{ optional($salesOrderDirect->submitted_by)->name ?? '-' }}
                            </x-shows.dd>
                        </x-shows.sub-dl>
                        <x-shows.sub-dl>
                            <x-shows.dt>@lang('crud.sales_order_directs.inputs.received_by')</x-shows.dt>
                            <x-shows.dd>{{ $salesOrderDirect->received_by ?? '-' }}</x-shows.dd>
                        </x-shows.sub-dl>
                    @endrole
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.sales_order_directs.inputs.delivery_status')</x-shows.dt>
                        <x-shows.dd>
                            <x-spans.status-valid class="{{ $salesOrderDirect->delivery_status_badge }}">
                                {{ $salesOrderDirect->delivery_status_name }}
                            </x-spans.status-valid>
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.sales_order_directs.inputs.notes')</x-shows.dt>
                        <x-shows.dd>{{ $salesOrderDirect->notes ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.sales_order_directs.inputs.image_receipt')</x-shows.dt>
                        @if ($salesOrderDirect->image_receipt != null)
                            <x-partials.thumbnail src="" size="150" />
                        @else
                            <a href="{{ \Storage::url($salesOrderDirect->image_receipt) }}">
                                <x-partials.thumbnail
                                    src="{{ $salesOrderDirect->image_receipt ? \Storage::url($salesOrderDirect->image_receipt) : '' }}"
                                    size="150" />
                            </a>
                        @endif
                    </x-shows.sub-dl>
                    @role('super-admin')
                        <x-shows.sub-dl>
                            <x-shows.dt>@lang('crud.sales_order_directs.inputs.sign')</x-shows.dt>
                            @if ($salesOrderDirect->sign != null)
                                <x-partials.thumbnail src="" size="150" />
                            @else
                                <a href="{{ \Storage::url($salesOrderDirect->sign) }}">
                                    <x-partials.thumbnail
                                        src="{{ $salesOrderDirect->sign ? \Storage::url($salesOrderDirect->sign) : '' }}"
                                        size="150" />
                                </a>
                            @endif
                        </x-shows.sub-dl>
                    @endrole
                    @role('super-admin|manager')
                        <x-shows.sub-dl>
                            <x-shows.dt>Created Date</x-shows.dt>
                            <x-shows.dd>{{ $salesOrderDirect->created_at ?? '-' }}</x-shows.dd>
                        </x-shows.sub-dl>
                        <x-shows.sub-dl>
                            <x-shows.dt>Updated Date</x-shows.dt>
                            <x-shows.dd>{{ $salesOrderDirect->updated_at ?? '-' }}</x-shows.dd>
                        </x-shows.sub-dl>
                    @endrole
                </x-shows.dl>

                <div class="mt-10">
                    <a href="{{ route('sales-order-directs.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>
                </div>
            </x-partials.card>

            @can('view-any', App\Models\SalesOrderDirectProduct::class)
                <x-partials.card class="mt-5">
                    <x-slot name="title"> Sales Order Direct Products </x-slot>

                    <livewire:sales-order-direct-sales-order-direct-products-detail :salesOrderDirect="$salesOrderDirect" />
                </x-partials.card>
            @endcan
        </div>
    </div>
</x-admin-layout>
