<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.request_purchases.index_title')
        </h2>
        <p class="mt-2 text-xs text-gray-700">permintaan bahan baku</p>
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
                @can('create', App\Models\RequestPurchase::class)
                    <a href="{{ route('request-purchases.create') }}">
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
                <x-tables.th-left>@lang('crud.request_purchases.inputs.store_id')</x-tables.th-left>
                <x-tables.th-left-hide>@lang('crud.request_purchases.inputs.date')</x-tables.th-left-hide>
                @role('super-admin')
                    <x-tables.th-left-hide>@lang('crud.request_purchases.inputs.user_id')</x-tables.th-left-hide>
                @endrole
                <x-tables.th-left-hide>Detail Request</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.request_purchases.inputs.status')</x-tables.th-left-hide>
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($requestPurchases as $requestPurchase)
                    <tr class="hover:bg-gray-50">
                        <x-tables.td-left-main>
                            <x-slot name="main">{{ optional($requestPurchase->store)->nickname ?? '-' }}</x-slot>
                            <x-slot name="sub">{{ $requestPurchase->date->toFormattedDate() ?? '-' }}
                                @foreach ($requestPurchase->detailRequests as $detailRequest)
                                    {{ $detailRequest->product->name }} - {{ $detailRequest->quantity_plan }}
                                    {{ $detailRequest->product->unit->unit }} -
                                    @if ($detailRequest->status == 1)
                                        <x-spans.yellow>belum disetujui</x-spans.yellow>
                                    @elseif($detailRequest->status == 2)
                                        <x-spans.green>disetujui</x-spans.green>
                                    @elseif($detailRequest->status == 3)
                                        <x-spans.red>tidak disetujui</x-spans.red>
                                    @endif
                                @endforeach
                            </x-slot>
                        </x-tables.td-left-main>
                        <x-tables.td-left-hide>{{ $requestPurchase->date->toFormattedDate() ?? '-' }}
                        </x-tables.td-left-hide>
                        @role('super-admin')
                            <x-tables.td-left-hide>{{ optional($requestPurchase->user)->name ?? '-' }}
                            </x-tables.td-left-hide>
                        @endrole
                        <x-tables.td-left-hide>
                            @foreach ($requestPurchase->detailRequests as $detailRequest)
                                {{ $detailRequest->product->name }} - {{ $detailRequest->quantity_plan }}
                                {{ $detailRequest->product->unit->unit }} -
                                @if ($detailRequest->status == 1)
                                    <x-spans.yellow>belum disetujui</x-spans.yellow>
                                @elseif($detailRequest->status == 2)
                                    <x-spans.green>disetujui</x-spans.green>
                                @elseif($detailRequest->status == 3)
                                    <x-spans.red>tidak disetujui</x-spans.red>
                                @endif
                            @endforeach
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            @if ($requestPurchase->status == 1)
                                <x-spans.yellow>process</x-spans.yellow>
                            @else
                                <x-spans.green>done</x-spans.green>
                            @endif
                        </x-tables.td-left-hide>
                        <td class="px-4 py-3 text-center" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @if ($requestPurchase->status != '2')
                                    <a href="{{ route('request-purchases.edit', $requestPurchase) }}" class="mr-1">
                                        <x-buttons.edit></x-buttons.edit>
                                    </a>
                                @elseif($requestPurchase->status == '2')
                                    <a href="{{ route('request-purchases.show', $requestPurchase) }}" class="mr-1">
                                        <x-buttons.show></x-buttons.show>
                                    </a>
                                @endif @can('delete', $requestPurchase)
                                <form action="{{ route('request-purchases.destroy', $requestPurchase) }}"
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
<div class="px-4 mt-10">{!! $requestPurchases->render() !!}</div>
</x-admin-layout>
