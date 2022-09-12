<x-admin-layout>
    {{-- <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.e_products.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('e-products.index') }}" class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <x-shows.dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.e_products.inputs.image')</x-shows.dt
                        >
                        @if ($eProduct->image != null)
                        <x-partials.thumbnail src="" size="150" />
                        @else
                        <a href="{{ \Storage::url($eProduct->image) }}">
                            <x-partials.thumbnail
                                src="{{ $eProduct->image ? \Storage::url($eProduct->image) : '' }}"
                                size="150"
                            />
                        </a>
                        @endif
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.e_products.inputs.product_id')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ optional($eProduct->product)->name ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.e_products.inputs.online_category_id')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ optional($eProduct->onlineCategory)->name ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.e_products.inputs.store_id')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ optional($eProduct->store)->name ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.e_products.inputs.quantity_stock')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $eProduct->quantity_stock ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.e_products.inputs.price')</x-shows.dt
                        >
                        <x-shows.dd>{{ $eProduct->price ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.e_products.inputs.status')</x-shows.dt
                        >
                        <x-shows.dd>{{ $eProduct->status ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Created Date</x-shows.dt>
                        <x-shows.dd
                            >{{ $eProduct->created_at ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Updated Date</x-shows.dt>
                        <x-shows.dd
                            >{{ $eProduct->updated_at ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                </x-shows.dl>

                <div class="mt-10">
                    <a href="{{ route('e-products.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>
                </div>
            </x-partials.card>
        </div>
    </div> --}}

    <!--
  This example requires Tailwind CSS v2.0+

  This example requires some changes to your config:

  ```
  // tailwind.config.js
  module.exports = {
    // ...
    plugins: [
      // ...
      require('@tailwindcss/typography'),
    ],
  }
  ```
-->

    <livewire:e-products.e-product-show :eProduct='$eProduct'>
</x-admin-layout>
