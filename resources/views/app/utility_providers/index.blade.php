<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.utility_providers.index_title')
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
                @can('create', App\Models\UtilityProvider::class)
                    <a href="{{ route('utility-providers.create') }}">
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
                <x-tables.th-left>@lang('crud.utility_providers.inputs.name')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.utility_providers.inputs.category')</x-tables.th-left>
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($utilityProviders as $utilityProvider)
                    <tr class="hover:bg-gray-50">
                        <x-tables.td-left-hide>{{ $utilityProvider->name ?? '-' }}</x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            @if ($utilityProvider->category == 1)
                                listrik
                            @elseif ($utilityProvider->category == 2)
                                air
                            @elseif ($utilityProvider->category == 3)
                                internet
                            @endif
                        </x-tables.td-left-hide>
                        <td class="px-4 py-3 text-center" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @if ($utilityProvider->status != '2')
                                    <a href="{{ route('utility-providers.edit', $utilityProvider) }}" class="mr-1">
                                        <x-buttons.edit></x-buttons.edit>
                                    </a>
                                @elseif($utilityProvider->status == '2')
                                    <a href="{{ route('utility-providers.show', $utilityProvider) }}" class="mr-1">
                                        <x-buttons.show></x-buttons.show>
                                    </a>
                                @endif @can('delete', $utilityProvider)
                                <form action="{{ route('utility-providers.destroy', $utilityProvider) }}" method="POST"
                                    onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                    @csrf @method('DELETE')
                                    <x-buttons.delete></x-buttons.delete>
                                </form>
                            @endcan
                        </div>
                    </td>
                </tr>
            @empty
                <x-tables.no-items-found colspan="3"> </x-tables.no-items-found>
            @endforelse
        </x-slot>
        <x-slot name="foot"> </x-slot>
    </x-table>
</x-tables.card>
<div class="px-4 mt-10">{!! $utilityProviders->render() !!}</div>
</x-admin-layout>
