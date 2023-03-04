<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.sales_order_directs.index_title')
        </h2>
        <p class="mt-2 text-xs text-gray-700">---</p>
    </x-slot>

    <div class="mb-5 mt-4">
        <div class="flex flex-wrap justify-between mt-1">
            <div class="mt-1 md:w-1/3">
                <form>
                    <div class="flex items-center w-full">
                        <x-inputs.text
                            name="search"
                            value="{{ $search ?? '' }}"
                            placeholder="{{ __('crud.common.search') }}"
                            autocomplete="off"
                        ></x-inputs.text>

                        <div class="ml-1">
                            <x-jet-button>
                                <i class="icon ion-md-search"></i>
                            </x-jet-button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="mt-1 md:w-1/3 text-right">
                @can('create', App\Models\SalesOrderDirect::class)
                <a href="{{ route('sales-order-directs.create') }}"
                    ><x-jet-button>
                        <i class="mr-1 icon ion-md-add"></i>
                        @lang('crud.common.create')</x-jet-button
                    >
                </a>
                @endcan
            </div>
        </div>
    </div>

    <x-tables.card>
        <x-table>
            <x-slot name="head">
                <x-tables.th-left
                    >@lang('crud.sales_order_directs.inputs.order_by_id')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.sales_order_directs.inputs.delivery_date')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.sales_order_directs.inputs.delivery_service_id')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.sales_order_directs.inputs.transfer_to_account_id')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.sales_order_directs.inputs.payment_status')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.sales_order_directs.inputs.store_id')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.sales_order_directs.inputs.submitted_by_id')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.sales_order_directs.inputs.received_by')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.sales_order_directs.inputs.sign')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.sales_order_directs.inputs.image_transfer')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.sales_order_directs.inputs.image_receipt')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.sales_order_directs.inputs.delivery_status')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.sales_order_directs.inputs.shipping_cost')</x-tables.th-left
                >
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($salesOrderDirects as $salesOrderDirect)
                <tr class="hover:bg-gray-50">
                    <x-tables.td-left-hide
                        >{{ optional($salesOrderDirect->order_by)->name ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $salesOrderDirect->delivery_date ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ optional($salesOrderDirect->deliveryService)->name
                        ?? '-' }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ optional($salesOrderDirect->transferToAccount)->name
                        ?? '-' }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $salesOrderDirect->payment_status ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ optional($salesOrderDirect->store)->name ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ optional($salesOrderDirect->submitted_by)->name ??
                        '-' }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $salesOrderDirect->received_by ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide>
                        @if ($salesOrderDirect->sign == null)
                        <x-partials.thumbnail src="" />
                        @else
                        <a href="{{ \Storage::url($salesOrderDirect->sign) }}">
                            <x-partials.thumbnail
                                src="{{ $salesOrderDirect->sign ? \Storage::url($salesOrderDirect->sign) : '' }}"
                            />
                        </a>
                        @endif
                    </x-tables.td-left-hide>

                    <x-tables.td-left-hide>
                        @if ($salesOrderDirect->image_transfer == null)
                        <x-partials.thumbnail src="" />
                        @else
                        <a
                            href="{{ \Storage::url($salesOrderDirect->image_transfer) }}"
                        >
                            <x-partials.thumbnail
                                src="{{ $salesOrderDirect->image_transfer ? \Storage::url($salesOrderDirect->image_transfer) : '' }}"
                            />
                        </a>
                        @endif
                    </x-tables.td-left-hide>

                    <x-tables.td-left-hide>
                        @if ($salesOrderDirect->image_receipt == null)
                        <x-partials.thumbnail src="" />
                        @else
                        <a
                            href="{{ \Storage::url($salesOrderDirect->image_receipt) }}"
                        >
                            <x-partials.thumbnail
                                src="{{ $salesOrderDirect->image_receipt ? \Storage::url($salesOrderDirect->image_receipt) : '' }}"
                            />
                        </a>
                        @endif
                    </x-tables.td-left-hide>

                    <x-tables.td-left-hide
                        >{{ $salesOrderDirect->delivery_status ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-right-hide
                        >{{ $salesOrderDirect->shipping_cost ?? '-'
                        }}</x-tables.td-right-hide
                    >
                    <td class="px-4 py-3 text-center" style="width: 134px;">
                        <div
                            role="group"
                            aria-label="Row Actions"
                            class="relative inline-flex align-middle"
                        >
                            @if($salesOrderDirect->status != '2')
                            <a
                                href="{{ route('sales-order-directs.edit', $salesOrderDirect) }}"
                                class="mr-1"
                            >
                                <x-buttons.edit></x-buttons.edit>
                            </a>
                            @elseif($salesOrderDirect->status == '2')
                            <a
                                href="{{ route('sales-order-directs.show', $salesOrderDirect) }}"
                                class="mr-1"
                            >
                                <x-buttons.show></x-buttons.show>
                            </a>
                            @endif @can('delete', $salesOrderDirect)
                            <form
                                action="{{ route('sales-order-directs.destroy', $salesOrderDirect) }}"
                                method="POST"
                                onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')"
                            >
                                @csrf @method('DELETE')
                                <x-buttons.delete></x-buttons.delete>
                            </form>
                            @endcan
                        </div>
                    </td>
                </tr>
                @empty
                <x-tables.no-items-found colspan="14">
                </x-tables.no-items-found>
                @endforelse
            </x-slot>
            <x-slot name="foot"> </x-slot>
        </x-table>
    </x-tables.card>
    <div class="mt-10 px-4">{!! $salesOrderDirects->render() !!}</div>
</x-admin-layout>
