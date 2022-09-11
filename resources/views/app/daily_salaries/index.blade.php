<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.daily_salaries.index_title')
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
                @can('create', App\Models\DailySalary::class)
                    <a href="{{ route('daily-salaries.create') }}">
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
                <x-tables.th-left>name</x-tables.th-left>
                <x-tables.th-left>@lang('crud.daily_salaries.inputs.store_id')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.daily_salaries.inputs.shift_store_id')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.daily_salaries.inputs.date')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.daily_salaries.inputs.amount')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.daily_salaries.inputs.payment_type_id')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.daily_salaries.inputs.status')</x-tables.th-left>
                {{-- <x-tables.th-left>@lang('crud.daily_salaries.inputs.presence_id')</x-tables.th-left> --}}
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($dailySalaries as $dailySalary)
                    <tr class="hover:bg-gray-50">
                        <x-tables.td-left-hide>{{ optional($dailySalary->created_by)->name ?? '-' }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            {{-- {{ optional($dailySalary->store)->nickname ?? '-' }} --}}
                            @foreach ($dailySalary->closingStores as $closingStore)
                                {{ optional($closingStore->store)->nickname }}
                            @endforeach

                            @foreach ($dailySalary->paymentReceipts as $paymentReceipt)
                                {{ optional($paymentReceipt->store)->nickname }}
                            @endforeach
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ optional($dailySalary->shiftStore)->name ?? '-' }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ optional($dailySalary->date)->toFormattedDate() ?? '-' }}
                        </x-tables.td-left-hide>
                        <x-tables.td-right-hide>@currency($dailySalary->amount)</x-tables.td-right-hide>
                        <x-tables.td-left-hide>{{ optional($dailySalary->paymentType)->name ?? '-' }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            @if ($dailySalary->status == 1)
                                <x-spans.yellow>belum diperiksa</x-spans.yellow>
                            @elseif ($dailySalary->status == 2)
                                <x-spans.green>sudah dibayar</x-spans.green>
                            @elseif ($dailySalary->status == 3)
                                <x-spans.gray>siap dibayar</x-spans.gray>
                            @elseif ($dailySalary->status == 4)
                                <x-spans.red>perbaiki</x-spans.red>
                            @endif
                        </x-tables.td-left-hide>
                        {{-- <x-tables.td-left-hide>{{ optional($dailySalary->presence)->image_in ?? '-' }}
                        </x-tables.td-left-hide> --}}
                        <td class="px-4 py-3 text-center" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @if ($dailySalary->status != '2')
                                    <a href="{{ route('daily-salaries.edit', $dailySalary) }}" class="mr-1">
                                        <x-buttons.edit></x-buttons.edit>
                                    </a>
                                @elseif($dailySalary->status == '2')
                                    <a href="{{ route('daily-salaries.show', $dailySalary) }}" class="mr-1">
                                        <x-buttons.show></x-buttons.show>
                                    </a>
                                @endif @can('delete', $dailySalary)
                                <form action="{{ route('daily-salaries.destroy', $dailySalary) }}" method="POST"
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
<div class="px-4 mt-10">{!! $dailySalaries->render() !!}</div>
</x-admin-layout>
