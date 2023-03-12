<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.delivery_locations.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a
                        href="{{ route('delivery-locations.index') }}"
                        class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <x-shows.dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.delivery_locations.inputs.label')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $deliveryLocation->label ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.delivery_locations.inputs.contact_name')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $deliveryLocation->contact_name ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.delivery_locations.inputs.contact_number')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $deliveryLocation->contact_number ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.delivery_locations.inputs.address')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $deliveryLocation->address ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.delivery_locations.inputs.village_id')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ optional($deliveryLocation->village)->name ??
                            '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.delivery_locations.inputs.user_id')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ optional($deliveryLocation->user)->name ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.delivery_locations.inputs.province_id')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ optional($deliveryLocation->province)->name ??
                            '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.delivery_locations.inputs.regency_id')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ optional($deliveryLocation->regency)->name ??
                            '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.delivery_locations.inputs.district_id')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ optional($deliveryLocation->district)->name ??
                            '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Created Date</x-shows.dt>
                        <x-shows.dd
                            >{{ $deliveryLocation->created_at ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Updated Date</x-shows.dt>
                        <x-shows.dd
                            >{{ $deliveryLocation->updated_at ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                </x-shows.dl>

                <div class="mt-10">
                    <a
                        href="{{ route('delivery-locations.index') }}"
                        class="button"
                    >
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>
                </div>
            </x-partials.card>
        </div>
    </div>
</x-admin-layout>
