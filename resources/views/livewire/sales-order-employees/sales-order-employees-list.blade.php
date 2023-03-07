<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.sales_order_employees.index_title')
        </h2>
        <p class="mt-2 text-xs text-gray-700">Laporan penjualan untuk Pegawai</p>
    </x-slot>

    <x-tables.topbar>
        <x-slot name="search">

        </x-slot>
        <x-slot name="action">
            <div class="flex flex-wrap justify-between mt-1">

                <div class="mt-1 text-right md:w-1/2">
                    @role('super-admin|manager')
                        @can('create', App\Models\SalesOrderEmployee::class)
                            <a href="{{ route('sales-order-employees.create') }}">
                                <x-jet-button>
                                    <i class="mr-1 icon ion-md-add"></i>
                                    Sales
                                </x-jet-button>
                            </a>
                        @endcan
                    @endrole
                    @can('create', App\Models\Customer::class)
                        <a href="{{ route('customers.create') }}">
                            <x-jet-button class="mt-1">
                                <i class="mr-1 icon ion-md-add"></i>
                                Customer
                            </x-jet-button>
                        </a>
                    @endcan
                </div>
            </div>
        </x-slot>
    </x-tables.topbar>

    <x-tables.card>
        <x-table>
            <x-slot name="head">
                @role('super-admin|manager')
                    <th></th>
                @endrole

                <th></th>
            </x-slot>
            <x-slot name="body">

            </x-slot>
            <x-slot name="foot">

            </x-slot>
        </x-table>
    </x-tables.card>

</div>
