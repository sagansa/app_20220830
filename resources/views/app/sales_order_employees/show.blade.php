<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.sales_order_employees.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a
                        href="{{ route('sales-order-employees.index') }}"
                        class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <x-shows.dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.sales_order_employees.inputs.store_id')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ optional($salesOrderEmployee->store)->name ??
                            '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.sales_order_employees.inputs.customer_id')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ optional($salesOrderEmployee->customer)->name ??
                            '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.sales_order_employees.inputs.delivery_address_id')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{
                            optional($salesOrderEmployee->deliveryAddress)->name
                            ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.sales_order_employees.inputs.date')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $salesOrderEmployee->date ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.sales_order_employees.inputs.image')</x-shows.dt
                        >
                        @if ($salesOrderEmployee->image != null)
                        <x-partials.thumbnail src="" size="150" />
                        @else
                        <a
                            href="{{ \Storage::url($salesOrderEmployee->image) }}"
                        >
                            <x-partials.thumbnail
                                src="{{ $salesOrderEmployee->image ? \Storage::url($salesOrderEmployee->image) : '' }}"
                                size="150"
                            />
                        </a>
                        @endif
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.sales_order_employees.inputs.status')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $salesOrderEmployee->status ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.sales_order_employees.inputs.notes')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $salesOrderEmployee->notes ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.sales_order_employees.inputs.user_id')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ optional($salesOrderEmployee->user)->name ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Created Date</x-shows.dt>
                        <x-shows.dd
                            >{{ $salesOrderEmployee->created_at ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Updated Date</x-shows.dt>
                        <x-shows.dd
                            >{{ $salesOrderEmployee->updated_at ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                </x-shows.dl>

                <div class="mt-10">
                    <a
                        href="{{ route('sales-order-employees.index') }}"
                        class="button"
                    >
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>
                </div>
            </x-partials.card>

            @can('view-any', App\Models\product_sales_order_employee::class)
            <x-partials.card class="mt-5">
                <x-slot name="title"> Products </x-slot>

                <livewire:sales-order-employee-products-detail
                    :salesOrderEmployee="$salesOrderEmployee"
                />
            </x-partials.card>
            @endcan
        </div>
    </div>
</x-admin-layout>
