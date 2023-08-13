<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.locations.index_title')
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
                @can('create', App\Models\Location::class)
                <a href="{{ route('locations.create') }}"
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
                    >@lang('crud.locations.inputs.name')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.locations.inputs.store_id')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.locations.inputs.address')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.locations.inputs.contact_person_name')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.locations.inputs.contact_person_number')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.locations.inputs.village_id')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.locations.inputs.codepos')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.locations.inputs.province_id')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.locations.inputs.regency_id')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.locations.inputs.district_id')</x-tables.th-left
                >
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($locations as $location)
                <tr class="hover:bg-gray-50">
                    <x-tables.td-left-hide
                        >{{ $location->name ?? '-' }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ optional($location->store)->name ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $location->address ?? '-' }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $location->contact_person_name ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $location->contact_person_number ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ optional($location->village)->name ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-right-hide
                        >{{ $location->codepos ?? '-' }}</x-tables.td-right-hide
                    >
                    <x-tables.td-left-hide
                        >{{ optional($location->province)->name ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ optional($location->regency)->name ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ optional($location->district)->name ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <td class="px-4 py-3 text-center" style="width: 134px;">
                        <div
                            role="group"
                            aria-label="Row Actions"
                            class="relative inline-flex align-middle"
                        >
                            @if($location->status != '2')
                            <a
                                href="{{ route('locations.edit', $location) }}"
                                class="mr-1"
                            >
                                <x-buttons.edit></x-buttons.edit>
                            </a>
                            @elseif($location->status == '2')
                            <a
                                href="{{ route('locations.show', $location) }}"
                                class="mr-1"
                            >
                                <x-buttons.show></x-buttons.show>
                            </a>
                            @endif @can('delete', $location)
                            <form
                                action="{{ route('locations.destroy', $location) }}"
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
    <div class="mt-10 px-4">{!! $locations->render() !!}</div>
</x-admin-layout>
