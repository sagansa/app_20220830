<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.self_consumptions.index_title')
        </h2>
        <p class="mt-2 text-xs text-gray-700">laporan harian mengenai bahan baku yang dikonsumsi oleh pegawai, dikerjakan
            setelah tutup
            warung</p>
    </x-slot>

    <div class="mt-4 mb-5">
        <div class="flex flex-wrap justify-between mt-1">
            <div class="md:w-1/3">
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
            <div class="text-right md:w-1/3">
                @can('create', App\Models\SelfConsumption::class)
                    <a href="{{ route('self-consumptions.create') }}">
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
                <x-tables.th-left>@lang('crud.self_consumptions.inputs.store_id')</x-tables.th-left>
                <x-tables.th-left-hide>@lang('crud.self_consumptions.inputs.date')</x-tables.th-left-hide>
                <x-tables.th-left-hide>Consumption</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.self_consumptions.inputs.status')</x-tables.th-left-hide>
                @role('super-admin|manager|supervisor')
                    <x-tables.th-left-hide>@lang('crud.self_consumptions.inputs.created_by_id')</x-tables.th-left-hide>
                @endrole
                @role('super-admin|staff')
                    <x-tables.th-left-hide>@lang('crud.self_consumptions.inputs.approved_by_id')</x-tables.th-left-hide>
                @endrole
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($selfConsumptions as $selfConsumption)
                    <tr class="hover:bg-gray-50">
                        <x-tables.td-left-main>
                            <x-slot name="main">{{ optional($selfConsumption->store)->name ?? '-' }}</x-slot>
                            <x-slot name="sub">
                                <p>{{ $selfConsumption->date->toFormattedDate() ?? '-' }}</p>
                                <x-spans.status-valid class="{{ $selfConsumption->status_badge }}">
                                    {{ $selfConsumption->status_name }}
                                </x-spans.status-valid>
                                @role('super-admin|manager|supervisor')
                                    <p>created: {{ optional($selfConsumption->created_by)->name ?? '-' }}</p>
                                @endrole
                                @role('super-admin|staff')
                                    <p>approved: {{ optional($selfConsumption->approved_by)->name ?? '-' }}</p>
                                @endrole
                            </x-slot>
                        </x-tables.td-left-main>
                        <x-tables.td-left-hide>{{ $selfConsumption->date->toFormattedDate() ?? '-' }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            @foreach ($selfConsumption->products as $key => $products)
                                <table>
                                    <tr>
                                        <td>{{ $products->name }}</td>
                                        <td>=
                                            @if ($products->pivot->quantity == null)
                                                <x-spans.text-red>0</x-spans.text-red>
                                            @else
                                                <x-spans.text-black>{{ $products->pivot->quantity }}
                                                </x-spans.text-black>
                                            @endif
                                            {{ $products->unit->unit }}
                                        </td>
                                    </tr>
                                </table>
                            @endforeach
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            <x-spans.status-valid class="{{ $selfConsumption->status_badge }}">
                                {{ $selfConsumption->status_name }}
                            </x-spans.status-valid>
                        </x-tables.td-left-hide>
                        @role('super-admin|manager|supervisor')
                            <x-tables.td-left-hide>{{ optional($selfConsumption->created_by)->name ?? '-' }}
                            </x-tables.td-left-hide>
                        @endrole
                        @role('super-admin|staff')
                            <x-tables.td-left-hide>{{ optional($selfConsumption->approved_by)->name ?? '-' }}
                            </x-tables.td-left-hide>
                        @endrole
                        <td class="px-4 py-3 text-center" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @if ($selfConsumption->status != '2')
                                    <a href="{{ route('self-consumptions.edit', $selfConsumption) }}" class="mr-1">
                                        <x-buttons.edit></x-buttons.edit>
                                    </a>
                                @elseif($selfConsumption->status == '2')
                                    <a href="{{ route('self-consumptions.show', $selfConsumption) }}" class="mr-1">
                                        <x-buttons.show></x-buttons.show>
                                    </a>
                                @endif @can('delete', $selfConsumption)
                                <form action="{{ route('self-consumptions.destroy', $selfConsumption) }}"
                                    method="POST" onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                    @csrf @method('DELETE')
                                    <x-buttons.delete></x-buttons.delete>
                                </form>
                            @endcan
                        </div>
                    </td>
                </tr>
            @empty
                <x-tables.no-items-found colspan="6"> </x-tables.no-items-found>
            @endforelse
        </x-slot>
        <x-slot name="foot"> </x-slot>
    </x-table>
</x-tables.card>
<div class="px-4 mt-10">{!! $selfConsumptions->render() !!}</div>
</x-admin-layout>
