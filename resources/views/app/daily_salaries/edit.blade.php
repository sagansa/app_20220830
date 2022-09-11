@if ($dailySalary->status != 2)
    <x-admin-layout>
        <x-slot name="header">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                @lang('crud.daily_salaries.edit_title')
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <x-partials.card>
                    <x-slot name="title">
                        <a href="{{ route('daily-salaries.index') }}" class="mr-4"><i
                                class="mr-1 icon ion-md-arrow-back"></i></a>
                    </x-slot>

                    <x-form method="PUT" action="{{ route('daily-salaries.update', $dailySalary) }}" class="mt-4">
                        @include('app.daily_salaries.form-inputs')

                        <div class="mt-10">
                            <a href="{{ route('daily-salaries.index') }}" class="button">
                                <i class="mr-1 icon ion-md-return-left text-primary"></i>
                                @lang('crud.common.back')
                            </a>

                            <x-jet-button class="float-right">
                                <i class="mr-1 icon ion-md-save"></i>
                                @lang('crud.common.update')
                            </x-jet-button>
                        </div>
                    </x-form>
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
                @endrole
            </div>
        </div>
    </x-admin-layout>
@else
    <x-admin-layout>
        <a href="{{ route('daily-salaries.index') }}" class="button">
            <i class="mr-1 icon ion-md-return-left text-primary"></i>
            FORBIDDEN ACCESS @lang('crud.common.back')
        </a>
    </x-admin-layout>
@endif
