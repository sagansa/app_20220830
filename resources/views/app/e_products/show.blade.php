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
    <div class="bg-white">
        <div class="pt-6 pb-16 sm:pb-24">
            <nav aria-label="Breadcrumb" class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <ol role="list" class="flex items-center space-x-4">

                    <li>
                        <div class="flex items-center">
                            <a href="#"
                                class="mr-4 text-sm font-medium text-gray-900">{{ $eProduct->onlineCategory->name }}</a>
                            <svg viewBox="0 0 6 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"
                                class="w-auto h-5 text-gray-300">
                                <path d="M4.878 4.34H3.551L.27 16.532h1.327l3.281-12.19z" fill="currentColor" />
                            </svg>
                        </div>
                    </li>

                    <li class="text-sm">
                        <a href="#" aria-current="page"
                            class="font-medium text-gray-500 hover:text-gray-600">{{ $eProduct->product->name }}</a>
                    </li>
                </ol>
            </nav>
            <div class="max-w-2xl px-4 mx-auto mt-8 sm:px-6 lg:max-w-7xl lg:px-8">
                <div class="lg:grid lg:auto-rows-min lg:grid-cols-12 lg:gap-x-8">
                    <div class="lg:col-span-5 lg:col-start-8">
                        <div class="flex justify-between">
                            <h1 class="text-xl font-medium text-gray-900">{{ $eProduct->product->name }} -
                                {{ $eProduct->product->unit->unit }}</h1>
                            <p class="text-xl font-medium text-gray-900">@currency($eProduct->price)</p>
                        </div>
                        <!-- Reviews -->
                        {{-- <div class="mt-4">
                            <h2 class="sr-only">Reviews</h2>
                            <div class="flex items-center">
                                <p class="text-sm text-gray-700">
                                    3.9
                                    <span class="sr-only"> out of 5 stars</span>
                                </p>
                                <div class="flex items-center ml-1">

                                    <svg class="flex-shrink-0 w-5 h-5 text-yellow-400"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z"
                                            clip-rule="evenodd" />
                                    </svg>

                                    <!-- Heroicon name: mini/star -->
                                    <svg class="flex-shrink-0 w-5 h-5 text-yellow-400"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z"
                                            clip-rule="evenodd" />
                                    </svg>

                                    <!-- Heroicon name: mini/star -->
                                    <svg class="flex-shrink-0 w-5 h-5 text-yellow-400"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z"
                                            clip-rule="evenodd" />
                                    </svg>

                                    <!-- Heroicon name: mini/star -->
                                    <svg class="flex-shrink-0 w-5 h-5 text-yellow-400"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z"
                                            clip-rule="evenodd" />
                                    </svg>

                                    <!-- Heroicon name: mini/star -->
                                    <svg class="flex-shrink-0 w-5 h-5 text-gray-200" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div aria-hidden="true" class="ml-4 text-sm text-gray-300">·</div>
                                <div class="flex ml-4">
                                    <a href="#"
                                        class="text-sm font-medium text-indigo-600 hover:text-indigo-500">See all 512
                                        reviews</a>
                                </div>
                            </div>
                        </div> --}}
                        <div class="flex justify-between">
                            <label for="first-name"
                                class="block mt-2 text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Quantity</label>
                            <div class="mt-1 sm:col-span-2 sm:mt-0">
                                <input type="number" name="first-name" id="first-name" autocomplete="given-name"
                                    class="block w-full max-w-lg text-right border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:max-w-xs sm:text-sm">

                            </div>
                        </div>

                        <div class="flex justify-between">
                            <label for="first-name"
                                class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Subtotal</label>
                            <div class="pt-1 sm:col-span-2 sm:mt-0">
                                <p>@currency($eProduct->price)</p>

                            </div>
                        </div>


                    </div>

                    <!-- Image gallery -->
                    <div class="mt-8 lg:col-span-7 lg:col-start-1 lg:row-span-3 lg:row-start-1 lg:mt-0">
                        <h2 class="sr-only">Images</h2>

                        <div class="grid grid-cols-1 lg:grid-cols-2 lg:grid-rows-3 lg:gap-8">
                            <img src="{{ \Storage::url($eProduct->image) }}"
                                alt="Back of women&#039;s Basic Tee in black."
                                class="rounded-lg lg:col-span-2 lg:row-span-2">

                            {{-- <img src="https://tailwindui.com/img/ecommerce-images/product-page-01-product-shot-01.jpg"
                                alt="Side profile of women&#039;s Basic Tee in black."
                                class="hidden rounded-lg lg:block">

                            <img src="https://tailwindui.com/img/ecommerce-images/product-page-01-product-shot-02.jpg"
                                alt="Front of women&#039;s Basic Tee in black." class="hidden rounded-lg lg:block"> --}}
                        </div>
                    </div>

                    <div class="mt-2 lg:col-span-5">
                        <form>
                            <!-- Color picker -->
                            {{-- <div>
                                <h2 class="text-sm font-medium text-gray-900">Color</h2>

                                <fieldset class="mt-2">
                                    <legend class="sr-only">Choose a color</legend>
                                    <div class="flex items-center space-x-3">

                                        <label
                                            class="-m-0.5 relative p-0.5 rounded-full flex items-center justify-center cursor-pointer focus:outline-none ring-gray-900">
                                            <input type="radio" name="color-choice" value="Black" class="sr-only"
                                                aria-labelledby="color-choice-0-label">
                                            <span id="color-choice-0-label" class="sr-only"> Black </span>
                                            <span aria-hidden="true"
                                                class="w-8 h-8 bg-gray-900 border border-black rounded-full border-opacity-10"></span>
                                        </label>

                                        <label
                                            class="-m-0.5 relative p-0.5 rounded-full flex items-center justify-center cursor-pointer focus:outline-none ring-gray-400">
                                            <input type="radio" name="color-choice" value="Heather Grey"
                                                class="sr-only" aria-labelledby="color-choice-1-label">
                                            <span id="color-choice-1-label" class="sr-only"> Heather Grey </span>
                                            <span aria-hidden="true"
                                                class="w-8 h-8 bg-gray-400 border border-black rounded-full border-opacity-10"></span>
                                        </label>
                                    </div>
                                </fieldset>
                            </div> --}}

                            <!-- Size picker -->
                            {{-- <div class="mt-8">
                                <div class="flex items-center justify-between">
                                    <h2 class="text-sm font-medium text-gray-900">Size</h2>
                                    <a href="#"
                                        class="text-sm font-medium text-indigo-600 hover:text-indigo-500">See sizing
                                        chart</a>
                                </div>

                                <fieldset class="mt-2">
                                    <legend class="sr-only">Choose a size</legend>
                                    <div class="grid grid-cols-3 gap-3 sm:grid-cols-6">

                                        <label
                                            class="flex items-center justify-center px-3 py-3 text-sm font-medium uppercase border rounded-md cursor-pointer sm:flex-1 focus:outline-none">
                                            <input type="radio" name="size-choice" value="XXS" class="sr-only"
                                                aria-labelledby="size-choice-0-label">
                                            <span id="size-choice-0-label">XXS</span>
                                        </label>

                                        <label
                                            class="flex items-center justify-center px-3 py-3 text-sm font-medium uppercase border rounded-md cursor-pointer sm:flex-1 focus:outline-none">
                                            <input type="radio" name="size-choice" value="XS" class="sr-only"
                                                aria-labelledby="size-choice-1-label">
                                            <span id="size-choice-1-label">XS</span>
                                        </label>

                                        <label
                                            class="flex items-center justify-center px-3 py-3 text-sm font-medium uppercase border rounded-md cursor-pointer sm:flex-1 focus:outline-none">
                                            <input type="radio" name="size-choice" value="S" class="sr-only"
                                                aria-labelledby="size-choice-2-label">
                                            <span id="size-choice-2-label">S</span>
                                        </label>

                                        <label
                                            class="flex items-center justify-center px-3 py-3 text-sm font-medium uppercase border rounded-md cursor-pointer sm:flex-1 focus:outline-none">
                                            <input type="radio" name="size-choice" value="M" class="sr-only"
                                                aria-labelledby="size-choice-3-label">
                                            <span id="size-choice-3-label">M</span>
                                        </label>

                                        <label
                                            class="flex items-center justify-center px-3 py-3 text-sm font-medium uppercase border rounded-md cursor-pointer sm:flex-1 focus:outline-none">
                                            <input type="radio" name="size-choice" value="L" class="sr-only"
                                                aria-labelledby="size-choice-4-label">
                                            <span id="size-choice-4-label">L</span>
                                        </label>

                                        <label
                                            class="flex items-center justify-center px-3 py-3 text-sm font-medium uppercase border rounded-md opacity-25 cursor-not-allowed sm:flex-1">
                                            <input type="radio" name="size-choice" value="XL" disabled
                                                class="sr-only" aria-labelledby="size-choice-5-label">
                                            <span id="size-choice-5-label">XL</span>
                                        </label>
                                    </div>
                                </fieldset>
                            </div> --}}

                            <button type="submit"
                                class="flex items-center justify-center w-full px-8 py-3 mt-8 text-base font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Add
                                to cart</button>
                        </form>

                        <!-- Product details -->
                        <div class="mt-10">
                            <h2 class="text-sm font-medium text-gray-900">Description</h2>

                            <div class="mt-4 prose-sm prose text-gray-500">
                                <p>{{ $eProduct->product->description }}</p>
                            </div>
                        </div>

                        <div class="pt-8 mt-8 border-t border-gray-200">
                            <h2 class="text-sm font-medium text-gray-900">Fabric &amp; Care</h2>

                            <div class="mt-4 prose-sm prose text-gray-500">
                                <ul role="list">
                                    <li>Only the best materials</li>

                                    <li>Ethically and locally made</li>

                                    <li>Pre-washed and pre-shrunk</li>

                                    <li>Machine wash cold with similar colors</li>
                                </ul>
                            </div>
                        </div>

                        {{-- <!-- Policies -->
                        <section aria-labelledby="policies-heading" class="mt-10">
                            <h2 id="policies-heading" class="sr-only">Our Policies</h2>

                            <dl class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-1 xl:grid-cols-2">
                                <div class="p-6 text-center border border-gray-200 rounded-lg bg-gray-50">
                                    <dt>
                                        <!-- Heroicon name: outline/globe-americas -->
                                        <svg class="flex-shrink-0 w-6 h-6 mx-auto text-gray-400"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6.115 5.19l.319 1.913A6 6 0 008.11 10.36L9.75 12l-.387.775c-.217.433-.132.956.21 1.298l1.348 1.348c.21.21.329.497.329.795v1.089c0 .426.24.815.622 1.006l.153.076c.433.217.956.132 1.298-.21l.723-.723a8.7 8.7 0 002.288-4.042 1.087 1.087 0 00-.358-1.099l-1.33-1.108c-.251-.21-.582-.299-.905-.245l-1.17.195a1.125 1.125 0 01-.98-.314l-.295-.295a1.125 1.125 0 010-1.591l.13-.132a1.125 1.125 0 011.3-.21l.603.302a.809.809 0 001.086-1.086L14.25 7.5l1.256-.837a4.5 4.5 0 001.528-1.732l.146-.292M6.115 5.19A9 9 0 1017.18 4.64M6.115 5.19A8.965 8.965 0 0112 3c1.929 0 3.716.607 5.18 1.64" />
                                        </svg>
                                        <span class="mt-4 text-sm font-medium text-gray-900">International
                                            delivery</span>
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-500">Get your order in 2 years</dd>
                                </div>

                                <div class="p-6 text-center border border-gray-200 rounded-lg bg-gray-50">
                                    <dt>
                                        <!-- Heroicon name: outline/currency-dollar -->
                                        <svg class="flex-shrink-0 w-6 h-6 mx-auto text-gray-400"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="mt-4 text-sm font-medium text-gray-900">Loyalty rewards</span>
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-500">Don&#039;t look at other tees</dd>
                                </div>
                            </dl>
                        </section> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-admin-layout>
