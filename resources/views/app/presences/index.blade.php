<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.presences.index_title')
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
                @can('create', App\Models\Presence::class)
                <a href="{{ route('presences.create') }}"
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
                    >@lang('crud.presences.inputs.store_id')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.presences.inputs.shift_store_id')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.presences.inputs.date_in')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.presences.inputs.time_in')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.presences.inputs.latitude_in')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.presences.inputs.longitude_in')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.presences.inputs.image_in')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.presences.inputs.created_by_id')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.presences.inputs.approved_by_id')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.presences.inputs.date_out')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.presences.inputs.time_out')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.presences.inputs.latitude_out')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.presences.inputs.longitude_out')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.presences.inputs.image_out')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.presences.inputs.status')</x-tables.th-left
                >
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($presences as $presence)
                <tr class="hover:bg-gray-50">
                    <x-tables.td-left-hide
                        >{{ optional($presence->store)->name ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ optional($presence->shiftStore)->name ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $presence->date_in ?? '-' }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $presence->time_in ?? '-' }}</x-tables.td-left-hide
                    >
                    <x-tables.td-right-hide
                        >{{ $presence->latitude_in ?? '-'
                        }}</x-tables.td-right-hide
                    >
                    <x-tables.td-right-hide
                        >{{ $presence->longitude_in ?? '-'
                        }}</x-tables.td-right-hide
                    >
                    <x-tables.td-left-hide>
                        @if ($presence->image_in == null)
                        <x-partials.thumbnail src="" />
                        @else
                        <a href="{{ \Storage::url($presence->image_in) }}">
                            <x-partials.thumbnail
                                src="{{ $presence->image_in ? \Storage::url($presence->image_in) : '' }}"
                            />
                        </a>
                        @endif
                    </x-tables.td-left-hide>

                    <x-tables.td-left-hide
                        >{{ optional($presence->created_by)->name ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ optional($presence->approved_by)->name ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $presence->date_out ?? '-' }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $presence->time_out ?? '-' }}</x-tables.td-left-hide
                    >
                    <x-tables.td-right-hide
                        >{{ $presence->latitude_out ?? '-'
                        }}</x-tables.td-right-hide
                    >
                    <x-tables.td-right-hide
                        >{{ $presence->longitude_out ?? '-'
                        }}</x-tables.td-right-hide
                    >
                    <x-tables.td-left-hide>
                        @if ($presence->image_out == null)
                        <x-partials.thumbnail src="" />
                        @else
                        <a href="{{ \Storage::url($presence->image_out) }}">
                            <x-partials.thumbnail
                                src="{{ $presence->image_out ? \Storage::url($presence->image_out) : '' }}"
                            />
                        </a>
                        @endif
                    </x-tables.td-left-hide>

                    <x-tables.td-left-hide
                        >{{ $presence->status ?? '-' }}</x-tables.td-left-hide
                    >
                    <td class="px-4 py-3 text-center" style="width: 134px;">
                        <div
                            role="group"
                            aria-label="Row Actions"
                            class="relative inline-flex align-middle"
                        >
                            @if($presence->status != '2')
                            <a
                                href="{{ route('presences.edit', $presence) }}"
                                class="mr-1"
                            >
                                <x-buttons.edit></x-buttons.edit>
                            </a>
                            @elseif($presence->status == '2')
                            <a
                                href="{{ route('presences.show', $presence) }}"
                                class="mr-1"
                            >
                                <x-buttons.show></x-buttons.show>
                            </a>
                            @endif @can('delete', $presence)
                            <form
                                action="{{ route('presences.destroy', $presence) }}"
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
                <x-tables.no-items-found colspan="16">
                </x-tables.no-items-found>
                @endforelse
            </x-slot>
            <x-slot name="foot"> </x-slot>
        </x-table>
    </x-tables.card>
    <div class="mt-10 px-4">{!! $presences->render() !!}</div>
</x-admin-layout>
