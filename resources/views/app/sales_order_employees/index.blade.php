<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.sales_order_employees.index_title')
        </h2>
        <p class="mt-2 text-xs text-gray-700">---</p>
    </x-slot>

    <div class="mt-4 mb-5">
        <div class="flex flex-wrap justify-between mt-1">
            <div class="mt-1 md:w-1/3">
                <form>
                    <div class="flex items-center w-full">
                        <x-inputs.text name="search" value="{{ $search ?? '' }}"
                            placeholder="{{ __('crud.common.search') }}" autocomplete="off"></x-inputs.text>

                        <div class="ml-1">
                            <x-jet-button>
                                <i class="icon ion-md-search"></i>
                            </x-jet-button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="mt-1 text-right md:w-1/3">
                @can('create', App\Models\SalesOrderEmployee::class)
                    <a href="{{ route('sales-order-employees.create') }}">
                        <x-jet-button>
                            <i class="mr-1 icon ion-md-add"></i>
                            @lang('crud.common.create')
                        </x-jet-button>
                    </a>
                @endcan
            </div>
        </div>
    </div>

    <x-tables.card>
        <x-table>
            <x-slot name="head">
                <x-tables.th-left>@lang('crud.sales_order_employees.inputs.image')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.sales_order_employees.inputs.store_id')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.sales_order_employees.inputs.customer')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.sales_order_employees.inputs.date')</x-tables.th-left>

                <x-tables.th-left>@lang('crud.sales_order_employees.inputs.status')</x-tables.th-left>
                <x-tables.th-left-hide>Detail Order</x-tables.th-left-hide>
                @role('super-admin|manager')
                    <x-tables.th-left>@lang('crud.sales_order_employees.inputs.user_id')</x-tables.th-left>
                @endrole
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($salesOrderEmployees as $salesOrderEmployee)
                    <tr class="hover:bg-gray-50">
                        <x-tables.td-left-hide>
                            @if ($salesOrderEmployee->image == null)
                                <x-partials.thumbnail src="" />
                            @else
                                <a href="{{ \Storage::url($salesOrderEmployee->image) }}">
                                    <x-partials.thumbnail
                                        src="{{ $salesOrderEmployee->image ? \Storage::url($salesOrderEmployee->image) : '' }}" />
                                </a>
                            @endif
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ optional($salesOrderEmployee->store)->name ?? '-' }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ $salesOrderEmployee->customer ?? '-' }}</x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ $salesOrderEmployee->date->toFormattedDate() ?? '-' }}
                        </x-tables.td-left-hide>


                        <x-tables.td-left-hide>
                            <x-spans.status-valid class="{{ $salesOrderEmployee->status_badge }}">
                                {{ $salesOrderEmployee->status_name }}</x-spans.status-valid>
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            @forelse($salesOrderEmployee->products as $product)
                                <p>
                                    {{ $product->name }} | {{ $product->pivot->quantity }} {{ $product->unit->unit }}
                                    | @currency($product->pivot->unit_price)
                                </p>
                            @empty
                                -
                            @endforelse
                        </x-tables.td-left-hide>
                        @role('super-admin|manager')
                            <x-tables.td-left-hide>{{ optional($salesOrderEmployee->user)->name ?? '-' }}
                            </x-tables.td-left-hide>
                        @endrole
                        <td class="px-4 py-3 text-center" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @if ($salesOrderEmployee->status != '2')
                                    <a href="{{ route('sales-order-employees.edit', $salesOrderEmployee) }}"
                                        class="mr-1">
                                        <x-buttons.edit></x-buttons.edit>
                                    </a>
                                @elseif($salesOrderEmployee->status == '2')
                                    <a href="{{ route('sales-order-employees.show', $salesOrderEmployee) }}"
                                        class="mr-1">
                                        <x-buttons.show></x-buttons.show>
                                    </a>
                                @endif @can('delete', $salesOrderEmployee)
                                <form action="{{ route('sales-order-employees.destroy', $salesOrderEmployee) }}"
                                    method="POST" onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                    @csrf @method('DELETE')
                                    <x-buttons.delete></x-buttons.delete>
                                </form>
                            @endcan
                        </div>
                    </td>
                </tr>
            @empty
                <x-tables.no-items-found colspan="7"> </x-tables.no-items-found>
            @endforelse
        </x-slot>
        <x-slot name="foot"> </x-slot>
    </x-table>
</x-tables.card>
<div class="px-4 mt-10">{!! $salesOrderEmployees->render() !!}</div>
{{-- <livewire:sales-order-employees.sales-order-employees-list /> --}}
</x-admin-layout>
