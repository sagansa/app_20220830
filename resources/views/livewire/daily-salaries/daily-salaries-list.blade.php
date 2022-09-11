<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.daily_salaries.index_title')
        </h2>
        <p class="mt-2 text-xs text-gray-700">seluruh pembayaran gaji harian pegawai</p>
    </x-slot>

    <x-tables.topbar>
        <x-slot name="search">
            <x-buttons.link wire:click="$toggle('showFilters')">
                @if ($showFilters)
                    Hide
                @endif Advanced Search...
            </x-buttons.link>
            @if ($showFilters)
                @role('super-admin')
                    <x-filters.group>
                        <x-filters.label>User</x-filters.label>
                        <x-filters.select wire:model="filters.created_by_id">
                            @foreach ($users as $label => $value)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </x-filters.select>
                    </x-filters.group>
                @endrole
                <x-filters.group>
                    <x-filters.label>Payment Type</x-filters.label>
                    <x-filters.select wire:model="filters.payment_type_id">
                        @foreach ($paymentTypes as $label => $value)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-filters.select>
                </x-filters.group>

                <x-filters.group>
                    <x-filters.label>Status</x-filters.label>
                    <x-filters.select wire:model="filters.status">
                        @foreach (App\Models\DailySalary::STATUSES as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-filters.select>
                </x-filters.group>

                <x-buttons.link wire:click="resetFilters">Reset Filter
                </x-buttons.link>
            @endif
        </x-slot>
        <x-slot name="action">
            <div class="flex flex-wrap justify-between mt-1">
                <div class="mt-1 md:w-1/3">
                    @role('super-admin')
                        <x-buttons.green wire:click="markAllAsSudahDibayar">sudah dibayar</x-buttons.green>
                        <x-buttons.gray wire:click="markAllAsSiapDibayar">siap dibayar</x-buttons.gray>
                        <x-buttons.red wire:click="markAllAsTidakValid">perbaiki</x-buttons.red>
                    @endrole
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
        </x-slot>
    </x-tables.topbar>

    <x-tables.card>
        <x-table>
            <x-slot name="head">
                @role('super-admin')
                    <th></th>
                @endrole
                <x-tables.th-left>name</x-tables.th-left>
                <x-tables.th-left-hide>@lang('crud.daily_salaries.inputs.store_id')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.daily_salaries.inputs.date')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.daily_salaries.inputs.amount')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.daily_salaries.inputs.payment_type_id')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.daily_salaries.inputs.status')</x-tables.th-left-hide>
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($dailySalaries as $dailySalary)
                    <tr class="hover:bg-gray-50">
                        @role('super-admin|manager')
                            <x-tables.td-checkbox id="{{ $dailySalary->id }}"></x-tables.td-checkbox>
                        @endrole
                        <x-tables.td-left-main>
                            <x-slot name="main">
                                @role('supervisor|manager|super-admin')
                                    <x-buttons.notes wire:click="edit({{ $dailySalary->id }})">
                                    </x-buttons.notes>
                                @endrole
                                {{ optional($dailySalary->created_by)->name ?? '-' }}
                            </x-slot>
                            <x-slot name="sub">
                                @foreach ($dailySalary->closingStores as $closingStore)
                                    {{ optional($closingStore->store)->nickname }}
                                @endforeach

                                @foreach ($dailySalary->paymentReceipts as $paymentReceipt)
                                    {{ optional($paymentReceipt->store)->nickname }}
                                @endforeach
                                -
                                {{ optional($dailySalary->date)->toFormattedDate() }} -

                                @foreach ($dailySalary->closingStores as $closingStore)
                                    {{ optional($closingStore->date)->toFormattedDate() }}
                                @endforeach

                                @foreach ($dailySalary->paymentReceipts as $paymentReceipt)
                                    {{ optional($paymentReceipt->date)->toFormattedDate() }}
                                @endforeach
                            </x-slot>
                        </x-tables.td-left-main>
                        <x-tables.td-left-hide>
                            @foreach ($dailySalary->closingStores as $closingStore)
                                {{ optional($closingStore->store)->nickname }}
                            @endforeach

                            @foreach ($dailySalary->paymentReceipts as $paymentReceipt)
                                {{ optional($paymentReceipt->store)->nickname }}
                            @endforeach
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            {{ optional($dailySalary->date)->toFormattedDate() }} |

                            @foreach ($dailySalary->closingStores as $closingStore)
                                {{ optional($closingStore->date)->toFormattedDate() }}
                            @endforeach

                            @foreach ($dailySalary->paymentReceipts as $paymentReceipt)
                                {{ $paymentReceipt->created_at }}
                            @endforeach

                        </x-tables.td-left-hide>
                        <x-tables.td-right-hide>@currency($dailySalary->amount)</x-tables.td-right-hide>
                        <x-tables.td-left-hide>{{ optional($dailySalary->paymentType)->name ?? '-' }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            <x-spans.status-valid class="{{ $dailySalary->status_badge }}">
                                {{ $dailySalary->status_name }}
                            </x-spans.status-valid>

                            {{-- @if ($dailySalary->status == 1)
                                <x-spans.yellow>belum diperiksa</x-spans.yellow>
                            @elseif ($dailySalary->status == 2)
                                <x-spans.green>sudah dibayar</x-spans.green>
                            @elseif ($dailySalary->status == 3)
                                <x-spans.gray>siap dibayar</x-spans.gray>
                            @elseif ($dailySalary->status == 4)
                                <x-spans.red>perbaiki</x-spans.red>
                            @endif --}}
                        </x-tables.td-left-hide>
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
                                @endif
                                @can('delete', $dailySalary)
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
            <x-slot name="foot">
                <tr>
                    <td colspan="8">
                        <div class="px-4 my-2">{!! $dailySalaries->render() !!}</div>
                    </td>
                </tr>
            </x-slot>
        </x-table>
    </x-tables.card>

    <!-- Save Purchase Order Modal -->
    <div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" wire:ignore.self>
        <form wire:submit.prevent="save">
            <x-modals.dialog wire:model.defer="showEditModal">
                <x-slot name="title">Daily Salary </x-slot>

                <x-slot name="content">
                    <div class="mt-1 sm:space-y-5">

                        <x-input.date name="dailySalaryDate" label="Date" wire:model.defer="dailySalaryDate">
                        </x-input.date>

                        <x-input.select name="status" label="status" wire:model.defer="editing.status" id="status">
                            <option value="1">belum diperiksa</option>
                            <option value="2">sudah dibayar</option>
                            <option value="3">siap dibayar</option>
                            <option value="4">perbaiki</option>
                        </x-input.select>

                        {{-- <livewire:daily-salary-payment-receipts-detail :dailySalary="$dailySalary" /> --}}
                    </div>
                </x-slot>

                <x-slot name="footer">
                    <x-buttons.secondary wire:click="$set('showEditModal', false)">Cancel</x-buttons.secondary>
                    <x-jet-button type="submit">Save</x-jet-button>
                </x-slot>
            </x-modals.dialog>
        </form>
    </div>
</div>
