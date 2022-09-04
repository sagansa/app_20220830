<x-admin-layout>
    {{-- <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.invoice_purchases.index_title')
        </h2>
        <p class="mt-2 text-xs text-gray-700">---</p>
    </x-slot>

    <div class="mt-4 mb-5">
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
            <div class="mt-1 text-right md:w-1/3">
                @can('create', App\Models\InvoicePurchase::class)
                <a href="{{ route('invoice-purchases.create') }}"
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
                    >@lang('crud.invoice_purchases.inputs.image')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.invoice_purchases.inputs.payment_type_id')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.invoice_purchases.inputs.store_id')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.invoice_purchases.inputs.supplier_id')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.invoice_purchases.inputs.date')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.invoice_purchases.inputs.payment_status')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.invoice_purchases.inputs.order_status')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.invoice_purchases.inputs.created_by_id')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.invoice_purchases.inputs.approved_id')</x-tables.th-left
                >
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($invoicePurchases as $invoicePurchase)
                <tr class="hover:bg-gray-50">
                    <x-tables.td-left-hide>
                        @if ($invoicePurchase->image == null)
                        <x-partials.thumbnail src="" />
                        @else
                        <a href="{{ \Storage::url($invoicePurchase->image) }}">
                            <x-partials.thumbnail
                                src="{{ $invoicePurchase->image ? \Storage::url($invoicePurchase->image) : '' }}"
                            />
                        </a>
                        @endif
                    </x-tables.td-left-hide>

                    <x-tables.td-left-hide
                        >{{ optional($invoicePurchase->paymentType)->name ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ optional($invoicePurchase->store)->name ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ optional($invoicePurchase->supplier)->name ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $invoicePurchase->date ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $invoicePurchase->payment_status ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $invoicePurchase->order_status ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ optional($invoicePurchase->created_by)->name ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ optional($invoicePurchase->approved_by)->name ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <td class="px-4 py-3 text-center" style="width: 134px;">
                        <div
                            role="group"
                            aria-label="Row Actions"
                            class="relative inline-flex align-middle"
                        >
                            @if ($invoicePurchase->status != '2')
                            <a
                                href="{{ route('invoice-purchases.edit', $invoicePurchase) }}"
                                class="mr-1"
                            >
                                <x-buttons.edit></x-buttons.edit>
                            </a>
                            @elseif($invoicePurchase->status == '2')
                            <a
                                href="{{ route('invoice-purchases.show', $invoicePurchase) }}"
                                class="mr-1"
                            >
                                <x-buttons.show></x-buttons.show>
                            </a>
                            @endif @can('delete', $invoicePurchase)
                            <form
                                action="{{ route('invoice-purchases.destroy', $invoicePurchase) }}"
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
                <x-tables.no-items-found colspan="10">
                </x-tables.no-items-found>
                @endforelse
            </x-slot>
            <x-slot name="foot"> </x-slot>
        </x-table>
    </x-tables.card>
    <div class="px-4 mt-10">{!! $invoicePurchases->render() !!}</div> --}}
    <livewire:invoice-purchases.invoice-purchases-list />
</x-admin-layout>
