<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.contract_locations.index_title')
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
                @can('create', App\Models\ContractLocation::class)
                <a href="{{ route('contract-locations.create') }}"
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
                    >@lang('crud.contract_locations.inputs.location_id')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.contract_locations.inputs.from_date')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.contract_locations.inputs.until_date')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.contract_locations.inputs.nominal_contract')</x-tables.th-left
                >
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($contractLocations as $contractLocation)
                <tr class="hover:bg-gray-50">
                    <x-tables.td-left-hide
                        >{{ optional($contractLocation->location)->name ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $contractLocation->from_date ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $contractLocation->until_date ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-right-hide
                        >{{ $contractLocation->nominal_contract ?? '-'
                        }}</x-tables.td-right-hide
                    >
                    <td class="px-4 py-3 text-center" style="width: 134px;">
                        <div
                            role="group"
                            aria-label="Row Actions"
                            class="relative inline-flex align-middle"
                        >
                            @if($contractLocation->status != '2')
                            <a
                                href="{{ route('contract-locations.edit', $contractLocation) }}"
                                class="mr-1"
                            >
                                <x-buttons.edit></x-buttons.edit>
                            </a>
                            @elseif($contractLocation->status == '2')
                            <a
                                href="{{ route('contract-locations.show', $contractLocation) }}"
                                class="mr-1"
                            >
                                <x-buttons.show></x-buttons.show>
                            </a>
                            @endif @can('delete', $contractLocation)
                            <form
                                action="{{ route('contract-locations.destroy', $contractLocation) }}"
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
                <x-tables.no-items-found colspan="5"> </x-tables.no-items-found>
                @endforelse
            </x-slot>
            <x-slot name="foot"> </x-slot>
        </x-table>
    </x-tables.card>
    <div class="mt-10 px-4">{!! $contractLocations->render() !!}</div>
</x-admin-layout>
