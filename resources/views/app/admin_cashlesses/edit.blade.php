@if ($adminCashless->status != 2)
<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.admin_cashlesses.edit_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('admin-cashlesses.index') }}" class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <x-form
                    method="PUT"
                    action="{{ route('admin-cashlesses.update', $adminCashless) }}"
                    class="mt-4"
                >
                    @include('app.admin_cashlesses.form-inputs')

                    <div class="mt-10">
                        <a
                            href="{{ route('admin-cashlesses.index') }}"
                            class="button"
                        >
                            <i
                                class="
                                    mr-1
                                    icon
                                    ion-md-return-left
                                    text-primary
                                "
                            ></i>
                            @lang('crud.common.back')
                        </a>

                        <x-jet-button class="float-right">
                            <i class="mr-1 icon ion-md-save"></i>
                            @lang('crud.common.update')
                        </x-jet-button>
                    </div>
                </x-form>
            </x-partials.card>

            @can('view-any', App\Models\AccountCashless::class)
            <x-partials.card class="mt-5">
                <x-slot name="title"> Account Cashlesses </x-slot>

                <livewire:admin-cashless-account-cashlesses-detail
                    :adminCashless="$adminCashless"
                />
            </x-partials.card>
            @endcan
        </div>
    </div>
</x-admin-layout>
@else
<x-admin-layout>
    <a href="{{ route('admin-cashlesses.index') }}" class="button">
        <i class="mr-1 icon ion-md-return-left text-primary"></i>
        FORBIDDEN ACCESS @lang('crud.common.back')
    </a>
</x-admin-layout>
@endif
