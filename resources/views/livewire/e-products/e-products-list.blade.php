<div>
    <section aria-labelledby="collection-heading" class="max-w-xl px-4 pt-6 mx-auto sm:px-6 lg:max-w-7xl lg:px-8">
        <div class="px-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8 xl:px-0">
            {{-- <h2 id="category-heading" class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                Produk Unggulan
            </h2> --}}
            {{-- <a href="#"
                        class="hidden text-sm font-semibold text-indigo-600 hover:text-indigo-500 sm:block">
                        Browse all categories
                        <span aria-hidden="true"> &rarr;</span>
                    </a> --}}
        </div>

        <!--
  This example requires Tailwind CSS v2.0+

  This example requires some changes to your config:

  ```
  // tailwind.config.js
  module.exports = {
    // ...
    plugins: [
      // ...
      require('@tailwindcss/aspect-ratio'),
    ],
  }
  ```
-->
        <div class="bg-white dark:bg-gray-900">
            <div class="max-w-2xl px-4 py-16 mx-auto sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
                <h2 class="text-2xl font-bold tracking-tight text-gray-900">Sagansa Product</h2>

                <div class="grid grid-cols-1 mt-6 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                    @foreach ($eProducts as $eProduct)
                        <div class="relative group">
                            <button wire:click.prevent="newOrder({{ $eProduct->id }})"
                                class="w-full overflow-hidden bg-gray-200 rounded-md min-h-80 aspect-w-1 aspect-h-1 group-hover:opacity-75 lg:aspect-none lg:h-80">
                                <img src="{{ $eProduct->image ? \Storage::url($eProduct->image) : '' }}"
                                    alt="Front of men&#039;s Basic Tee in black."
                                    class="object-cover object-center w-full h-full lg:h-full lg:w-full">
                            </button>
                            {{-- <div class="mt-6">
                                <button
                                    class="w-full overflow-hidden bg-gray-200 rounded-md min-h-80 aspect-w-1 aspect-h-1 group-hover:opacity-75 lg:aspect-none lg:h-10">Add
                                    to bag</button>
                            </div> --}}
                            <div class="flex justify-between mt-4">
                                <div>
                                    <h3 class="text-sm text-gray-700 dark:text-gray-100">
                                        <a href="#">
                                            <span aria-hidden="true" class="absolute inset-0"></span>
                                            {{ $eProduct->product->name }}
                                        </a>
                                    </h3>

                                </div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">@currency($eProduct->price)</p>
                            </div>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-200">
                                {{ $eProduct->product->description }}</p>
                        </div>
                    @endforeach

                    <!-- More products... -->
                </div>
            </div>
        </div>

        <div class="px-4 mt-10">{{ $eProducts->links() }}</div>


        {{-- <div class="px-4 mt-6 sm:hidden">
                    <a href="#" class="block text-sm font-semibold text-indigo-600 hover:text-indigo-500">
                        Browse all categories
                        <span aria-hidden="true"> &rarr;</span>
                    </a>
                </div> --}}
    </section>

    <form wire:submit.prevent="save">
        <x-modal wire:model.defer="showEditModal">

            <div class="relative z-10" role="dialog" aria-modal="true">
                <!--
                Background backdrop, show/hide based on modal state.

                Entering: "ease-out duration-300"
                From: "opacity-0"
                To: "opacity-100"
                Leaving: "ease-in duration-200"
                From: "opacity-100"
                To: "opacity-0"
            -->
                <div class="fixed inset-0 hidden transition-opacity bg-gray-500 bg-opacity-75 md:block"></div>

                <div class="fixed inset-0 z-10 overflow-y-auto">
                    <div
                        class="flex items-stretch justify-center min-h-full text-center md:items-center md:px-2 lg:px-4">
                        <!--
                        Modal panel, show/hide based on modal state.

                        Entering: "ease-out duration-300"
                        From: "opacity-0 translate-y-4 md:translate-y-0 md:scale-95"
                        To: "opacity-100 translate-y-0 md:scale-100"
                        Leaving: "ease-in duration-200"
                        From: "opacity-100 translate-y-0 md:scale-100"
                        To: "opacity-0 translate-y-4 md:translate-y-0 md:scale-95"
                    -->
                        <div
                            class="flex w-full text-base text-left transition transform md:my-8 md:max-w-2xl md:px-4 lg:max-w-4xl">
                            <div
                                class="relative flex items-center w-full px-4 pb-8 overflow-hidden bg-white shadow-2xl pt-14 sm:px-6 sm:pt-8 md:p-6 lg:p-8">
                                <button type="button"
                                    class="absolute text-gray-400 top-4 right-4 hover:text-gray-500 sm:top-8 sm:right-6 md:top-6 md:right-6 lg:top-8 lg:right-8">
                                    <span class="sr-only">Close</span>
                                    <!-- Heroicon name: outline/x-mark -->
                                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>

                                <div
                                    class="grid items-start w-full grid-cols-1 gap-y-8 gap-x-6 sm:grid-cols-12 lg:gap-x-8">
                                    <div class="sm:col-span-4 lg:col-span-5">
                                        <div class="overflow-hidden bg-gray-100 rounded-lg aspect-w-1 aspect-h-1">
                                            <img src="https://tailwindui.com/img/ecommerce-images/product-page-03-product-04.jpg"
                                                alt="Back angled view with bag open and handles to the side."
                                                class="object-cover object-center">
                                        </div>
                                    </div>
                                    <div class="sm:col-span-8 lg:col-span-7">
                                        <h2 class="text-2xl font-bold text-gray-900 sm:pr-12">Zip Tote Basket</h2>

                                        <section aria-labelledby="information-heading" class="mt-3">
                                            <h3 id="information-heading" class="sr-only">Product information</h3>

                                            <p class="text-2xl text-gray-900">$220</p>

                                            <!-- Reviews -->
                                            <div class="mt-3">
                                                <h4 class="sr-only">Reviews</h4>
                                                <div class="flex items-center">
                                                    <div class="flex items-center">
                                                        <!--
                                                        Heroicon name: mini/star

                                                        Active: "text-gray-400", Inactive: "text-gray-200"
                                                    -->
                                                        <svg class="flex-shrink-0 w-5 h-5 text-gray-400"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" aria-hidden="true">
                                                            <path fill-rule="evenodd"
                                                                d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z"
                                                                clip-rule="evenodd" />
                                                        </svg>

                                                        <!-- Heroicon name: mini/star -->
                                                        <svg class="flex-shrink-0 w-5 h-5 text-gray-400"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" aria-hidden="true">
                                                            <path fill-rule="evenodd"
                                                                d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z"
                                                                clip-rule="evenodd" />
                                                        </svg>

                                                        <!-- Heroicon name: mini/star -->
                                                        <svg class="flex-shrink-0 w-5 h-5 text-gray-400"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" aria-hidden="true">
                                                            <path fill-rule="evenodd"
                                                                d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z"
                                                                clip-rule="evenodd" />
                                                        </svg>

                                                        <!-- Heroicon name: mini/star -->
                                                        <svg class="flex-shrink-0 w-5 h-5 text-gray-400"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" aria-hidden="true">
                                                            <path fill-rule="evenodd"
                                                                d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z"
                                                                clip-rule="evenodd" />
                                                        </svg>

                                                        <!-- Heroicon name: mini/star -->
                                                        <svg class="flex-shrink-0 w-5 h-5 text-gray-200"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" aria-hidden="true">
                                                            <path fill-rule="evenodd"
                                                                d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                    <p class="sr-only">3.9 out of 5 stars</p>
                                                </div>
                                            </div>

                                            <div class="mt-6">
                                                <h4 class="sr-only">Description</h4>

                                                <p class="text-sm text-gray-700">The Zip Tote Basket is the perfect
                                                    midpoint between shopping tote and comfy backpack. With convertible
                                                    straps, you can hand carry, should sling, or backpack this
                                                    convenient
                                                    and spacious bag. The zip top and durable canvas construction keeps
                                                    your
                                                    goods protected for all-day use.</p>
                                            </div>
                                        </section>

                                        <section aria-labelledby="options-heading" class="mt-6">
                                            <h3 id="options-heading" class="sr-only">Product options</h3>

                                            <form>
                                                <!-- Colors -->
                                                <div>
                                                    <h4 class="text-sm text-gray-600">Color</h4>

                                                    <fieldset class="mt-2">
                                                        <legend class="sr-only">Choose a color</legend>
                                                        <div class="flex items-center space-x-3">
                                                            <!--
                                                            Active and Checked: "ring ring-offset-1"
                                                            Not Active and Checked: "ring-2"
                                                        -->
                                                            <label
                                                                class="-m-0.5 relative p-0.5 rounded-full flex items-center justify-center cursor-pointer focus:outline-none ring-gray-700">
                                                                <input type="radio" name="color-choice"
                                                                    value="Washed Black" class="sr-only"
                                                                    aria-labelledby="color-choice-0-label">
                                                                <span id="color-choice-0-label" class="sr-only">
                                                                    Washed
                                                                    Black </span>
                                                                <span aria-hidden="true"
                                                                    class="w-8 h-8 bg-gray-700 border border-black rounded-full border-opacity-10"></span>
                                                            </label>

                                                            <!--
                                                            Active and Checked: "ring ring-offset-1"
                                                            Not Active and Checked: "ring-2"
                                                        -->
                                                            <label
                                                                class="-m-0.5 relative p-0.5 rounded-full flex items-center justify-center cursor-pointer focus:outline-none ring-gray-400">
                                                                <input type="radio" name="color-choice"
                                                                    value="White" class="sr-only"
                                                                    aria-labelledby="color-choice-1-label">
                                                                <span id="color-choice-1-label" class="sr-only"> White
                                                                </span>
                                                                <span aria-hidden="true"
                                                                    class="w-8 h-8 bg-white border border-black rounded-full border-opacity-10"></span>
                                                            </label>

                                                            <!--
                                                            Active and Checked: "ring ring-offset-1"
                                                            Not Active and Checked: "ring-2"
                                                        -->
                                                            <label
                                                                class="-m-0.5 relative p-0.5 rounded-full flex items-center justify-center cursor-pointer focus:outline-none ring-gray-500">
                                                                <input type="radio" name="color-choice"
                                                                    value="Washed Gray" class="sr-only"
                                                                    aria-labelledby="color-choice-2-label">
                                                                <span id="color-choice-2-label" class="sr-only">
                                                                    Washed
                                                                    Gray </span>
                                                                <span aria-hidden="true"
                                                                    class="w-8 h-8 bg-gray-500 border border-black rounded-full border-opacity-10"></span>
                                                            </label>
                                                        </div>
                                                    </fieldset>
                                                </div>

                                                <div class="mt-6">
                                                    <button type="submit"
                                                        class="flex items-center justify-center w-full px-8 py-3 text-base font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-50">Add
                                                        to cart</button>
                                                </div>

                                                <p class="absolute text-center top-4 left-4 sm:static sm:mt-6">
                                                    <a href="#"
                                                        class="font-medium text-indigo-600 hover:text-indigo-500">View
                                                        full
                                                        details</a>
                                                </p>
                                            </form>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </x-modal>
    </form>
</div>
