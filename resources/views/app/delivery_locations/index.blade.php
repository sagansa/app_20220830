<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.delivery_locations.index_title')
        </h2>
        <p class="mt-2 text-xs text-gray-700">---</p>
    </x-slot>

    <div class="mt-4 mb-5">
        <div class="flex flex-wrap justify-between mt-1">
            <div class="mt-1 md:w-1/3">
                <form>
                    <div class="flex items-center w-full">
                        <x-inputs.text name="search" value="{{ $search ?? '' }}"
                            placeholder="{{ __('crud.common.search') }}" autocomplete="off"></x-inputs.text>

                        <div class="ml-1">
                            <x-jet-button>
                                <i class="icon ion-md-search"></i>
                            </x-jet-button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="mt-1 text-right md:w-1/3">
                @can('create', App\Models\DeliveryLocation::class)
                    <a href="{{ route('delivery-locations.create') }}">
                        <x-jet-button>
                            <i class="mr-1 icon ion-md-add"></i>
                            @lang('crud.common.create')
                        </x-jet-button>
                    </a>
                @endcan
            </div>
        </div>
    </div>

    <x-tables.card>
        <x-table>
            <x-slot name="head">
                <x-tables.th-left>@lang('crud.delivery_locations.inputs.label')</x-tables.th-left>
                <x-tables.th-left-hide>@lang('crud.delivery_locations.inputs.contact_name')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.delivery_locations.inputs.contact_number')</x-tables.th-left-hide>
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($deliveryLocations as $deliveryLocation)
                    <tr class="hover:bg-gray-50">
                        <x-tables.td-left-main>
                            <x-slot name="main"> {{ $deliveryLocation->label ?? '-' }}</x-slot>
                            <x-slot name="sub">
                                <div>{{ $deliveryLocation->contact_name ?? '-' }}</div>
                                <div>{{ $deliveryLocation->contact_number ?? '-' }}</div>
                            </x-slot>

                        </x-tables.td-left-main>
                        <x-tables.td-left-hide>{{ $deliveryLocation->contact_name ?? '-' }}</x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ $deliveryLocation->contact_number ?? '-' }}</x-tables.td-left-hide>
                        <td class="px-4 py-3 text-center" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @if ($deliveryLocation->status != '2')
                                    <a href="{{ route('delivery-locations.edit', $deliveryLocation) }}" class="mr-1">
                                        <x-buttons.edit></x-buttons.edit>
                                    </a>
                                @elseif($deliveryLocation->status == '2')
                                    <a href="{{ route('delivery-locations.show', $deliveryLocation) }}" class="mr-1">
                                        <x-buttons.show></x-buttons.show>
                                    </a>
                                @endif @can('delete', $deliveryLocation)
                                <form action="{{ route('delivery-locations.destroy', $deliveryLocation) }}"
                                    method="POST" onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                    @csrf @method('DELETE')
                                    <x-buttons.delete></x-buttons.delete>
                                </form>
                            @endcan
                        </div>
                    </td>
                </tr>
            @empty
                <x-tables.no-items-found colspan="4"> </x-tables.no-items-found>
            @endforelse
        </x-slot>
        <x-slot name="foot"> </x-slot>
    </x-table>
</x-tables.card>
<div class="px-4 mt-10">{!! $deliveryLocations->render() !!}</div>
</x-admin-layout>
