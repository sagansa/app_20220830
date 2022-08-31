<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.sales_order_employees.index_title')
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
                @can('create', App\Models\SalesOrderEmployee::class)
                <a href="{{ route('sales-order-employees.create') }}"
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
                    >@lang('crud.sales_order_employees.inputs.store_id')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.sales_order_employees.inputs.customer_id')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.sales_order_employees.inputs.delivery_address_id')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.sales_order_employees.inputs.date')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.sales_order_employees.inputs.total')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.sales_order_employees.inputs.image')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.sales_order_employees.inputs.status')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.sales_order_employees.inputs.notes')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.sales_order_employees.inputs.created_by_id')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.sales_order_employees.inputs.approved_by_id')</x-tables.th-left
                >
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($salesOrderEmployees as $salesOrderEmployee)
                <tr class="hover:bg-gray-50">
                    <x-tables.td-left-hide
                        >{{ optional($salesOrderEmployee->store)->name ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ optional($salesOrderEmployee->customer)->name ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ optional($salesOrderEmployee->deliveryAddress)->name
                        ?? '-' }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $salesOrderEmployee->date ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-right-hide
                        >{{ $salesOrderEmployee->total ?? '-'
                        }}</x-tables.td-right-hide
                    >
                    <x-tables.td-left-hide>
                        @if ($salesOrderEmployee->image == null)
                        <x-partials.thumbnail src="" />
                        @else
                        <a
                            href="{{ \Storage::url($salesOrderEmployee->image) }}"
                        >
                            <x-partials.thumbnail
                                src="{{ $salesOrderEmployee->image ? \Storage::url($salesOrderEmployee->image) : '' }}"
                            />
                        </a>
                        @endif
                    </x-tables.td-left-hide>

                    <x-tables.td-left-hide
                        >{{ $salesOrderEmployee->status ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $salesOrderEmployee->notes ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ optional($salesOrderEmployee->created_by)->name ??
                        '-' }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ optional($salesOrderEmployee->approved_by)->name ??
                        '-' }}</x-tables.td-left-hide
                    >
                    <td class="px-4 py-3 text-center" style="width: 134px;">
                        <div
                            role="group"
                            aria-label="Row Actions"
                            class="relative inline-flex align-middle"
                        >
                            @if($salesOrderEmployee->status != '2')
                            <a
                                href="{{ route('sales-order-employees.edit', $salesOrderEmployee) }}"
                                class="mr-1"
                            >
                                <x-buttons.edit></x-buttons.edit>
                            </a>
                            @elseif($salesOrderEmployee->status == '2')
                            <a
                                href="{{ route('sales-order-employees.show', $salesOrderEmployee) }}"
                                class="mr-1"
                            >
                                <x-buttons.show></x-buttons.show>
                            </a>
                            @endif @can('delete', $salesOrderEmployee)
                            <form
                                action="{{ route('sales-order-employees.destroy', $salesOrderEmployee) }}"
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
                <x-tables.no-items-found colspan="11">
                </x-tables.no-items-found>
                @endforelse
            </x-slot>
            <x-slot name="foot"> </x-slot>
        </x-table>
    </x-tables.card>
    <div class="mt-10 px-4">{!! $salesOrderEmployees->render() !!}</div>
</x-admin-layout>
