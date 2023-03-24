<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.presences.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('presences.index') }}" class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <x-shows.dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.presences.inputs.store_id')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ optional($presence->store)->name ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.presences.inputs.shift_store_id')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ optional($presence->shiftStore)->name ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.presences.inputs.date')</x-shows.dt
                        >
                        <x-shows.dd>{{ $presence->date ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.presences.inputs.created_by_id')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ optional($presence->created_by)->name ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.presences.inputs.approved_by_id')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ optional($presence->approved_by)->name ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.presences.inputs.latitude_in')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $presence->latitude_in ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.presences.inputs.longitude_in')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $presence->longitude_in ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.presences.inputs.image_in')</x-shows.dt
                        >
                        @if ($presence->image_in != null)
                        <x-partials.thumbnail src="" size="150" />
                        @else
                        <a href="{{ \Storage::url($presence->image_in) }}">
                            <x-partials.thumbnail
                                src="{{ $presence->image_in ? \Storage::url($presence->image_in) : '' }}"
                                size="150"
                            />
                        </a>
                        @endif
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.presences.inputs.latitude_out')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $presence->latitude_out ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.presences.inputs.longitude_out')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $presence->longitude_out ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.presences.inputs.image_out')</x-shows.dt
                        >
                        @if ($presence->image_out != null)
                        <x-partials.thumbnail src="" size="150" />
                        @else
                        <a href="{{ \Storage::url($presence->image_out) }}">
                            <x-partials.thumbnail
                                src="{{ $presence->image_out ? \Storage::url($presence->image_out) : '' }}"
                                size="150"
                            />
                        </a>
                        @endif
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.presences.inputs.status')</x-shows.dt
                        >
                        <x-shows.dd>{{ $presence->status ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.presences.inputs.time_in')</x-shows.dt
                        >
                        <x-shows.dd>{{ $presence->time_in ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.presences.inputs.time_out')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $presence->time_out ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Created Date</x-shows.dt>
                        <x-shows.dd
                            >{{ $presence->created_at ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Updated Date</x-shows.dt>
                        <x-shows.dd
                            >{{ $presence->updated_at ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                </x-shows.dl>

                <div class="mt-10">
                    <a href="{{ route('presences.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>
                </div>
            </x-partials.card>
        </div>
    </div>
</x-admin-layout>
