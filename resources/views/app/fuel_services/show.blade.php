<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.fuel_services.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('fuel-services.index') }}" class="mr-4"><i
                            class="mr-1 icon ion-md-arrow-back"></i></a>
                </x-slot>

                <x-shows.dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.fuel_services.inputs.image')</x-shows.dt>
                        @if ($fuelService->image != null)
                            <x-partials.thumbnail src="" size="150" />
                        @else
                            <a href="{{ \Storage::url($fuelService->image) }}">
                                <x-partials.thumbnail
                                    src="{{ $fuelService->image ? \Storage::url($fuelService->image) : '' }}"
                                    size="150" />
                            </a>
                        @endif
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.fuel_services.inputs.vehicle_id')</x-shows.dt>
                        <x-shows.dd>{{ optional($fuelService->vehicle)->image ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.fuel_services.inputs.fuel_service')</x-shows.dt>
                        <x-shows.dd>{{ $fuelService->fuel_service ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.fuel_services.inputs.payment_type_id')</x-shows.dt>
                        <x-shows.dd>{{ optional($fuelService->paymentType)->name ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.fuel_services.inputs.km')</x-shows.dt>
                        <x-shows.dd>{{ $fuelService->km ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.fuel_services.inputs.liter')</x-shows.dt>
                        <x-shows.dd>{{ $fuelService->liter ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.fuel_services.inputs.amount')</x-shows.dt>
                        <x-shows.dd>{{ $fuelService->amount ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.fuel_services.inputs.status')</x-shows.dt>
                        <x-shows.dd>{{ $fuelService->status ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.fuel_services.inputs.notes')</x-shows.dt>
                        <x-shows.dd>{{ $fuelService->notes ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Created Date</x-shows.dt>
                        <x-shows.dd>{{ $fuelService->created_at ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Updated Date</x-shows.dt>
                        <x-shows.dd>{{ $fuelService->updated_at ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                </x-shows.dl>

                <div class="mt-10">
                    <a href="{{ route('fuel-services.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>
                </div>
            </x-partials.card>

            @if ($fuelService->payment_type_id == 2)
                @can('view-any', App\Models\FuelService::class)
                    <x-partials.card class="mt-5">
                        <x-slot name="title"> Closing Stores </x-slot>

                        <livewire:fuel-service-closing-stores-detail :fuelService="$fuelService" />
                    </x-partials.card>
                @endcan
            @endif

        </div>
    </div>
</x-admin-layout>
