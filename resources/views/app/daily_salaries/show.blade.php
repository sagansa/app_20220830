<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.daily_salaries.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('daily-salaries.index') }}" class="mr-4"><i
                            class="mr-1 icon ion-md-arrow-back"></i></a>
                </x-slot>

                <x-shows.dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.daily_salaries.inputs.store_id')</x-shows.dt>
                        <x-shows.dd>{{ optional($dailySalary->store)->name ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.daily_salaries.inputs.shift_store_id')</x-shows.dt>
                        <x-shows.dd>{{ optional($dailySalary->shiftStore)->name ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.daily_salaries.inputs.date')</x-shows.dt>
                        <x-shows.dd>{{ $dailySalary->date ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.daily_salaries.inputs.amount')</x-shows.dt>
                        <x-shows.dd>{{ $dailySalary->amount ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.daily_salaries.inputs.payment_type_id')</x-shows.dt>
                        <x-shows.dd>{{ optional($dailySalary->paymentType)->name ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.daily_salaries.inputs.status')</x-shows.dt>
                        <x-shows.dd>{{ $dailySalary->status ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.daily_salaries.inputs.presence_id')</x-shows.dt>
                        <x-shows.dd>{{ optional($dailySalary->presence)->image_in ?? '-' }}
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Created Date</x-shows.dt>
                        <x-shows.dd>{{ $dailySalary->created_at ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Updated Date</x-shows.dt>
                        <x-shows.dd>{{ $dailySalary->updated_at ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                </x-shows.dl>

                <div class="mt-10">
                    <a href="{{ route('daily-salaries.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>
                </div>
            </x-partials.card>

            @role('supervisor|staff')
                @if ($dailySalary->payment_type_id == 2)
                    @can('view-any', App\Models\ClosingStore::class)
                        <x-partials.card class="mt-5">
                            <x-slot name="title"> Closing Stores </x-slot>

                            <livewire:daily-salary-closing-stores-detail :dailySalary="$dailySalary" />
                        </x-partials.card>
                    @endcan
                @elseif ($dailySalary->payment_type_id == 1)
                    @can('view-any', App\Models\PaymentReceipt::class)
                        <x-partials.card class="mt-5">
                            <x-slot name="title"> Payment Receipts </x-slot>

                            <livewire:daily-salary-payment-receipts-detail :dailySalary="$dailySalary" />
                        </x-partials.card>
                    @endcan
                @endif
            @endrole

            @role('manager|super-admin')
                <x-partials.card class="mt-5">
                    <x-slot name="title"> Closing Stores </x-slot>

                    <livewire:daily-salary-closing-stores-detail :dailySalary="$dailySalary" />
                </x-partials.card>

                <x-partials.card class="mt-5">
                    <x-slot name="title"> Payment Receipts </x-slot>

                    <livewire:daily-salary-payment-receipts-detail :dailySalary="$dailySalary" />
                </x-partials.card>
            @endrole
        </div>
    </div>
</x-admin-layout>
