<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.transfer_to_accounts.index_title')
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
                @can('create', App\Models\TransferToAccount::class)
                <a href="{{ route('transfer-to-accounts.create') }}"
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
                    >@lang('crud.transfer_to_accounts.inputs.name')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.transfer_to_accounts.inputs.number')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.transfer_to_accounts.inputs.bank_id')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.transfer_to_accounts.inputs.status')</x-tables.th-left
                >
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($transferToAccounts as $transferToAccount)
                <tr class="hover:bg-gray-50">
                    <x-tables.td-left-hide
                        >{{ $transferToAccount->name ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $transferToAccount->number ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ optional($transferToAccount->bank)->name ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $transferToAccount->status ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <td class="px-4 py-3 text-center" style="width: 134px;">
                        <div
                            role="group"
                            aria-label="Row Actions"
                            class="relative inline-flex align-middle"
                        >
                            @if($transferToAccount->status != '2')
                            <a
                                href="{{ route('transfer-to-accounts.edit', $transferToAccount) }}"
                                class="mr-1"
                            >
                                <x-buttons.edit></x-buttons.edit>
                            </a>
                            @elseif($transferToAccount->status == '2')
                            <a
                                href="{{ route('transfer-to-accounts.show', $transferToAccount) }}"
                                class="mr-1"
                            >
                                <x-buttons.show></x-buttons.show>
                            </a>
                            @endif @can('delete', $transferToAccount)
                            <form
                                action="{{ route('transfer-to-accounts.destroy', $transferToAccount) }}"
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
    <div class="mt-10 px-4">{!! $transferToAccounts->render() !!}</div>
</x-admin-layout>
