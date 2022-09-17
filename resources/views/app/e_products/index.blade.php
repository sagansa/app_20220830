<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.e_products.index_title')
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
                @can('create', App\Models\EProduct::class)
                    <a href="{{ route('e-products.create') }}">
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
                <x-tables.th-left-hide>@lang('crud.e_products.inputs.image')</x-tables.th-left-hide>
                <x-tables.th-left>@lang('crud.e_products.inputs.product_id')</x-tables.th-left>
                <x-tables.th-left-hide>@lang('crud.e_products.inputs.online_category_id')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.e_products.inputs.store_id')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.e_products.inputs.quantity_stock')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.e_products.inputs.price')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.e_products.inputs.status')</x-tables.th-left-hide>
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($eProducts as $eProduct)
                    <tr class="hover:bg-gray-50">
                        <x-tables.td-left-main>
                            <x-slot name="main">
                                @if ($eProduct->image == null)
                                    <x-partials.thumbnail src="" />
                                @else
                                    <a href="{{ \Storage::url($eProduct->image) }}">
                                        <x-partials.thumbnail
                                            src="{{ $eProduct->image ? \Storage::url($eProduct->image) : '' }}" />
                                    </a>
                                @endif
                            </x-slot>
                            <x-slot name="sub">
                                <p>{{ optional($eProduct->product)->name ?? '-' }}</p>
                                <p>{{ optional($eProduct->onlineCategory)->name ?? '-' }}</p>
                                <p>{{ optional($eProduct->store)->name ?? '-' }}</p>
                                <p>{{ $eProduct->price ?? '-' }}</p>
                                <p>
                                    <x-spans.status-valid class="{{ $eProduct->status_badge }}">
                                        {{ $eProduct->status_name }}
                                    </x-spans.status-valid>
                                </p>
                            </x-slot>

                        </x-tables.td-left-main>

                        <x-tables.td-left-hide>{{ optional($eProduct->product)->name ?? '-' }}</x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ optional($eProduct->onlineCategory)->name ?? '-' }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ optional($eProduct->store)->name ?? '-' }}</x-tables.td-left-hide>
                        <x-tables.td-right-hide>{{ $eProduct->quantity_stock ?? '-' }}</x-tables.td-right-hide>
                        <x-tables.td-right-hide>{{ $eProduct->price ?? '-' }}</x-tables.td-right-hide>
                        <x-tables.td-left-hide>
                            <x-spans.status-valid class="{{ $eProduct->status_badge }}">
                                {{ $eProduct->status_name }}
                            </x-spans.status-valid>
                        </x-tables.td-left-hide>
                        <td class="px-4 py-3 text-center" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @if ($eProduct->status != '2')
                                    <a href="{{ route('e-products.edit', $eProduct) }}" class="mr-1">
                                        <x-buttons.edit></x-buttons.edit>
                                    </a>
                                @elseif($eProduct->status == '2')
                                    <a href="{{ route('e-products.show', $eProduct) }}" class="mr-1">
                                        <x-buttons.show></x-buttons.show>
                                    </a>
                                @endif @can('delete', $eProduct)
                                <form action="{{ route('e-products.destroy', $eProduct) }}" method="POST"
                                    onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                    @csrf @method('DELETE')
                                    <x-buttons.delete></x-buttons.delete>
                                </form>
                            @endcan
                        </div>
                    </td>
                </tr>
            @empty
                <x-tables.no-items-found colspan="8"> </x-tables.no-items-found>
            @endforelse
        </x-slot>
        <x-slot name="foot"> </x-slot>
    </x-table>
</x-tables.card>
<div class="px-4 mt-10">{!! $eProducts->render() !!}</div>
</x-admin-layout>
