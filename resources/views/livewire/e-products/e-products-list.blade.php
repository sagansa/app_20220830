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
            <div class="max-w-2xl px-2 py-6 mx-auto sm:px-6 lg:max-w-7xl lg:px-8">
                <h2 class="text-2xl font-bold tracking-tight text-gray-900">Sagansa Product</h2>

                <div class="grid grid-cols-2 mt-6 gap-y-10 gap-x-4 sm:grid-cols-4 lg:grid-cols-6">
                    @foreach ($eProducts as $eProduct)
                        <div class="relative group">
                            <button wire:click.prevent="newOrder({{ $eProduct->id }})"
                                class="w-full overflow-hidden bg-gray-200 rounded-md min-h-40 aspect-w-1 aspect-h-1 group-hover:opacity-75 lg:aspect-none lg:h-40">
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
                                    <h3 class="text-sm font-bold text-gray-700 dark:text-gray-50">
                                        <a href="{{ route('e-products.detail', $eProduct) }}">
                                            <span aria-hidden="true" class="absolute inset-0"></span>
                                            {{ $eProduct->product->name }}
                                        </a>
                                    </h3>

                                </div>

                            </div>
                            <p class="text-sm font-medium text-right text-gray-900 dark:text-white">@currency($eProduct->price)
                            </p>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-200">
                                {{ $eProduct->product->description }}</p>
                        </div>
                    @endforeach

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
</div>
